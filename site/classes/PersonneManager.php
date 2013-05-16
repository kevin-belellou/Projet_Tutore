<?php

    /**
     * Manager de Personne
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class PersonneManager {

        /**
         *
         * @var PDO
         */
        private $_db;

        /**
         * Contructeur
         *
         * @param PDO $db Base de données
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne la liste de toutes les personnes dans la BD
         *
         * @return Personne[]
         */
        public function getList() {
            $persos = array();

            $req = $this->_db->query('SELECT
                codePe, type, nom, prenom, email, login, mdp
                FROM Personne
                ORDER BY nom');

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $persos[] = new Personne($donnees);
            }

            return $persos;
        }

        /**
         * Retourne la personne désignée par son id
         *
         * @param int $id Id de la personne à récupérer
         * @return Personne
         */
        public function getPersonne($id) {
            $req = $this->_db->prepare('SELECT
                codePe, type, nom, prenom, email, login, mdp
                FROM Personne
                WHERE codePe = :id');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $personne = new Personne($donnees);
            }

            return $personne;
        }

        /**
         * Setter de $_db
         *
         * @param PDO $db Base de données
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
