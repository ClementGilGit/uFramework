<?php

namespace Model;

interface FinderInterface
{
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll($criterion);

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id);

    public function findOneByLogin($login);
}
