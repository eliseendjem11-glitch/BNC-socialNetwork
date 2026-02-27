<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Models\Notification;

final class ApiController extends BaseController
{
    public function notifications(Request $request): void
    {
        $this->requireAuth($request);
        $rows = (new Notification())->unreadByUser((int) Auth::user()['id']);
        Response::json(['data' => $rows]);
    }
}
