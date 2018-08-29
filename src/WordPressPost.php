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

    public function addImageInPost($image, $postId)
    {
        $body = array(
            'media_urls' => $image,
        );
        
        $this->_options[] = 'Content-Type: application/x-www-form-urlencoded';
        
        $result = $this->send(
            'https://public-api.wordpress.com/rest/v1.1/sites/' . $this->_site . '/media/new/', 
            $body,
            $this->_options
        );

        if ( isset($result['media'][0]['ID']) ) {
            $result['join_image'] = $this->joinImageToPost($result['media'][0]['ID'], $postId);
            $result['featured_image'] = $this->featuredImage($result['media'][0]['ID'], $postId);
        }

        return $result;
    }

    private function joinImageToPost($imageId, $parentId)
    {
        $body = array(
            'parent_id' => $parentId
        );
        
        $this->_options[] = 'Content-Type: application/x-www-form-urlencoded';
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.2/sites/' . $this->_site . '/media/' . $imageId . '/edit/', 
            $body,
            $this->_options
        );
    }

    private function featuredImage($imageId, $postId)
    {
        $body = array(
            'featured_image' => $imageId
        );
        
        $this->_options[] = 'Content-Type: application/x-www-form-urlencoded';
        return $this->send(
            'https://public-api.wordpress.com/rest/v1.2/sites/' . $this->_site . '/posts/' . $postId, 
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