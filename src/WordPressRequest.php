<?php

namespace WordPress;

class WordPressRequest
{
    private $_ch;

    public function __construct()
    {
        $this->_ch = curl_init();
    }

    public function __destruct()
    {
        curl_close($this->_ch);
    }

    public function send($url, $data = array(), $headers = array())
    {
        try {
            $fields_string = "";

            if ( count($data) > 0 )  {
                //url-ify the data for the POST
                foreach($data as $key => $value) { $fields_string .= $key . '=' . $value . '&'; }
                rtrim($fields_string, '&');
            }
    
            //set the url, number of POST vars, POST data
            curl_setopt($this->_ch, CURLOPT_URL, $url);

            if ( count($data) > 0 )  {
                curl_setopt($this->_ch, CURLOPT_POST, count($data));
                curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $fields_string);
            }

            curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->_ch, CURLOPT_HEADER, false);
            curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, false);

            if ( count($headers) > 0 ) {
                curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);
            }

            $response = curl_exec($this->_ch);
            return json_decode($response, true);

        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
}