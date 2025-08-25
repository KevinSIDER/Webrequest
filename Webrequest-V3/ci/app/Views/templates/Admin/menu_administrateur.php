<!DOCTYPE html>
<html>
<head>
 <title>Web[re]quest</title>
 <!-- Bootstrap -->
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap2/startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.css">
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap2/startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href=" <?php echo base_url(); ?>index.php/compte/accueil">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Web[re]quest <sup>Admin</sup></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href=" <?php echo base_url() ?>index.php/compte/afficher_profil">
                    <span>Profil</span>
                </a>

                <?php 
                $session = session();

                if ($session->get('role') === 'A')
                {
                    echo "<a class='nav-link' href='" . base_url() . "index.php/compte/lister'>";
                    echo "<span>Comptes</span>";
                    echo "</a>";
                }
                ?>
                <a class="nav-link" href=" <?php echo base_url() ?>index.php/actualite/lister">
                    <span>Actualités</span>
                </a>
                <?php 
                if ($session->get('role') === 'O')
                {
                    echo "<a class='nav-link' href='" . base_url() . "index.php/scenario/lister'>";
                    echo "<span>Scénarios</span>";
                    echo "</a>";
                }
                ?>
                <a class="nav-link" href=" <?php echo base_url() ?>index.php/compte/deconnecter">
                    <span class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Déconnexion</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->