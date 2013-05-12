<?php
    /**
     * Page de contact
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Chargement des fichiers de classes
     *
     * @param string $classe La classe à charger
     */
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();

    // On vérifie si l'on a le droit d'accéder à cette page
    if (!verifierAcces(__FILE__)) {
        $_SESSION['erreur_droits'] = true;
        header("Location: login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
    <?php
//        include 'formulaire.php';
        /*         * ************ //Design pour formulaire de contact
          label {
          display:block;
          width:150px;
          float:left;
          text-align:left;
          padding-right:5px;
          margin-bottom:2px;
          }
          fieldset
          {
          border: solid 1px #222;
          }
          fieldset legend
          {
          padding: 0 10px;
          border-left: #222 1px solid;
          border-right: #222 1px solid;
          font-size: 1.2em;
          color: #222;
          }
          #formulaire_contact textarea
          {
          width:180px;
          height:150px;
          }
         */
    ?>
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <link rel="stylesheet" href="css/contact.css" />

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
                <center>
                    <p>
                        Vous pouvez utiliser le formulaire suivant afin de contacter l'administrateur pour lui signaler une erreur, un problème ou un bug,<br />
                        ainsi que lui demander la modification ou suppression de votre compte ou tout autre chose.
                    </p>
                    <br />
                    <form  action="fonctions/formulaireContact.php" method="post">
                        <fieldset style="width: 550px;">
                            <legend>Formulaire de contact</legend>

                            <br />

                            <label for="label_message">Votre message&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>

                            <textarea name="message" rows="8" cols="45" id="label_message" placeholder="Taper votre texte.">
                                <?php
                                    if (isset($_POST['message']))
                                        echo htmlspecialchars($_POST['message']);
                                ?>
                            </textarea>

                            <br />

                            <label for ="label_email">Votre email&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>

                            <input type="text" name="email" id="label_email"
                                   value="
                                   <?php
                                       if (isset($_POST['email']))
                                           echo htmlspecialchars($_POST['email']);
                                   ?>"
                                   placeholder="truc@truc.truc"/>

                            <br />
                            <br />

                            <input type="submit" value="Envoyer" />

                            <label class="erreur">
                                <?php
                                    if (isset($_SESSION['erreur']))
                                        echo $_SESSION['erreur'];
                                ?>
                            </label>

                            <label class="sortie">
                                <?php
                                    if (isset($_SESSION['info']))
                                        echo $_SESSION['info'];
                                ?>
                            </label>
                        </fieldset>
                    </form>

                    <p>
                        <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                    </p>
                </center>
            </div>
        </div>
    </body>
</html>
