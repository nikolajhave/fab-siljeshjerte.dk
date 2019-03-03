<?php

namespace app;

/**
 * Test interface
 **/
class DecodeInterface extends \App\DB
{
    /**
     * Displays (outputs) the complete interface view
     **/
    public function getPage()
    {
        $template = new \Smarty();
        return $template->fetch('interface.tpl');
    }

    public function getMenu() {
        $template = new \Smarty();
        $template->assign('links', $this->getLinks());
        return $template->fetch('menu.tpl');
    }

    public function getPreview($vars) {
        $db = $this->getObject($vars['id']);

        $obj = $db->data;

        return $obj->getPreview();
    }

    private function getLinks() {
        $query = $this->DB->query('select id, name, type from object order by type, name');
        $links = [];

        while ($result = $query->fetch_assoc()) {
            $links[] = $result;
        }

        return $links;
    }
}
