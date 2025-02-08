<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use GrotonSchool\SlimLTI\Actions\LTIAction;
use GrotonSchool\SlimLTI\GAE\Infrastructure\Cache;
use Psr\Log\LoggerInterface;

Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // TODO **DEPLOY** Should be set to false in production
                'logError' => true,
                'logErrorDetails' => true,
                LoggerInterface::class => [
                    'name' => 'lti-gae',
                ],
                Cache::class => [
                    Cache::DURATION => 3600, // seconds
                ],
                'projectId' => $_ENV['PROJECT'],
                LTIAction::PROJECT_URL => $_ENV['PROJECT_URL'],
            ]);
        },
    ]);
};
