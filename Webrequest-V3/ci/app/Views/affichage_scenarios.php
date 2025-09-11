<header id="head" class="secondary"></header>
<div class="container">
    <div class="row">
        <header class="page-header">
            <h1 class="page-title text-center">Scénarios disponibles</h1>
        </header>
    </div>
</div>

<?php
if (!empty($scenarios) && is_array($scenarios)) 
{
    echo '<section id="gallery">';
    echo '<div class="container">';
    echo '<div class="row">';

    foreach ($scenarios as $scenario)
    {
        echo '<div class="col-lg-4 mb-4">';
        echo '<div class="card">';
        
        if (!empty($scenario['sce_illustration'])) 
        {
            echo "<img src='" . base_url($scenario['sce_illustration']) . "' class='img-fluid mb-3 card-img' alt='" . $scenario['sce_titre'] . "'>";
        }

        echo '<div class="card-body">';
        if ($scenario["nbr"]->nbr_etapes == 0){
            echo "<a class='d-none d-sm-inline-block btn btn-sm btn-primary text-center' style='display: block; width: 100%; pointer-events: none;'>Bientôt disponible !</a>";
            echo "<a>";
        }
        else {
            echo "<a href='" . base_url("index.php/scenario/participer/{$scenario['sce_id']}") . "'>";
        }
        echo "<h3 class='card-title text-center  page-title'>" . $scenario["sce_titre"] . "</h3>";
        echo "</a>"; 
        echo "<p class='card-text .texte'>" . $scenario["sce_texte"] . "</p>";
        echo "<p class='list-group-item'>Auteur : " . $scenario["com_mail"] . "</p>";
        echo "<p class='list-group-item'>Nombre d'étapes : " . $scenario["nbr"]->nbr_etapes . "</p>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    echo '</section>';
} 
else 
{
    echo "<div class='container'><h3 class='text-center'>Aucun scénario pour l'instant !</h3></div>";
}
?>
