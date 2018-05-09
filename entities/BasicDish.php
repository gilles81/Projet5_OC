<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:42
 */

namespace Projet5;


class BasicDish
{
    private $dishId;
    private $name;
    private $category;
    private $Author;
    private $creationDate;
    private $recipe;
    private $portion;
    private $ImagePAth;
    private $origin;
    private $bakeTime;
    private $preparationTime;
    private $ingredients;
    private $Difficulty;

    /**
     * @return mixed
     */
    public function getDishId()
    {
        return $this->dishId;
    }

    /**
     * @param mixed $dishId
     */
    public function setDishId($dishId)
    {
        $this->dishId = $dishId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->Author;
    }

    /**
     * @param mixed $Author
     */
    public function setAuthor($Author)
    {
        $this->Author = $Author;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param mixed $recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @return mixed
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * @param mixed $portion
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;
    }

    /**
     * @return mixed
     */
    public function getImagePAth()
    {
        return $this->ImagePAth;
    }

    /**
     * @param mixed $ImagePAth
     */
    public function setImagePAth($ImagePAth)
    {
        $this->ImagePAth = $ImagePAth;
    }

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return mixed
     */
    public function getBakeTime()
    {
        return $this->bakeTime;
    }

    /**
     * @param mixed $bakeTime
     */
    public function setBakeTime($bakeTime)
    {
        $this->bakeTime = $bakeTime;
    }

    /**
     * @return mixed
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * @param mixed $preparationTime
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param mixed $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->Difficulty;
    }

    /**
     * @param mixed $Difficulty
     */
    public function setDifficulty($Difficulty)
    {
        $this->Difficulty = $Difficulty;
    }



}