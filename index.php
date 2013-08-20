<?php

///////////////////////////////////////////////////////////
// --------------------- VARIABLES --------------------- //
///////////////////////////////////////////////////////////

define('TOEMAIL','iam@markoaleksic.com');

///////////////////////////////////////////////////////////////////////////
// --------------------- LOAD AND INSTANTIATE LIBS --------------------- //
///////////////////////////////////////////////////////////////////////////

require '_lib/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

////////////////////////////////////////////////////////
// --------------------- ROUTES --------------------- //
////////////////////////////////////////////////////////

$app->get('/',function () use ($app) {
        return $app->render('master.php');
    });

$app->post('/post-contact', function() use ($app) {

        $req = $app->request();

        $name    = $req->post('name');
        $email   = $req->post('email');
        $message = $req->post('message');
        $subject = $req->post('subject');

        $return_array = validate($name, $email, $message, $subject);

        if($return_array['success'] == '1')
        {
            send_email($name, $email, $subject, $message);
        }

        if($req->isAjax())
        {
            header('Content-type: text/json');
            echo json_encode($return_array);
        }
        else
        {
            $app->redirect($_SERVER['HTTP_REFERER'] . '#contact');
        }

        die();
    });

//////////////////////////////////////////////////////////
// --------------------- RUN SLIM --------------------- //
//////////////////////////////////////////////////////////

$app->run();

///////////////////////////////////////////////////////////////////
// --------------------- PRIVATE FUNCTIONS --------------------- //
///////////////////////////////////////////////////////////////////

function send_email($name, $email, $email_subject, $email_message)
{
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n";

    $message = "<strong>Name: </strong>" . $name . "<br>";
    $message .= "<strong>Message:</strong>" . "<br>" . $email_message . "<br>";

    @mail(TOEMAIL, $email_subject, $message,$headers);

    return true;
}

function validate($name,$email,$message,$subject)
{
    $return_array                = array();
    $return_array['success']     = '1';
    $return_array['errors']      = array();

    if($email == '')
    {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Email is required');
    }
    else
    {
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email))
        {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid email');
        }
    }

    if($name == '')
    {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Name is required');
    }
    else
    {
        $string_exp = "/^[A-Za-z .'-]+$/";

        if (!preg_match($string_exp, $name))
        {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid name');
        }
    }


    if($subject == '')
    {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Subject is required');
    }

    if($message == '')
    {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Message is required');
    }
    else
    {
        if (strlen($message) < 2)
        {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid message');
        }
    }
    return $return_array;
}