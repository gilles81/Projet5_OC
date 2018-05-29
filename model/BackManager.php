<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 22:22
 */



/**
 * Class BackManager
 * @package Projet5
 *
 * Back manager define method used in several managers
 */
class BackManager extends lib
{

    private  $bdd;
    Public function bddAssign() {
        try {
            return $this->bdd = new PDO("mysql:host=".BDDDIR.";dbname=".DBNAME.";charset=utf8", USERNAME, PSWDB);
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }



}