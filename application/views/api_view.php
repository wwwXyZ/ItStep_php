<?php
if(!empty($data) && is_array($data))
    $json = json_encode($data);
else
    $json = "[{}]";
print_r($json);