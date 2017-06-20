<?php
    header('Content-Type: application/json');
    if (!empty($content_view) && '/application/views/'.$content_view) include 'application/views/'.$content_view;