<?php
namespace WordPress;
use WordPress\WordPressRequest;

class WordPressAuth extends WordPressRequest
{
    private $_token;
    private $_params;
    private $_request;
    
    public function __construct($request, $client, $redirect, $secret, $code)
    {
        parent::__construct();
        $this->_token = array();

        $this->_params = array(
            'client_id'     => $client,
            'redirect_uri'  => $redirect,
            'client_secret' => $secret,
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'scope' => 'global'
        );

        $this->_request = $request;
    }

    public function getToken(): array
    {
        return $this->send($this->_request, $this->_params);
    }
}