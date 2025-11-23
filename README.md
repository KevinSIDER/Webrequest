# Webrequest

- **Intitulé et sujet du projet** : Webrequest - Application web de quiz sur le thème du Football

## Description

Webrequest est une application web qui permet de participer à des **scénarios sur le thème du football**.

Chaque scénario est composé de plusieurs étapes comprenant des questions auxquelles il faut répondre. Des indices et des ressources peuvent parfois être proposés pour aider ou illustrer la question.

Un système d’actualités récentes permet d’afficher sur la page d’accueil les nouveautés, comme par exemple un scénario en vogue ayant beaucoup de participations ou un scénario venant d’être publié ou rendu inaccessible.

L’application Webrequest peut être gérée de manière **CRUD** par les administrateurs/organisateurs. Néanmoins, certaines actions sont restreintes, par exemple un organisateur ne pourra pas supprimer les actualités qui ne sont pas les siennes.

## Interface Utilisateur

Capture d’écran de la page affichant l'intégralité des scénarios :

![Illustration de la liste des scénarios](https://github.com/KevinSIDER/Webrequest/raw/918c8164ed238a6abe0594c9f61d7d4e39801828/Illustration_liste_scenarios.JPG)

Capture d’écran de la page affichant une étape d'un scénario :

![Illustration etape d'un scénario](https://github.com/KevinSIDER/Webrequest/blob/918c8164ed238a6abe0594c9f61d7d4e39801828/Illustration_etape_scenario.JPG)

Capture d'écran de la page d'accueil d'un administrateur dont le compte est activé :

![Illustration page d'accueil admin](https://github.com/KevinSIDER/Webrequest/blob/918c8164ed238a6abe0594c9f61d7d4e39801828/Illustration_profil_admin.JPG)



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

## Sauvegardes et versions

Le projet Webrequest a été **sauvegardé, versionné et documenté** de manière progressive :  

Le projet était stocké sur **deux serveurs de la faculté** et versionné sur le **GitLab de la faculté** également.  

Le projet a été versionné et stocké de manière progressive, avec des versions telles que **V1, V1.1, V2, V2.2**, etc., permettant de **revenir en arrière en cas de problème** si nécessaire.
