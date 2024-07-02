<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'country' => ['required', 'string', 'size:2']
        ]);

        $user = $request->user();
        $profile = $user->profile;

        // Assuming the profile model has a fillable property set up for the fields
        $profile->fill($request->only([
            'first_name', 'last_name', 'birthday', 'gender', 'street_address', 'city', 'state', 'postal_code', 'country', 'locale'
        ]))->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }


}
