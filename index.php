<?php
include 'vendor/autoload.php';
//https://developer.wordpress.com/docs/wpcc/
//https://developer.wordpress.com/2014/10/23/oauth2-global-scope-tokens/
use WordPress\WordPressStateManager;
use WordPress\WordPressLoginUrl;
use WordPress\WordPressAuth;
use WordPress\WordPressMe;
use WordPress\WordPressPost;

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

    echo '<h4>Token:</h4><pre>';
    var_dump($token);
    echo '</pre><hr>';

    
    $me = new WordPressMe($token["access_token"]);
    $user = $me->getUser();

    echo '<h4>Informações do usuário:</h4><pre>';
    var_dump($user);
    echo '</pre><hr>';

    $sites = $me->getSites();
    echo '<h4>Sites do Usuário:</h4><pre>';
    var_dump($sites);
    echo '</pre><hr>';

    $site = $me->getSiteInfo(15303042);
    echo '<h4>Informações sobre um site em especifíco:</h4><pre>';
    var_dump($site);
    echo '</pre><hr>';

    $post = new WordPressPost($token["access_token"], 15303042);
    $result = $post->add(
        'Teste de post com a api',
        '<p>isso é um teste -> <a href="http://www.uol.com.br">Link</a></p>',
        'este é o resumo maroto'
    );
    echo '<h4>Informações sobre o post:</h4><pre>';
    var_dump($result);
    echo '</pre><hr>';

    $myPost = $post->getPostById($result['ID']);
    echo '<h4>Informações sobre o post adicionado:</h4><pre>';
    var_dump($myPost);
    echo '</pre><hr>';

    $edit = $post->edit(
        $result['ID'],
        'Novo Teste de post com a api' . time(),
        '<p>isso é um teste de edição -> <a href="http://www.bol.com.br">Link bol</a></p>',
        'este é o resumo maroto novamente'
    );
    echo '<h4>Informações sobre o post editado:</h4><pre>';
    var_dump($edit);
    echo '</pre><hr>';

    /*$del = $post->delete($result['ID']);
    echo '<h4>Deletando o post:</h4><pre>';
    var_dump($del);
    echo '</pre><hr>';*/
 }
