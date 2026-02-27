<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Models\Connection;

final class NetworkController extends BaseController
{
    public function index(Request $request): void
    {
        $this->requireAuth($request);
        $suggestions = (new Connection())->suggestions((int) Auth::user()['id']);
        $this->view('network/index', ['title' => 'Réseau', 'suggestions' => $suggestions]);
    }
}
