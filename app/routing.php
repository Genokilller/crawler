<?php

# Routing
$app->post('/search', "search.controller:searchAction");

$app->get('/', function() { return 'OK'; });
$app->match('{url}', function() use ($app) { return 'OK'; })->assert('url', '.*')->method('OPTIONS');


$app->error(function (\Exception $e, $code) use ($app) {

    var_dump($e);die;
    if ($app['debug']) {
        return;
    }
});
