<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        // Return an Inertia response rendering the 'User/Show' component
        return Inertia::render('User/Show', [
            'user' => $user // Pass the user data to the Vue component
        ]);
    }
}
