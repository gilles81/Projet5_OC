<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:42
 */

class RecipeIngredient
{
    private $Id;//to delette after debug
    private $RecipeId;
    private $IngredientId;
    private $Name;
    private $Quantity;
    private $Unit;



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
    public function getUnit()
    {
        return $this->Unit;
    }

    /**
     * @param mixed $Unit
     */
    public function setUnit($Unit)
    {
        $this->Unit = $Unit;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * @param mixed $Quantity
     */
    public function setQuantity($Quantity)
    {
        if (!is_numeric($Quantity)){
            return;
        }
        if ($Quantity < 0 ){
            return;
        }
        $this->Quantity = $Quantity;
    }

    /**
     * @return mixed
     */


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
    public function getRecipeId()
    {
        return $this->RecipeId;
    }

    /**
     * @param mixed $RecipeId
     */
    public function setRecipeId($RecipeId)
    {
        if (!is_numeric($RecipeId)){
            return;
        }
        if ($RecipeId < 0 ){
            return;
        }
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
        if (!is_numeric($IngredientId)){
            return;
        }
        if ($IngredientId < 0 ){
            return;
        }
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
        if (!is_string($Name)){
            return;
        }
        if ($Name < 0 ){
            return;
        }
        $this->Name = $Name;
    }



// …



}