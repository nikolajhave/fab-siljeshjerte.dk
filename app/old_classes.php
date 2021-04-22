<?php

/*
 * Must exists to unserialize
 *
 * Preview function added
 */

class Data {
    function getHeader() {
        return $this->navn;
    }

    function getPreview() {
        $html = "<h3>". $this->getHeader() ."</h3>";

        // Vars
        foreach (get_object_vars($this) as $var => $value) {
            if (strstr($var, 'object_')) {
                continue;
            }
            $html.= "<p>". $value ."</p>";
        }

        // Vardump
        $html .= '<code>'. nl2br(print_r($this, true)) .'</code>';

        return $html;
    }
}

class Image
{
    function getPreview() {
        header('Content-type: '. $this->content_type);
        echo $this->rawdata;
        exit;
    }
}

class LocalImage extends Image {}

class Web extends Data {}
class CandlePage extends Data {}
class Comment extends Data {}
class ContactPage extends Data {}
class Frontpage extends Data {}
class GalleryView extends Data {}
class Page extends Data {}
class PageFolder extends Data {}
class Bruger extends Data {}
class BrugerFolder extends Data {}
class LocalImageArchive extends Data {}


// Soelvske
class Billede extends Image {}
class Billedkategori extends Data {}
class Mester extends Data {}
class Produkt extends Data {}
class By extends Data {}
class Art extends Data {}
