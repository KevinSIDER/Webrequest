<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Actualite extends BaseController
{
 public function __construct()
 {
    helper('form');
    $this->model = model(Db_model::class);
 }

 // Afficher toutes les actualités
 public function lister()
 {
    $data['news'] = $this->model->get_all_actualites();
    return view('templates/Admin/menu_administrateur',  $data)
          . view('actualite/actualite_liste')
          . view('templates/Admin/bas_admin');
 }
 
 // Permet de publier une actualité
 public function publier()
 {
    $session = session();
    if ($session->has('user')) {
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "POST") {
            // Validation des données du formulaire
            if (!$this->validate([
                'titre' => 'required|max_length[200]|min_length[5]',
                'texte' => 'required|min_length[10]',
            ], [
                // Configuration des messages d’erreurs
                'titre' => [
                    'required' => 'Veuillez entrer un titre pour cette actualité !',
                    'min_length' => 'Le titre saisi est trop court !',
                ],
                'texte' => [
                    'required' => 'Veuillez entrer le contenu de votre actualité !',
                    'min_length' => 'Le contenu de votre actualité est trop court !',
                ],
            ])) {
                // La validation du formulaire a échoué, retour au formulaire
                return view('templates/Admin/menu_administrateur')
                    . view('actualite/actualite_creer')
                    . view('templates/Admin/bas_admin');
            }
            // Récupération des données du formulaire
            $titre = $this->request->getVar('titre');
            $texte = $this->request->getVar('texte');
            $mail = $session->get('user');

            $this->model->create_actualite($titre, $texte, $mail);
            return redirect()->to('actualite/lister');
        }
        return view('templates/Admin/menu_administrateur')
            . view('actualite/actualite_creer')
            . view('templates/Admin/bas_admin');
    }
    // L'utilisateur n'est pas connecté
    return redirect()->to('compte/connecter');
  }

  // Permet de modifier une actualité
  public function modifier($id = null)
  {
    $session = session();
    if ($session->has('user') && $id !== null) 
    {
        $actualite = $this->model->get_actualite($id);
        if($actualite == null)
        {
            return redirect()->to('actualite/lister');
        }
        $role = $session->get('role');

        if (($role == 'O' && isset($actualite->com_mail) && $actualite->com_mail == $session->get('user')) || $role == 'A') {
            if ($this->request->getMethod() == "POST") {
                if (!$this->validate([
                    'titre' => 'required|max_length[200]|min_length[5]',
                    'texte' => 'required|min_length[10]',
                    'etat'   => 'required|in_list[0,1]',
                ], [
                    'titre' => [
                        'required' => 'Veuillez entrer un titre pour cette actualité !',
                        'min_length' => 'Le titre saisi est trop court !',
                    ],
                    'texte' => [
                        'required' => 'Veuillez entrer le contenu de votre actualité !',
                        'min_length' => 'Le contenu de votre actualité est trop court !',
                    ],
                    'etat' => [
                        'required' => 'Veuillez choisir un état pour le compte !',
                        'in_list'  => 'Vous n\'avez le choix qu\'entre l\'état 1 et 0 !',
                    ],
                ])) {
                    return view('templates/Admin/menu_administrateur')
                        . view('actualite/actualite_modifier')
                        . view('templates/Admin/bas_admin');
                }
                $titre = $this->request->getVar('titre');
                $texte = $this->request->getVar('texte');
                $etat = $this->request->getVar('etat');
                
                $this->model->update_actualite($titre, $texte, $etat, $id);
                return redirect()->to('actualite/lister');
            }
            $data['new'] = $actualite;
            return view('templates/Admin/menu_administrateur', $data)
                . view('actualite/actualite_modifier')
                . view('templates/Admin/bas_admin');
        }
    }
    return redirect()->to('actualite/lister');
  }

  // Permet de supprimer une actualité
  public function supprimer($id = null)
  {
    $session = session();
    if ($session->has('user') && $id !== null)
    {
        $actualite = $this->model->get_actualite($id);
        $role = $session->get('role');

        if (($role == 'O' && isset($actualite->com_mail) && $actualite->com_mail == $session->get('user')) || $role == 'A')
        {
            $this->model->delete_actualite($id);
            return redirect()->to('actualite/lister');
        }
    }
    return redirect()->to('actualite/lister');
  }
}
?>