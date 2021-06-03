<?php
//session_start();
//require_once('../vendor/autoload.php');

require_once(dirname(dirname(__FILE__)).  "/vendor/autoload.php");

$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => 'dqv55t2rc9npk2ty',
    'publicKey' => '98np9hd284qkxjr5',
    'privateKey' => 'b2f39996edcc9867c3947ed557942086'
]);
$baseUrl = stripslashes(dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = $baseUrl == '/' ? $baseUrl : $baseUrl . '/';