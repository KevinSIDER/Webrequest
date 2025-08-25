-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 03 avr. 2025 à 20:09
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1-log
-- Version de PHP : 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e00000000_db1`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`e00000000sql`@`%` PROCEDURE `update_actualite` (IN `titre` VARCHAR(255), IN `texte` TEXT, IN `etat` ENUM('0','1'), IN `id` INT)   BEGIN
    UPDATE t_actualite_act
    SET act_titre = titre,
        act_texte = texte,
        act_etat = etat
    WHERE act_id = id;
END$$

--
-- Fonctions
--
CREATE DEFINER=`e00000000sql`@`%` FUNCTION `donner_nb_reussite` (`p_sce_id` INT) RETURNS VARCHAR(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE Nb_reussites INT DEFAULT 0;
    DECLARE Nb_participants INT DEFAULT 0;
    
    SELECT COUNT(*) INTO Nb_participants
    FROM t_participation_pct
    WHERE sce_id = p_sce_id;
    
    SELECT COUNT(*) INTO Nb_reussites
    FROM t_participation_pct
    WHERE sce_id = p_sce_id
    AND pct_date_premiere_reussite IS NOT NULL;
    
    RETURN CONCAT(Nb_reussites, ' / ', Nb_participants);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `get_all_comptes`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `get_all_comptes` (
`com_mail` varchar(200)
,`pro_nom` varchar(80)
,`pro_prenom` varchar(80)
,`pro_etat` char(1)
,`pro_role` enum('A','O')
,`pro_date_creation` date
,`pro_chemin` varchar(300)
,`com_mdp` char(64)
);

-- --------------------------------------------------------

--
-- Structure de la table `t_actualite_act`
--

CREATE TABLE `t_actualite_act` (
  `act_id` int(11) NOT NULL,
  `act_titre` varchar(200) NOT NULL,
  `act_texte` text DEFAULT NULL,
  `act_date` datetime NOT NULL,
  `act_etat` char(1) NOT NULL,
  `com_mail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_actualite_act`
--

INSERT INTO `t_actualite_act` (`act_id`, `act_titre`, `act_texte`, `act_date`, `act_etat`, `com_mail`) VALUES
(1, 'Nouveau scénario !', 'Le scénario \" Les règles du football \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-02-02 20:45:50', '1', 'administrATeur@webquest.fr'),
(2, 'Nouveau scénario !', 'Le scénario \" Paris Saint-Germain \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-03-07 15:24:47', '1', 'gplassart@webquest.fr'),
(3, 'Nouveau scénario !', 'Le scénario \" Désiré Doué \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-03-07 14:26:05', '1', 'administrATeur@webquest.fr'),
(4, 'Nouveau scénario !', 'Le scénario \" LOSC Lille \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-03-07 15:27:50', '1', 'administrATeur@webquest.fr'),
(5, 'Nouveau scénario !', 'Le scénario \" Bradley BARCOLA \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-03-09 18:18:03', '1', 'administrATeur@webquest.fr'),
(6, 'Nouveau scénario !', 'Le scénario \" Olympique lyonnais \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-03-26 15:28:29', '1', 'eoliveira@webquest.fr'),
(7, 'Nouveau scénario !', 'Le scénario \" Qui est ce joueur de l\EDF ? \" est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !', '2025-04-01 10:38:09', '1', 'administrATeur@webquest.fr'),
(8, 'Ce scénario est populaire en ce moment !', 'Le scénario Les règles du football est populaire en ce moment ! Venez approfondir vos connaissances !', '2025-04-02 16:34:31', '1', 'administrATeur@webquest.fr'),
(11, 'Scénario Qui est ce joueur de l\EDF ? inaccessible !', 'Ce scénario sera inaccessible pendant une durée indéterminée. Merci pour votre compréhension.', '2025-04-03 15:07:57', '1', 'administrATeur@webquest.fr');

-- --------------------------------------------------------

--
-- Structure de la table `t_compte_com`
--

CREATE TABLE `t_compte_com` (
  `com_mail` varchar(200) NOT NULL,
  `com_mdp` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_compte_com`
--

INSERT INTO `t_compte_com` (`com_mail`, `com_mdp`) VALUES
('administrATeur@webquest.fr', '46b3dcad7728e45b9556ed712dad5cfeb4b80eac65c48384f1bf4dada17dfc08'),
('eoliveira@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830'),
('ethanfournier@webquest.fr', 'd756fd0869c7868ea4a829f41c5a695c0060c36d690d68b734cdfb6c1181ffac'),
('flecoq@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830'),
('gplassart@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830'),
('lhernandez@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830'),
('mmerrer@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830'),
('organisATeur@webquest.fr', 'bb9f477c547e4af63490ffd35bfcc5db52e1a706ed4d78d71daa70875056d830');

-- --------------------------------------------------------

--
-- Structure de la table `t_etape_eta`
--

CREATE TABLE `t_etape_eta` (
  `eta_id` int(11) NOT NULL,
  `eta_code` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `eta_numero` int(11) NOT NULL,
  `eta_question` varchar(100) NOT NULL,
  `eta_reponse` varchar(50) NOT NULL,
  `eta_etat` char(1) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `sce_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_etape_eta`
--

INSERT INTO `t_etape_eta` (`eta_id`, `eta_code`, `eta_numero`, `eta_question`, `eta_reponse`, `eta_etat`, `res_id`, `sce_id`) VALUES
(1, 'Fs5RjU90', 2, 'Combien de joueurs une équipe doit-elle avoir sur le terrain pour commencer un match officiel ?', '11', '1', NULL, 1),
(2, '0kZXjQ89', 1, 'Quelle couleur de carton signifie une expulsion directe ?', 'Rouge', '1', 1, 1),
(3, '0r9Nt62P', 3, 'Quelle est la durée réglementaire d’un match de football (hors prolongations) ?', '90', '1', 2, 1),
(4, 'a1B2c3D4', 1, 'Dans quel championnat joue le Paris Saint-Germain', 'Ligue 1', '1', 5, 2),
(5, 'e5F6G7h8', 2, 'Quel joueur du Paris Saint-Germain est actuellement meilleur buteur de ligue 1 ? (Nom)', 'Dembélé', '1', NULL, 2),
(6, 'Ax2RjU40', 1, 'Quel numéro porte Désiré DOUÉ au PSG ?', '14', '1', 7, 5),
(8, 'Fo5RjI76', 2, 'Par quel centre de formation est passé le natif d\Angers ?', 'Stade-rennais', '1', NULL, 5),
(9, 'Qz1RjU78', 1, 'Quel est le principal rival du LOSC ?', 'Lens', '1', NULL, 7),
(10, 'Pq1RpU54', 2, 'Quelle est la couleur principale du maillot domicile ?', 'Rouge', '1', NULL, 7),
(11, 'Az9RwU54', 1, 'Bradley BARCOLA est-il Footballeur international ?', 'Oui', '1', NULL, 8),
(18, 'Xy1Z3aA4', 3, 'Quel est le stade où joue le Paris Saint-Germain ?', 'Parc des Princes', '1', 6, 2),
(19, 'Jk2L3mN4', 4, 'Quelle année le PSG a-t-il été fondé ?', '1970', '1', NULL, 2),
(20, 'N5o6P7q8', 5, 'Combien de Ligue 1 le PSG a-t-il remporté avant 2025 ?', '11', '1', NULL, 2),
(21, 'Rr1S2tU3', 6, 'Quelle est la couleur principale du maillot du PSG ?', 'Bleu', '1', 7, 2),
(22, 'L9m8N7o6', 7, 'Quelle équipe le PSG a battu en 8ème de finale de la Ligue des Champions ?', 'Liverpool', '1', NULL, 2),
(23, 'Pq9Qr8St', 3, 'Quelle est la valeur marchande estimée de Désiré Doué le 24 mars 2025 ?', '60', '1', NULL, 5),
(24, 'Ab3Cd4Ef', 4, 'En quelle année Désiré Doué a-t-il rejoint le PSG ?', '2024', '1', NULL, 5),
(25, 'Gh7Ij9Kl', 5, 'Quelle est la position principale de Désiré Doué ?', 'Ailier gauche', '1', NULL, 5),
(26, 'Hj1Kk2L3', 2, 'Quel est le club formateur de Bradley Barcola ?', 'Olympique Lyonnais', '1', 8, 8),
(27, 'Mn4Op5Q6', 3, 'Quel est le poste principal de Bradley Barcola ?', 'Ailier gauche', '1', 9, 8),
(28, 'Rs7Tu8V9', 4, 'En quelle année Bradley Barcola a-t-il signé son premier contrat professionnel ?', '2021', '1', NULL, 8),
(29, 'Bc3Dd4Ee', 5, 'Quel numéro de maillot porte Bradley Barcola au PSG ?', '29', '1', NULL, 8),
(30, 'Ab1Cd2Ef', 3, 'Quel est le nom du stade du LOSC ?', 'Stade Pierre-Mauroy', '1', 10, 7),
(31, 'Gh3Ij4Kl', 4, 'En quelle année le LOSC a-t-il remporté son dernier titre de Ligue 1 ?', '2021', '1', NULL, 7),
(32, 'Mn5Op6Qr', 5, 'Qui est l\entraîneur actuel du LOSC ?', 'Bruno Génésio', '1', NULL, 7);

-- --------------------------------------------------------

--
-- Structure de la table `t_indice_ind`
--

CREATE TABLE `t_indice_ind` (
  `ind_id` int(11) NOT NULL,
  `ind_texte` varchar(300) DEFAULT NULL,
  `ind_url` varchar(300) DEFAULT NULL,
  `eta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_indice_ind`
--

INSERT INTO `t_indice_ind` (`ind_id`, `ind_texte`, `ind_url`, `eta_id`) VALUES
(1, 'Peut-être que ce lien pourrait vous aider !', 'https://fr.wikipedia.org/wiki/Football', 1),
(2, NULL, 'https://fr.wikipedia.org/wiki/Carton_rouge', 2),
(3, NULL, NULL, 3),
(4, 'Ceci pourrait vous aider !', 'https://www.lequipe.fr/Football/ligue-1/page-classement-individuel/buteurs', 5),
(5, NULL, 'https://www.transfermarkt.fr/desire-doue/rueckennummern/spieler/914562#:~:text=%2314%20D%C3%A9sir%C3%A9%20Dou%C3%A9&text=Cette%20statistique%20montre%20quels%20num%C3%A9ros,sa%20carri%C3%A8re%20en%20%C3%A9quipe%20nationale.', 6),
(6, NULL, 'https://fr.wikipedia.org/wiki/Paris_Saint-Germain_Football_Club', 19),
(7, 'Ce lien pourrait t\aider !', 'https://www.transfermarkt.fr/desire-doue/marktwertverlauf/spieler/914562', 23),
(9, NULL, 'https://g.co/kgs/vUoCPtx', 9);

-- --------------------------------------------------------

--
-- Structure de la table `t_participant_par`
--

CREATE TABLE `t_participant_par` (
  `par_id` int(11) NOT NULL,
  `par_mail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_participant_par`
--

INSERT INTO `t_participant_par` (`par_id`, `par_mail`) VALUES
(1, 'jean.dupont@gmail.com'),
(2, 'marie.rouge@gmail.com'),
(3, 'paul.legrand@gmail.com'),
(4, 'lucie.martin@gmail.com'),
(5, 'pierre.durand@gmail.com'),
(6, 'emily.jones@gmail.com'),
(7, 'david.smith@gmail.com'),
(8, 'sophie.brown@gmail.com'),
(9, 'julien.toussaint@gmail.com'),
(12, 'claire.benjamin@gmail.com'),
(13, 'benjamin.leclerc@gmail.com'),
(14, 'fandupsg@gmail.com'),
(15, 'corentin.penard@gmai.coml'),
(16, 'john.lock@gmail.com'),
(17, 'sandrine.lescop@gmail.com'),
(18, 'stephane.gelbon@gmail.com'),
(19, 'cathrine.desire@gmail.com'),
(20, 'fandebarcola@gmail.com'),
(21, 'fandupsg@gmail.com'),
(22, 'ethienne.philipe@gmail.com'),
(23, 'philipe22@gmail.com'),
(24, 'lilloisdunord@gmail.com'),
(25, 'jonathan.david29@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `t_participation_pct`
--

CREATE TABLE `t_participation_pct` (
  `par_id` int(11) NOT NULL,
  `sce_id` int(11) NOT NULL,
  `pct_date_premiere_reussite` datetime DEFAULT NULL,
  `pct_date_derniere_reussite` datetime DEFAULT NULL,
  `pct_etape` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_participation_pct`
--

INSERT INTO `t_participation_pct` (`par_id`, `sce_id`, `pct_date_premiere_reussite`, `pct_date_derniere_reussite`, `pct_etape`) VALUES
(1, 1, '2025-04-02 16:03:08', NULL, 3),
(2, 1, '2025-04-02 16:03:39', NULL, 3),
(3, 1, '2025-04-02 16:04:31', NULL, 3),
(4, 1, NULL, NULL, 3),
(5, 1, NULL, NULL, 2),
(6, 1, NULL, NULL, 1),
(7, 1, NULL, NULL, 1),
(8, 1, NULL, NULL, 2),
(9, 1, NULL, NULL, 1),
(12, 1, NULL, NULL, 1),
(13, 2, NULL, NULL, 2),
(14, 2, '2025-04-03 18:51:22', NULL, 7),
(15, 2, '2025-04-03 19:48:54', NULL, 7),
(16, 2, NULL, NULL, 4),
(17, 5, '2025-04-03 20:15:21', NULL, 5),
(18, 5, NULL, NULL, 4),
(19, 5, NULL, NULL, 2),
(20, 8, NULL, NULL, 4),
(21, 8, '2025-04-03 20:37:13', NULL, 5),
(22, 8, NULL, NULL, 1),
(23, 8, NULL, NULL, 3),
(24, 7, '2025-04-03 20:47:11', NULL, 5),
(25, 7, NULL, NULL, 3);

--
-- Déclencheurs `t_participation_pct`
--
DELIMITER $$
CREATE TRIGGER `detect_scenario_populaire` AFTER INSERT ON `t_participation_pct` FOR EACH ROW BEGIN
    DECLARE nb_participations INT;
    DECLARE sce_title VARCHAR(200);

    -- Compter le nombre de participations pour le scénario donné
    SELECT COUNT(*) INTO nb_participations 
    FROM t_participation_pct 
    WHERE sce_id = NEW.sce_id;

    -- Récupérer le titre du scénario à partir de t_scenario_sce
    SELECT sce_titre INTO sce_title 
    FROM t_scenario_sce
    WHERE sce_id = NEW.sce_id
    LIMIT 1;  -- Limité à 1 pour éviter les doublons si jamais il y a plusieurs enregistrements pour un même sce_id

    -- Vérifier si le nombre de participations a atteint 10
    IF nb_participations = 10 THEN  
        INSERT INTO t_actualite_act (act_id, act_titre, act_texte, act_date, act_etat, com_mail)
        VALUES (NULL, 
                'Ce scénario est populaire en ce moment !', 
                CONCAT('Le scénario ', sce_title, ' est populaire en ce moment ! Venez approfondir vos connaissances !'), 
                NOW(), 
                '1', 
                'administrATeur@webquest.fr');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_profil_pro`
--

CREATE TABLE `t_profil_pro` (
  `pro_nom` varchar(80) NOT NULL,
  `pro_prenom` varchar(80) NOT NULL,
  `pro_etat` char(1) NOT NULL,
  `com_mail` varchar(200) NOT NULL,
  `pro_role` enum('A','O') NOT NULL,
  `pro_date_creation` date NOT NULL,
  `pro_chemin` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_profil_pro`
--

INSERT INTO `t_profil_pro` (`pro_nom`, `pro_prenom`, `pro_etat`, `com_mail`, `pro_role`, `pro_date_creation`, `pro_chemin`) VALUES
('Admin', 'Admin', '1', 'administrATeur@webquest.fr', 'A', '2025-02-02', NULL),
('OLIVEIRA', 'Evan', '1', 'eoliveira@webquest.fr', 'O', '2025-02-02', 'uploads/img/pp/20250403_152555_pp_simple.jpg'),
('FOURNIER', 'Ethan', '1', 'ethanfournier@webquest.fr', 'O', '2025-03-13', NULL),
('LECOQ', 'Frédéric', '0', 'flecoq@webquest.fr', 'O', '2025-02-02', NULL),
('PLASSART', 'Gaël', '1', 'gplassart@webquest.fr', 'A', '2025-02-02', 'uploads/img/pp/20250403_150018_pp_vitinha.jpg'),
('HERNANDEZ', 'Luis', '0', 'lhernandez@webquest.fr', 'O', '2025-02-22', NULL),
('MERRER', 'Mael', '1', 'mmerrer@webquest.fr', 'A', '2025-02-02', NULL),
('Organisateur', 'Organisateur', '1', 'organisATeur@webquest.fr', 'O', '2025-02-28', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_ressource_res`
--

CREATE TABLE `t_ressource_res` (
  `res_id` int(11) NOT NULL,
  `res_source` varchar(300) DEFAULT NULL,
  `res_text_alt` varchar(300) DEFAULT NULL,
  `res_type` enum('Vidéo','Image','Document','Audio') DEFAULT NULL,
  `res_chemin` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_ressource_res`
--

INSERT INTO `t_ressource_res` (`res_id`, `res_source`, `res_text_alt`, `res_type`, `res_chemin`) VALUES
(1, NULL, 'Arbitre de football donnant un carton rouge.', 'Image', 'uploads/img/20250317_111215_arbitre.jpg'),
(2, 'https://youtu.be/hnmtBu0Ykmg?feature=shared', 'Vidéo expliquant les règles de bases du Football.', 'Vidéo', NULL),
(3, 'https://media.fff.fr/uploads/document/03d97ac96835f74537bf6837bd65dab3.pdf', 'Document sur les règles de bases du football.', 'Document', NULL),
(4, NULL, 'Logo du club français Paris Saint-Germain.', 'Image', ''),
(5, NULL, 'Logo du psg', 'Image', 'uploads/img/02.11.25_08:24:56_logo_psg.png'),
(6, NULL, 'Image stade psg', 'Image', 'uploads/img/20250403_195321_stade_psg.jpg'),
(7, NULL, 'Désiré DOUE', 'Image', 'uploads/img/20250317_111215_desire_doue.jpg'),
(8, NULL, 'BARCOLA qui porte le maillot extérieur du PSG', 'Image', 'uploads/img/20250403_202831_barcola_exterieur.jpg'),
(9, NULL, 'Postes que BARCOLA peut jouer', 'Image', 'uploads/img/20250403_202831_barcola_poste.JPG'),
(10, NULL, 'Stade du LOSC', 'Image', 'uploads/img/20250403_202831_stade_losc.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `t_scenario_sce`
--

CREATE TABLE `t_scenario_sce` (
  `sce_id` int(11) NOT NULL,
  `sce_code` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `sce_titre` varchar(200) NOT NULL,
  `sce_texte` varchar(300) NOT NULL,
  `sce_illustration` varchar(300) NOT NULL,
  `com_mail` varchar(200) DEFAULT NULL,
  `sce_etat` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_scenario_sce`
--

INSERT INTO `t_scenario_sce` (`sce_id`, `sce_code`, `sce_titre`, `sce_texte`, `sce_illustration`, `com_mail`, `sce_etat`) VALUES
(1, 'WsSAyxRJpD5H', 'Les règles du football', 'Plongez dans un défi palpitant avec ce scénario où chaque énigme vous plonge au cœur des règles fondamentales du football. Testez vos connaissances, le tout dans un univers sportif ! Une expérience immersive et excitante vous attend.', 'uploads/img/pierluigi_colina.jpg', 'organisATeur@webquest.fr', '1'),
(2, 'A1b2C3d4E5f6', 'Paris Saint-Germain', 'Plongez dans l\'univers du PSG avec ce scénario palpitant ! Chaque étape vous confronte à des énigmes sur l\'histoire du club, ses joueurs légendaires et ses exploits. Testez vos connaissances et résolvez des défis captivants pour prouver que vous êtes un véritable fan du Paris Saint-Germain !', 'uploads/img/20250317_111215_equipe_psg.jpeg', 'gplassart@webquest.fr', '1'),
(5, 'auDfKiOqVFng', 'Désiré DOUÉ', 'Découvrez l’univers fascinant de Désiré DOUÉ ! Plongez dans sa carrière, explorez ses performances et revivez ses moments forts. Résolvez des énigmes stimulantes, testez vos connaissances et relevez des défis captivants.  Prouvez que vous êtes un véritable expert de ce jeune talent prometteur !', 'uploads/img/20250317_111215_desire_doue.jpg', 'gplassart@webquest.fr', '1'),
(6, 'V1b8Y3d4E5y9', 'Olympique lyonnais', 'Plongez dans l\'univers de l\'Olympique Lyonnais avec ce scénario palpitant ! Testez vos connaissances et résolvez des défis captivants ! Prouver que vous êtes un vrai fan de l\'Olympique lyonnais !', 'uploads/img/20250401_104311_ol.webp', 'organisATeur@webquest.fr', '1'),
(7, 'z1B2m3D4E5R0', 'LOSC Lille', 'Plongez dans l\'univers du LOSC avec ce scénario palpitant ! Chaque étape vous confronte à des énigmes sur l\'histoire du club, ses joueurs légendaires et ses exploits. Testez vos connaissances et résolvez des défis captivants pour prouver que vous êtes un véritable fan du LOSC !', 'uploads/img/20250317_111215_losc.PNG', 'organisATeur@webquest.fr', '1'),
(8, 'o1z2d3h4EwF0', 'Bradley BARCOLA', 'Plongez dans le monde de Bradley Barcola ! Résolvez des énigmes sur sa carrière, ses performances et ses moments forts. Testez vos connaissances et relevez des défis captivants pour devenir un véritable expert de ce jeune talent !', 'uploads/img/20250317_111215_bradley_barcola.jpg', 'gplassart@webquest.fr', '1'),
(9, 'W3eeOcL383Pd', 'Qui est ce joueur de l\'EDF ?', 'Plongez dans l\'univers de l\'équipe de France avec ce scénario palpitant ! Chaque étape vous confronte à ses joueurs légendaires. Testez vos connaissances ! Réussirez-vous à retrouver tout ces joueurs français ?', 'uploads/img/20250401_083809_zinedine_zidane.jpg', 'eoliveira@webquest.fr', '0');

--
-- Déclencheurs `t_scenario_sce`
--
DELIMITER $$
CREATE TRIGGER `create_actualite` AFTER INSERT ON `t_scenario_sce` FOR EACH ROW BEGIN
    INSERT INTO t_actualite_act (act_id, act_titre, act_texte, act_date, com_mail, act_etat)
    VALUES (NULL, 
            CONCAT('Nouveau scénario !'), 
            CONCAT('Le scénario " ', NEW.sce_titre, ' " est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !'),
            NOW(), 
            'administrATeur@webquest.fr', 
            '1');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detect_scenario_inaccessible` BEFORE UPDATE ON `t_scenario_sce` FOR EACH ROW BEGIN
    IF (OLD.sce_etat = '1' AND NEW.sce_etat = '0') THEN
        INSERT INTO t_actualite_act 
        VALUES (NULL, 
                CONCAT('Scénario ', NEW.sce_titre, ' inaccessible !'), 
                'Ce scénario sera inaccessible pendant une durée indéterminée. Merci pour votre compréhension.', 
                NOW(), 
                1, 
                'administrATeur@webquest.fr');
    
    ELSEIF (OLD.sce_etat = '0' AND NEW.sce_etat = '1') THEN
        DELETE FROM t_actualite_act 
        WHERE act_titre = CONCAT('Scénario ', NEW.sce_titre, ' inaccessible !');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la vue `get_all_comptes`
--
DROP TABLE IF EXISTS `get_all_comptes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`e00000000sql`@`%` SQL SECURITY DEFINER VIEW `get_all_comptes`  AS SELECT `t_profil_pro`.`com_mail` AS `com_mail`, `t_profil_pro`.`pro_nom` AS `pro_nom`, `t_profil_pro`.`pro_prenom` AS `pro_prenom`, `t_profil_pro`.`pro_etat` AS `pro_etat`, `t_profil_pro`.`pro_role` AS `pro_role`, `t_profil_pro`.`pro_date_creation` AS `pro_date_creation`, `t_profil_pro`.`pro_chemin` AS `pro_chemin`, `t_compte_com`.`com_mdp` AS `com_mdp` FROM (`t_profil_pro` join `t_compte_com` on(`t_profil_pro`.`com_mail` = `t_compte_com`.`com_mail`)) ORDER BY `t_profil_pro`.`pro_date_creation` DESC ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  ADD PRIMARY KEY (`act_id`),
  ADD KEY `FK_COMPTE` (`com_mail`);

--
-- Index pour la table `t_compte_com`
--
ALTER TABLE `t_compte_com`
  ADD PRIMARY KEY (`com_mail`);

--
-- Index pour la table `t_etape_eta`
--
ALTER TABLE `t_etape_eta`
  ADD PRIMARY KEY (`eta_id`),
  ADD UNIQUE KEY `eta_code_UNIQUE` (`eta_code`),
  ADD KEY `FK_RESSOURCE` (`res_id`),
  ADD KEY `FK_SCENARIO` (`sce_id`);

--
-- Index pour la table `t_indice_ind`
--
ALTER TABLE `t_indice_ind`
  ADD PRIMARY KEY (`ind_id`,`eta_id`),
  ADD KEY `FK_ETAPE` (`eta_id`);

--
-- Index pour la table `t_participant_par`
--
ALTER TABLE `t_participant_par`
  ADD PRIMARY KEY (`par_id`);

--
-- Index pour la table `t_participation_pct`
--
ALTER TABLE `t_participation_pct`
  ADD PRIMARY KEY (`par_id`,`sce_id`),
  ADD KEY `FK_SCENARIO` (`sce_id`),
  ADD KEY `FK_PARTICIPANT` (`par_id`);

--
-- Index pour la table `t_profil_pro`
--
ALTER TABLE `t_profil_pro`
  ADD PRIMARY KEY (`com_mail`);

--
-- Index pour la table `t_ressource_res`
--
ALTER TABLE `t_ressource_res`
  ADD PRIMARY KEY (`res_id`);

--
-- Index pour la table `t_scenario_sce`
--
ALTER TABLE `t_scenario_sce`
  ADD PRIMARY KEY (`sce_id`),
  ADD UNIQUE KEY `sce_code_UNIQUE` (`sce_code`),
  ADD KEY `FK_COMPTE` (`com_mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `t_etape_eta`
--
ALTER TABLE `t_etape_eta`
  MODIFY `eta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `t_indice_ind`
--
ALTER TABLE `t_indice_ind`
  MODIFY `ind_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `t_participant_par`
--
ALTER TABLE `t_participant_par`
  MODIFY `par_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `t_ressource_res`
--
ALTER TABLE `t_ressource_res`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `t_scenario_sce`
--
ALTER TABLE `t_scenario_sce`
  MODIFY `sce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  ADD CONSTRAINT `fk_t_actualite_act_t_compte_com1` FOREIGN KEY (`com_mail`) REFERENCES `t_compte_com` (`com_mail`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_etape_eta`
--
ALTER TABLE `t_etape_eta`
  ADD CONSTRAINT `fk_t_etape_eta_t_ressource_res1` FOREIGN KEY (`res_id`) REFERENCES `t_ressource_res` (`res_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_etape_eta_t_scenario_sce1` FOREIGN KEY (`sce_id`) REFERENCES `t_scenario_sce` (`sce_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_indice_ind`
--
ALTER TABLE `t_indice_ind`
  ADD CONSTRAINT `fk_t_indice_ind_t_etape_eta1` FOREIGN KEY (`eta_id`) REFERENCES `t_etape_eta` (`eta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_participation_pct`
--
ALTER TABLE `t_participation_pct`
  ADD CONSTRAINT `fk_t_participant_par_has_t_scenario_sce_t_participant_par1` FOREIGN KEY (`par_id`) REFERENCES `t_participant_par` (`par_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_participant_par_has_t_scenario_sce_t_scenario_sce1` FOREIGN KEY (`sce_id`) REFERENCES `t_scenario_sce` (`sce_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_profil_pro`
--
ALTER TABLE `t_profil_pro`
  ADD CONSTRAINT `fk_t_profil_pro_t_compte_com1` FOREIGN KEY (`com_mail`) REFERENCES `t_compte_com` (`com_mail`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_scenario_sce`
--
ALTER TABLE `t_scenario_sce`
  ADD CONSTRAINT `fk_t_scenario_sce_t_compte_com` FOREIGN KEY (`com_mail`) REFERENCES `t_compte_com` (`com_mail`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
