<?php

class View
{

    //public $template_view; //default view.

    function generate($content_view, $template_view, $data = null, $header_view = 'header_view.php', $footer_view = 'footer_view.php')
    {

        if(is_array($data)) {
            extract($data);//convert elem of array to var
        }

        include 'application/views/' . $template_view;
    }
}
