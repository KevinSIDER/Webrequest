## Web[RE]Quest

**Nom de l'étudiant** : Kevin SIDER  
 **Date** : 03/04/2025  
**Intitulé et sujet du projet** : Web[RE]Quest - Application web de quiz sur le thème du Football

## Template Bootstrap utilisé

- **Admin** : https://startbootstrap.com/theme/sb-admin-2
- **Utilisateur** : https://www.gettemplate.com/info/progressus/?source=codeur-com-blog&utm_source=codeur-com-blog

## URL de l'application

- **Production**: [https://obiwan.univ-brest.fr/~e22400310/](https://obiwan.univ-brest.fr/~e22400310/)

## Architecture

- **Backend**: PHP 8.2 avec CodeIgniter 4.5
- **Base de données**: MariaDB 10.11
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5

## Commandes pour les sauvegarde

#### Mise en poduction (Lien symbolique) :

```bash
cd public_html
rm prod
ln -s V3 prod
ls -l
```

#### Gitlab :

```bash
cd V3
git init .
git status
git add ci
git status
git commit -m "V3 de l'application web"
git branch V3
git checkout V3
git remote add gitlab https://gitlab-depinfo.univ-brest.fr/e22402713/project_isi.git
git push gitlab V1.1
```

#### Sauvegarde sur vador :

```bash
- Sur vador :
mkdir V3_sauv
- Sur Obiwan :
cd V3
scp -r ci/ kevin.sider@vador-fs.univ-brest.fr:projet_isi/V3_sauv
```

#### Sauvegarde sur obiwan :

```bash
cd ..
mkdir V3_copie
cp -r V3/ci V3_copie
```

## Rappel des informations des comptes de test :

### Administrateurs :

1. Admin 1 :

- Email: administrATeur@univ-brest.fr
- Mot de passe: admin25_TSEUQ

2. Admin 2 :

- Email: gplassart@webquest.fr
- Mot de passe: Btssio2017

3. Admin 3 (Désactivé) :

- Email: mmerrer@webquest.fr
- Mot de passe: Btssio2017

### Organisateurs :

1. Organisateur 1 :

- Email: organisATeur@webquest.fr
- Mot de passe: Btssio2017

2. Organisateur 2 :

- Email: eoliveira@webquest.fr
- Mot de passe: Btssio2017

3. Organisateur 3 (Désactivé):

- Email: flecoq@webquest.fr
- Mot de passe: Btssio2017

## Rappel des code des scénarios :

1. Scénario 1 :

- Titre : Les règles du football
- Code : WsSAyxRJpD5H

2. Scénario 2 :

- Titre : Paris Saint-Germain
- Code : A1b2C3d4E5f6

3. Scénario 3 :

- Titre : Désiré DOUÉ
- Code : auDfKiOqVFng

4. Scénario 4 (Actif mais sans étapes) :

- Titre : Olympique lyonnais
- Code : V1b8Y3d4E5y9

5. Scénario 5 :

- Titre : LOSC Lille
- Code : z1B2m3D4E5R0

6. Scénario 6 :

- Titre : Bradley BARCOLA
- Code : o1z2d3h4EwF0

7. Scénario 7 (Désactivé) :

- Titre : Qui est ce joueur de l'EDF ?
- Code : W3eeOcL383Pd

## Rappel du code SQL/PSM :

1. Vue

```bash
CREATE VIEW get_all_comptes AS
SELECT *
FROM t_profil_pro
JOIN t_compte_com USING (com_mail)
ORDER BY pro_date_creation DESC;

SELECT * FROM get_all_comptes
```

1. Fonction

```bash
DELIMITER //
CREATE FUNCTION donner_nb_reussite(p_sce_id INT) RETURNS varchar(255)
DETERMINISTIC
BEGIN
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
END//
DELIMITER ;

SELECT donner_nb_reussite(1);
```

1. Procédure

```bash
DELIMITER //
CREATE PROCEDURE update_actualite(IN titre VARCHAR(255), IN texte TEXT, IN etat ENUM('0', '1'), IN id INT)
BEGIN
    UPDATE t_actualite_act
    SET act_titre = titre,
        act_texte = texte,
        act_etat = etat
    WHERE act_id = id;
END//
DELIMITER ;
```

1. Trigger

```bash
CREATE TRIGGER detect_scenario_populaire
AFTER INSERT ON t_participation_pct
 FOR EACH ROW BEGIN
    DECLARE nb_participations INT;
    DECLARE sce_title VARCHAR(200);

    SELECT COUNT(*) INTO nb_participations
    FROM t_participation_pct
    WHERE sce_id = NEW.sce_id;

    SELECT sce_titre INTO sce_title
    FROM t_scenario_sce
    WHERE sce_id = NEW.sce_id
    LIMIT 1;

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
```

2. Trigger

```bash
CREATE TRIGGER detect_scenario_inaccessible BEFORE UPDATE ON t_scenario_sce
 FOR EACH ROW BEGIN
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
```

3. Trigger

```bash
CREATE TRIGGER create_actualite
AFTER INSERT ON t_scenario_sce
 FOR EACH ROW BEGIN
    INSERT INTO t_actualite_act (act_id, act_titre, act_texte, act_date, com_mail, act_etat)
    VALUES (NULL,
            CONCAT('Nouveau scénario !'),
            CONCAT('Le scénario " ', NEW.sce_titre, ' " est maintenant accessible, venez tester vos connaissances avec ce nouveau scénario !'),
            NOW(),
            'administrATeur@webquest.fr',
            '1');
END
```
