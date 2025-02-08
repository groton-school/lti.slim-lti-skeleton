<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Google\Cloud\Logging\LoggingClient;
use Packback\Lti1p3\Interfaces\ICache;
use Packback\Lti1p3\Interfaces\ICookie;
use Packback\Lti1p3\Interfaces\IDatabase;
use Packback\Lti1p3\Interfaces\ILtiServiceConnector;
use Packback\Lti1p3\LtiServiceConnector;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use DI;
use GrotonSchool\SlimLTI\GAE\Infrastructure\Cache;
use GrotonSchool\SlimLTI\GAE\Infrastructure\Cookie;
use GrotonSchool\SlimLTI\GAE\Infrastructure\Database;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $loggerSettings = $settings->get(LoggerInterface::class);
            $client = new LoggingClient([
                'projectId' => $settings->get('projectId'),
            ]);
            $logger = $client->psrLogger($loggerSettings['name']);
            return $logger;
        },
        IDatabase::class => DI\autowire(Database::class),
        ICache::class => DI\autowire(Cache::class),
        ICookie::class => DI\autowire(Cookie::class),
        ILtiServiceConnector::class => DI\autowire(LtiServiceConnector::class),
    ]);
};
