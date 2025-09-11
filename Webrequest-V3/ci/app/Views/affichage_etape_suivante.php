<header id="head" class="secondary"></header>
<div class="container">
    <div class="row">
        <header class="page-header"></header>
    </div>
</div>

<?php

if (isset($etape)) {
    echo "<div class='container'>";
    echo "<div class='row'>";
        
        echo "<div class='col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2'>";
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-body'>";

        if (isset($error)){
            echo "<div class='alert alert-danger'>";
            echo esc($error);
            echo "</div>";
        }

        if (!empty($etape->res_chemin)) {
            echo "<img src='" . base_url($etape->res_chemin) . "' class='img-fluid mb-3' alt='" . $etape->res_text_alt . "'>";
        }

        echo "<h3 class='card-title'>Étape " . $etape->eta_numero . "</h3>";
        echo "<h4 class='card-text'>" . $etape->eta_question . "</h4>";
        
        if (!empty($etape->ind_texte) || !empty($etape->ind_url))
        {
            echo "<br />";
            echo "<p class='mt-3'><strong>Indice :</strong> ";
            echo $etape->ind_texte;
            echo " <a href='" . $etape->ind_url . "' target='_BLANCK'>💡</a>";
            echo "</p>";
        }

        echo form_open("/etape/afficher_suivante/{$sce_code}/{$eta_code}");
        echo csrf_field();
        echo '<div class="form-group">';
        echo '<label for="code">Votre réponse :</label>';
        echo '<input type="text" name="reponse" class="form-control">';
        echo validation_show_error('reponse');
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Valider</button>';
        
    

        echo "</div>";
        echo "</div>";
        echo "</div>"; 
    echo "</div>"; 
    echo "</div>"; 
    
} else {
    echo "<h3>Aucune étape pour l'instant !</h3>";
}
?>
