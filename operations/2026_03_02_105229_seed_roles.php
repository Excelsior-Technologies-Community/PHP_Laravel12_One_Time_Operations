<?php

use Spatie\Permission\Models\Role;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation {
    public function process(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
    }
};