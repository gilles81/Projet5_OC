<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 22:37
 */

namespace Projet5;


/**
 * Class lib
 *
 * this is a librarie of common method
 *
 *  *
 */


class lib
{
    /**
     * public function sessionStatus()
     *
     * Set Session status in visitor level if a session is not created.
     *
     */

    public function sessionStatus()
    {
        if (!isset($_SESSION['Status']))
        {
            $_SESSION['Status'] = 1;
            $_SESSION['adminLevel'] = 0; // Direct in VISITOR MODE
        }
    }
}