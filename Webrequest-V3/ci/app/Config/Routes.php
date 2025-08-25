<?php

// use 

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Accueil;
use App\Controllers\Compte;
use App\Controllers\Actualite;
use App\Controllers\Scenario;
use App\Controllers\Etape;

/**
 * @var RouteCollection $routes
 */

// Routes de type get

$routes->get('/', [Accueil::class, 'afficher']);

$routes->get('/compte/accueil', [Compte::class, 'accueil']);

$routes->get('compte/lister', [Compte::class, 'lister']);

$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);

$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']); 

$routes->get('scenario/afficher', [Scenario::class, 'afficher']);

$routes->get('scenario/lister', [Scenario::class, 'lister']);

$routes->get('scenario/visualiser/(:num)', [Scenario::class, 'visualiser']);
$routes->get('scenario/visualiser/', [Scenario::class, 'lister']);

$routes->get('scenario/quiz_termine', [Scenario::class, 'quiz_termine']);

$routes->get('actualite/lister', [Actualite::class, 'lister']);

$routes->get('scenario/fin/(:any)/(:any)', [Scenario::class, 'fin']);
$routes->get('scenario/fin/(:any)', [Scenario::class, 'participer']);
$routes->get('scenario/fin/', [Scenario::class, 'participer']);

$routes->get('actualite/supprimer/(:num)', [Actualite::class, 'supprimer']);
$routes->get('actualite/supprimer/', [Actualite::class, 'lister']);

$routes->get('scenario/supprimer/(:num)', [Scenario::class, 'supprimer']);
$routes->get('scenario/supprimer/', [Scenario::class, 'lister']);

$routes->get('scenario/changer_etat/(:num)/(:num)', [Scenario::class, 'changer_etat']);
$routes->get('scenario/changer_etat/(:num)/', [Scenario::class, 'lister']);
$routes->get('scenario/changer_etat/', [Scenario::class, 'lister']);

$routes->get('scenario/remettre_a_zero/(:num)', [Scenario::class, 'remettre_a_zero']);
$routes->get('scenario/remettre_a_zero/', [Scenario::class, 'lister']);

$routes->get('scenario/copier/(:num)', [Scenario::class, 'copier']);
$routes->get('scenario/copier/', [Scenario::class, 'lister']);

// Routes de type match (get/post)

$routes->match(["get","post"], 'compte/modifier', [Compte::class, 'modifier']);

$routes->match(["get","post"],'compte/connecter', [Compte::class, 'connecter']);

$routes->match(["get","post"],'compte/creer', [Compte::class, 'creer']);

$routes->match(["get","post"], 'actualite/publier', [Actualite::class, 'publier']);

$routes->match(["get","post"],'actualite/modifier/(:num)', [Actualite::class, 'modifier']);
$routes->match(["get","post"],'actualite/modifier/', [Actualite::class, 'lister']);

$routes->match(["get","post"], 'etape/afficher/(:any)/(:any)', [Etape::class, 'afficher']);
$routes->match(["get","post"], 'etape/afficher/(:any)', [Scenario::class, 'participer']);
$routes->match(["get","post"], 'etape/afficher/', [Scenario::class, 'participer']);

$routes->match(["get","post"], 'etape/afficher_suivante/(:any)/(:any)', [Etape::class, 'afficher_suivante']);
$routes->match(["get","post"], 'etape/afficher_suivante/(:any)', [Scenario::class, 'participer']);
$routes->match(["get","post"], 'etape/afficher_suivante/', [Scenario::class, 'participer']);

$routes->match(["get","post"],'scenario/participer/(:num)', [Scenario::class, 'participer']);
$routes->match(["get","post"],'scenario/participer/', [Scenario::class, 'participer']);

$routes->match(["get","post"],'scenario/creer', [Scenario::class, 'creer']);

$routes->match(["get","post"],'scenario/modifier/(:num)', [Scenario::class, 'modifier']);
$routes->match(["get","post"],'scenario/modifier/', [Scenario::class, 'lister']);