<?php

namespace app;

/**
 * Test interface
 **/
class DecodeInterface extends \App\DB
{
    /**
     * Returns the interface frameset
     **/
    public function getPage()
    {
        $template = new \Smarty();
        return $template->fetch('interface.tpl');
    }

    /**
     * Returns the interface menu
     **/
    public function getMenu() {
        $template = new \Smarty();
        $template->assign('links', DB::instance()->getObjectList());
        return $template->fetch('menu.tpl');
    }

    /**
     * Returns the object preview
     **/
    public function getPreview($vars) {

        if (empty($vars)) {

            return $this->getPreviewAll();

        } else {

            $db = $this->getObject($vars['id']);

            // If we have an object
            if (is_object($db->data)) {
                return $db->data->getPreview();
            }

            // Else - unserialize failed. Return as string
            // header('image/jpeg');
            return $db->data;
        }

    }

    function getPreviewAll() {
//        $query = $this->DB->query('select * from Comment order by Created');
//
//        while ($page = $query->fetch_object()) {
//            echo "<h3>". utf8_decode($page->Name) ."</h3>";
//            echo "<p>". utf8_decode($page->Created) ."</p>";
//            echo utf8_decode($page->Comment);
//        }
//
//        $query = $this->DB->query('select * from Page order by Created');
//
//        while ($page = $query->fetch_object()) {
//            echo "<h3>". utf8_decode($page->Header) ."</h3>";
//            echo utf8_decode($page->Text);
//        }

        $query = $this->DB->query('select * from object where type != "localimage" order by stamp');

        while ($result = $query->fetch_object()) {
            $object = $this->getObject($result->id);

            var_dump($object);

            if ($object->type == 'comment') {
                $this->DB->query('insert into Comment set 
                    object_id='. $object->data->object_id .', 
                    Name="'. utf8_encode($object->data->navn) .'", 
                    Email="'. $object->data->email .'", 
                    Created="'. $object->stamp .'", 
                    Comment="'. utf8_encode($object->data->text) .'"');
                echo "<li>Comment: ". $this->id;
            } elseif ($object->type == 'page') {
                $this->DB->query('insert into Page set 
                    object_id='. $object->data->object_id .', 
                    Header="'. utf8_encode($object->data->name) .'", 
                    Created="'. $object->stamp .'", 
                    Text="'. utf8_encode($this->DB->real_escape_string($object->data->text)) .'"');
                echo "<li>". $object->type;
            } else {
                echo "<li>". $object->type;
            }
        }
    }

    public function getData($param)
    {
        $type = ucfirst($param['type']);

        $query = $this->DB->query("select * from {$type} order by id");
        $data = $query->fetch_all(MYSQLI_ASSOC);

        header('Content-type: application/json');
        return json_encode($data);
    }

    public function getObjects($param)
    {
        $query = $this->DB->query("select id, parent, name, type, stamp from object order by id");
        $data = $query->fetch_all(MYSQLI_ASSOC);

        header('Content-type: application/json');
        return json_encode($data);
    }
}
