<?php

/**
 * Created by PhpStorm.
 * User: Rémi
 * Date: 07/02/2017
 * Time: 17:24
 */
namespace EventDispatcher;

trait EventDispatcherTrait
{
    private $events = [];

    public function addListener($name, $callable)
    {
        $this->events[$name][]=$callable;
    }

    public function dispatch($name, array $arguments = [])
    {
        foreach ($this->events[$name] as $callable) {
            call_user_func_array($callable, $arguments);
        }
    }
}
