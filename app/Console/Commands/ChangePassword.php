<?php

namespace Gameap\Console\Commands;

use Illuminate\Console\Command;
use Gameap\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:change-password {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the job.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userLogin = $this->argument('login');
        $userPassword = $this->argument('password');

        try {
            $user = User::where(['login' => $userLogin])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->error("User not found");
            return 1;
        }

        $user->password = $userPassword;
        $user->save();

        $this->info("Password changed");
    }
}
