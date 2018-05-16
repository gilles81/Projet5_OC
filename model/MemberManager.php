<?php
/**
 *
 *
 */

class MemberManager extends BackManager
{
    private  $bdd;

    public function __construct()
    {
        $this->bdd = parent ::bddAssign();
    }

    /**
     *  getMember($pseudo) method .
     *
     * Get One user definition from a $pseudo
     *
    * @param $pseudo
     * @return user
     */


    public function getMember($pseudo)
    {
        $bdd = $this->bdd;
        $query = 'SELECT * FROM member WHERE pseudo =:pseudo';


        $req = $bdd->prepare($query);
        $req->bindValue(':pseudo', $pseudo , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);
        $user->setPass($row['pass']);
        $user->setEmail($row['email']);
        $user->setRight($row['rights']);

        return $user;
    }

    /**
     *  getMembers() method .
     *
     * Get all users in BDD
     *
     * @return user
     */
    public function getMembers()
    {

        $bdd = $this->bdd;
        $query = "SELECT * FROM members WHERE member ";

        $req = $bdd->prepare($query);
        //$req->bindValue(':pseudo', $pseudo , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);

        $user->setEmail($row['email']);
        $user->setRight($row['rights']);

        return $user;
    }

    /**
     * getAdminMember()
     *
     * Get Admins member in dataBase
     *
     * @return User
     */
    public function getAdminMember()
    {
        $bdd = $this->bdd;
        $query = "SELECT * FROM member WHERE rights =:rights";

        $req = $bdd->prepare($query);
        $req->bindValue('rights', "1" , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);

        $user->setEmail($row['email']);
        $user->setRight($row['rights']);

        return $user;
    }



}