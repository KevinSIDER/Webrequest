<div id='content-wrapper' class='d-flex flex-column'>
    <div id='content'>
        <div class='container-fluid'>
            <br>
            <h2 class='font-weight-bold text-center'>Mon profil</h2>

            <?php
            $session = session();
            ?>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <div class="container-fluid">
                        <br>

                        <div class="p-3"> 
                        <a href="<?= base_url('index.php/compte/modifier') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Modifier</a>
                        <br/>
                        <br/>
                            <table class="table table-bordered table-striped"> 
                                <tbody>
                                    <tr>
                                        <td><strong>Nom</strong></td>
                                        <td><?= $profil->pro_nom ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Prénom</strong></td>
                                        <td><?= $profil->pro_prenom ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rôle</strong></td>
                                        <td><?= $profil->pro_role == 'A' ? 'Administrateur' : 'Organisateur' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>État</strong></td>
                                        <td><?= $profil->pro_etat == 1 ? 'Activé' : 'Désactivé' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mail</strong></td>
                                        <td><?= $profil->com_mail ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date de création</strong></td>
                                        <td><?= $profil->pro_date_creation ?></td>
                                    </tr>
                                    <?php if (!empty($profil->pro_chemin)) { ?>
                                        <tr>
                                            <td><strong>Image de profil</strong></td>
                                            <td>
                                                <img src="<?= base_url($profil->pro_chemin); ?>" class="img-fluid mb-3" style="max-width: 100px; border-radius: 100px;" alt="<?= $profil->pro_chemin; ?>">
                                            </td>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
