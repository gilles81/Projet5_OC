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

        $perPage=8;
        $req=$bdd->query('SELECT COUNT(*) AS total FROM dish');
        $result=$req->fetch();
        $total = $result['total'];

        $nbPage = ceil($total/$perPage);

        if ((isset ($_GET['page'])) &&  (!empty($_GET['page'])) && (ctype_digit($_GET['page']) ==1 )){
            if ($_GET['page'] > $nbPage) {
                $current = $nbPage;
            }else {

                $current = $_GET['page'];
            }
        }else {
            $current = 1;
        }
        $firstOfPage = ($current-1)*$perPage;


        /**
         * model access
         * */
        $query = "SELECT * FROM dish LIMIT $firstOfPage,$perPage ";
        $req = $bdd->prepare($query);
        $req->execute();
        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;
        }
        $dishToDisplay = array();
        $dishToDisplay = ['dishes'=>$Dishes ,'cPage'=> $current ,'nbPage'=>$nbPage ];
        return  $dishToDisplay;
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

    public function duplicRecipe( $currentDish)
    {
        $bdd = $this->bdd;

        $query = "INSERT INTO `dish` (`DishId`, `Title`, `Category`, `Author`, `CreationDate`, `Recipe`, `Portion`, `ImagePathName`, `Origin`, `CookingTime`,
 `PreparationTime`, `Ingredients`, `Difficulty`, `Featured`, `Status`, `lke`)
                  VALUES (NULL, 'Nouvelle recette ', :Category, '', now(), 'rrr', '5', 'rrr', 'FRANCE', '0:00:00', '0:00:00', '', '0', '0', 'D', '0');";


        $req = $bdd->prepare($query);
        $req->execute();

        //$req->bindValue(':Title',$values['Name'],PDO::PARAM_STR);
        $req->bindValue(':Category',$currentDish->getCategory(),PDO::PARAM_INT);
        $req->bindValue(':Author',$currentDish->getAuthor(),PDO::PARAM_STR);
        $req->bindValue(':Recipe',$currentDish->getRecipe(),PDO::PARAM_STR);
        $req->bindValue(':Portion',4,PDO::PARAM_INT);
        $req->bindValue(':ImagePathName','',PDO::PARAM_STR);
        $req->bindValue(':Origin','FRANCE',PDO::PARAM_STR);
        //$req->bindValue(':CookingTime','',PDO::PARAM_STR );
        //$req->bindValue(':PreparationTime','',PDO::PARAM_STR);
        $req->bindValue(':Ingredients','ffff',PDO::PARAM_STR);
        $req->bindValue(':Difficulty',1,PDO::PARAM_INT);
        $req->bindValue(':Featured',0,PDO::PARAM_INT);
        $req->bindValue(':Status','D',PDO::PARAM_STR);
        $req->bindValue(':Likes',0,PDO::PARAM_INT);
        $req->execute();
    }



    public function createEmptyRecipe()
    {
        $bdd = $this->bdd;

        $query = "INSERT INTO `dish` (`DishId`, `Title`, `Category`, `Author`, `CreationDate`, `Recipe`, `Portion`, `ImagePathName`, `Origin`, `CookingTime`,
 `PreparationTime`, `Ingredients`, `Difficulty`, `Featured`, `Status`, `lke`)
                  VALUES (NULL, 'Nouvelle recette ', '1', '', now(), 'rrr', '5', 'rrr', 'FRANCE', '0:00:00', '0:00:00', '', '0', '0', 'D', '0');";


        $req = $bdd->prepare($query);
        $req->execute();
    }

    public function addDish($values)
    {
        $bdd = $this->bdd;
        $query = "INSERT INTO dish (DishId,Title,Category,Author, CreationDate,Recipe,Portion,ImagePathName,Origin,CookingTime,PreparationTime,Ingredients ,Difficulty,Featured,Status,lke)
                  VALUES (NULL ,:Title,:Category,:Author,Now(),:Recipe,:Portion,:ImagePathName,:Origin,NULL,NULL,:Ingredients,:Difficulty,:Featured,:Status,:Likes );";


        $req = $bdd->prepare($query);
        $req->execute();

        $req->bindValue(':Title',$values['Name'],PDO::PARAM_STR);
        $req->bindValue(':Category',1,PDO::PARAM_INT);
        $req->bindValue(':Author','Gilles',PDO::PARAM_STR);
        $req->bindValue(':Recipe',$values['Preparation'],PDO::PARAM_STR);
        $req->bindValue(':Portion',4,PDO::PARAM_INT);
        $req->bindValue(':ImagePathName','',PDO::PARAM_STR);
        $req->bindValue(':Origin','FRANCE',PDO::PARAM_STR);
        //$req->bindValue(':CookingTime','',PDO::PARAM_STR );
        //$req->bindValue(':PreparationTime','',PDO::PARAM_STR);
        $req->bindValue(':Ingredients','ffff',PDO::PARAM_STR);
        $req->bindValue(':Difficulty',1,PDO::PARAM_INT);
        $req->bindValue(':Featured',0,PDO::PARAM_INT);
        $req->bindValue(':Status','D',PDO::PARAM_STR);
        $req->bindValue(':Likes',0,PDO::PARAM_INT);
        $req->execute();

    }
    /**
     *  removePost
     *
     * delette a post from database
     *
     * @param $PostId
     */
    public function removeDish( $dishId)
    {

        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `dish` WHERE `DishId` = $dishId");

        if (!$req) {

            echo 'Erreur a la suppression du chapitre';

        }
    }

    /**
     * u
     */

    public function UpdateRecipeName($newRecipeName)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Title =:Name WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipeName->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Name',$newRecipeName->getName(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * u
     */

    public function UpdateRecipePreparation($newRecipePreparation)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Recipe =:Name WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipePreparation->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Name',$newRecipePreparation->getRecipe(),PDO::PARAM_STR);
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