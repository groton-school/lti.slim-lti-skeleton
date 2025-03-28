# @groton-school/slim-lti-skeleton

## Install

### For local development

#### gRPC

Make sure that [gRPC](https://cloud.google.com/php/grpc) is installed so that the current version of Firestore can be used (on macOS, it's worth checking to see if the `pecl` symlink in the active PHP installation is valid, per [this note](https://yarnaudov.com/php-pecl-module-install-warning-mkdir-file-exists-fix.html)).

#### Redis

```sh
pecl install redis # PHP plugin for GAE Memorystore use 
composer install # PHP libraries
```

If the above command fails after compilation, saying that installation of `/path/to/redis.so` failed, the extension has been successfully built, but installation likely failed due to permissions errors. You can follow [these troubleshooting steps](https://github.com/phpredis/phpredis/blob/develop/INSTALL.md#installation-on-osx) or just add the following to your `php.ini` (discoverable by invoking `php --ini`) or (better still) as a separate `ext-redis.ini` file in the `conf.d` directory:

```ini
extension="/path/to/redis.so"
```

Add `redis` to your Intelephense stubs (via your IDE, e.g. in Visual Studio Code, go to Settings and search for `intelephense stubs`).

### For deployment on Google App Engine

#### Node

Make sure that [Node](https://nodejs.org/en) is installed, as the deploy script runs on node.

```sh
npm install # deploy script dependencies (one-time)
node bin/deploy.js # to GAE as changes are made
```

On first deployment, this will run you through the Google App Engine project creation, the only prerequisite for which is that you must already have a [Google Cloud billing account](https://console.cloud.google.com/billing) configured. (This has to be done interactively, and cannot be scripted for security reasons.)