<?php

namespace WordPress;

class WordPressLoginUrl
{
    private $_url;

    public function __construct($authenticate, $client, $state, $redirect)
    {
        $this->_url = $authenticate . '?' . http_build_query( array(
            'response_type' => 'code',
            'client_id'     => $client,
            'state'         => $state,
            'redirect_uri'  => $redirect,
            'scope' => 'global'
        ) );
    }

    public function getUrl(): string
    {
        return $this->_url;
    }
}