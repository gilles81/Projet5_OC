<?php

/**
 * Class MiscController
 */

class MiscController
{
    /**
     * public function showAbout()
     *
     * call a view with Presentation of J.Forteroche form
     *
     *
     */

    public function showAbout()
    {
        $myView = new View('about');
        $myView->build(array('chapters'=> null ,'comments'=>null,'warningList' => null,'HOST'=>HOST ,'adminLevel'=>$_SESSION['adminLevel'] ));
    }

    /**
     * public function showContact()
     *
     * call a view with contact form
     */


    public function showContact()
    {
        $myView = new View('contact');
        $myView->build(array('recipes' => null, 'comments' => null,'warningList' => null ,'message'=> null,'HOST' => HOST, 'adminLevel' =>$_SESSION['adminLevel']));
    }

    /**
     *  ContactMail()
     *
     *    send mail to mailbox
     *
     * @return bool
     */
    public function ContactMail()
    {
        if(empty($_POST['name'])      ||
            empty($_POST['email'])     ||
            empty($_POST['phone'])     ||
            empty($_POST['message'])   ||
            !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            echo "No arguments Provided!";
            return false;
        }

        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email_address = strip_tags(htmlspecialchars($_POST['email']));
        $phone = strip_tags(htmlspecialchars($_POST['phone']));
        $message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
        $to = 'jean.forteroche@gillessabathe.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
        $email_subject = "Website Contact Form:  $name";
        $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
        $headers = "From: noreply@gillessabathe.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $headers .= "Reply-To: $email_address";
        mail($to,$email_subject,$email_body,$headers);
        return true;

    }

    /**
     * displayMentions
     *
     * call a view to display legal mention
     */


    public function displayMentions()
    {

        $myView = new View('legalMentions');
        $myView->build(array('recipes' => null, 'comments' => null,'warningList' => null ,'message'=> null,'HOST' => HOST, 'adminLevel' =>$_SESSION['adminLevel']));
    }

}