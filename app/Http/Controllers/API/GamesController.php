<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\GameRepository;

class GamesController extends AuthController
{
    /**
     * The GameRepository instance.
     *
     * @var \Gameap\Repositories\GameRepository
     */
    public $repository;

    /**
     * GamesController constructor.
     * @param GameRepository $repository
     */
    public function __construct(GameRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }
}