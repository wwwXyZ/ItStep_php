<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="ru"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="ru"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ru"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="/css/style.css" />
	<link rel="stylesheet" href="/css/normalize.css" />
	<link rel="stylesheet" href="/css/skeleton.css" />
    <?php
    $pattern = "/([\\/].?.[\\/])|([\\/][\\?])+/";
    $file = preg_split($pattern, $_SERVER['REQUEST_URI'])[0];
    if (file_exists('css'.$file.'.css'))
        echo '<link rel="stylesheet" href="css'.$_SERVER['REQUEST_URI'].'.css" />';//todo: check security!!!
    ?>
</head>
<body>
<?php
    if (!empty($header_view) && '/application/views/'.$header_view) include 'application/views/'.$header_view;
    if (!empty($content_view) && '/application/views/'.$content_view) include 'application/views/'.$content_view;
    if (!empty($footer_view) &&'/application/views/'.$footer_view) include 'application/views/'.$footer_view;
?>
<?php
if (file_exists('js'.$file.'.js'))
    echo '<script src="/js'.$file.'.js"></script>';//todo: check security!!!
?>
<script src="/js/user/index.js"></script>
</body>
</html>
