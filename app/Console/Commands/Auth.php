<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Auth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login by credentials';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::firstWhere(['email' => $this->ask('Input email:')]);

        if (!$user || !\Hash::check($this->secret('Input password:'), $user->password)) {
            $this->error('User not found');
        } else {
            $this->info($user->createToken('Bearer')->plainTextToken);
        }
    }
}