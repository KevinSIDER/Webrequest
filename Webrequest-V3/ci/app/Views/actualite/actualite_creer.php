<?php

$session = session();

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<h2 class='font-weight-bold text-center'>Créer une actualité</h2>";
echo session()->getFlashdata('error');

// Formulaire
echo form_open('/actualite/publier', ['class' => 'w-50 mx-auto']); ?>
<?= csrf_field() ?>

<br />
<div class="form-group">
    <label for="titre">Titre :</label>
    <input type="texte" name="titre" class="form-control">
    <small class="text-danger"><?= validation_show_error('titre') ?></small>
</div>

<div class="form-group">
    <label for="texte">Contenu :</label>
    <textarea name="texte" class="form-control" rows="4"></textarea>
    <small class="text-danger"><?= validation_show_error('texte') ?></small>
</div>

<div class="form-group">
   <label>Publié par :</label>
   <input class="form-control" value="<?= $session->get('user') ?>" disabled>
</div>

<div class="form-group">
   <label>à la date suivante :</label>
   <input class="form-control" value="<?= date('Y-m-d') ?>" disabled>
</div>
<br />
<div class="form-group text-center">
    <input type="submit" name="submit" value="Créer une nouvelle actualité" class="btn btn-success">
</div>

<?php

echo "</div>";
echo "</div>";
echo "</div>";

?>
