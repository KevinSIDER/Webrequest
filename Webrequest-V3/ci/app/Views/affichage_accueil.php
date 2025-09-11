<header id="head">
  <div class="container">
    <div class="row">
      <h1 class="lead">Bienvenue sur Web[re]quest !</h1>
      <h3 class="tagline">Renforcez vos connaissances footballistiques avec Web[re]quest ⚽</h3>
    </div>
  </div>
</header>

<div class="container text-center">
  <?php
    echo("<br>");
    echo "<h2 class='thin'>Actualités récentes</h2>";
    echo("<br>");
    if (!empty($news) && is_array($news))
    {
      echo "<div class=\"table-responsive\">";
      echo "<table class=\"table table-striped table-bordered\">";
      echo "<thead class=\"thead-dark\">";
      echo "<tr>
              <th>Titre</th>
              <th>Contenu</th>
              <th>Date</th>
              <th>Auteur</th>
            </tr>";
      echo "</thead><tbody>";
      
      foreach ($news as $new) {
        echo "<tr>";
        echo "<td>" . $new["act_titre"] . "</td>";
        echo "<td>" . $new["act_texte"] . "</td>";
        echo "<td>" . $new["act_date"] . "</td>";
        echo "<td>" . $new["com_mail"] . "</td>";
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