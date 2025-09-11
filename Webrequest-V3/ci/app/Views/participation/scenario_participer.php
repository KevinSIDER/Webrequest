<header id="head" class="secondary"></header>
	<div class="container">
		<div class="row">
            <header class="page-header">
                <h1 class="page-title text-center">Participer à un scénario</h1>
            </header>
        </div>
    </div>

<?php

echo "<div id='content-wrapper' class='d-flex flex-column'>";
echo "<div id='content'>";
echo "<div class='container-fluid'>";
echo "<br>";
echo "<div class='container'>";
echo "<div class='row justify-content-center'>";
echo "<div class='col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2'>";
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";

echo form_open("/scenario/participer/{$id}");
?>

    <?= csrf_field() ?>
    <?php if (session()->getFlashdata('error')): ?>
    <p class='text-center alert alert-danger'><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <div class="form-group">
        <label for="code">Code du scénario :</label>
        <input type="text" name="code" class="form-control">
        <?= validation_show_error('code') ?>
    </div>
    <div class="form-group">
        <label for="mail">E-mail :</label>
        <input type="email" name="mail" class="form-control">
        <?= validation_show_error('mail') ?>
    </div>
    <button type="submit" class="btn btn-primary">Participer</button>
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>