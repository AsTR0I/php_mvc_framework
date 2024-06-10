<?php

    echo $query = $_SERVER['QUERY_STRING'];

    require '../vendor/core/Router.php';

    $router = new Router();