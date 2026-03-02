<?php

use App\Models\User;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation {
    // This runs synchronously
    protected bool $async = false;

    public function process(): void
    {
        User::create([
            'name' => 'Awesome User',
            'email' => 'awesome@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
};