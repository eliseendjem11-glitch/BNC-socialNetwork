<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;

final class MessageController extends BaseController
{
    public function index(Request $request): void
    {
        $this->requireAuth($request);
        $this->view('messages/index', ['title' => 'Messagerie']);
    }
}
