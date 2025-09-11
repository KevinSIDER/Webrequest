<div id='content-wrapper' class='d-flex flex-column'>
    <div id='content'>
        <div class='container-fluid'>
            <br>
            <h2 class='font-weight-bold text-center'>Gestion des scénarios</h2>
            <br>
            <div class="text-center">
                 <a href="<?= base_url('index.php/scenario/creer') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Créer un scénario</a>
            </div>
            <br>

<?php
if (!empty($scenarios) && is_array($scenarios)) 
{
    echo "<div class='container'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>Illustration</th>";
    echo "<th>Titre</th>";
    echo "<th>Auteur</th>";
    echo "<th>Nombre d'étapes</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($scenarios as $scenario)
    {
        echo "<tr>";
        echo "<td>";
        if (!empty($scenario['sce_illustration'])) 
        {
            echo "<img src='" . base_url($scenario['sce_illustration']) . "' class='img-thumbnail' width='100' height='100' alt='" . $scenario['sce_titre'] . "'>";
        }
        echo "</td>";
        echo "<td>" . $scenario['sce_titre'] . "</td>";
        echo "<td>" . $scenario['com_mail'] . "</td>";
        echo "<td>" . ($scenario['nbr']->nbr_etapes == 0 ? 'Aucune étape pour ce scénario' : $scenario['nbr']->nbr_etapes) . "</td>";
        echo "<td>";
        echo "<a href='" . base_url('/index.php/scenario/visualiser/' . $scenario["sce_id"]) . "' class='btn btn-info btn-sm' title='Visualiser'><img src='" . base_url('images/icones/voir.png') . "' alt='Visualiser' style='width:16px; height:16px;'></a>";
        echo "<a href='" . base_url('/index.php/scenario/modifier/' . $scenario["sce_id"]) . "' class='btn btn-primary btn-sm' title='Modifier'><img src='" . base_url('images/icones/modifier.png') . "' alt='Modifier' style='width:16px; height:16px;'></a> ";
        if ($scenario['sce_etat'] == 1){
            echo "<a href='" . base_url('/index.php/scenario/changer_etat/' . $scenario["sce_id"]) . "/0' class='btn btn-warning btn-sm' title='Désactiver' onclick='return confirm(\"Êtes-vous sûr vouloir désactiver ce scénario ?\")'><img src='" . base_url('images/icones/desactiver.png') . "' alt='Désactiver' style='width:16px; height:16px;'></a> ";
        } 
        else if ($scenario['sce_etat'] == 0)
        {
            echo "<a href='" . base_url('/index.php/scenario/changer_etat/' . $scenario["sce_id"]) . "/1' class='btn btn-success btn-sm' title='Activer' onclick='return confirm(\"Êtes-vous sûr de vouloir activer ce scénario ?\")'><img src='" . base_url('images/icones/activer.png') . "' alt='Activer' style='width:16px; height:16px;'></a> ";
        }
        echo "<a href='" . base_url('index.php/scenario/supprimer/' . $scenario["sce_id"]) . "' class='btn btn-sm btn-danger' title='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce scénario ?\");'><img src='" . base_url('images/icones/supprimer.png') . "' alt='Supprimer' style='width:16px; height:16px;'></a>";
        echo "<a href='" . base_url('/index.php/scenario/remettre_a_zero/' . $scenario["sce_id"]) . "' class='btn btn-secondary btn-sm' title='Remettre à zéro'  onclick='return confirm(\"Êtes-vous sûr de vouloir remettre à zéro les participations pour ce scénario ?\");'><img src='" . base_url('images/icones/reinitialiser.png') . "' alt='Remettre à zéro' style='width:16px; height:16px;'></a>";
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} 
else 
{
    echo "<div class='container'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>Image</th>";
    echo "<th>Intitulé</th>";
    echo "<th>Auteur</th>";
    echo "<th>Nombre d'étapes</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td colspan='5' class='text-center'>Aucun scénario pour l'instant !</td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
}
?>

</div>
</div>
</div>
