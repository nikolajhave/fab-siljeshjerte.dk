<?php

namespace app;

/**
 * DB abstraction
 **/
class DB
{
    function __construct()
    {
        $this->DB = new \mysqli("localhost", "root", "root", "have_siljeshjerte");

        return $this->DB;
    }

    public function getObject($object_id)
    {
        $query = $this->DB->query('select * from object where id = "'. $object_id .'"');

        if ($result = $query->fetch_object()) {
            return $result;
        }

        return false;
    }
}
