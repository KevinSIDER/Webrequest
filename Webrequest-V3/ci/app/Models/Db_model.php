<?php

/**
 * Modèle de gestion des données pour l'application.
 * 
 * Ce fichier définit la classe Db_model, qui permet d'interagir avec la base de données.
 * 
 * @author Kevin SIDER
 * @version 1.0
 * @date 09/03/2025
 * @package App\Models
 */

namespace App\Models;

use CodeIgniter\Model;

class Db_model extends Model
{
  protected $db;

  // Initialise la connexion à la base de données.
  public function __construct()
  {
    $this->db = db_connect(); //charger la base de données
    // ou
    // $this->db = \Config\Database::connect();
  }

  /**
   * Récupère tous les comptes et retourne uniquement leur adresse mail.
   *
   * @return array Liste des comptes avec leur email.
   */
  public function get_all_compte()
  {
      $resultat = $this->db->query("SELECT * FROM get_all_comptes");
      return $resultat->getResultArray();
  }

  /**
   * Compte le nombre total de comptes présents dans la table t_compte_com.
   *
   * @return object Le nombre total de comptes.
   */
  public function count_all_comptes()
  {
      $resultat = $this->db->query("SELECT COUNT(*) AS nbrComptes 
                                    FROM t_compte_com;");
      return $resultat->getRow();
  }

  /**
   * Cherche l'actualité avec le même ID passé en paramètre
   *
   * @param int $numero Identifiant de l'actualité.
   * @return object L'actualité si trouvée.
   */
  public function get_actualite($numero)
  {
    $requete="SELECT * FROM t_actualite_act
              WHERE act_id=".$numero.";";
    $resultat = $this->db->query($requete);
    return $resultat->getRow();
  }

  /**
   * Retourne la totalité des actualités dont l'état est actif
   *
   * @return array La liste des actualités
   */
  public function get_all_actualites()
  {
    $resultat = $this->db->query("SELECT *
                                  FROM t_actualite_act
                                  ORDER BY act_date DESC;");
    return $resultat->getResultArray();

  }

  public function get_recent_news()
  {
    $resultat = $this->db->query("SELECT act_titre, act_texte, act_date, com_mail 
                                  FROM t_actualite_act 
                                  WHERE act_etat = 1
                                  ORDER BY act_date DESC
                                  LIMIT 5;");
    return $resultat->getResultArray();
  }

  /**
   * Retourne la totalité des scénarios dont l'état est actif
   *
   * @return array La liste des des scénarios
   */
  public function get_all_activate_scenarios()
  {
    $resultat = $this->db->query("SELECT sce_id, sce_titre, sce_texte, com_mail, sce_code, sce_illustration
                                  FROM t_scenario_sce
                                  WHERE sce_etat = 1;");
    return $resultat->getResultArray();
  }

  /**
   * Retourne le nombre d'étapes pour un scénario spcéifique dont le code est passé
   * en paramètre
   *
   * @param char Le code du scénario
   * @return object Le nombre détapes pour le scénario choisis
   */
  public function count_nbr_etapes($sce_id)
  {
    $resultat = $this->db->query("SELECT COUNT(*) AS nbr_etapes
                                  FROM t_etape_eta
                                  JOIN t_scenario_sce USING (sce_id)
                                  WHERE sce_id = '$sce_id'");
    return $resultat->getRow();
  }

  /**
   * Retourne les informations de la première étape d'un scénario
   *
   * @param char Le code du scénario
   * @param char Le code de l'étape
   * @return object les informations de la première étape d'un scénario
   */
  public function get_first_etape($sce_code, $eta_code)
  {
    $resultat = $this->db->query("SELECT eta_numero, eta_question, eta_reponse, res_type,res_source, res_chemin, res_text_alt, ind_texte, ind_url
                                  FROM t_etape_eta
                                  JOIN t_scenario_sce USING (sce_id)
                                  LEFT JOIN t_indice_ind USING (eta_id)
                                  LEFT JOIN t_ressource_res USING (res_id)
                                  WHERE eta_etat = 1
                                  AND sce_code = '$sce_code'
                                  AND eta_code = '$eta_code'
                                  AND eta_numero = 1;");
    return $resultat->getRow();
  }

  /**
   * Retourne le résultat de l'insertion des informations de profil dans la base de données
   *
   * @param string $mail Le mail de l'utilisateur
   * @param string $mdp Le mot de passe de l'utilisateur
   * @param string $nom Le nom de l'utilisateur
   * @param string $prenom Le prénom de l'utilisateur
   * @param string $etat L'état de l'utilisateur (actif ou inactif)
   * @param string $role Le rôle de l'utilisateur (Administrateur ou organisateur)
   * @param string $nom_fichier Le nom du fichier d'image de profil
   * @return object Résultat de l'exécution de la requête d'insertion dans la table t_profil_pro
   */
  public function set_compte($mail, $mdp, $nom, $prenom, $etat, $role, $nom_fichier)
  {
    $sql1 = "INSERT INTO t_compte_com 
             VALUES('". $mail ."', SHA2(CONCAT('l3cda', '$mdp'), 256));";
    $this->db->query($sql1);

    $sql2 = "INSERT INTO t_profil_pro (pro_nom, pro_prenom, pro_role, pro_etat, com_mail, pro_date_creation, pro_chemin)
             VALUES ('" . $nom . "', '" . $prenom . "', '" . $role ."' , '" . $etat . "', '" . $mail . "', curdate(), 'uploads/img/pp" . $nom_fichier ."');";
    return $this->db->query($sql2);
  }

  /**
   * Retourne le résultat de l'insertion des informations de participation à une étape
   *
   * @param string $saisie Toutes les données de la saisie du formulaire
   * @return object Le résultat de l'insertion des informations de participation à une étape
   */
  public function set_participation($saisie)
  {
      $mail = $saisie['mail'];
      $code = $saisie['code'];
      // Obtention de l'id du scénario depuis son code pour l'insérer dans t_participation_pct
      $result = $this->get_scenario_id_by_code($code)->sce_id;

      $sql = "INSERT INTO t_participant_par VALUES (null, '$mail');";
      $this->db->query($sql);

      // Requête SELECT pour prendre le dernier participant inséré
      $sql2 = "INSERT INTO t_participation_pct
               VALUES ((SELECT par_id FROM t_participant_par ORDER BY par_id DESC LIMIT 1), $result, NULL, NULL, 1);";
      $this->db->query($sql2);

      $resultat = $this->db->query("SELECT par_id, sce_id
                                    FROM t_participation_pct
                                    ORDER BY par_id DESC, sce_id DESC
                                    LIMIT 1;");
      return $resultat->getRow();
  }

  /**
   * Retourne le code d'un scénario et de son étape depuis son id
   *
   * @param int $id L'id du scénario
   * @return object Le code du scénario et de son étape
   */
  public function get_scenario_by_id($id)
  {
    $resultat = $this->db->query("SELECT sce_code, eta_code
                                  FROM t_scenario_sce
                                  JOIN t_etape_eta USING (sce_id)
                                  WHERE sce_id = '$id'
                                  AND sce_etat = 1
                                  AND eta_numero = 1;");
    return $resultat->getRow();
  }

  /**
   * Retourne l'id du scénario depuis son code
   *
   * @param int $code Le code du scénario
   * @return object L'id du scénario'
   */
  public function get_scenario_id_by_code($code)
  {
    $resultat = $this->db->query("SELECT sce_id
                                  FROM t_scenario_sce
                                  WHERE sce_code = '$code'
                                  AND sce_etat = 1;");
    return $resultat->getRow();
  }

  /**
   * Vérifie la validité des informations de connexion d'un utilisateur
   *
   * @param string $mail L'email de l'utilisateur
   * @param string $mdp Le mot de passe de l'utilisateur
   * @return bool Retourne true si les informations de connexion sont valides, sinon false
   */
  public function connect_compte($mail , $mdp)
  {
      $sql = "SELECT com_mail, com_mdp
              FROM t_compte_com
              JOIN t_profil_pro USING (com_mail)
              WHERE com_mail = '$mail' 
              AND pro_etat = '1'
              AND com_mdp = SHA2(CONCAT('$mdp','l3cda'), 256)";
      $resultat = $this->db->query($sql);
      if ($resultat->getNumRows() > 0) {
          return true;
      } else {
          return false;
      }
  }

   /**
   * Retourne les informations de l'utilisateur connecté
   *
   * @param string $mail L'email de l'utilisateur
   * @return object Retourne les informations de l'utilisateur connecté
   */
  public function get_profil($mail)
  {
    $resultat = $this->db->query("SELECT * 
                                  FROM t_profil_pro
                                  JOIN t_compte_com USING (com_mail)
                                  WHERE com_mail = '$mail';");
    return $resultat->getRow();
  }

  /**
   * Retourne le code de l'étape suivante
   *
   * @param char $code Le code de la première étape
   * @return object Retourne le code de l'étape suivante
   */
  public function get_prochaine_etape($code)
  {
    $resultat = $this->db->query("SELECT eta_code
                                  FROM t_etape_eta
                                  JOIN t_scenario_sce USING (sce_id)
                                  WHERE eta_etat = 1
                                  AND eta_numero = (SELECT eta_numero + 1
                                                    FROM t_etape_eta
                                                    WHERE eta_code = '$code')
                                  AND sce_id = (SELECT sce_id
                                                FROM t_etape_eta
                                                WHERE eta_code = '$code');");
    return $resultat->getRow();
  }

   /**
   * Retourne les informations de l'étape avec le code correspondant
   *
   * @param char $eta_code Le code de l'étape
   * @param char $sce_code Le code du scénario
   * @return object Retourne les informations de l'étape concernée
   */
  public function get_etape($sce_code, $eta_code)
  {
    $resultat = $this->db->query("SELECT eta_numero, eta_question, eta_reponse, res_type, res_source, res_chemin, res_text_alt, ind_texte, ind_url
                                  FROM t_etape_eta
                                  JOIN t_scenario_sce USING (sce_id)
                                  LEFT JOIN t_indice_ind USING (eta_id)
                                  LEFT JOIN t_ressource_res USING (res_id)
                                  WHERE eta_etat = 1
                                  AND sce_code = '$sce_code'
                                  AND eta_code = '$eta_code';");
    return $resultat->getRow();
  }

  /**
   * Valide la réponse à une étape
   *
   * @param char $code Le code de l'étape
   * @param string $reponse La réponse de l'utilisateur
   * @return bool Retourne true si la réponse est correcte, false sinon
   */
  public function validation_reponse($code, $reponse)
  {
    $sql = "SELECT eta_reponse
            FROM t_etape_eta
            WHERE eta_code = '$code'
            AND eta_reponse = '$reponse';";
      $resultat = $this->db->query($sql);
      if ($resultat->getNumRows() > 0) {
          return true;
      } else {
          return false;
      }
  }

  /**
   * Retourne le rôle de l'utilisateur depuis son mail
   *
   * @param string $mail Le mail de l'utilisateur 
   * @return object Retourne le rôle de l'utilisateur
   */
  public function get_role_by_mail($mail)
  {
    $resultat = $this->db->query("SELECT pro_role 
                                  FROM t_profil_pro 
                                  WHERE com_mail = '$mail';");
    return $resultat->getRow();
  }

  /**
   * Met à jour les informations d'un compte 
   *
   * @param string $mail L'adresse mail de l'utilisateur
   * @param string $mdp Le mot de passe à mettre à jour
   * @param string $nom Le nouveau nom de l'utilisateur
   * @param string $prenom Le nouveau prénom de l'utilisateur
   * @param string $nom_fichier Le nom du fichier image de profil
   * @return object Résultat de la requête d'update
   */
  public function update_compte($mail, $mdp, $nom, $prenom, $nom_fichier)
  {
      return $this->db->query("UPDATE t_profil_pro
                                JOIN t_compte_com USING (com_mail)
                                SET pro_nom = '$nom',
                                    pro_prenom = '$prenom',
                                    pro_chemin = '$nom_fichier',
                                    com_mdp = SHA2(CONCAT('$mdp', 'l3cda'), 256)
                                WHERE com_mail = '$mail';");
  }

  /**
   * Insère une nouvelle actualité
   *
   * @param string $titre Le titre de l'actualité
   * @param string $texte Le contenu de l'actualité
   * @param string $mail L'adresse e-mail de l'auteur de l'actualité
   * @return object Résultat de la requête d'insertion
   */
  public function create_actualite($titre, $texte, $mail)
  {
      $titre = $this->db->escapeString($titre);
      $texte = $this->db->escapeString($texte);
      return $this->db->query("INSERT INTO t_actualite_act
                               VALUES (null,'$titre','$texte',now(),1,'$mail');");
  }

  /**
   * Met à jour une actualité
   *
   * @param string $titre Le nouveau titre de l'actualité
   * @param string $texte Le nouveau contenu de l'actualité
   * @param int $etat L'état de l'actualité (ex: publié, brouillon)
   * @param int $id L'identifiant de l'actualité à modifier
   * @return object Résultat de la requête d'update
   */
  public function update_actualite($titre, $texte, $etat, $id)
  {
      return $this->db->query("CALL update_actualite('$titre', '$texte', '$etat', '$id')");
  }

  /**
   * Supprime une actualité
   *
   * @param int $id L'identifiant de l'actualité à supprimer
   * @return object Résultat de la requête de suppression
   */
  public function delete_actualite($id)
  {
      return $this->db->query("DELETE 
                              FROM t_actualite_act
                              WHERE act_id = '$id';");
  }

   /**
   * Met à jour la participation d'un participant
   *
   * @param int $par_id L'identifiant du participant
   * @param int $sce_id L'identifiant du scénario
   * @param int $num_etape Le numéro de l'étape
   * @return object Résultat de la requête de mise à jour
   */
  public function update_participation($par_id, $sce_id, $num_etape)
  {
    return $this->db->query("UPDATE t_participation_pct
                             SET pct_date_premiere_reussite = NULL, 
                                pct_date_derniere_reussite = NULL, 
                                pct_etape= '$num_etape'
                             WHERE par_id='$par_id' 
                             AND sce_id='$sce_id'");
  }

   /**
   * Met à jour la participation d'un participant lors d'une reussite
   *
   * @param int $par_id L'identifiant du participant
   * @param int $sce_id L'identifiant du scénario
   * @param int $num_etape Le numéro de l'étape
   * @return object Résultat de la requête de mise à jour
   */
  public function update_participation_reussite($par_id, $sce_id, $num_etape)
  {
    return $this->db->query("UPDATE t_participation_pct
                             SET pct_date_premiere_reussite = NOW(), 
                                pct_date_derniere_reussite = NULL, 
                                pct_etape= '$num_etape'
                             WHERE par_id='$par_id' 
                             AND sce_id='$sce_id'");
  }

  /**
   * Donne toutes les informations d'un scénario et les questions/reponses de ses etapes
   *
   * @param int $id L'identifiant du scénario
   * @return array Les informations du scénario
   */
  public function get_all_infos_for_scenario($id)
  {
    $resultat = $this->db->query("SELECT sce_id, sce_code, sce_titre, sce_texte, com_mail, sce_etat, sce_illustration, eta_question, eta_reponse, eta_numero
                                  FROM t_scenario_sce
                                  LEFT JOIN t_etape_eta USING (sce_id)
                                  LEFT JOIN t_indice_ind USING (eta_id)
                                  WHERE sce_id = '$id'
                                  ORDER BY eta_numero;");
    return $resultat->getResultArray();
  }

   /**
   * Créer un scénario
   *
   * @param string $code Le code du scénario préalablement généré automatiquement
   * @param string $titre Le titre du scénario
   * @param string $texte La description du scénario
   * @param int $etat L'état du scénario
   * @param string $nom_fichier Le nom du fichier
   * @param string $mail Le mail de l'utilisateur
   * @return object Résultat de la requête d'insertion
   */
  public function create_scenario($code, $titre, $texte, $etat, $nom_fichier, $mail)
  {
    $titre = $this->db->escapeString($titre);
    $texte = $this->db->escapeString($texte);
    return $this->db->query("INSERT INTO t_scenario_sce
                             VALUES (null,'$code','$titre','$texte','$nom_fichier','$mail','$etat');");
  }

   /**
   * Supprimer un scénario
   *
   * @param int $id L'identifiant du scénario
   * @return object Résultat de la requête de suppression
   */
  public function delete_scenario($id)
  {
    $this->db->query("DELETE FROM t_indice_ind 
                      WHERE eta_id IN (SELECT eta_id FROM t_etape_eta WHERE sce_id = '$id');");

    $this->db->query("DELETE FROM t_etape_eta WHERE sce_id = '$id';");

    $this->db->query("DELETE FROM t_participation_pct WHERE sce_id = '$id';");

    $this->db->query("DELETE FROM t_participant_par 
                      WHERE par_id NOT IN (SELECT par_id 
                                           FROM t_participation_pct);");

    return $this->db->query(" DELETE FROM t_scenario_sce WHERE sce_id = '$id';");
  }

  /**
   * Retourne tout les scénarios
   *
   * @return array Tous les scénarios
   */
  public function get_all_scenarios()
  {
    $resultat = $this->db->query("SELECT sce_id, sce_titre, sce_etat, sce_texte, com_mail, sce_code, sce_illustration
                                  FROM t_scenario_sce;");
    return $resultat->getResultArray();
  }

  /**
   * Met à jour un scénario avec les nouvelles valeurs fournies
   *
   * @param string $code Le code du scénario
   * @param string $titre Le titre du scénario
   * @param string $texte Le texte du scénario
   * @param string $nom_fichier Le nom du fichier d'illustration du scénario
   * @param string $etat L'état du scénario (par exemple, actif ou inactif)
   * @param int $id L'ID unique du scénario à mettre à jour
   * 
   * @return array Résultat de la requête de mise à jour dans la base de données
   */
  public function update_scenario($code, $titre, $texte, $nom_fichier, $etat, $id)
  {
      return $this->db->query("UPDATE t_scenario_sce 
                              SET sce_code = '$code',
                                  sce_titre = '$titre',
                                  sce_texte = '$texte',
                                  sce_illustration = '$nom_fichier',
                                  sce_etat = '$etat' 
                              WHERE sce_id = '$id';");
  }

  /**
   * Récupère les informations d'un scénario en fonction de son ID
   *
   * @param int $id L'ID du scénario à récupérer
   * 
   * @return array Les données du scénario correspondant à l'ID fourni
   */
  public function get_scenario($id)
  {
      $resultat = $this->db->query("SELECT *
                                    FROM t_scenario_sce
                                    WHERE sce_id = '$id';");
      return $resultat->getRow();
  }

  /**
   * Met à jour l'état d'un scénario donné
   *
   * @param int $id L'ID du scénario à mettre à jour
   * @param string $etat Le nouvel état du scénario
   * 
   * @return array Résultat de la requête de mise à jour dans la base de données
   */
  public function set_etat($id, $etat)
  {
      return $this->db->query("UPDATE t_scenario_sce 
                              SET sce_etat = '$etat' 
                              WHERE sce_id = '$id';");
  }

  /**
   * Réinitialise un scénario, en supprimant les participations et participants associés
   *
   * @param int $id L'ID du scénario à réinitialiser
   * 
   * @return array Résultat de la suppression des participations et des participants non associés
   */
  public function raz_scenario($id)
  {
      $this->db->query("DELETE FROM t_participation_pct WHERE sce_id = '$id';");

      return $this->db->query("DELETE FROM t_participant_par 
                               WHERE par_id NOT IN (SELECT par_id 
                                                    FROM t_participation_pct);");
  }

  /**
   * Récupère le nombre de réussites d'un scénario donné
   *
   * @param int $id L'ID du scénario pour lequel obtenir le nombre de réussites
   * 
   * @return array Le nombre de réussites du scénario
   */
  public function donner_nb_reussite($id)
  {
      $resultat = $this->db->query("SELECT donner_nb_reussite('$id') AS nb_reussite");
      return $resultat->getRow();
  }
}
