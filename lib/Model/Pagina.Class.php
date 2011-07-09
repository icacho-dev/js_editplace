<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pagina
 *
 * @author User
 */
require ("aut_config.inc.php");
include ("aut_login.inc.php");
require_once 'sql.php';
class Pagina {
    private $id;
    private $titulo;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

        public function __construct() {
        ;
    }
    public function __destruct() {
        ;
    }
    
}

?>
