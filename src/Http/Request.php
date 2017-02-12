<?php

namespace Http;

use Negotiation\Negotiator;

class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    private $method;
    private $uri;
    private $parameters;

    public function __construct(array $query = array(), array $request = array())
    {
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;
        $this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $this->parameters = array_merge($query, $request);
    }

    public function getParameter($name, $default = null)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }
        return $default;
    }

    public function getMethod()
    {
        //$this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;
        if (self::POST === $this->method) {
            return $this->getParameter('_method', $this->method);
        }
        return $this->method;
    }

    public function getUri()
    {
        if ($pos = strpos($this->uri, '?')) {
            $this->uri = substr($this->uri, 0, $pos);
        }
        return $this->uri;
    }

    public static function createFromGlobals()
    {
        if (isset($_SERVER['CONTENT_TYPE']) && isset($_SERVER['HTTP_CONTENT_TYPE'])) {
            if ($_SERVER['CONTENT_TYPE']==='application/json' || $_SERVER['HTTP_CONTENT_TYPE']==='application/json') {
                $data = file_get_contents('php://input');
                $request = @json_decode($data, true);
                return new self($_GET, $request);
            }
        }
        return new self($_GET, $_POST);
    }

    public function guessBestFormat()
    {
        $negotiator = new Negotiator();
        $acceptHeader = $_SERVER['HTTP_ACCEPT'];
        $priorities   = array('text/html; charset=UTF-8', 'application/json');
        $mediaType = $negotiator->getBest($acceptHeader, $priorities);
        $value = $mediaType->getValue();
        switch ($value) {
            case 'application/json':
                return 'application/json';
                break;
            case 'text/html':
                return 'text/html';
                break;
        }
    }
}
