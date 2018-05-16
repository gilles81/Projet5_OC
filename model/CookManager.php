<?php
/**
 *
 *Class CookManager
 *
 * Manage
 */


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
     * Get all Dishes in database return an array.
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
        $query = "SELECT * FROM dish ";
        $req = $bdd->prepare($query);
        $req->execute();
        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;
        }
        return $Dishes;
    }





    /**
     * @return array
     */
    public function findDishesFromStatus($status)
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM dish WHERE Status =:Status ";
        $req = $bdd->prepare($query);
        $req->bindValue(':Status', $status , PDO::PARAM_STR);
        $req->execute();

        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;

        }
        return $Dishes;
    }




    public function findFeaturedDishes()
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM dish WHERE Featured =:Featured AND Status ='R'";


        $req = $bdd->prepare($query);
        $req->bindValue(':Featured', 1 , PDO::PARAM_INT);
        $req->execute();

        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
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
        $query = "SELECT * FROM dish WHERE DishId =:id";

        $req = $bdd->prepare($query);
        $req->bindValue(':id', $id , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $data = $this->rowInArray($row);
        $dish = new BasicDish( $data);

        return $dish;
    }

    public function findCategory($category ,$status )
    {
        $bdd = $this->bdd;

        if ((!isset($status)) AND (($status ='D')  OR ($status ='R') OR ($status ='W') )) {

            $status = 'R';

        }

        $query =  "SELECT * FROM dish WHERE Category=:Category AND Status =:Status";

        $req = $bdd->prepare($query);
        $req->bindValue(':Category', $category , PDO::PARAM_INT);
        $req->bindValue(':Status', $status , PDO::PARAM_STR);
        $req->execute();
        $dishes=  array();
        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $dishes[] = $dish;
        }

        return $dishes;
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
     * remove a comment from database
     *
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

    public function addDish(Dish $dish)
    {
        $bdd = $this->bdd;
        $query = "INSERT INTO Dishes (DishId ,Name,Category,Author,Recipe,Portion,ImagePAth,Origin,BakeTime,PreparationTime,Difficulty,Ingredients , CreationDate,Status,Likes)
                VALUES ( NULL ,:Name, :Category, :Author,:Recipe,:Portion,:ImagePAth,:Origin,:BakeTime,:PreparationTime,:Difficulty,:Ingredients,Now(),:Status,:Likes );";
        $req = $bdd->prepare($query);

        $req->bindValue(':Name',$dish->getName(),PDO::PARAM_STR);
        $req->bindValue(':Category',$dish->getCategory(),PDO::PARAM_STR);
        $req->bindValue(':Author',$dish->getAuthor(),PDO::PARAM_STR);
        $req->bindValue(':Recipe',$dish->getRecipe(),PDO::PARAM_STR);
        $req->bindValue(':Portion',$dish->getPortion(),PDO::PARAM_INT);
        $req->bindValue(':ImagePAth',$dish->getImagePAth(),PDO::PARAM_STR);
        $req->bindValue(':Origin',$dish->getOrigin(),PDO::PARAM_STR);
        $req->bindValue(':BakeTime',$dish->getBakeTime(),PDO::PARAM_STR);
        $req->bindValue(':PreparationTime',$dish->getPreparationTime(),PDO::PARAM_STR);

        $req->bindValue(':Difficulty',$dish->getDifficulty(),PDO::PARAM_INT);

        $req->bindValue(':Ingredients',$dish->getIngredients(),PDO::PARAM_STR);
        $req->bindValue(':Status',$dish->getStatus(),PDO::PARAM_STR);
        $req->bindValue(':Status',$dish->getLikes(),PDO::PARAM_INT);

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
     * updateDishRecipe
     *
     * @param BasicDish $dish
     */

    public function updateDishRecipe(BasicDish $dish)
    {
        $bdd = $this->bdd;

        $req = $bdd->prepare('UPDATE posts SET PostContent = :Content, Title = :Title , modificationDate=NOW(),Position= :PostPosition WHERE PostId = :PostId');
        // TODO : faire updateDishRecipe

        /*
        $req->bindValue(':PostId',$post->getPostId(),PDO::PARAM_INT);
        $req->bindValue(':Content',$post->getContent() ,PDO::PARAM_STR);
        $req->bindValue(':Title',$post->getTitle(),PDO::PARAM_STR);
        $req->bindValue(':PostPosition',$post->getPosition(),PDO::PARAM_INT);
*/

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