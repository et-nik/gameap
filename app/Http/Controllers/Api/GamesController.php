<?php

namespace Gameap\Http\Controllers\Api;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\GameRepository;
use Gameap\Models\Game;

class GamesController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameRepository
     */
    public $repository;

    /**
     * GameModsController constructor.
     * @param GamesController $repository
     */
    public function __construct(GameRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }
}