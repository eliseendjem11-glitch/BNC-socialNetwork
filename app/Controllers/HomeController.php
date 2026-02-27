<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;

final class HomeController extends BaseController
{
    public function index(Request $request): void
    {
        $this->view('home/index', ['title' => 'Accueil']);
    }
}
