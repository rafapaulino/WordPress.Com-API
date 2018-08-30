<?php 
namespace WordPress;
use WordPress\WordPressStateManager;
use WordPress\WordPressLoginUrl;
use WordPress\WordPressAuth;
use WordPress\WordPressMe;
use WordPress\WordPressPost;

class WordPressFacade
{
    private $_authenticate;
    private $_requestUrl;
    private $_clientId;
    private $_redirectUrl;
    private $_secret;
    private $_token;

    public function __construct($clientId, $redirectUrl, $secret)
    {
        $this->_authenticate = 'https://public-api.wordpress.com/oauth2/authorize';
        $this->_requestUrl = 'https://public-api.wordpress.com/oauth2/token';
        $this->_clientId = $clientId;
        $this->_redirectUrl = $redirectUrl;
        $this->_secret = $secret;
        $this->_token = '';
    }

    public function setToken($token)
    {
        $this->_token = $token;
    }

    public function getToken(): array
    {
        $retorno = array();
        $session = new WordPressStateManager;
        $code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : '';

        if( empty($code) ) {

            $session->setState();
            $state = $session->getState();

            $wp = new WordPressLoginUrl(
                $this->_authenticate,
                $this->_clientId,
                $state,
                $this->_redirectUrl
            );

            $retorno['url'] = $wp->getUrl();
            $retorno['token'] = '';

        } elseif ( $session->verifyStateIsValid() ) {
            
            $auth = new WordPressAuth(
                $this->_requestUrl, 
                $this->_clientId,
                $this->_redirectUrl, 
                $this->_secret, 
                $code
            );

            $retorno['url'] = '';
            $retorno['token'] = $auth->getToken();
            
            if ( isset($retorno['token']["access_token"]) )
            $this->_token = $retorno['token']["access_token"];
        }

        return $retorno;        
    }

    public function getUserInfo(): array
    {
        if ( trim($this->_token) !== "" ) {

            $me = new WordPressMe($this->_token);
            $user = $me->getUser();
            $sites = $me->getSites();

            return array(
                'status' => 'success',
                'user' => $user,
                'sites' => $sites
            );

        } else {
            return array(
                'status' => 'error',
                'user' => array(),
                'sites' => array()
            );
        }
    }

    public function getSiteInfo($id): array
    {
        if ( trim($this->_token) !== "" ) {

            $me = new WordPressMe($this->_token);
            $site = $me->getSiteInfo($id);

            return array(
                'status' => 'success',
                'site' => $site
            );

        } else {
            return array(
                'status' => 'error',
                'site' => array()
            );
        }
    }

    public function postAdd($siteId, $title, $content, $excerpt, $image = ""): array
    {
        if ( trim($this->_token) !== "" ) {
            $result_image = array();

            $post = new WordPressPost($this->_token, $siteId);
            $result = $post->add(
                $title,
                $content,
                $excerpt
            );

            if ( isset($result['ID']) && trim($image) !== "")
            {
                $result_image = $post->addImageInPost($image, $result['ID']);
            }

            return array(
                'status' => 'success',
                'post' => $result,
                'image' => $result_image,
            );

        } else {
            return array(
                'status' => 'error',
                'post' => array(),
                'image' => array(),
            );
        }
    }

    public function postDel($siteId, $postId): array
    {
        if ( trim($this->_token) !== "" ) {
            $post = new WordPressPost($this->_token, $siteId);
            $del = $post->delete($postId);

            return array(
                'status' => 'success',
                'del' => $del
            );

        } else {
            return array(
                'status' => 'error',
                'del' => array()
            );
        }
    }

    public function postInfo($siteId, $postId): array
    {
        if ( trim($this->_token) !== "" ) {
            $post = new WordPressPost($this->_token, $siteId);
            $myPost = $post->getPostById($postId);

            return array(
                'status' => 'success',
                'post' => $del
            );

        } else {
            return array(
                'status' => 'error',
                'post' => array()
            );
        }
    }

    public function postEdit($siteId, $postId, $title, $content, $excerpt, $image = ""): array
    {
        if ( trim($this->_token) !== "" ) {
            $result_image = array();

            $post = new WordPressPost($this->_token, $siteId);

            $result = $post->edit(
                $postId,
                $title,
                $content,
                $excerpt
            );

            if ( isset($result['ID']) && trim($image) !== "")
            {
                $result_image = $post->addImageInPost($image, $result['ID']);
            }

            return array(
                'status' => 'success',
                'post' => $result,
                'image' => $result_image,
            );

        } else {
            return array(
                'status' => 'error',
                'post' => array(),
                'image' => array(),
            );
        }
    }
}