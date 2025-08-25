<header id="head" class="secondary"></header>
<div class="container">
    <div class="row">
        <header class="page-header">
            <h1 class="page-title text-center">Se connecter</h1>
        </header>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= esc($error) ?>
                    </div>
                    <?php endif; ?>
                    <?= session()->getFlashdata('error') ?>
                    <?php echo form_open('/compte/connecter', ['class' => 'needs-validation', 'novalidate' => true]); ?>
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="mail" class="form-label">Mail :</label>
                        <input type="email" class="form-control" name="mail" value="<?= set_value('mail') ?>" required>
                      
                    </div>
                    
                    <div class="form-group">
                        <label for="mdp" class="form-label">Mot de passe :</label>
                        <input type="password" class="form-control" name="mdp" required>
                     
                    </div>
                    
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>