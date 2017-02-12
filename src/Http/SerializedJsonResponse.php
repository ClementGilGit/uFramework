<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Http;

/**
 * Description of SerializedJsonResponse
 *
 * @author clgil1
 */
class SerializedJsonResponse extends Response
{
    public function __construct($content, $statusCode =200, $ĥeaders = array())
    {
        parent::__construct(json_encode($content), $statusCode, array_merge(['Content-Type' => 'application/json']));
    }
}
