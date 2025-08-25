<?php
date_default_timezone_set('Europe/Paris');
$success_date = date('Y-m-d H:i:s'); 
?>

<header id="head" class="secondary"></header>
<div class="container">
    <div class="row">
        <header class="page-header text-center">
            <h1 class="page-title text-center">Félicitations !</h1>
        </header>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body flex-grow-1">
                    <h4 class="text-center panel-success">
                        Félicitations ! Vous avez terminé ce scénario avec succès.
                    </h4>
                    <br/>
                    <p class="text-center">
                        <strong>Date et Heure de Réussite :</strong> <?php echo $success_date; ?>
                    </p>
                    <div class="text-center mt-auto">
                        <a href="<?php echo base_url('index.php/scenario/afficher'); ?>" class="btn btn-primary">
                            Retourner à la liste des scénarios
                        </a>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>