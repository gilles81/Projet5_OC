<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 21:42
 */

class BasicDish
{
    private $dishId;
    private $name;
    private $category;
    private $Author;
    private $creationDate;
    private $recipe;
    private $portion;
    private $ImagePathName;
    private $origin;
    private $cookingTime;
    private $preparationTime;
    private $ingredients;
    private $difficulty;
    private $featured;
    private $status;// R = Ready to published , D = Draft , W = Wainting list
    private $cat1;
    private $cat2;
    private $cat3;
    private $cat4;


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

// …
    /**
     * @return mixed
     */
    public function getCat1()
    {


        return $this->cat1;
    }

    /**
     * @param mixed $cat1
     */
    public function setCat1($cat1)
    {
        if (!is_numeric($cat1)){
            return;
        }
        if ($cat1 < 0 ){
            return;
        }
        $this->cat1 = $cat1;
    }

    /**
     * @return mixed
     */
    public function getCat2()
    {

        return $this->cat2;
    }

    /**
     * @param mixed $cat2
     */
    public function setCat2($cat2)
    {
        if (!is_numeric($cat2)){
            return;
        }
        if ($cat2 < 0 ){
            return;
        }
        $this->cat2 = $cat2;
    }

    /**
     * @return mixed
     */
    public function getCat3()
    {

        return $this->cat3;
    }

    /**
     * @param mixed $cat3
     */
    public function setCat3($cat3)
    {
        if (!is_numeric($cat3)){
            return;
        }
        if ($cat3 < 0 ){
            return;
        }
        $this->cat3 = $cat3;
    }

    /**
     * @return mixed
     */
    public function getCat4()
    {
        return $this->cat4;
    }

    /**
     * @param mixed $cat4
     */
    public function setCat4($cat4)
    {
        if (!is_numeric($cat4)){
            return;
        }
        if ($cat4 < 0 ){
            return;
        }
        $this->cat4 = $cat4;
    }








    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if (!is_string($status)){
            return;
        }


        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getFeatured()
    {

        return $this->featured;
    }

    /**
     * @param mixed $featured
     */
    public function setFeatured($featured)
    {
        if (!is_numeric($featured)){
            return;
        }
        if ($featured < 0 ){
            return;
        }
        $this->featured = $featured;
    }

    /**
     * @return mixed
     */
    public function getImagePathName()
    {

        return $this->ImagePathName;
    }

    /**
     * @param mixed $ImagePathName
     */
    public function setImagePathName($ImagePathName)
    {
        if (!is_string($ImagePathName)){
            return;
        }
        $this->ImagePathName = $ImagePathName;
    }



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
        if (!is_numeric($dishId)){
            return;
        }
        if ($dishId < 0 ){
            return;
        }

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
        if (!is_string($name)){
            return;
        }
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
        if (!is_string($category)){
            return;
        }
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
        if (!is_string($Author)){
            return;
        }
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
        if (!is_string($recipe)){
            return;
        }
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
        if (!is_numeric($portion)){
            return;
        }
        if ($portion < 0 ){
            return;
        }
        $this->portion = $portion;
    }


    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     */
    public function setOrigin($origin)
    {
        if (!is_string($origin)){
            return;
        }

        $this->origin = $origin;
    }

    /**
     * @return mixed
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * @param mixed $cookingTime
     */
    public function setCookingTime($cookingTime)
    {
        if (!is_string($cookingTime)){
            return;
        }


        $this->cookingTime = $cookingTime;
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
        if (!is_string($preparationTime)){
            return;
        }

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
        if (!is_string($ingredients)){
            return;
        }
        $this->ingredients = $ingredients;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        if (!is_numeric($difficulty)){
            return;
        }
        $this->difficulty = $difficulty;
    }








}