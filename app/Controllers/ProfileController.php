<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Models\Profile;

final class ProfileController extends BaseController
{
    public function show(Request $request): void
    {
        $this->requireAuth($request);
        $profile = (new Profile())->findByUserId((int) Auth::user()['id']);
        $this->view('profile/show', ['title' => 'Mon profil', 'profile' => $profile]);
    }

    public function update(Request $request): void
    {
        $this->requireAuth($request);
        if (!Csrf::validate($request->input('_csrf'))) {
            Response::json(['error' => 'Invalid CSRF token'], 422);
        }

        $data = [
            'headline' => strip_tags((string) $request->input('headline')),
            'bio' => strip_tags((string) $request->input('bio')),
            'location' => strip_tags((string) $request->input('location')),
            'website' => filter_var((string) $request->input('website'), FILTER_SANITIZE_URL),
        ];

        (new Profile())->update((int) Auth::user()['id'], $data);
        Response::json(['success' => true]);
    }
}
