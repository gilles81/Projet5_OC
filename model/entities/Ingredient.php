<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:42
 */

class Ingredient
{
    private $Id;
    private $Name;

    private $Category;




    public function __construct($data)
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }

    }


    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

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
    public function getName()
    {



        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        if (!is_string($Name)){
            return;
        }
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * @param mixed $Category
     */
    public function setCategory($Category)
    {

        $this->Category = $Category;
    }



// …



}