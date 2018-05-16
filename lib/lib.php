<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 22:37
 */




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

    public function rowInArray( $row)
    {
        $donnees = array();
        $donnees = [
            'dishId' => $row['DishId'],
            'name' => $row['Name'],
            'category' => $row['Category'],
            'author' =>$row['Author'],
            'creationDate' => $row['CreationDate'],
            'recipe' => $row['Recipe'],
            'portion' => $row['Portion'],
            'imagePathName' => $row['ImagePathName'],
            'origin' => $row['Origin'],
            'cookingTime' => $row['CookingTime'],
            'preparationTime' => $row['PreparationTime'],
            'ingredients' => $row['Ingredients'],
            'difficulty' => $row['Difficulty'],
            'featured' => $row['Featured'],
            'likes' => $row['Likes'],
            'status' => $row['Status']
        ];
        return $donnees;
    }
}