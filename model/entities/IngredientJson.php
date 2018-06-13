<?php
/**
 * Class IngredientJs
 * This class is not used for . It shall be use for select2 ingredient dropdown
 *
 */

class IngredientJson
{
    private $id;
    private $text;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }





}