<?php

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);
$app->useAppPath(realpath(__DIR__.'/../src/Infra'));
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    \Src\Infra\Http\Kernel::class,
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    \Src\Infra\Console\Kernel::class,
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Src\Infra\Exceptions\Handler::class
);

return $app;
