<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Autorizzazione
        $this->authorize('update', $user);

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Autorizzazione
        $this->authorize('update', $user);

        // Validazione dei dati
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Aggiornamento dei dati dell'utente
        $user->update($validatedData);

        return redirect()->route('profile.edit', $user->id)->with('success', 'Profile updated successfully');
    }
}


