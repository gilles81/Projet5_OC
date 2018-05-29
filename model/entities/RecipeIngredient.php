<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:42
 */

class RecipeIngredient
{
    private $Id;
    private $RecipeId;
    private $IngredientId;
    private $Name;



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
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getRecipeId()
    {
        return $this->RecipeId;
    }

    /**
     * @param mixed $RecipeId
     */
    public function setRecipeId($RecipeId)
    {
        $this->RecipeId = $RecipeId;
    }

    /**
     * @return mixed
     */
    public function getIngredientId()
    {
        return $this->IngredientId;
    }

    /**
     * @param mixed $IngredientId
     */
    public function setIngredientId($IngredientId)
    {
        $this->IngredientId = $IngredientId;
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
        $this->Name = $Name;
    }



// …



}