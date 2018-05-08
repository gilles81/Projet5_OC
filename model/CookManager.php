<?php
/**
 *
 *Class CookManager
 *
 *
 */
namespace Projet5;
class CookManager extends BackManager
{
    private  $bdd;

    public function __construct()
    {
        $this->bdd = parent ::bddAssign();
    }

    /**
     *
     *  public function findDishes()
     *
     * Get all Dishes in database in an array
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
            $dish = new Dish();
            $dish->setDishId($row['DishId']);
            $dish->setName($row['Name']);
            $dish->setCategory($row['category']);
            $dish->setAuthor($row['Author']);
            $dish->setCreationDate($row['CreationDate']);
            $dish->setRecipe(( ($row['Recipe'])));
            $dish->setPotion(( ($row['Portion'])));
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

        $dish = new Dish();
        $dish->setDishId($row['DishId']);
        $dish->setName($row['Name']);
        $dish->setCategory($row['category']);
        $dish->setAuthor($row['Author']);
        $dish->setCreationDate($row['CreationDate']);
        $dish->setRecipe(( ($row['Recipe'])));
        $dish->setPotion(( ($row['Portion'])));
        $dish->setImagePath(( ($row['ImagePath'])));
        $dish->setOrigin(( ($row['Origin'])));
        $dish->setBakeTime(( ($row['BakeTime'])));
        $dish->setPreparationTime(( ($row['PreparationTime'])));
        $dish->setIngredients(( ($row['PIngredients'])));
        $dish->setDifficulty(( ($row['Difficulty'])));

        return $dish;
    }


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
    public function remove($ComId)
    {
        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `Comments` WHERE `CommentId` = $ComId");

        if (!$req) {
            echo 'Erreur a la suppression du commentaire';
        }
    }

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
     *
     * public function removePost($PostId)
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

    public function updateDish(Dish $dish)
    {
        $bdd = $this->bdd;

        $req = $bdd->prepare('UPDATE posts SET PostContent = :Content, Title = :Title , modificationDate=NOW(),Position= :PostPosition WHERE PostId = :PostId');

        $req->bindValue(':PostId',$post->getPostId(),PDO::PARAM_INT);
        $req->bindValue(':Content',$post->getContent() ,PDO::PARAM_STR);
        $req->bindValue(':Title',$post->getTitle(),PDO::PARAM_STR);
        $req->bindValue(':PostPosition',$post->getPosition(),PDO::PARAM_INT);

        $req->execute();
    }
    public function Warning($id , $value)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE comments SET Warning = :Warning  WHERE CommentId = :CommentId');
        $req->bindValue(':Warning',$value,PDO::PARAM_INT);
        $req->bindValue(':CommentId',$id,PDO::PARAM_INT);

        $req->execute();
    }


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