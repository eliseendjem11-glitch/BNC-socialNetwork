<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

final class ErrorHandler
{
    public static function register(): void
    {
        set_exception_handler(function (Throwable $exception): void {
            self::log($exception);
            http_response_code(500);
            if (Config::get('app.debug')) {
                echo '<pre>' . htmlspecialchars($exception->getMessage() . "\n" . $exception->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
                return;
            }
            echo 'An unexpected error occurred.';
        });
    }

    public static function log(Throwable $exception): void
    {
        $line = sprintf("[%s] %s in %s:%d\n", date('c'), $exception->getMessage(), $exception->getFile(), $exception->getLine());
        file_put_contents(__DIR__ . '/../../storage/logs/app.log', $line, FILE_APPEND);
    }
}
