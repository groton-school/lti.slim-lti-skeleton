<?php

declare(strict_types=1);

use App\Middleware\Authorization;
use GrotonSchool\Firestore\HttpBasicAuthentication\FirestoreAuthenticator;
use Tuupola\Middleware\HttpBasicAuthentication;
use Slim\App;

return function (App $app) {
    $app->add(Authorization::class);

    $app->add(new HttpBasicAuthentication([
        'path' => ['/admin'],
        'realm' => 'LTI Administration',
        'authenticator' => new FirestoreAuthenticator(),
        'before' => function ($request, $arguments) {
            return $request->withAttribute('user', $arguments['user']);
        },
    ]));
};
