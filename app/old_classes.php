<?php


class Data {
    function name() {
        return 'navn';
    }

    function getPreview() {
        $html = "<h3>". $this->{$this->name()} ."</h3>";

        foreach (get_object_vars($this) as $var => $value) {
            if (strstr($var, 'object_')) {
                continue;
            }
            $html.= "<p>". $value ."</p>";
        }

        $html .= '<code>'. nl2br(var_dump($this, true)) .'</code>';

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
