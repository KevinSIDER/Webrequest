<header id="head" class="secondary"></header>
	<div class="container">
		<div class="row">
            <header class="page-header">
                <h1 class="page-title text-center">Actualité spécifique</h1>
            </header>
        </div>
    </div>
    <div class='container'>
    <div class='row'>

<?php

// Vérifie si la variable $scenarios est non vide et est bien un tableau
if (isset($news)) 
{
    echo $news->act_id;
    echo(" -- ");
    echo $news->act_titre;
    echo(" -- ");
    echo $news->act_date;   
} else {
    echo "<h3>OUPS ! L'actualité souhaitée n'est pas disponible !</h3>";
}
?>

</div>
</div>