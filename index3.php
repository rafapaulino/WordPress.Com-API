<?php
include 'vendor/autoload.php';
//https://developer.wordpress.com/docs/wpcc/
//https://developer.wordpress.com/2014/10/23/oauth2-global-scope-tokens/
use WordPress\WordPressFacade;

$client_id = '62951';
$redirect_url = 'http://localhost:81/wpapi/';
$secret = 'EeJubCqV3J0A2tAXfqeeBC5QNzlsififiMiHBykOzeCK8GbVrhWSffGWChoLq030';

$facade = new WordPressFacade($client_id, $redirect_url, $secret);
$retorno = $facade->getToken();

if ($retorno['url'] !== "") {
    echo '<a href="' . $retorno['url'] . '">Login</a>';
} else {
    /*
    $user = $facade->getUserInfo();
    echo '<h1>User and Site Info:</h1><pre>';
    var_dump($user);
    echo '</pre><hr>';

    $site = $facade->getSiteInfo(15303042);
    echo '<h1>Especific Site Info:</h1><pre>';
    var_dump($site);
    echo '</pre><hr>';

    $post = $facade->postAdd(
        15303042,
        'titulo',
        'conteudo',
        'resumo',
        'http://visitsetubal.com.pt/wp-content/uploads/2013/03/Praia_Albarquel_02.jpg'
    );
    echo '<h1>Add Post:</h1><pre>';
    var_dump($post);
    echo '</pre><hr>';

    $p = $facade->postInfo(
        15303042,
        139
    );
    echo '<h1>Post Info:</h1><pre>';
    var_dump($p);
    echo '</pre><hr>';


    $post = $facade->postEdit(
        15303042,
        147,
        'titulo 123',
        'conteudo 456',
        'resumo 8910',
        'https://www.tribunapr.com.br/cacadores-de-noticias/wp-content/uploads/sites/2/2018/03/WEB-PREDIO-10-1024x683.jpg'
    );
    echo '<h1>Edit Post:</h1><pre>';
    var_dump($post);
    echo '</pre><hr>';

*/
    $del = $facade->postDel(
        15303042,
        147
    );
    echo '<h1>Del Post:</h1><pre>';
    var_dump($del);
    echo '</pre><hr>';
    

}