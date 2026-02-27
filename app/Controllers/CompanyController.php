<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;

final class CompanyController extends BaseController
{
    public function index(Request $request): void
    {
        $this->view('companies/index', ['title' => 'Entreprises']);
    }
}
