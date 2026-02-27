<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\CompanyController;
use App\Controllers\FeedController;
use App\Controllers\HomeController;
use App\Controllers\JobController;
use App\Controllers\MessageController;
use App\Controllers\NetworkController;
use App\Controllers\ProfileController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/verify-email', [AuthController::class, 'verifyEmail']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/feed', [FeedController::class, 'index']);
$router->post('/feed', [FeedController::class, 'store']);
$router->get('/profile', [ProfileController::class, 'show']);
$router->post('/profile', [ProfileController::class, 'update']);
$router->get('/network', [NetworkController::class, 'index']);
$router->get('/messages', [MessageController::class, 'index']);
$router->get('/companies', [CompanyController::class, 'index']);
$router->get('/jobs', [JobController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

$router->get('/api/notifications', [ApiController::class, 'notifications']);
