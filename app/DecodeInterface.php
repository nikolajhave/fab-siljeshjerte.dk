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
    public function display()
    {
        $template = new \Smarty();

        $template->display('interface.tpl');
    }
}
