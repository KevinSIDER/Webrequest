<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accueil extends BaseController
{

  public function __construct()
  {
    $this->model = model(Db_model::class);
  }

  public function afficher()
  {
    $data['news'] = $this->model->get_recent_news();
    return view('templates/menu_visiteur', $data)
          . view('affichage_accueil')
          . view('templates/bas');
  }
}
?>