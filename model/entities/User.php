<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:43
 */


/**
 * Class User.php
 *
 * Define User
 */

class User
{
    private $Id;
    private $pseudo;
    private $email;
    private $pass;
    private $right;

    /**
     * @return mixed
     */
    public function getId()
    {

        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        if (!is_numeric($Id)){
            return;
        }
        if ($Id < 0 ){
            return;
        }
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        if (!is_string($pseudo)){
            return;
        }

        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if (!is_string($email)){
            return;
        }
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param mixed $right
     */
    public function setRight($right)
    {
        if (!is_numeric($right)){
            return;
        }
        if ($right < 0 ){
            return;
        }
        $this->right = $right;
    }

}