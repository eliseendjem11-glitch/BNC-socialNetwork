<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;

final class AdminController extends BaseController
{
    public function index(Request $request): void
    {
        Auth::requireRole(['admin']);
        $this->view('admin/index', ['title' => 'Admin']);
    }
}
