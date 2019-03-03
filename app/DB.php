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
        $query = $this->DB->query('select * from object where id = '. $object_id);

        if ($result = $query->fetch_object()) {
            $result->data = $this->decode($result->data);
            return $result;
        }

        return false;
    }

    private function decode($data) {
        $data = utf8_decode($data);

        if ($unserialzed = unserialize($data)) {
            $data = $unserialzed;
        }

        return $data;
    }
}
