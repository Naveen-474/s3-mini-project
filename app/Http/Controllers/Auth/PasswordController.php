<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        info($request);
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        info([$validated]);
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

         return redirect()->route('change.password')->with('status', 'Password Successfully Changed!!');

//
//
//        if (!Hash::check($request->current_password, Auth::user()->password)) {
//            return back()->withErrors(['current_password' => 'Current password does not match']);
//        }
//
//        Auth::user()->update(['password' => Hash::make($request->password)]);



    }
}
