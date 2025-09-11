<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Scenario extends BaseController
{

  public function __construct()
  {
    helper('form');
    $this->model = model(Db_model::class);
  }

  // Permet d'afficher tout les scénarios actifs pour y jouer
  public function afficher()
  {
    $scenarios = $this->model->get_all_activate_scenarios();
    // Affiche pour chaque scénario son nombre d'étapes
    foreach ($scenarios as &$scenario)
    {
        $scenario['nbr'] = $this->model->count_nbr_etapes($scenario['sce_id']);
    }
    $data['scenarios'] = $scenarios;

    return view('templates/menu_visiteur', $data)
        . view('affichage_scenarios')
        . view('templates/bas');
  }

  // Permet de participer à un scénario
  public function participer($id = null)
  {
    if ($id == null){
        return redirect()->route('scenario/afficher');
    }
    if ($this->request->getMethod() == "POST") {
        if (!$this->validate([
            'code' => 'required|max_length[12]|min_length[12]',
            'mail' => 'required|max_length[300]|min_length[8]'
        ], [
            'code' => [
                'required' => 'Veuillez saisir le code du scénario !',
                'min_length' => 'Le code du scénario est trop court !',
            ],
            'mail' => [
                'required' => 'Veuillez saisir une adresse mail !',
                'min_length' => 'L\'adresse mail saisie est trop courte !',
            ],
        ])) {
            return view('templates/menu_visiteur')
                . view('participation/scenario_participer', ['id' => $id]);
        }

        $recuperation = $this->validator->getValidated();

        // Vérification que le scénario existe
        $scenario = $this->model->get_scenario_by_id($id);
        if (!$scenario) {
            return redirect()->to("/scenario/participer/$id")->with('error', 'Le code du scénario saisi est incorrect !');
        }

        // Vérification du code
        if (isset($recuperation['code']) && $recuperation['code'] == $scenario->sce_code) {
            $sce_code = $scenario->sce_code;
            $eta_code = $scenario->eta_code;

            // Vérification que l'étape existe
            $etape = $this->model->get_first_etape($sce_code, $eta_code);    

            $participation = $this->model->set_participation($recuperation);
            $par_id = $participation->par_id;
            $sce_id = $participation->sce_id;


            $session = session();
            $session->set('par_id', $par_id);
            $session->set('sce_id', $sce_id);


            return redirect()->to("/etape/afficher/$sce_code/$eta_code");
        } else {
            return redirect()->to("/scenario/participer/$id")->with('error', 'Le code du scénario saisi est incorrect !');
        }
    }
    return view('templates/menu_visiteur')
        . view('participation/scenario_participer', ['id' => $id]);
    }

    // Permet d'afficher tout les scénarios actifs pour la gestion
    public function lister()
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $scenarios = $this->model->get_all_scenarios();
            // Affiche le nombre d'étapes pour chaque scénario
            foreach ($scenarios as &$scenario) 
            {
                $scenario['nbr'] = $this->model->count_nbr_etapes($scenario['sce_id']);
            }
            $data['scenarios'] = $scenarios;

            return view('templates/Admin/menu_administrateur', $data)
                . view('scenario/scenario_gestion')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    public function fin($sce_code, $eta_code){
        if (strlen($sce_code) != 12 || strlen($eta_code) != 8) {
            return redirect()->to('/scenario/afficher');
        }
        return view('templates/menu_visiteur')
                . view('scenario_termine');
    }

    public function visualiser($id){
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $data['scenarios'] = $this->model->get_all_infos_for_scenario($id);
            $data['nbrReussites'] = $this->model->donner_nb_reussite($id);

            return view('templates/Admin/menu_administrateur', $data)
                . view('scenario/scenario_visualiser')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    
    public function generate_code($length = 12) 
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $maxIndex)];
        }

        return $code;
    }

    public function creer()
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $code = $this->generate_code();
            if ($this->request->getMethod() == "POST") {
                if (!$this->validate([
                    'titre' => 'required|max_length[200]|min_length[5]',
                    'texte'    => 'required|max_length[300]|min_length[10]',
                    'etat'   => 'required|in_list[0,1]',
                ], [
                    // Configuration des messages d’erreurs
                    'titre' => [
                        'required' => 'Veuillez entrer un titre pour votre scénario !',
                        'min_length' => 'Le titre saisi est trop court !',
                        'max_length' => 'Le titre saisi est trop long !',
                    ],
                    'texte' => [
                        'required'   => 'Veuillez entrer une description pour votre scénario !',
                        'min_length' => 'La description de votre scénario est trop courte !',
                        'max_length' => 'La description de votre scénario est trop longue !',
                    ],
                    'etat' => [
                        'required' => 'Veuillez choisir un état pour votre scénario !',
                        'in_list'  => 'Vous n\'avez le choix qu\'entre l\'état 1 et 0 !',
                    ],
                    'fichier' => [
                        'label' => 'Fichier image',
                        'rules' => [
                            'uploaded[fichier]',
                            'is_image[fichier]',
                            'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[fichier,100]',
                            'max_dims[fichier,1024,768]',
                        ],
                    ],
                ])) {
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/Admin/menu_administrateur',  ['code' => $code])
                        . view('scenario/scenario_creer')
                        . view('templates/Admin/bas_admin');
                }

                $titre = $this->request->getVar('titre');
                $texte = $this->request->getVar('texte');
                $etat = $this->request->getVar('etat');
                $fichier = $this->request->getFile('fichier');
                $mail = $session->get('user');

                if (!empty($fichier)) 
                {
                    // Récupération du nom du fichier téléversé
                    $nom_fichier = $fichier->getName();
                    // Ajout de la date et de l'heure au nom du ficheir pour différencier
                    $new_nom_fichier = date('Ymd_His') . '_' . $nom_fichier;
                    // Dépôt du fichier dans le répertoire ci/public/uploads/img/pp(profil picture)
                    if ($fichier->move("uploads/img", $new_nom_fichier)) 
                    {
                        $new_nom_fichier = 'uploads/img/' . $new_nom_fichier;
                        $this->model->create_scenario($code, $titre, $texte, $etat, $new_nom_fichier, $mail);
                        return redirect()->to('scenario/lister');
                    }
                }   
            }
            return view('templates/Admin/menu_administrateur',  ['code' => $code])
                . view('scenario/scenario_creer')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    public function supprimer($id)
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $this->model->delete_scenario($id);
            return redirect()->to('scenario/lister');
        }
        return redirect()->to('compte/connecter');
    }

    public function modifier($id)
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O') 
        {
            $data['scenario'] = $this->model->get_scenario($id);
            $code = $this->generate_code();
            
            if ($this->request->getMethod() == "POST") {
                if (!$this->validate([
                    'titre' => 'required|max_length[200]|min_length[5]',
                    'texte'    => 'required|max_length[300]|min_length[10]',
                    'etat'   => 'required|in_list[0,1]',
                ], [
                    // Configuration des messages d’erreurs
                    'titre' => [
                        'required' => 'Veuillez entrer un titre pour votre scénario !',
                        'min_length' => 'Le titre saisi est trop court !',
                        'max_length' => 'Le titre saisi est trop long !',
                    ],
                    'texte' => [
                        'required'   => 'Veuillez entrer une description pour votre scénario !',
                        'min_length' => 'La description de votre scénario est trop courte !',
                        'max_length' => 'La description de votre scénario est trop longue !',
                    ],
                    'etat' => [
                        'required' => 'Veuillez choisir un état pour votre scénario !',
                        'in_list'  => 'Vous n\'avez le choix qu\'entre l\'état 1 et 0 !',
                    ],
                    'fichier' => [
                        'label' => 'Fichier image',
                        'rules' => [
                            'uploaded[fichier]',
                            'is_image[fichier]',
                            'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[fichier,100]',
                            'max_dims[fichier,1024,768]',
                        ],
                    ],
                ])) {
                    return view('templates/Admin/menu_administrateur', ['code' => $code])
                        . view('scenario/scenario_modifier', $data)
                        . view('templates/Admin/bas_admin');
                }

                $titre = $this->request->getVar('titre');
                $texte = $this->request->getVar('texte');
                $etat = $this->request->getVar('etat');
                $fichier = $this->request->getFile('fichier');
                $mail = $session->get('user');
                $current_illustration = $data['scenario']->sce_illustration;

                if ($fichier && $fichier->isValid()) {
                    // Si un fichier est téléchargé, on le traite et on le remplace
                    $nom_fichier = $fichier->getName();
                    $new_nom_fichier = date('Ymd_His') . '_' . $nom_fichier;

                    if ($fichier->move("uploads/img", $new_nom_fichier))
                    {
                        $new_nom_fichier = 'uploads/img/' . $new_nom_fichier;
                        $this->model->update_scenario($code, $titre, $texte, $new_nom_fichier, $etat, $id);
                        return redirect()->to('scenario/lister');
                    }
                } else {
                    $this->model->update_scenario($code, $titre, $texte, $current_illustration, $etat, $id);
                    return redirect()->to('scenario/lister');
                }
            }

            return view('templates/Admin/menu_administrateur', ['code' => $code])
                . view('scenario/scenario_modifier', $data)
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    public function changer_etat($id, $etat)
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $this->model->set_etat($id, $etat);
            return redirect()->to('scenario/lister');
        }
        return redirect()->to('compte/connecter');
    }

    public function remettre_a_zero($id)
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $this->model->raz_scenario($id);
            return redirect()->to('scenario/lister');
        }
        return redirect()->to('compte/connecter');
    }

    public function copier($id)
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'O')
        {
            $scenario = $this->model->get_scenario($id);
            $code = $this->generate_code();
            $mail = $session->get('user');
            $this->model->create_scenario($code, $scenario->sce_titre, $scenario->sce_texte, $scenario->sce_etat, $scenario->sce_illustration, $mail);
            return redirect()->to('scenario/lister');
        }
        return redirect()->to('compte/connecter');
    }
}
?>