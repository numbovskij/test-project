<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Метод регистрации пользователя
     * @param Request $request
     *
     * @return Redirector|Application|RedirectResponse
     */
    public function save(Request $request): Redirector|Application|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('user.ticket'));
        }

        $validate = $request->validate([
            'name'     => 'required|string|min:2|max:64',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|max:100',
        ]);

        if (User::where('email', $validate['email'])->exists()) {
            redirect(route('user.registration'))->withErrors([
                'email' => 'Пользователь с таким email уже существует'
            ]);
        }

        $user = User::create($validate);

        if ($user) {
            Auth::login($user);

            return redirect(route('user.ticket'));
        }

        return redirect(route('user.login'))->withErrors([
            'formError' => 'Произошла ошибка при регистрации'
        ]);
    }
}
