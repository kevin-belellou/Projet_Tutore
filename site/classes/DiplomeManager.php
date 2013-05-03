<?php

    /**
     * Manager de Diplome
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class DiplomeManager {

        /**
         *
         * @var PDO
         */
        private $_db;

        /**
         * Contructeur
         *
         * @param PDO $db
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne les diplômes désignés par l'id du profil correspondant
         *
         * @param int $id Id du profil
         * @return array of Diplome
         */
        public function getDiplomes($id) {
            $diplomes = array();

            $q = $this->_db->prepare('SELECT
                codeDi, codePe, visibilite, annee, type, discipline, etablissement
                FROM Diplome
                WHERE codePe = :id');

            $q->execute(array(
                'id' => $id
            ));

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $diplomes[] = new Diplome($donnees);
            }

            return $diplomes;
        }

        /**
         * Setter de $_db
         *
         * @param PDO $db
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
