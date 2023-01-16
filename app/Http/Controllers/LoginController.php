<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Метод авторизации пользователя
     * @param Request $request
     *
     * @return Redirector|Application|RedirectResponse
     */
    public function login(Request $request): Redirector|Application|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('user.ticket'));
        }

        $fields = $request->only(['email', 'password']);

        if (Auth::attempt($fields)) {
            return redirect(route('user.ticket'));
        }
        return redirect(route('user.login'))->withErrors([
            'formError' => 'Не удалось авторизоваться'
        ]);

    }
}
