<?php

// configure
$from = 'info@halrefrigeracion.com';
$sendTo = 'info@halrefrigeracion.com';
$subject = 'Nuevo mensaje desde formulario de contacto web';
$fields = array('name' => 'Nombre', 'email' => 'Email', 'reason' => 'Asunto', 'message' => 'Mensaje'); // array variable name => Text to appear in the email
$okMessage = 'Tu mensaje se ha enviado correctamente.';
$errorMessage = 'Hubo un error, por favor intentá nuevamente';

// let's do the sending

try
{
    $emailText = "Has recibido un nuevo mensaje desde el formulario de contacto de la web.\r\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value \r\n";
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $_POST['email'],
        'Reply-To: ' . $_POST['email'],
        'Return-Path: ' . $_POST['email'],
    );

    mail($sendTo, $subject, $emailText, implode("\r\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
