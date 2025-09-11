<!DOCTYPE html>
<html>
<head>
 <title>Web[re]quest</title>
 <!-- Bootstrap -->
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/Progressus/assets/css/bootstrap.min.css">
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/Progressus/assets/css/bootstrap-theme.css" />
 <!-- Main css -->
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/Progressus/assets/css/main.css">
 <!-- font-awesome -->
 <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/Progressus/assets/css/font-awesome.min.css" />
 <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700"/>
</head>
<body class="home">
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top headroom">
      <div class="container">
        <div class="navbar-header">
          <!-- Button for smallest screens -->
          <button
            type="button"
            class="navbar-toggle"
            data-toggle="collapse"
            data-target=".navbar-collapse"
          >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>">Web[re]Quest</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
          <li><a href="<?php echo base_url('index.php/scenario/afficher'); ?>">Scénarios</a></li>
          <a href="<?= base_url('index.php/compte/connecter'); ?>" class="btn btn-default btn-lg" role="button">Se connecter</a>
          </ul>
        </div>
      </div>
    </div>