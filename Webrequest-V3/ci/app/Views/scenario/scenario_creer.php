<?php

$session = session();

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<h2 class='font-weight-bold text-center'>Créer un scénario</h2>";
echo session()->getFlashdata('error');

// Formulaire
echo form_open_multipart('/scenario/creer', ['class' => 'w-50 mx-auto']); ?>
<?= csrf_field() ?>

<br />
<div class="form-group">
    <label for="titre">Titre :</label>
    <input type="texte" name="titre" class="form-control">
    <small class="text-danger"><?= validation_show_error('titre') ?></small>
</div>

<div class="form-group">
    <label for="texte">Description :</label>
    <textarea name="texte" class="form-control" rows="4"></textarea>
    <small class="text-danger"><?= validation_show_error('texte') ?></small>
</div>

<div class="form-group">
   <label>Publié par :</label>
   <input class="form-control" value="<?= $session->get('user') ?>" disabled>
</div>

<div class="form-group">
    <label for="etat">État :</label>
    <select name="etat" class="form-control">
        <option value="1" <?= set_select('etat', '1') ?>>Activé</option>
        <option value="0" <?= set_select('etat', '0') ?>>Désactivé</option>
    </select>
    <small class="text-danger"><?= validation_show_error('etat') ?></small>
</div>

<div class="form-group">
    <label for="fichier">Illustration :</label>
    <input type="file" name="fichier" class="form-control-file">
</div>

<br />
<div class="form-group text-center">
    <input type="submit" name="submit" value="Créer un nouveau scénario" class="btn btn-success">
</div>

<?php

echo "</div>";
echo "</div>";
echo "</div>";

?>
