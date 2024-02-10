<?php

namespace Gameap\Console\Commands;

use Gameap\Repositories\GameRepository;
use Illuminate\Console\Command;

class UpgradeGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade games';

    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameRepository
     */
    protected $repository;


    /**
     * Create a new command instance.
     *
     * @param  \Gameap\Repositories\GameRepository $repository
     */
    public function __construct(GameRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = $this->repository->upgradeFromRepo();

        if ($result) {
            $this->info('Games upgraded');
        } else {
            $this->error('Error while upgrading games');
        }
    }
}