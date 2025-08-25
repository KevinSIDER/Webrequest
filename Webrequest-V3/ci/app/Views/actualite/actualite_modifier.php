<?php

$session = session();

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<h2 class='font-weight-bold text-center'>Modifier une actualité</h2>";
echo session()->getFlashdata('error');

// Formulaire
echo form_open('/actualite/modifier/' . $new->act_id, ['class' => 'w-50 mx-auto']); ?>
<?= csrf_field() ?>

<br />
<div class="form-group">
    <label for="titre">Titre :</label>
    <input type="texte" name="titre" value="<?= isset($new->act_titre) ? esc($new->act_titre) : '' ?>" class="form-control">
    <small class="text-danger"><?= validation_show_error('titre') ?></small>
</div>

<div class="form-group">
    <label for="texte">Contenu :</label>
    <textarea name="texte" class="form-control" rows="4"><?= isset($new->act_texte) ? esc($new->act_texte) : '' ?></textarea>
    <small class="text-danger"><?= validation_show_error('texte') ?></small>
</div>

<div class="form-group">
    <label for="etat">État :</label>
    <select name="etat" class="form-control">
        <option value="1" <?= set_select('etat', '1', (isset($new->act_etat) && $new->act_etat == '1')) ?>>Activé</option>
        <option value="0" <?= set_select('etat', '0', (isset($new->act_etat) && $new->act_etat == '0')) ?>>Désactivé</option>
    </select>
    <small class="text-danger"><?= validation_show_error('etat') ?></small>
</div>

<div class="form-group">
   <label>Publié par :</label>
   <input class="form-control" value="<?= $session->get('user') ?>" disabled>
</div>

<br />
<div class="form-group d-flex justify-content-between">
  <a href="<?= base_url('index.php/actualite/lister') ?>" class="btn btn-primary">Annuler</a>
  <input type="submit" name="submit" value="Modifier" class="btn btn-success">
</div>

<?php

echo "</div>";
echo "</div>";
echo "</div>";

?>
