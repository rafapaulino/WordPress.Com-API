<?php
include 'vendor/autoload.php';
//https://developer.wordpress.com/docs/wpcc/
//https://developer.wordpress.com/2014/10/23/oauth2-global-scope-tokens/
use WordPress\WordPressStateManager;
use WordPress\WordPressLoginUrl;
use WordPress\WordPressAuth;
use WordPress\WordPressMe;

$authenticate = 'https://public-api.wordpress.com/oauth2/authorize';
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

    
    $me = new WordPressMe($token["access_token"]);
    $user = $me->getUser();

    echo '<pre>';
    var_dump($user);
    echo '</pre>';

    $sites = $me->getSites();
    echo '<pre>';
    var_dump($sites);
    echo '</pre>';
 }