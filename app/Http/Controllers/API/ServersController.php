<?php

namespace Gameap\Http\Controllers\API;

use Exception;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Helpers\PermissionHelper;
use Gameap\Helpers\ServerPermissionHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\ServerDestroyRequest;
use Gameap\Http\Requests\API\SaveServerRequest;
use Gameap\Http\Requests\API\ServerConsoleCommandRequest;
use Gameap\Models\GdaemonTask;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\ServerControlService;
use Gameap\Services\ServerService;
use Gameap\UseCases\Commands\CreateGameServerCommand;
use Gameap\UseCases\Commands\EditGameServerCommand;
use Gameap\UseCases\CreateGameServer;
use Gameap\UseCases\EditGameServer;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Psr\SimpleCache\CacheInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ServersController extends AuthController
{
    /**
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    public $repository;

    /**
     * The GdaemonTaskRepository instance.
     *
     * @var GdaemonTaskRepository
     */
    public $gdaemonTaskRepository;

    /** @var \Gameap\Services\ServerService  */
    public $serverService;

    /** @var \Gameap\Services\ServerControlService */
    public $serverControlService;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var AuthFactory */
    protected $authFactory;

    /** @var CacheInterface */
    protected $cache;

    /**
     * ServersController constructor.
     * @param ServerRepository $repository
     */
    public function __construct(
        ServerRepository $repository,
        GdaemonTaskRepository $gdaemonTaskRepository,
        ServerService $serverService,
        ServerControlService $serverControlService,
        SerializerInterface $serializer,
        AuthFactory $authFactory,
        CacheInterface $cache
    ) {
        parent::__construct();

        $this->repository            = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->serverService         = $serverService;
        $this->serverControlService  = $serverControlService;
        $this->serializer            = $serializer;
        $this->authFactory           = $authFactory;
        $this->cache                 = $cache;
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function get(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);

        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();
        $isAdmin = $currentUser->can(PermissionHelper::ADMIN_PERMISSIONS);

        if ($isAdmin) {
            return $server->only([
                'id',
                'uuid',
                'uuid_short',
                'enabled',
                'installed',
                'blocked',
                'name',
                'ds_id',
                'game_id',
                'game_mod_id',
                'server_ip',
                'server_port',
                'query_port',
                'rcon_port',
                'game',
                'last_process_check',
                'online',

                // Admin details
                'rcon',
                'dir',
                'su_user',
                'start_command',
                'aliases',
                'vars',
            ]);
        }

        return $server->only([
            'id',
            'uuid',
            'uuid_short',
            'enabled',
            'installed',
            'blocked',
            'name',
            'ds_id',
            'game_id',
            'game_mod_id',
            'server_ip',
            'server_port',
            'query_port',
            'rcon_port',
            'game',
            'last_process_check',
            'online',
        ]);
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function abilities(Server $server)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();
        $isAdmin = $currentUser->can(PermissionHelper::ADMIN_PERMISSIONS);

        $abilities = [];

        foreach (ServerPermissionHelper::getAllPermissions() as $permission) {
            $abilities[$permission] = $isAdmin || $currentUser->can($permission, $server);
        }

        return $abilities;
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function start(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::START_ABILITY, $server);

        try {
            $gdaemonTaskId = $this->serverControlService->start($server);
        } catch (GdaemonTaskRepositoryException $exception) {
            return $this->handleException($exception);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_START
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function stop(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::STOP_ABILITY, $server);

        try {
            $gdaemonTaskId = $this->serverControlService->stop($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_STOP
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::RESTART_ABILITY, $server);

        try {
            $gdaemonTaskId = $this->serverControlService->restart($server);
        } catch (GdaemonTaskRepositoryException $exception) {
            return $this->handleException($exception);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_RESTART
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::UPDATE_ABILITY, $server);

        try {
            $gdaemonTaskId = $this->serverControlService->update($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_UPDATE
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function install(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::UPDATE_ABILITY, $server);

        try {
            $gdaemonTaskId = $this->serverControlService->install($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_INSTALL
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reinstall(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::UPDATE_ABILITY, $server);

        try {
            $deleteTaskId  = $this->gdaemonTaskRepository->addServerDelete($server);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerInstall($server, $deleteTaskId);
        } catch (RecordExistExceptions $exception) {
            return $this->makeErrorResponse($exception->getMessage());
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * Get server status
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getStatus(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);

        return [
            'processActive' => $server->processActive(),
        ];
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);

        $query = $this->serverService->query($server);

        return $query;
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function consoleLog(Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::CONSOLE_VIEW_ABILITY, $server);

        return [
            'console' => $this->serverService->getConsoleLog($server),
        ];
    }

    /**
     * @param ServerConsoleCommandRequest $request
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sendCommand(ServerConsoleCommandRequest $request, Server $server)
    {
        $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $server);
        $this->authorize(ServerPermissionHelper::CONSOLE_SEND_ABILITY, $server);

        $command = $request->input('command');
        $this->serverService->sendConsoleCommand($server, $command);

        return ['message' => 'success'];
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        return $this->repository->search($query);
    }

    public function getList()
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        if ($currentUser->can(PermissionHelper::ADMIN_PERMISSIONS)) {
            $collection = $this->repository->getAllServers()->collect();
        } else {
            $collection = $this->repository->getServersForUser($currentUser->id);
        }

        return $collection->map(function ($item) {
            return $item->only([
                'id',
                'uuid',
                'uuid_short',
                'enabled',
                'installed',
                'blocked',
                'name',
                'ds_id',
                'game_id',
                'game_mod_id',
                'server_ip',
                'server_port',
                'query_port',
                'rcon_port',
                'game',
                'online'
            ]);
        });
    }

    public function allServersAbilities()
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        $cacheKey = 'users:' . $currentUser->id . ':servers-abilities';

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $isAdmin = $currentUser->can(PermissionHelper::ADMIN_PERMISSIONS);

        if ($isAdmin) {
            $servers = $this->repository->getAllServers()->collect();
        } else {
            $servers = $this->repository->getServersForUser($currentUser->id);
        }

        $abilities = [];
        foreach ($servers as $server) {
            $abilities[$server->id] = [];

            foreach (ServerPermissionHelper::getAllPermissions() as $permission) {
                $abilities[$server->id][$permission] = $isAdmin || $currentUser->can($permission, $server);
            }
        }

        $this->cache->set($cacheKey, $abilities, 60);

        return $abilities;
    }

    public function summary()
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        if ($currentUser->can(PermissionHelper::ADMIN_PERMISSIONS)) {
            $collection = $this->repository->getAllServers()->collect();
        } else {
            $collection = $this->repository->getServersForUser($currentUser->id);
        }

        $total = $collection->count();
        $online = $collection->filter(function ($item) {
            return $item->online;
        })->count();

        return [
            'total' => $total,
            'online' => $online,
            'offline' => $total - $online,
        ];
    }

    public function store(SaveServerRequest $request, CreateGameServer $createGameServer): array
    {
        /** @var CreateGameServerCommand $command */
        $command = $this->serializer->denormalize(
            $request->all(),
            CreateGameServerCommand::class,
        );

        $result = $createGameServer($command);

        return ['message' => 'success', 'result' => $result];
    }

    public function save(int $id, SaveServerRequest $request, EditGameServer $saveGameServer): array
    {
        /** @var EditGameServerCommand $command */
        $command = $this->serializer->denormalize(
            $request->all(),
            EditGameServerCommand::class,
        );

        $command->id = $id;

        $result = $saveGameServer($command);

        return ['message' => 'success', 'result' => $result->id];
    }

    public function destroy(ServerDestroyRequest $request, Server $server)
    {
        if ($request->input('delete_files')) {
            try {
                $this->gdaemonTaskRepository->addServerDelete($server);
            } catch (RecordExistExceptions $e) {
                // Nothing
            }

            $server->delete();
        } else {
            $server->forceDelete();
        }

        return ['message' => 'success'];
    }

    /**
     * @param Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleException(\Throwable $exception)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        if ($currentUser->can(PermissionHelper::ADMIN_PERMISSIONS)) {
            $extraMessage = $this->getDocMessage($exception);
        } else {
            $extraMessage = (string)__('main.common_admin_error');
        }

        return $this->makeErrorResponse($exception->getMessage() . $extraMessage);
    }

    /**
     * @param Exception $exception
     * @return string
     */
    private function getDocMessage(\Throwable $exception)
    {
        $msg = '';

        if ($exception instanceof EmptyServerStartCommandException) {
            $msg = __('gdaemon_tasks.empty_server_start_command_doc');
        }

        return is_string($msg) ? $msg : '';
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function makeErrorResponse($message, $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'message'   => $message,
            'http_code' => $code,
        ], $code);
    }
}
