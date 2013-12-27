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

$app = new \Slim\Slim(array(
    'debug' => true,
    'mode'  => 'testing'
));

////////////////////////////////////////////////////////
// --------------------- ROUTES --------------------- //
////////////////////////////////////////////////////////

$app->get('/',function () use ($app) {

        $data = array(
            'title'             => 'The CV of Marko Aleksić',
            'description'       => 'Professional website and CV of Marko Aleksić.',
            'keywords'          => 'Marko, Aleksic, CV, web developer, professional, career, personal, consulting, business, software, php, laravel, codeigniter',
            'author'            => 'Marko Aleksić',
            'googleAnalyticsId' => 'UA-43415136-1',
            'domain'            => 'markoaleksic.com',
            'sections'          => array(
                    'career',
                    'education',
                    'experience',
                    'skills',
                    'projects',
                    'contact'
                )
            );

        return $app->render('master.php',$data);
    });

$app->post('/post-contact', function() use ($app) {

        $req = $app->request();

        $name    = $req->post('name');
        $email   = $req->post('email');
        $message = $req->post('message');

        $return_array = validate($name, $email, $message);

        $subject = "[MarkoAleksic.com] - {$name} has requested information.";

        if($return_array['success'] == '1') {
            send_email($name, $email, $subject, $message);
        }

        if($req->isAjax()) {
            header('Content-type: text/json');
            echo json_encode($return_array);
        }
        else {
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

function send_email($to, $clientName, $clientEmail, $emailSubject, $clientMessage)
{
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
    $headers .= "From: {$clientName} <{$clientEmail}>" . "\r\n";

    $message  = "<strong>Name:</strong> {$clientName} <{$clientEmail}><br>";
    $message .= "<hr>";
    $message .= "{$clientMessage}<br>";
    $message .= "<hr><br>";
    $message .= '<strong>Request Time:</strong> ' . date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']) . "<br>";
    $message .= '<strong>Remote Address:</strong> ' . $_SERVER['REMOTE_ADDR'] . "<br>";

    @mail(TOEMAIL, $emailSubject, $message, $headers);

    return true;
}

function validate($name,$email,$message)
{
    $return_array                = array();
    $return_array['success']     = '1';
    $return_array['errors']      = array();

    if($email == '') {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Email is required');
    }
    else {
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email)) {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid email');
        }
    }

    if($name == '') {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Name is required');
    }
    else {
        $string_exp = "/^[A-Za-z .'-]+$/";

        if (!preg_match($string_exp, $name)) {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid name');
        }
    }

    if($message == '') {
        $return_array['success'] = '0';
        array_push($return_array['errors'],'Message is required');
    }
    else {
        if (strlen($message) < 2) {
            $return_array['success'] = '0';
            array_push($return_array['errors'],'Enter valid message');
        }
    }
    return $return_array;
}