<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }
    private function user()
    {
        return Auth::user();
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        try {
            // Redirect berdasarkan role 
            $role = $this->user()->getRoleNames()->first();
            // dd($role);
            if ($role === 'Superadmin') {
                $request->session()->regenerate();
                $this->activityService->log(
                    $role,
                    $this->user()->id,
                    'Login',
                    'Login ke sistem sebagai ' . $role
                );
                return redirect()->intended(route('superadmin.dashboard', absolute: false));
            } else if ($role === 'Admin') {
                $request->session()->regenerate();
                $this->activityService->log(
                    $role,
                    $this->user()->id,
                    'Login',
                    'Login ke sistem sebagai ' . $role
                );
                return redirect()->intended(route('admin.dashboard', absolute: false));
            } else if ($role === 'District') {
                $request->session()->regenerate();
                $this->activityService->log(
                    $role,
                    $this->user()->id,
                    'Login',
                    'Login ke sistem sebagai ' . $role
                );
                return redirect()->intended(route('district.dashboard', absolute: false));
            } else if ($role === 'Village') {
                $request->session()->regenerate();
                $this->activityService->log(
                    $role,
                    $this->user()->id,
                    'Login',
                    'Login ke sistem sebagai ' . $role
                );
                return redirect()->intended(route('village.dashboard', absolute: false));
            } else {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return to_route('login')->withErrors(['error' => 'Akun Anda tidak aktif atau tidak memiliki peran yang sesuai.']);
            }
        } catch (\Throwable $th) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return to_route('login')->withErrors(['error' => 'Unauthorized access.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }
}
