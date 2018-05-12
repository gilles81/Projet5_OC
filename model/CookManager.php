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
        $query = "SELECT * FROM dish ";
        $req = $bdd->prepare($query);
        $req->execute();
        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $dish = new BasicDish();
            $dish->setDishId($row['DishId']);
            $dish->setName($row['Name']);
            $dish->setCategory($row['Category']);
            $dish->setAuthor($row['Author']);
            $dish->setCreationDate($row['CreationDate']);
            $dish->setRecipe(( ($row['Recipe'])));
            $dish->setPortion(( ($row['Portion'])));
            $dish->setImagePathName(( ($row['ImagePathName'])));
            $dish->setOrigin(( ($row['Origin'])));
            $dish->setCookingTime(( ($row['CookingTime'])));
            $dish->setPreparationTime(( ($row['PreparationTime'])));
            $dish->setIngredients(( ($row['Ingredients'])));
            $dish->setDifficulty(( ($row['Difficulty'])));
            $dish->setFeatured(( ($row['Featured'])));

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
        $query = "SELECT * FROM dish WHERE Featured =:Featured";


        $req = $bdd->prepare($query);
        $req->bindValue(':Featured', 1 , PDO::PARAM_INT);
        $req->execute();

        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $dish = new BasicDish();
            $dish->setDishId($row['DishId']);
            $dish->setName($row['Name']);
            $dish->setCategory($row['Category']);
            $dish->setAuthor($row['Author']);
            $dish->setCreationDate($row['CreationDate']);
            $dish->setRecipe(( ($row['Recipe'])));
            $dish->setPortion(( ($row['Portion'])));
            $dish->setImagePathName(( ($row['ImagePathName'])));
            $dish->setOrigin(( ($row['Origin'])));
            $dish->setCookingTime(( ($row['CookingTime'])));
            $dish->setPreparationTime(( ($row['PreparationTime'])));
            $dish->setIngredients(( ($row['Ingredients'])));
            $dish->setDifficulty(( ($row['Difficulty'])));
            $dish->setFeatured(( ($row['Featured'])));

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

        $dish = new BasicDish();
        $dish->setDishId($row['DishId']);
        $dish->setName($row['Name']);
        $dish->setCategory($row['Category']);
        $dish->setAuthor($row['Author']);
        $dish->setCreationDate($row['CreationDate']);
        $dish->setRecipe(( ($row['Recipe'])));
        $dish->setPortion(( ($row['Portion'])));
        $dish->setImagePathName(( ($row['ImagePathName'])));
        $dish->setOrigin(( ($row['Origin'])));
        $dish->setCookingTime(( ($row['CookingTime'])));
        $dish->setPreparationTime(( ($row['PreparationTime'])));
        $dish->setIngredients(( ($row['Ingredients'])));
        $dish->setDifficulty(( ($row['Difficulty'])));
        $dish->setFeatured(( ($row['Featured'])));
        return $dish;
    }

    public function findCategory($category)
    {

        $bdd = $this->bdd;


        $query =  "SELECT * FROM dish WHERE Category =:Category";


        $req = $bdd->prepare($query);
        $req->bindValue(':Category', $category , PDO::PARAM_INT);
        $req->execute();

        $dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $dish = new BasicDish();
            $dish->setDishId($row['DishId']);
            $dish->setName($row['Name']);
            $dish->setCategory($row['Category']);
            $dish->setAuthor($row['Author']);
            $dish->setCreationDate($row['CreationDate']);
            $dish->setRecipe(( ($row['Recipe'])));
            $dish->setPortion(( ($row['Portion'])));
            $dish->setImagePathName(( ($row['ImagePathName'])));
            $dish->setOrigin(( ($row['Origin'])));
            $dish->setCookingTime(( ($row['CookingTime'])));
            $dish->setPreparationTime(( ($row['PreparationTime'])));
            $dish->setIngredients(( ($row['Ingredients'])));
            $dish->setDifficulty(( ($row['Difficulty'])));
            $dish->setFeatured(( ($row['Featured'])));

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
        $query = "INSERT INTO Dishes (DishId ,Name,Category,Author,Recipe,Portion,ImagePAth,Origin,BakeTime,PreparationTime,Difficulty,Ingredients , CreationDate)
                VALUES ( NULL ,:Name, :Category, :Author,:Recipe,:Portion,:ImagePAth,:Origin,:BakeTime,:PreparationTime,:Difficulty,:Ingredients,Now() );";
        $req = $bdd->prepare($query);

        $req->bindValue(':Name',$dish->setName(),PDO::PARAM_STR);
        $req->bindValue(':Category',$dish->setCategory(),PDO::PARAM_STR);
        $req->bindValue(':Author',$dish->setAuthor(),PDO::PARAM_STR);
        $req->bindValue(':Recipe',$dish->setRecipe(),PDO::PARAM_STR);
        $req->bindValue(':Portion',$dish->setPortion(),PDO::PARAM_INT);
        $req->bindValue(':ImagePAth',$dish->setImagePAth(),PDO::PARAM_STR);
        $req->bindValue(':Origin',$dish->setOrigin(),PDO::PARAM_STR);
        $req->bindValue(':BakeTime',$dish->setBakeTime(),PDO::PARAM_STR);
        $req->bindValue(':PreparationTime',$dish->setPreparationTime(),PDO::PARAM_STR);

        $req->bindValue(':Difficulty',$dish->setDifficulty(),PDO::PARAM_INT);

        $req->bindValue(':Ingredients',$dish->setIngredients(),PDO::PARAM_STR);

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