<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }

    // Affichage de l'accueil de la partie "administrateur"
    public function accueil()
    {
        $session = session();
        if ($session->has('user'))
        {
            return view('templates/Admin/menu_administrateur')
            . view('compte/compte_accueil')
            . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    // Permet d'afficher la liste des comptes et leurs nombre
    public function lister()
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'A')
        {
            $data['comptes'] = $this->model->get_all_compte();
            $data['nbr'] = $this->model->count_all_comptes();
            return view('templates/Admin/menu_administrateur', $data)
                . view('affichage_comptes')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    public function creer()
    {
        $session = session();
        if ($session->has('user') && $session->get('role') == 'A')
        {
            // L’utilisateur a validé le formulaire en cliquant sur le bouton
            if ($this->request->getMethod() == "POST") {
                if (!$this->validate([
                    'pseudo' => 'required|max_length[255]|min_length[2]',
                    'mdp'    => 'required|max_length[255]|min_length[8]',
                    'nom'    => 'required|max_length[80]|min_length[1]',
                    'prenom' => 'required|max_length[80]|min_length[1]',
                    'role'   => 'required|in_list[A,O]',
                    'etat'   => 'required|in_list[0,1]',
                ], [
                    // Configuration des messages d’erreurs
                    'pseudo' => [
                        'required' => 'Veuillez entrer un mail pour le compte !',
                    ],
                    'mdp' => [
                        'required'   => 'Veuillez entrer un mot de passe !',
                        'min_length' => 'Le mot de passe saisi est trop court !',
                    ],
                    'nom' => [
                        'required'   => 'Veuillez entrer un nom pour le compte !',
                        'min_length' => 'Le nom saisi est trop court !',
                    ],
                    'prenom' => [
                        'required'   => 'Veuillez entrer un prénom pour le compte !',
                        'min_length' => 'Le prénom saisi est trop court !',
                    ],
                    'role' => [
                        'required' => 'Veuillez choisir un rôle pour le compte !',
                        'in_list'  => 'Vous n\'avez le choix qu\'entre le rôle A et O !',
                    ],
                    'etat' => [
                        'required' => 'Veuillez choisir un état pour le compte !',
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
                    return view('templates/Admin/menu_administrateur')
                        . view('compte/compte_creer')
                        . view('templates/Admin/bas_admin');
                }

                $pseudo  = $this->request->getVar('pseudo');
                $mdp     = $this->request->getVar('mdp');
                $nom     = $this->request->getVar('nom');
                $prenom  = $this->request->getVar('prenom');
                $etat    = $this->request->getVar('etat');
                $role    = $this->request->getVar('role');
                $fichier = $this->request->getFile('fichier');

                if (!empty($fichier)) 
                {
                    // Récupération du nom du fichier téléversé
                    $nom_fichier = $fichier->getName();
                    // Ajout de la date et de l'heure au nom du ficheir pour différencier
                    $new_nom_fichier = date('Ymd_His') . '_' . $nom_fichier;
                    // Dépôt du fichier dans le répertoire ci/public/uploads/img/pp(profil picture)
                    if ($fichier->move("uploads/img/pp", $new_nom_fichier)) 
                    {
                        $recuperation = $this->validator->getValidated();
                        $this->model->set_compte($pseudo, $mdp, $nom, $prenom, $etat, $role, $new_nom_fichier);
                        $data['le_compte'] = $recuperation['pseudo'];
                        $data['le_message'] = "Nouveau nombre de comptes : ";
                        $data['le_total'] = $this->model->count_all_comptes();

                        return view('templates/Admin/menu_administrateur', $data)
                            . view('compte/compte_succes')
                            . view('templates/Admin/bas_admin');
                    }
                }   
            }
            return view('templates/Admin/menu_administrateur')
                . view('compte/compte_creer')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }

    // Affiche le formulaire de connexion pour accèder à la partie admin
    public function connecter()
    {
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "POST") {
            if (!$this->validate([
                'mail' => ['required'],
                'mdp' => ['required']
                ]
            )) {
                // La validation du formulaire a échoué, retour au formulaire !
                $data['error'] = 'Veuillez remplir tous les champs !';
                return view('templates/menu_visiteur', $data)
                    . view('compte/compte_connecter');
            }

            // La validation du formulaire a réussi, traitement du formulaire
            $mail = $this->request->getVar('mail');
            $mdp  = $this->request->getVar('mdp');

            if ($this->model->connect_compte($mail, $mdp) == true) {
                $session = session();
                $role = $this->model->get_role_by_mail($mail);
                
                $session->set('user', $mail);
                $session->set('role', $role->pro_role);
                
                return view('templates/Admin/menu_administrateur')
                . view('compte/compte_accueil')
                . view('templates/Admin/bas_admin');
            } else {
                $data['error'] = 'Identifiants erronés ou inexistants !';
                return view('templates/menu_visiteur', $data)
                    . view('compte/compte_connecter');
            }
        }
        // L’utilisateur veut afficher le formulaire pour se connecter
        return view('templates/menu_visiteur')
            . view('compte/compte_connecter');
    }

    // Affiche le profil de l'utilisateur connecté
    public function afficher_profil()
    {
        $session = session();
        if ($session->has('user'))
        {
            $mail = $session->get('user');
            $data['profil'] = $this->model->get_profil($mail);
            
            return view('templates/Admin/menu_administrateur', $data)
            . view('compte/compte_profil')
            . view('templates/Admin/bas_admin');
        } else {
            return redirect()->to('compte/connecter');
        }
    }

    // Permet à l'utilisateur connecté de se déconnecter
    public function deconnecter()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('compte/connecter');
    }

    // Permet à l'utilisateur connecté de modifier son profil
    public function modifier()
    {
        $session = session();
        if ($session->has('user'))
        {
            $mail = $session->get('user');
            $data['profil'] = $this->model->get_profil($mail);

            if ($this->request->getMethod() == "POST") {
                if (!$this->validate([
                    'nom' => 'required|max_length[255]|min_length[2]',
                    'prenom'    => 'required|max_length[255]|min_length[2]',
                    'mdp'    => 'required|max_length[80]|min_length[1]',
                    'mdp_confirm' => 'required|matches[mdp]'
                ], [
                    // Configuration des messages d’erreurs
                    'mdp' => [
                        'required'   => 'Veuillez entrer un mot de passe !',
                        'min_length' => 'Le mot de passe saisi est trop court !',
                    ],
                    'nom' => [
                        'required'   => 'Veuillez entrer un nom pour le compte !',
                        'min_length' => 'Le nom saisi est trop court !',
                    ],
                    'prenom' => [
                        'required'   => 'Veuillez entrer un prénom pour le compte !',
                        'min_length' => 'Le prénom saisi est trop court !',
                    ],
                    'mdp_confirm' => [
                        'required'   => 'Veuillez comfirmer votre mot de passe !',
                        'matches'    => 'Confirmation du mot de passe erronée, veuillez réessayer !',
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
                ])) 
                {
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/Admin/menu_administrateur')
                        . view('compte/compte_modifier')
                        . view('templates/Admin/bas_admin');
                }

                $mdp = $this->request->getVar('mdp');
                $nom = $this->request->getVar('nom');
                $prenom = $this->request->getVar('prenom');
                $fichier = $this->request->getFile('fichier');
                $current_pp = $data['profil']->pro_chemin;

                if ($fichier && $fichier->isValid()) 
                {
                    // Récupération du nom du fichier téléversé
                    $nom_fichier = $fichier->getName();
                    // Ajout de la date et de l'heure au nom du ficheir pour différencier
                    $new_nom_fichier = date('Ymd_His') . '_' . $nom_fichier;
                    // Dépôt du fichier dans le répertoire ci/public/uploads/img/pp(profil picture)
                    if ($fichier->move("uploads/img/pp", $new_nom_fichier)) 
                    {
                        $new_nom_fichier = 'uploads/img/pp/' . $new_nom_fichier;
                        $this->model->update_compte($mail, $mdp, $nom, $prenom, $new_nom_fichier);
                        return redirect()->to('compte/afficher_profil');
                    }
                }
                else {
                    $this->model->update_compte($mail, $mdp, $nom, $prenom, $current_pp);
                    return redirect()->to('compte/afficher_profil');
                }
            }
            return view('templates/Admin/menu_administrateur', $data)
                . view('compte/compte_modifier')
                . view('templates/Admin/bas_admin');
        }
        return redirect()->to('compte/connecter');
    }
}
?>