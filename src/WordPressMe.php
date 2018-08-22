<?php

namespace WordPress;
use WordPress\WordPressRequest;

class WordPressMe extends WordPressRequest
{
    private $_options;

    public function __construct($token)
    {
        $options = array( 'Authorization: Bearer ' . $token );
        parent::__construct();
        $this->_options = $options;
    }

    public function getUser()
    {
        return $this->send(
            'https://public-api.wordpress.com/rest/v1/me/', 
            array(),
            $this->_options
        );
    }

    public function getSites()
    {
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.1/me/sites', 
            array(),
            $this->_options
        );
    }

    public function getSiteInfo($id)
    {
        $result = $this->send(
            'https://public-api.wordpress.com/rest/v1.1/sites/' . $id, 
            array(),
            array()
        );

        $result['posts'] = $this->getSitePosts($result);

        return $result;
    }

    private function getSitePosts($json)
    {
        $result = array();

        if ( isset($json["meta"]["links"]["posts"]) ) {
            $result = $this->send(
                $json["meta"]["links"]["posts"], 
                array(),
                array()
            );
        }

        return $result;
    }
}