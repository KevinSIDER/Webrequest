<?php

$session = session();

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<h2 class='font-weight-bold text-center'>Créer un compte</h2>";
echo session()->getFlashdata('error');

// Formulaire
echo form_open_multipart('/compte/creer', ['class' => 'w-50 mx-auto']); ?>
<?= csrf_field() ?>

<br />
<div class="form-group">
    <label for="pseudo">E-mail :</label>
    <input type="email" name="pseudo" class="form-control" value="<?= set_value('pseudo') ?>">
    <small class="text-danger"><?= validation_show_error('pseudo') ?></small>
</div>

<div class="form-group">
    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" class="form-control">
    <small class="text-danger"><?= validation_show_error('mdp') ?></small>
</div>

<div class="form-group">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" class="form-control" value="<?= set_value('nom') ?>">
    <small class="text-danger"><?= validation_show_error('nom') ?></small>
</div>

<div class="form-group">
    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" class="form-control" value="<?= set_value('prenom') ?>">
    <small class="text-danger"><?= validation_show_error('prenom') ?></small>
</div>

<div class="form-group">
    <label for="role">Rôle :</label>
    <select name="role" class="form-control">
        <option value="A" <?= set_select('role', 'A') ?>>Administrateur</option>
        <option value="O" <?= set_select('role', 'O') ?>>Organisateur</option>
    </select>
    <small class="text-danger"><?= validation_show_error('role') ?></small>
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
    <label for="fichier">Image de profil :</label>
    <input type="file" name="fichier" class="form-control-file">
</div>

<div class="form-group text-center">
    <input type="submit" name="submit" value="Créer un nouveau compte" class="btn btn-success">
</div>

<?php

echo "</div>";
echo "</div>";
echo "</div>";

?>
