<?php

declare(strict_types=1);

use App\Core\Request;
use App\Core\Router;

require __DIR__ . '/../bootstrap.php';

$router = new Router();
require __DIR__ . '/../routes/web.php';
$router->dispatch(new Request());
