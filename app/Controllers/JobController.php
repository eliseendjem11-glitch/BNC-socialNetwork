<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;

final class JobController extends BaseController
{
    public function index(Request $request): void
    {
        $this->view('jobs/index', ['title' => 'Offres d\'emploi']);
    }
}
