<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;

final class FeedController extends BaseController
{
    public function index(Request $request): void
    {
        $this->requireAuth($request);
        $user = Auth::user();
        $page = max(1, (int) $request->input('page', 1));
        $posts = (new Post())->feed((int) $user['id'], 10, ($page - 1) * 10);
        $this->view('feed/index', ['title' => 'Fil d\'actualité', 'posts' => $posts]);
    }

    public function store(Request $request): void
    {
        $this->requireAuth($request);
        if (!Csrf::validate($request->input('_csrf'))) {
            Response::json(['error' => 'Invalid CSRF token'], 422);
        }
        $user = Auth::user();
        $content = trim((string) $request->input('content'));
        $visibility = in_array($request->input('visibility'), ['public', 'connections', 'private'], true) ? $request->input('visibility') : 'public';
        if ($content === '') {
            Response::json(['error' => 'Contenu requis'], 422);
        }
        (new Post())->create((int) $user['id'], htmlspecialchars($content, ENT_QUOTES, 'UTF-8'), null, $visibility);
        Response::json(['success' => true]);
    }
}
