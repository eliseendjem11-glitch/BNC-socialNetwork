<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $templatePath = __DIR__ . '/../Views/' . $template . '.php';

        if (!is_file($templatePath)) {
            throw new \RuntimeException("View {$template} not found");
        }

        require __DIR__ . '/../Views/layouts/main.php';
    }
}
