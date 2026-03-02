<?php

use App\Models\User;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation {
    public function process(): void
    {
        User::where('created_at', '<', now()->subYear())->delete();
    }
};