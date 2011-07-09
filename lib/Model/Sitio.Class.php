<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sitio
 *
 * @author User
 */
require ("aut_config.inc.php");
include ("aut_login.inc.php");
require_once 'sql.php';
class Sitio {
    private $sql;
    private $id;
    private $titulo;
    private $icon;
    private $mostrar;
    private $theme;
    private $portada;
    private $id_portada;
    private $orden;
    
    public function __construct() {
        $this->sql = new sql();
    }
    public function __destruct() {
        $this->sql = NULL;
    }
    
    public function set_id($new_value){
        $this->id = $new_value;
    }
    public function get_id(){
        return $this->id;
    }
    
     public function set_titulo($new_value){
        $this->titulo = $new_value;
    }
    public function get_titulo(){
        return $this->titulo;
    }
    
     public function set_icon($new_value){
        $this->icon = $new_value;
    }
    public function get_icon(){
        return $this->icon;
    }
    
     public function set_mostrar($new_value){
        $this->mostrar = $new_value;
    }
    public function get_mostrar(){
        return $this->mostrar;
    }
    
    public function set_theme($new_value){
        $this->theme = $new_value;
    }
    public function get_theme(){
        return $this->theme;
    }
    
    public function set_portada($new_value){
        $this->portada = $new_value;
    }
    public function get_portada(){
        return $this->portada;
    }
    
    public function set_idportada($new_value){
        $this->id_portada = $new_value;
    }
    public function get_idportada(){
        return $this->id_portada;
    }
    
    public function set_orden($new_value){
        $this->orden = $new_value;
    }
    public function get_orden(){
        return $this->orden;
    }
    
    
    public function add(){
        $dt_sitio="";
        $dt_sitio=$this->sql->go("INSERT INTO sitios (titulo,icon,mostrar) VALUES('" . $this->titulo ."',
                                '" . $this->icon ."' ,'1')");
        return ($this->sql->lastId());
        
    }
    public function update(){
        $dt_sitio="";
        $dt_sitio=$this->sql->go("UPDATE sitios SET  titulo ='" . $this->titulo . "' ,
                                            icon = '" . $this->icon . "' 
                                                WHERE id = '" . $this->id .  "'");
        return ($dt_sitio);
    }
    public function desactivate(){
        $dt_sitio   =   "";
        $dt_sitio   =  $this->sql->go("UPDATE sitios SET  mostrar =0 
                                                WHERE id = '" . $this->id .  "'");
        return ($dt_sitio);
    }
    public function delete(){
        
    }
    public function order($array_sitio){
        try {
           
        $cont=0;
        $item;
        $dt_Sitio="";
        
        foreach ($array_sitio as $item) :
            $cont+=1;
            $dt_Sitio   = $this->sql->go("UPDATE sitios SET orden = $cont WHERE id = $item");
            
            
        endforeach;
        return $dt_Sitio;
        
        } catch (Exception $exc) {
            return FALSE;
        }

        
    }


    
    //
    
    
    
    public function getAll(){
        
    }
    
    Public function getidSitio(){
        $query= "";
        $query="SELECT * FROM sitios WHERE id IN ('" . $this->id ."')";
        $this->sql->go($query);
        return $this->sql->fetchArray();
        
       
    }
    
    
    
    
}

// chequear página que lo llama para devolver errores a dicha página.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script. si es asi se arroja un error.
if ($_SERVER['HTTP_REFERER'] == ""){
	die ("Error cod.:1 - Acceso incorrecto!");
	exit;
}


?>
