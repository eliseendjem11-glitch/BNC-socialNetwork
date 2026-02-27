<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Profile;
use App\Models\User;

final class AuthController extends BaseController
{
    public function showRegister(Request $request): void
    {
        $this->view('auth/register', ['title' => 'Inscription']);
    }

    public function register(Request $request): void
    {
        if (!Csrf::validate($request->input('_csrf'))) {
            Response::json(['error' => 'Invalid CSRF token'], 422);
        }

        $email = filter_var((string) $request->input('email'), FILTER_VALIDATE_EMAIL);
        $password = (string) $request->input('password');
        $role = in_array($request->input('role'), ['user', 'recruiter'], true) ? $request->input('role') : 'user';

        if (!$email || strlen($password) < 8) {
            Response::json(['error' => 'Validation failed'], 422);
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            Response::json(['error' => 'Email already used'], 422);
        }

        $token = bin2hex(random_bytes(24));
        $id = $userModel->create([
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'token' => $token,
        ]);

        (new Profile())->createDefault($id, 'u' . $id);
        Session::set('flash', 'Compte créé. Simulez la vérification email via /verify-email?token=' . $token);

        Response::json(['success' => true, 'redirect' => '/login']);
    }

    public function showLogin(Request $request): void
    {
        $this->view('auth/login', ['title' => 'Connexion']);
    }

    public function login(Request $request): void
    {
        if (!Csrf::validate($request->input('_csrf'))) {
            Response::json(['error' => 'Invalid CSRF token'], 422);
        }

        $email = (string) $request->input('email');
        $password = (string) $request->input('password');

        $user = (new User())->findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            Response::json(['error' => 'Identifiants invalides'], 401);
        }

        if (empty($user['email_verified_at'])) {
            Response::json(['error' => 'Email non vérifié'], 403);
        }

        Session::regenerate();
        Session::set('user_id', (int) $user['id']);

        Response::json(['success' => true, 'redirect' => '/feed']);
    }

    public function verifyEmail(Request $request): void
    {
        $ok = (new User())->verifyEmail((string) $request->input('token'));
        Session::set('flash', $ok ? 'Email vérifié.' : 'Token invalide.');
        header('Location: /login');
    }

    public function logout(Request $request): void
    {
        Session::remove('user_id');
        header('Location: /');
    }
}
