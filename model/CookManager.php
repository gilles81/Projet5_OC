<?php
/**
 *
 *Class CookManager
 *
 * Manage
 */
namespace Projet5;

class CookManager extends BackManager
{
    private  $bdd;

    /**
     * CookManager constructor.
     */
    public function __construct()
    {
        $this->bdd = parent ::bddAssign();
    }

    /**
     *
     *  findDishes
     *
     * Get all Dishes in database return an array
     *
     *

     * @return array
     */
    public function findDishes()
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM Dishes ";
        $req = $bdd->prepare($query);
        $req->execute();
        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $dish = new BasicDish();
            $dish->setDishId($row['DishId']);
            $dish->setName($row['Name']);
            $dish->setCategory($row['category']);
            $dish->setAuthor($row['Author']);
            $dish->setCreationDate($row['CreationDate']);
            $dish->setRecipe(( ($row['Recipe'])));
            $dish->setPortion(( ($row['Portion'])));
            $dish->setImagePath(( ($row['ImagePath'])));
            $dish->setOrigin(( ($row['Origin'])));
            $dish->setBakeTime(( ($row['BakeTime'])));
            $dish->setPreparationTime(( ($row['PreparationTime'])));
            $dish->setIngredients(( ($row['PreparationTime'])));
            $dish->setDifficulty(( ($row['Difficulty'])));

            $Dishes[] = $dish;
        }
        return $Dishes;
    }

    /**
     * findDish
     *
     * find a dish in database and return in a object
     *
     * @param $id
     * @return BasicDish
     */
    public function findDish($id)
    {
        /**
         * model access
         * */
        $bdd = $this->bdd;
        $query = "SELECT * FROM Dishes WHERE DishId =:id";

        $req = $bdd->prepare($query);
        $req->bindValue(':id', $id , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $dish = new BasicDish();
        $dish->setDishId($row['DishId']);
        $dish->setName($row['Name']);
        $dish->setCategory($row['category']);
        $dish->setAuthor($row['Author']);
        $dish->setCreationDate($row['CreationDate']);
        $dish->setRecipe(( ($row['Recipe'])));
        $dish->setPortion(( ($row['Portion'])));
        $dish->setImagePath(( ($row['ImagePath'])));
        $dish->setOrigin(( ($row['Origin'])));
        $dish->setBakeTime(( ($row['BakeTime'])));
        $dish->setPreparationTime(( ($row['PreparationTime'])));
        $dish->setIngredients(( ($row['PIngredients'])));
        $dish->setDifficulty(( ($row['Difficulty'])));

        return $dish;
    }

    /**
     * addComment
     *
     * @param $values
     */


    public function addComment($values)
    {
            $bdd = $this->bdd;
            $query = "INSERT INTO Comments (CommentId , DishId , Author,CreationDate,ModificationDate,CommentContent,Answ) VALUES (NULL, :DishID ,:Author, NOW(), NOW(),:CommentContent,'');";
            $req = $bdd->prepare($query);


            $req->bindValue(':Dishid', $values['DishId'], PDO::PARAM_INT);
            $req->bindValue(':Author', $values['Author'], PDO::PARAM_STR);
            $req->bindValue(':CommentContent', $values['Topic'], PDO::PARAM_STR);

            $req->execute();

    }
    /**
     * addanswer
     *
     * @param $values
     */

    public function addAnswer($values)
    {
        $bdd = $this->bdd;
        $query = "INSERT INTO Comments (CommentId , DishId , Author,CreationDate,ModificationDate,CommentContent,Answ,AnswerId) VALUES (NULL, :Dishid ,:Author, NOW(), NOW(),:CommentContent,:Answ,:AnswerId);";
        $req = $bdd->prepare($query);

        //
        $req->bindValue(':Dishid',  $values['DishId'], PDO::PARAM_INT);
        //
        $req->bindValue(':CommentContent', 'NA', PDO::PARAM_STR);
        //
        $req->bindValue(':Author', $values['Author'], PDO::PARAM_STR);
        $req->bindValue(':AnswerId', $values['AnswerId'], PDO::PARAM_INT);
        $req->bindValue(':Answ', $values['Answ'], PDO::PARAM_STR);

        $req->execute();
    }

    /**
     *  remove
     *
     * remov e a comment from database
     * @param $ComId
     */
    public function remove($ComId)
    {
        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `Comments` WHERE `CommentId` = $ComId");

        if (!$req) {
            echo 'Erreur a la suppression du commentaire';
        }
    }

    /**
     * addDish
     *
     *
     *
     * @param Post $post
     */

    //TODO : A faire
    public function addDish(Post $post)
    {
        $bdd = $this->bdd;
        $query = "INSERT INTO Dishes (DishId , Author,CreationDate,ModificationDate,Title,PostContent) VALUES ( NULL ,:Author, NOW(), NOW(),:Name,:PostContent);";
        $req = $bdd->prepare($query);

        $req->bindValue(':Title',$post->getTitle(),PDO::PARAM_STR);
        $req->bindValue(':Author','Jean Forteroche',PDO::PARAM_STR);
        $req->bindValue(':PostContent',$post->getContent(),PDO::PARAM_STR);
        $req->bindValue(':PostPosition',$post->getPosition(),PDO::PARAM_INT);
        $req -> execute();
    }

    /**
     *  removePost
     *
     * delette a post from database
     *
     * @param $PostId
     */
    public function removeDish($DishId)
    {

        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `Dishes` WHERE `DishId` = $DishId");

        if (!$req) {

            echo 'Erreur a la suppression du chapitre';

        }
    }

    /**
     * updateDish
     *
     * @param BasicDish $dish
     */

    public function updateDish(BasicDish $dish)
    {
        $bdd = $this->bdd;

        $req = $bdd->prepare('UPDATE posts SET PostContent = :Content, Title = :Title , modificationDate=NOW(),Position= :PostPosition WHERE PostId = :PostId');

        $req->bindValue(':PostId',$post->getPostId(),PDO::PARAM_INT);
        $req->bindValue(':Content',$post->getContent() ,PDO::PARAM_STR);
        $req->bindValue(':Title',$post->getTitle(),PDO::PARAM_STR);
        $req->bindValue(':PostPosition',$post->getPosition(),PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * Warning
     *
     * @param $id
     * @param $value
     */
    public function Warning($id , $value)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE comments SET Warning = :Warning  WHERE CommentId = :CommentId');
        $req->bindValue(':Warning',$value,PDO::PARAM_INT);
        $req->bindValue(':CommentId',$id,PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * getWarnings
     *
     * @return array
     */
    public function getWarnings()
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare($query = "SELECT * FROM Comments WHERE Warning =:warning");
        $req->bindValue(':warning','1',PDO::PARAM_INT);
        $req->execute();

        //$req->fetch(PDO::FETCH_ASSOC);

        $warnings = array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC)){
            $warning = new Warning();
            $warning->setPostId($row['PostId']);
            $warning->setCommentId($row['CommentId']);
            $warning->setAnswerId($row['AnswerId']);
            $warning->setAnswer($row['Answ']);
            $warning->setTopic($row['CommentContent']);
            $warning->setAuthor($row['Author']);

            $warnings[] = $warning;

        }

        return $warnings;


    }

    
}