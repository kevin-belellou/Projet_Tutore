<?php

    /**
     * Permet l'encodage en UTF-8 des textes sortis de la BD
     *
     * @param string $text Le texte à encoder
     * @return string
     */
    function echoBD($text) {
        return utf8_encode($text);
    }

    /**
     * Retourne la liste des départements depuis la BD
     *
     * @return array
     */
    function listeDepartement() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query('SELECT codeDe, codePostal, nom
            FROM ListeDepartement
            ORDER BY codeDE');

        $liste = array();

        // On ajoute les données récupérées au tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = array(
                'codeDe' => $donnees['codeDe'],
                'nom' => echoBD($donnees['codePostal'] . " - " . $donnees['nom'])
            );
        }

        return $liste;
    }

    /**
     * Retourne la liste des types d'offres depuis la BD
     *
     * @return array
     */
    function listeType() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SHOW COLUMNS
            FROM Offre
            LIKE 'type'");

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        /*
         * La chaîne reçue est de la forme "enum('Emploi','Type')"
         * On enlève donc les 6 premiers et les 2 derniers caractères
         * avant de découper la chaîne selon le caratère ','
         */
        $liste = explode("','", substr(echoBD($donnees['Type']), 6, -2));

        return $liste;
    }

    /**
     *  Expression régulière pour vérifier les nombres entiers
     * ou décimaux à 1 ou 2 décimales positifs
     *
     * @param mixed $floatATester Présumé float ou int à tester
     * @return float ou int si $floatATester est correct, false sinon
     */
    function validerFloat($floatATester) {
        return preg_match('/^[0-9]+((,|.)[0-9]{1,2})?$/', $floatATester) ? $floatATester : false;
    }

    /**
     * Gère l'indentation du code au niveau du source html
     * Ne sert pas vraiment à grand chose, à part faire joli
     *
     * @param string $text Texte à indenter
     * @param int $nbTabs Nombre de tabulations
     * @param int $nbRetours Nombre de retours chariot
     * @return string
     */
    function indenter($text, $nbTabs = 0, $nbRetours = 0) {
        $tabs = str_repeat("\t", $nbTabs);
        $retours = str_repeat("\n", $nbRetours);

        return $tabs . $text . $retours;
    }

    /**
     * Supprime l'avertissement du navigateur
     * lors du renvoi d'un formulaire
     */
    function supprimerMessageAvertissement() {
        // S'il y a des infos dans $_POST ou $_FILES
        if (!empty($_POST) OR !empty($_FILES)) {
            // Sauvegarde des infos
            $_SESSION['sauvegarde'] = $_POST;
            $_SESSION['sauvegardeFILES'] = $_FILES;

            // Copie de l'URL
            $fichierActuel = $_SERVER['PHP_SELF'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $fichierActuel .= '?' . $_SERVER['QUERY_STRING'];
            }

            /*
             * Pour éviter que les fichiers uploadés ne soient détruits,
             * on les sauvegarde dans un dossier temporaire
             */
            foreach ($_FILES as $fichier => $valeurs) {
                $nom = substr($valeurs['tmp_name'], 1);

                if ($valeurs['error'] == 0
                        && move_uploaded_file($valeurs['tmp_name'], $nom)) {
                    $_SESSION['sauvegardeFILES'][$fichier]['tmp_name'] = $nom;
                }
            }

            // Redirection
            header('Location: ' . $fichierActuel);
            exit;
        }

        // S'il y a des données sauvegardées, restauration de celles-ci
        if (isset($_SESSION['sauvegarde'])) {
            $_POST = $_SESSION['sauvegarde'];
            $_FILES = $_SESSION['sauvegardeFILES'];

            unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
        }
    }

?>
