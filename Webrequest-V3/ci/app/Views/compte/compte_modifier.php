<?php

$session = session();

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<h2 class='font-weight-bold text-center'>Modifier mon profil</h2>";
echo session()->getFlashdata('error');

echo form_open_multipart('/compte/modifier', ['class' => 'w-50 mx-auto']); ?>
<?= csrf_field() ?>

<br />

<div class="form-group">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" class="form-control" value="<?= isset($profil->pro_nom) ? esc($profil->pro_nom) : '' ?>">
    <small class="text-danger"><?= validation_show_error('nom') ?></small>
</div>

<div class="form-group">
    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" class="form-control" value="<?= isset($profil->pro_prenom) ? esc($profil->pro_prenom) : '' ?>">
    <small class="text-danger"><?= validation_show_error('prenom') ?></small>
</div>

<div class="form-group">
    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" class="form-control">
    <small class="text-danger"><?= validation_show_error('mdp') ?></small>
</div>

<div class="form-group">
    <label for="mdp_confirm">Confirmation du mot de passe :</label>
    <input type="password" name="mdp_confirm" class="form-control">
    <small class="text-danger"><?= validation_show_error('mdp_confirm') ?></small>
</div>

<div class="form-group">
    <label for="fichier">Image pour le profil :</label>
    <input type="file" name="fichier" class="form-control-file">
</div>

<br />

<div class="form-group d-flex justify-content-between">
    <a href="<?= base_url('index.php/compte/afficher_profil') ?>" class="btn btn-primary">Annuler</a>
    <input type="submit" name="submit" value="Valider" class="btn btn-success">
</div>

</form>
</div>
</div>
</div>
