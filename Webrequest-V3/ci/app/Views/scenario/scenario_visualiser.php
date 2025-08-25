<div id='content-wrapper' class='d-flex flex-column'>
    <div id='content'>
        <div class='container-fluid'>
            <br>
            <h2 class='font-weight-bold text-center'>Informations générales du scénario</h2>
            <br>

<?php
if (!empty($scenarios) && is_array($scenarios)) {
    echo "<div class='container'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>Illustration</th>";
    echo "<th>Code</th>";
    echo "<th>Titre</th>";
    echo "<th>Contenu</th>";
    echo "<th>Etat</th>";
    echo "<th>Auteur</th>";
    echo "<th>Nombre de reussites</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($scenarios as $scenario) {
        echo "<tr>";
        echo "<td>";
        if (!empty($scenario['sce_illustration'])) {
            echo "<img src='" . base_url($scenario['sce_illustration']) . "' class='img-thumbnail' width='100' height='100' alt='" . htmlspecialchars($scenario['sce_titre']) . "'>";
        }
        echo "</td>";
        echo "<td>" . htmlspecialchars($scenario['sce_code']) . "</td>";
        echo "<td>" . htmlspecialchars($scenario['sce_titre']) . "</td>";
        echo "<td>" . htmlspecialchars($scenario['sce_texte']) . "</td>";
        echo "<td>" . htmlspecialchars($scenario['sce_etat'] ? 'Activé' : 'Désactivé') . "</td>";
        echo "<td>" . htmlspecialchars($scenario['com_mail']) . "</td>";
        echo "<td>" . $nbrReussites->nb_reussite . "</td>";
        echo "</tr>";
        break;
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
    echo "<div class='container'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>Numéro</th>";
    echo "<th>Question</th>";
    echo "<th>Réponse</th>";
    echo "<th>Possède une ressource</th>";
    echo "<th>Possède un indice</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($scenarios as $scenario) 
    {
      if (!empty($scenario['eta_numero'])) 
      {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($scenario['eta_numero']) . "</td>";
          echo "<td>" . htmlspecialchars($scenario['eta_question']) . "</td>";
          echo "<td>" . htmlspecialchars($scenario['eta_reponse']) . "</td>";
          echo "<td>" . (!empty($scenario['res_id']) ? 'Oui' : 'Non') . "</td>";
          echo "<td>" . (!empty($scenario['ind_id']) ? 'Oui' : 'Non') . "</td>";
          echo "</tr>";
      } else {
          echo "<tr><td colspan='5' class='text-center'>Aucune étape disponible pour ce scénario.</td></tr>";
      }
  }  
    
    echo "</tbody>";
    echo "</table>";
    echo "<a href='". base_url('index.php/scenario/copier/'. $scenario['sce_id'])."' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Copier ce scénario</a>";
    echo "</div>";
   } else {
    echo "<div class='container'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>Illustration</th>";
    echo "<th>Code</th>";
    echo "<th>Titre</th>";
    echo "<th>Contenu</th>";
    echo "<th>Etat</th>";
    echo "<th>Auteur</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td colspan='6' class='text-center'>Ce scénario n'existe pas !</td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}
?>

        </div>
    </div>
</div>
