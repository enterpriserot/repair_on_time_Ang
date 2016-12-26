<?php
    class db {
        private $server;
        private $user;
        private $password;
        private $database;
        private $link;
        private $stmt;
        private $array;
        static $_instance;

        private function __construct() {
            $this->setConexion();
            $this->conectar();
        }

        private function setConexion() {
            require_once 'conf.class.singleton.php';
            $conf = conf::getInstance();
            //http://stackoverflow.com/a/14068747
            //http://xaviesteve.com/354/acentos-y-enes-aparecen-mal-a%C2%B1-en-php-con-mysql-utf-8-iso-8859-1/
            //mysql_query("SET NAMES 'utf8'");
            //$acentos = $db->query("SET NAMES 'utf8'");
            $this->server = $conf->_hostdb;
            $this->database = $conf->_db;
            $this->user = $conf->_userdb;
            $this->password = $conf->_passdb;
        }

        private function __clone() {

        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }

        private function conectar() {
            $this->link = new mysqli($this->server, $this->user, $this->password);
            //http://es.stackoverflow.com/questions/15953/problema-con-caracteres-%C3%B1-y-acentos-gerando-json-php
            mysqli_set_charset($this->link,"utf8");
            $this->link->select_db($this->database);
        }

        public function ejecutar($sql) {
            $this->stmt = $this->link->query($sql);
            return $this->stmt;
        }

        public function listar($stmt) {
            $this->array = array();
            while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
                array_push($this->array, $row);
            }
            return $this->array;
        }

    }
