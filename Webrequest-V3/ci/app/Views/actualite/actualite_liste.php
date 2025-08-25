<div id='content-wrapper' class='d-flex flex-column'>
    <div id='content'>
        <div class='container-fluid'>
            <br>
            <h2 class='font-weight-bold text-center'>Gestion des actualités</h2>
            <br>
           
  <?php

  echo "<td><a href='" . base_url('/index.php/actualite/publier') . "' class='d-none d-sm-inline-block btn btn-sm btn-success shadow-sm'>Publier une actualité</a></td>";
  echo "<br>";
  echo "<br>";
  $session = session();
    if (!empty($news) && is_array($news))
    {
      echo "<div class=\"table-responsive\">";
      echo "<table class=\"table table-striped table-bordered\">";
      echo "<thead class=\"thead-dark\">";
      echo "<tr>
              <th>Identifiant</th>
              <th>Titre</th>
              <th>Contenu</th>
              <th>Date</th>
              <th>État</th>
              <th>Auteur</th>
              <th>Modifier</th>
              <th>Supprimer</th>
            </tr>";
      echo "</thead><tbody>";

      foreach ($news as $new) {
        echo "<tr>";
        echo "<td>" . $new["act_id"] . "</td>";
        echo "<td>" . $new["act_titre"] . "</td>";
        echo "<td>" . $new["act_texte"] . "</td>";
        echo "<td>" . $new["act_date"] . "</td>"; 
        echo "<td>" . ($new["act_etat"] == 1 ? 'Activé' : 'Désactivé') . "</td>";
        echo "<td>" . $new["com_mail"] . "</td>";
    
        if ($session->get('role') == 'A' || $session->get('user') == $new["com_mail"]) {
            // Si l'utilisateur a un rôle 'A' ou est l'auteur de l'actualité
            echo "<td><a href='" . base_url('/index.php/actualite/modifier/' . $new["act_id"]) . "' class='btn btn-sm btn-primary'><img src='" . base_url('images/icones/modifier.png') . "' alt='Modifier' style='width:16px; height:16px;'></a></td>";
            echo "<td><a href='" . base_url('index.php/actualite/supprimer/' . $new["act_id"]) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette actualité ?\");'><img src='" . base_url('images/icones/supprimer.png') . "' alt='Supprimer' style='width:16px; height:16px;'></a></td>";


        } else {
           // Si mon user n'as pas le bon rôle
            echo "<td> </td><td> </td>";
        }
        echo "</tr>";
      }
      echo "</tbody></table></div>";
    } 
    else 
    {
      echo "<h3>Aucune actualité pour l'instant !</h3>";
    }
    echo("<br>");
  ?>
</div>
</div>
</div>
</div>
