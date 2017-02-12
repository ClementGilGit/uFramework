<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Http;

/**
 * Description of Response
 *
 * @author clgil1
 */
class Response
{
    private $content;

    private $statusCode;

    private $headers;

    public function __construct($content, $statusCode = 200, array $headers = [])
    {
        $this->content    = $content;
        $this->statusCode = $statusCode;
        $this->headers    = array_merge([ 'Content-Type' => 'text/html' ], $headers);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function sendHeaders()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }
    }

    public function send()
    {
        $this->sendHeaders();

        echo $this->content;
    }
}
