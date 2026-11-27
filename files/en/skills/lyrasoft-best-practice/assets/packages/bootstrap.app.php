<?php

/**
 * PHPUnit bootstrap for Luna tests.
 *
 * Works in two modes, selected by the WINDWALKER_TEST_APP_ROOT variable:
 *
 * - Standalone (default): the root is this package, which must have its own
 *   `vendor/` installed by `composer install`.
 * - Host app (phpunit.app.dist.xml): the root is the host application, so the
 *   host's autoloader, etc/define.php and installed packages are used.
 *
 * In both modes the migrations come from this package's resources/migrations
 * and the database comes from WINDWALKER_TEST_DB_DSN (MySQL only).
 * TestDatabaseFixtures::initialize() DROPS and recreates that database, so
 * always point it at a disposable one.
 */

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Lyrasoft\Luna\Tests\TestApp;
use Windwalker\Core\Testing\TestAppRegistry;
use Windwalker\DI\Container;

$package = dirname(__DIR__);
$root = env('WINDWALKER_TEST_APP_ROOT') ?: $package;

// A relative root is resolved against the package directory.
if (!preg_match('#^([a-z]:)?[\\\\/]#i', $root)) {
    $root = realpath($package . '/' . $root) ?: $root;
}

$init = include $root . '/vendor/windwalker/core/src/Core/Testing/test.init.php';

/** @var Container $container */
/** @var ClassLoader $classLoader */
[$container, $classLoader] = $init(
    root: $root,
    workDir: $root,
);

$container->options->lazy = true;

$classLoader->addPsr4('Lyrasoft\{Namespace}\Tests\\', __DIR__ . '/');

$container->loadParameters([
    // configs...
]);

TestApp::createInstance(
    container: $container->createChild(),
    config: [
        '@root' => $root,
        '@temp' => $root . '/tmp',
        '@cache' => $root . '/cache',
        '@public' => $package . '/tests/public',
        '@migrations' => $package . '/resources/migrations',
        '@seeders' => $package . '/resources/seeders',
    ],
    providers: [
        // Providers...
    ],
    bindings: [
        /// Bindings...
    ],
);

TestAppRegistry::use(TestApp::$instance);
