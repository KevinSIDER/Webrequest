<?php

// Vérifie si la variable $logins est non vide et est bien un tableau
if (!empty($comptes) && is_array($comptes)) {
    echo "<div id='content-wrapper' class='d-flex flex-column'>";
    echo "<div id='content'>";
    echo "<div class='container-fluid'>";
    echo("<br>");
    echo "<h2 class='font-weight-bold text-center'>Liste des comptes</h2>";
    echo "<p class='text-center'>Nombre de comptes : " . $nbr->nbrComptes . "</p>";
    echo "<a href='" . base_url('/index.php/compte/creer') . "' class='text-center d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Ajouter un compte</a>";
    echo "</div>";
    echo "<div class='p-3'>";
    echo "<table class='table table-bordered table-success'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mail</th>";
    echo "<th>Nom</th>";
    echo "<th>Prénom</th>";
    echo "<th>État</th>";
    echo "<th>Rôle</th>";
    echo "<th>Date de création</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($comptes as $compte) {
        if ($compte['pro_etat'] == 1) {
            // Détermine le rôle
            $role = ($compte['pro_role'] == 'A') ? 'Administrateur' : 'Organisateur';

            echo "<tr>";
            echo "<td>" . $compte["com_mail"] . "</td>";
            echo "<td>" . $compte["pro_nom"] . "</td>";
            echo "<td>" . $compte["pro_prenom"] . "</td>";
            echo "<td>Activé</td>";
            echo "<td>" . $role . "</td>";
            echo "<td>" . $compte["pro_date_creation"] . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "<tfoot>";
    echo "<tr><td colspan='6' class='text-center'>Comptes activés</td></tr>";
    echo "</tfoot>";
    echo "</table>";
    echo "</div>";  // Fin du div avec padding
   
    echo "<div class='p-3'>";  // Ajoute du padding autour du tableau
    // Table pour les comptes désactivés avec une bordure rouge
    echo "<table class='table table-bordered table-danger'>"; // Classe ajoutée ici
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mail</th>";
    echo "<th>Nom</th>";
    echo "<th>Prénom</th>";
    echo "<th>État</th>";
    echo "<th>Rôle</th>";
    echo "<th>Date de création</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($comptes as $compte) {
        if ($compte['pro_etat'] == 0) {
            // Détermine le rôle
            $role = ($compte['pro_role'] == 'A') ? 'Administrateur' : 'Organisateur';

            echo "<tr>";
            echo "<td>" . $compte["com_mail"] . "</td>";
            echo "<td>" . $compte["pro_nom"] . "</td>";
            echo "<td>" . $compte["pro_prenom"] . "</td>";
            echo "<td>Désactivé</td>";
            echo "<td>" . $role . "</td>";
            echo "<td>" . $compte["pro_date_creation"] . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "<tfoot>";
    echo "<tr><td colspan='6' class='text-center'>Comptes désactivés</td></tr>";
    echo "</tfoot>";
    echo "</table>";
    echo "</div>";  // Fin du div avec padding

    echo "</div>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<h3>Aucun compte pour le moment</h3>";
}
?>
