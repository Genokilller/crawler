<?php

use Silex\Route\SecurityTrait;

# Security
$securityPatterns = $app['config']['security'];

if (empty($securityPatterns)) {
    throw new \Exception('You must configure at least one security pattern');
}

$patterns = array();
foreach ($securityPatterns as $username => $pattern) {
    # Request matcher
    $matcher = new \Symfony\Component\HttpFoundation\RequestMatcher();
    $paths = implode('|', $pattern['paths']);
    $matcher->matchPath($paths);

    $patterns[$username] = array ('matcher' => $matcher, 'password' => $pattern['password']);
}


# Apply firewall
$app->before(function() use ($app, $patterns) {

    # Exclude OPTIONS method from security
    if ($_SERVER['REQUEST_METHOD'] != 'OPTIONS' && !($_SERVER['REQUEST_URI'] == '/' && $_SERVER['REQUEST_METHOD'] == 'GET')) {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['REDIRECT_HTTP_AUTHORIZATION'], 6)));
        }

        # Apply Request matcher
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Search Engine"');
            return $app->json(array('Message' => 'Not Authorised'), 401);
        } else {
            # Check user authentication
            $user = $patterns[$_SERVER['PHP_AUTH_USER']];
            if($user['password'] !== $_SERVER['PHP_AUTH_PW'] || !$user['matcher']->matches($app['request'])) {
                return $app->json(array('Message' => 'You shall not pass !'), 403);
            }
        }
    }
});
