<?php
    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

    <body>
        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
            </div>
            <div id="navigation">
                <h1>MENU</h1>
                <hr/>
                <ul id="sous_menu">
                    <li>
                        <a href="index.php">Accueil</a>
                    </li>
                    <li>
                        <a href="profil.php">Mon Profil</a>
                    </li>
                    <li>
                        <a href="recherche_profil.php">Rechercher un profil</a>
                    </li>
                    <li>
                        <a href="offres.php">Offres Emplois/Stage</a>
                    </li>
                    <li>
                        <a href="ajouter_offre.php">Ajouter une offre</a>
                    </li>
                    <li>
                        <a href="statistiques.php">Statistiques</a>
                    </li>
                </ul>
            </div>
            <div id="contenu">
                <p>Consulter les offres.</p>
                <?php
                    $bdd = ConnexionBD::getInstance()->getBDD();

                    $managerOffre = new OffreManager($bdd);
                    $offres = $managerOffre->getList();
                    $taille = count($offres);

                    echo "<p>\n";
                    for ($i = 0; $i < $taille; $i++) {
                        echo "\t\t";
                        $offres[$i]->afficher();
                        echo "<br />\n";
                    }
                    echo "\t</p>\n";
                ?>
            </div>
        </div>
    </body>
</html>
