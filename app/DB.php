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

    /*
     * Returns a list of all the object ids
     */
    public function getObjectList() {
        $query = $this->DB->query('select id, name, type from object order by type, name');
        $links = [];

        while ($result = $query->fetch_assoc()) {
            $links[] = $result;
        }

        return $links;
    }

    private function decode($data) {
        $data = utf8_decode($data);

        if ($unserialzed = unserialize($data)) {
            $data = $unserialzed;
        }

        return $data;
    }

    /**
     * Returns an instance of the class
     */
    public function instance()
    {
        return new DB();
    }
    
}
