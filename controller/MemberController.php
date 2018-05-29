<?php
/**
 * Class MemberController
 *
 * used to manage loggin session and deconnection
 */
class MemberController extends lib
{
    /**
     *  loginSession()
     *
     * Loggin : Call login view for define Log an Pswd
     */
    public function loginSession()
    {
       $this->sessionStatus();

        $myView = new View('userCnxForm');
        $myView->build( array('recipes'=> null ,'ingredientList'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST,'adminLevel'=>  $_SESSION['adminLevel']));
    }

    /**
     *   public function deconnexion()
     *
     * Used to deconnect from admin mode .
     *
     *
     */

    public function deconnection()

    {
        $_SESSION['adminLevel']=0;
        session_destroy();
        // redirect to Home Page
        $myView = new View('userCnxForm');
        $myView->build( array('recipes'=> null ,'ingredientList'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST,'adminLevel'=> 0));

    }

    /**
     *
     *   identification()
     *
     *
     *  control of identifiation
     *
     *       *
     *
     */
    public function identification()
    {
        if (isset($_POST['pass']) AND isset($_POST['login'])) {

            // Get Bdd ident
            $manager = new MemberManager();
            $member = $manager->getMember($_POST['login']); //object from data base definition corresponding to login request
            if (!$member) {
                echo 'Ce pseudo n\'est pas enregistré dans la base de donnée des membres !';

            } else {

                if (($member->getRight() == '1')) // Vréifiction of Bdd right on Bdd member registration
                {
                    $isPasswordCorrect = password_verify($_POST['pass'], $member->getPass());
                    if ($isPasswordCorrect) {
                        $_SESSION['id'] = $member->getId();
                        $_SESSION['pseudo'] = $member->getPseudo();
                        $_SESSION['adminLevel'] = 1;
                        /** Redirection to home Page with all Posts**/
                        $myView = new View(' ');
                        $myView->redirect('adminBoard.html');
                    } else {
                        /** Redirection to cnx PAge**/

                        $myView = new View('userCnxForm');
                        $myView->build( array('recipes'=> null ,'ingredientList'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST,'adminLevel'=>  $_SESSION['adminLevel']) );

                    }
                } else {
                    /** Redirection to PWD Page **/

                    $myView = new View('userCnxForm');
                    $myView->build( array('recipes'=> null ,'ingredientList'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST,'adminLevel'=>  $_SESSION['adminLevel']) );
                }
            }
        }else{
            $myView = new View('userCnxForm');
            $myView->build( array('recipes'=> null ,'ingredientList'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST,'adminLevel'=>  $_SESSION['adminLevel']  ));
        }
    }



}