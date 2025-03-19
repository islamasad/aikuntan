<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Log data sebelum membuat Company
            Log::debug('Membuat Company dengan data:', [
                'uuid' => Str::orderedUuid(),
                'name' => $request->company_name,
            ]);

            $company = Company::create([
                'uuid' => Str::orderedUuid(),
                'name' => $request->company_name,
            ]);

            // Log hasil pembuatan Company
            Log::debug('Company berhasil dibuat:', $company->toArray());

            // Log data sebelum membuat User
            Log::debug('Membuat User dengan data:', [
                'uuid' => Str::orderedUuid(),
                'company_id' => $company->id,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user = User::create([
                'uuid' => Str::orderedUuid(),
                'company_id' => $company->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Log hasil pembuatan User
            Log::debug('User berhasil dibuat:', $user->toArray());

            event(new Registered($user));
            Auth::login($user);

            return redirect(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            // Log error detail
            Log::error('Error saat registrasi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            throw $e; // Re-throw exception untuk melihat stacktrace di lingkungan development
        }
    }
}
