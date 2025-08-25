# Web[RE]Quest

- **Intitulé et sujet du projet** : Web[RE]Quest - Application web de quiz sur le thème du Football

## Description

Webrequest est une application web qui permet de participer à des **scénarios sur le thème du football**.

Chaque scénario est composé de plusieurs étapes comprenant des questions auxquelles il faut répondre. Des indices et des ressources peuvent parfois être proposés pour aider ou illustrer la question.

Un système d’actualités récentes permet d’afficher sur la page d’accueil les nouveautés, comme par exemple un scénario en vogue ayant beaucoup de participations ou un scénario venant d’être publié ou rendu inaccessible.

L’application Webrequest peut être gérée de manière **CRUD** par les administrateurs/organisateurs. Néanmoins, certaines actions sont restreintes, par exemple un organisateur ne pourra pas supprimer les actualités qui ne sont pas les siennes.

## Template Bootstrap utilisé

- **Admin** : [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2)  
- **Utilisateur** : [Progressus](https://www.gettemplate.com/info/progressus/?source=codeur-com-blog&utm_source=codeur-com-blog)

## Architecture

- **Backend** : PHP 8.2 avec CodeIgniter 4.5  
- **Base de données** : MariaDB 10.11  
- **Frontend** : HTML5, CSS3, JavaScript, Bootstrap 5

## Contenu du dépôt

Ce dépôt contient trois dossiers :

- **Export DB** : Contient l’export de la base de données utilisée, comprenant un jeu d’essai complet.  
- **Modélisations** : Contient le diagramme UML de classes de la base de données de Webrequest ainsi qu’un modèle logique des données.  
- **Webrequest-V3** : La troisième et dernière version de Webrequest, développée avec le framework CodeIgniter.  

### À propos de la V3

La version 3 a été retenue comme version finale car nous avons souvent changé de version au cours du développement.  
Ces changements successifs nous ont permis de :  
- conserver des sauvegardes régulières,  
- revenir en arrière facilement si nécessaire,  
- préparer des démonstrations et tester différentes fonctionnalités sans risque de perte de données.
