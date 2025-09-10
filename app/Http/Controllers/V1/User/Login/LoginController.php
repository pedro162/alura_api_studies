<?php

namespace App\Http\Controllers\V1\User\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();

        if (Auth::check()) {
            return to_route('seasons.episodes.index');
        }

        return view('login', [
            'user' => $user,
            'userId' => $userId,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $password = '';

        Auth::logout();
        Auth::logoutOtherDevices($password);

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->back()->withErrors('Invalid user or password');
        }

        return to_route('seasons.episodes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyUserRequest $request, string $id)
    {
        Auth::logout();
        return to_route('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $crendentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([...$crendentials, 'is_active' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('seasons.episodes.index');
        }

        if (Auth::attempt([...$crendentials, 'is_active' => 1, fn(Builder $query) => $query->has('activeSubscription')])) {
            $request->session()->regenerate();
            return redirect()->intended('seasons.episodes.index');
        }

        if (Auth::attempt($crendentials)) {
            $request->session()->regenerate();
            return redirect()->intended('seasons.episodes.index');
        }

        if (Auth::attemptWhen($crendentials, function (User $user) {
            return $user->isNotBanned();
        })) {
            $request->session()->regenerate();
            return redirect()->intended('seasons.episodes.index');
        }

        if (Auth::guard('admin')->attempt($crendentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin.dashboard');
        }

        $remember = true;

        if (Auth::attempt($crendentials, $remember)) {
            //
        }

        if (Auth::viaRemember()) {
            //
        }

        $user = User::first();

        Auth::login($user, $remember);

        Auth::loginUsingId($user->id, $remember);
        Auth::loginUsingId($user->id, remember: true);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
