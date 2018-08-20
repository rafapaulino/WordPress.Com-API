<?php
include 'vendor/autoload.php';

use WordPress\WordPressStateManager;
use WordPress\WordPressLoginUrl;
use WordPress\WordPressAuth;

$authenticate = 'https://public-api.wordpress.com/oauth2/authenticate';
$client_id = '62951';
$redirect_url = 'http://localhost:81/wpapi/';
$request_url = 'https://public-api.wordpress.com/oauth2/token';
$secret = 'EeJubCqV3J0A2tAXfqeeBC5QNzlsififiMiHBykOzeCK8GbVrhWSffGWChoLq030';

$session = new WordPressStateManager;

$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : '';

if( empty($code) ) {

    $session->setState();
    $state = $session->getState();

    $wp = new WordPressLoginUrl(
        $authenticate,
        $client_id,
        $state,
        $redirect_url
    );
    $url = $wp->getUrl();

    echo '<a href="' . $url .'">Login</a>';

 } elseif ( $session->verifyStateIsValid() ) {
    $auth = new WordPressAuth(
        $request_url, 
        $client_id,
        $redirect_url, 
        $secret, 
        $code
    );

    $token = $auth->getToken();

    echo '<pre>';
    var_dump($token);
    echo '</pre>';

 }
