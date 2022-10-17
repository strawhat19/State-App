<?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
        $url.=$_SERVER['HTTP_HOST'];
        $url.=$_SERVER['REQUEST_URI'];
        $url;
    }
    $page = $url;
    $localPage = '/apps/State-App/';
    $title = 'PHP Form Submissions';
  ?>