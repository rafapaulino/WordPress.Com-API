<?php

namespace WordPress;
use WordPress\WordPressRequest;

class WordPressPost extends WordPressRequest
{
    private $_options;
    private $_site;

    public function __construct($token, $site)
    {
        $options = array( 'Authorization: Bearer ' . $token );
        parent::__construct();
        $this->_options = $options;
        $this->_site = $site;
    }

    public function add($title, $content, $excerpt = '', $tags = array(), $categories = array())
    {
        $body['title'] = $title;
        $body['content'] = $content;

        if ( trim($excerpt) !== "" ) {
            $body['excerpt'] = $excerpt;
        }

        if ( count($tags) > 0 ) {
            $body['tags'] = implode(",",$tags);
        }

        if ( count($categories) > 0 ) {
            $body['categories'] = implode(",",$categories);
        }
                
        $this->_options[] = 'Content-Type: application/x-www-form-urlencoded';
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.2/sites/' . $this->_site . '/posts/new/', 
            $body,
            $this->_options
        );
    }

    public function getPostById($id)
    {
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.1/sites/' . $this->_site . '/posts/' . $id, 
            array(),
            $this->_options
        ); 
    }

    public function delete($id)
    {
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.1/sites/' . $this->_site . '/posts/' . $id . '/delete', 
            array(),
            $this->_options
        ); 
    }

    public function edit($id, $title, $content, $excerpt = '', $tags = array(), $categories = array())
    {
        $body['title'] = $title;
        $body['content'] = $content;

        if ( trim($excerpt) !== "" ) {
            $body['excerpt'] = $excerpt;
        }

        if ( count($tags) > 0 ) {
            $body['tags'] = implode(",",$tags);
        }

        if ( count($categories) > 0 ) {
            $body['categories'] = implode(",",$categories);
        }
                
        $this->_options[] = 'Content-Type: application/x-www-form-urlencoded';
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.2/sites/' . $this->_site . '/posts/' . $id, 
            $body,
            $this->_options
        );
    }
}