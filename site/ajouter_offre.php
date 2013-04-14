<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();

    if (!verifierAcces(__FILE__)) {
        header("Location: index.php");
    }
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
            <?php
                // Appel dynamique du menu selon l'identité de la personne
                afficherMenu();
            ?>
            <div id="contenu">
                <h2>Ajouter une offre</h2>
                <p>Veuillez éviter les lettres majuscules accentuées, elles ne s'afficheraient pas correctement</p>

                <form action="fonctions/ajouterOffre.php" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <label for="intitule">Intitulé : </label>
                            </td>
                            <td colspan="3">
                                <input type="text" name="intitule" id="intitule" size="55" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="entreprise">Entreprise / Organisation : </label>
                            </td>
                            <td>
                                <input type="text" name="entreprise" id="entreprise" />
                            </td>
                            <td>
                                <label for="ville">Ville : </label>
                            </td>
                            <td>
                                <input type="text" name="ville" id="ville" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="departement">Département : </label>
                            </td>
                            <td>
                                <select name="departement" id="departement">
                                    <?php
                                        $listeDep = listeDepartement();

                                        foreach ($listeDep as $value) {
                                            echo "<option value=\"" . $value['codeDe']
                                            . "\">" . $value['nom']
                                            . "</option>\n";
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <label for="remuneration">Rémunération : </label>
                            </td>
                            <td>
                                <input type="text" name="remuneration" id="remuneration" />
                                <select name="periodicite" id="periodicite">
                                    <option value="mois">€ / mois</option>
                                    <option value="annee">€ / an</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="type">Type : </label>
                            </td>
                            <td>
                                <select name="type" id="type">
                                    <?php
                                        $listeType = listeType();

                                        foreach ($listeType as $value) {
                                            echo "<option value=\"" . $value
                                            . "\">" . $value
                                            . "</option>\n";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br />
                                <label for="fichier">Sélectionner le fichier pdf à uploader (max : 2Mo) : </label>
                                <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                                <input type="file" name="fichier" id="fichier" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center" >
                                <input type="submit" value="Envoyer" />
                            </td>
                        </tr>
                    </table>
                </form>
                <br />
                <label id="erreur">
                    <?php
                        if (isset($_SESSION['erreurs_ajout'])) {
                            echo substr_count($_SESSION['erreurs_ajout'], "<br />\n") > 2 ? "Erreurs :" : "Erreur :";
                            echo "<br />\n";
                            echo $_SESSION['erreurs_ajout'];
                            unset($_SESSION['erreurs_ajout']);
                        } else {
                            echo "\n";
                        }
                    ?>
                </label>
                <label id="sortie">
                    <?php
                        if (isset($_SESSION['sortie_ajout'])) {
                            echo "<br />\n";
                            echo $_SESSION['sortie_ajout'];
                            unset($_SESSION['sortie_ajout']);
                        } else {
                            echo "\n";
                        }
                    ?>
                </label>
            </div>
        </div>
    </body>
</html>
