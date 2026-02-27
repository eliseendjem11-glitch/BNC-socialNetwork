<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Core\View;

abstract class BaseController
{
    protected function view(string $template, array $data = []): void
    {
        $data['authUser'] = Auth::user();
        $data['csrf'] = Csrf::token();
        $data['flash'] = Session::get('flash');
        Session::remove('flash');
        View::render($template, $data);
    }

    protected function requireAuth(Request $request): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }
    }
}
