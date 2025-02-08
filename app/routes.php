<?php

declare(strict_types=1);

use GrotonSchool\SlimLTI\Actions\JWKSAction;
use GrotonSchool\SlimLTI\Actions\LaunchAction;
use GrotonSchool\SlimLTI\Actions\LoginAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy as Group;

return function (App $app) {
    /*    $app->options('/{routes:.*}', function (
        Request $request,
        Response $response
    ) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    }); */

    $app->group('/lti', function (Group $lti) {
        $lti->post('/login', LoginAction::class);
        $lti->post('/launch', LaunchAction::class);
        $lti->get('/jwk', JWKSAction::class);
    });
};
