<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Etape extends BaseController
{

  public function __construct()
  {
    helper('form'); 
    $this->model = model(Db_model::class);
  }

  // Permet d'afficher la première étape d'un scénario
  public function afficher($sce_code = null, $eta_code = null)
  {
    if ($sce_code == null || $eta_code == null) {
        return redirect()->to('/scenario/afficher');
    
    }
    
    if (strlen($sce_code) != 12 || strlen($eta_code) != 8) {
        return redirect()->to('/scenario/afficher');
    }



    $data['etape'] = $this->model->get_first_etape($sce_code, $eta_code);
    $etape = $data['etape'];

    if ($this->request->getMethod() == "POST") {
        $reponse = $this->request->getPost('reponse');
        
        // Validation de la réponse
        if ($this->model->validation_reponse($eta_code, $reponse)) 
        {
            $session = session();
            $par_id = $session->get('par_id');
            $sce_id = $session->get('sce_id');
            $num_etape = $etape->eta_numero + 1;
            $session->set('num_etape', $num_etape);
            $this->model->update_participation($par_id, $sce_id, $num_etape);
            return redirect()->to('/etape/afficher_suivante/' . $sce_code . '/' . $this->model->get_prochaine_etape($eta_code)->eta_code);
        } else {
            $data['error'] = 'Réponse incorrecte, essayez à nouveau.';
        }
    }
    return view('templates/menu_visiteur', $data)
        . view('affichage_etape', ['sce_code' => $sce_code, 'eta_code' => $eta_code])
        . view('templates/bas');
  }

  // Permet d'afficher l'étape suivant la première étape
  public function afficher_suivante($sce_code = null, $eta_code = null)
  {
    if ($sce_code == null || $eta_code == null) {
        return redirect()->to('/scenario/afficher');
    
    }
    if (strlen($sce_code) != 12 || strlen($eta_code) != 8) {
        return redirect()->to('/scenario/afficher');
    }
    $session = session();
    
    $data['etape'] = $this->model->get_etape($sce_code, $eta_code);
    $etape = $data['etape'];


    if ($this->request->getMethod() == "POST") {
        $reponse = $this->request->getPost('reponse');
        
        // Validation de la réponse
        if ($this->model->validation_reponse($eta_code, $reponse)) 
        {
            $session = session();
            $par_id = $session->get('par_id');
            $sce_id = $session->get('sce_id');
            $prochaine_etape = $this->model->get_prochaine_etape($eta_code);

            if ($prochaine_etape === null)
            {
                $num_etape = $etape->eta_numero;
                $this->model->update_participation_reussite($par_id, $sce_id, $num_etape);
                return redirect()->to('/scenario/fin/' . $sce_code . '/' . $eta_code);
            }

            $num_etape = $etape->eta_numero + 1;
            $session->set('num_etape', $num_etape);
            $this->model->update_participation($par_id, $sce_id, $num_etape);
            return redirect()->to('/etape/afficher_suivante/' . $sce_code . '/' . $this->model->get_prochaine_etape($eta_code)->eta_code);
        } else {
            $data['error'] = 'Réponse incorrecte, essayez à nouveau.';
        }
    }
    return view('templates/menu_visiteur', $data)
        . view('affichage_etape_suivante', ['sce_code' => $sce_code, 'eta_code' => $eta_code])
        . view('templates/bas');
  }
}
?>