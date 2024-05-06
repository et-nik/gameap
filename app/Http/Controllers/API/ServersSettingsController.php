<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Helpers\PermissionHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\ServerSettingSaveRequest;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\ServerRepository;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Symfony\Component\Serializer\SerializerInterface;

class ServersSettingsController extends AuthController
{
    /**
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    public $repository;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var AuthFactory */
    protected $authFactory;

    /**
     * ServersController constructor.
     * @param ServerRepository $repository
     */
    public function __construct(
        ServerRepository $repository,
        SerializerInterface $serializer,
        AuthFactory $authFactory
    ) {
        parent::__construct();

        $this->repository            = $repository;
        $this->serializer            = $serializer;
        $this->authFactory           = $authFactory;
    }

    public function get(Server $server)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        $this->authorize('server-control', $server);
        $this->authorize('server-settings', $server);

        $isAdmin = $currentUser->can(PermissionHelper::ADMIN_PERMISSIONS);

        $settings = [
            $server::AUTOSTART_SETTING_KEY => [
                'name' => $server::AUTOSTART_SETTING_KEY,
                'value' => $server->getSetting($server::AUTOSTART_SETTING_KEY)->value,
                'type' => 'bool',
                'label' => __('servers.autostart_setting'),
            ],
            $server::UPDATE_BEFORE_START_SETTING_KEY => [
                'name' => $server::UPDATE_BEFORE_START_SETTING_KEY,
                'value' => $server->getSetting($server::UPDATE_BEFORE_START_SETTING_KEY)->value,
                'type' => 'bool',
                'label' => __('servers.update_before_start_setting'),
            ],
        ];

        foreach($server->gameMod->vars as $var) {
            if (!empty($var['admin_var']) && !$isAdmin) {
                continue;
            }

            $settings[$var['var']] = [
                'name' => $var['var'],
                'value' => $var['default'],
                'type' => $var['type'] ?? 'string',
                'label' => $var['info'] ?? $var['var'],
            ];
        }

        foreach($server->settings as $setting) {
            if (!isset($settings[$setting->name])) {
                continue;
            }

            if (!empty($settings[$setting->name]['admin_var']) && !$isAdmin) {
                continue;
            }

            $settings[$setting->name] = [
                'name' => $setting->name,
                'value' => $setting->value,
                'label' => $settings[$setting->name]['label'] ?? $setting->name,
                'type' => $settings[$setting->name]['type'] ?? 'string',
            ];
        }

        unset($settings[$server::AUTOSTART_CURRENT_SETTING_KEY]);

        return array_values($settings);
    }

    public function save(Server $server, ServerSettingSaveRequest $request)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        $this->authorize('server-control', $server);
        $this->authorize('server-settings', $server);

        $isAdmin = $currentUser->can(PermissionHelper::ADMIN_PERMISSIONS);

        $settingsInput = $request->all();

        $settings = [
            $server::AUTOSTART_SETTING_KEY => [
                'name' => $server::AUTOSTART_SETTING_KEY,
                'value' => $server->getSetting($server::AUTOSTART_SETTING_KEY)->value,
                'type' => 'bool',
                'label' => __('servers.autostart_setting'),
            ],
            $server::UPDATE_BEFORE_START_SETTING_KEY => [
                'name' => $server::UPDATE_BEFORE_START_SETTING_KEY,
                'value' => $server->getSetting($server::UPDATE_BEFORE_START_SETTING_KEY)->value,
                'type' => 'bool',
                'label' => __('servers.update_before_start_setting'),
            ],
        ];

        foreach($server->gameMod->vars as $var) {
            if (!empty($var['admin_var']) && !$isAdmin) {
                continue;
            }

            $settings[$var['var']] = [
                'name' => $var['var'],
                'value' => $var['default'],
                'type' => $var['type'] ?? 'string',
                'label' => $var['info'] ?? $var['var'],
            ];
        }

        /** @var ServerSettingSaveRequest[][] $settingsInputMap */
        $settingsInputMap = [];
        foreach($settingsInput as $setting) {
            $settingsInputMap[$setting['name']] = $setting['value'];
        }

        foreach($settings as $setting) {
            if (!isset($settingsInputMap[$setting['name']])) {
                continue;
            }

            if (!empty($setting['admin_var']) && !$isAdmin) {
                continue;
            }

            $value = $server->getSetting($setting['name']);
            $value->value = $settingsInputMap[$setting['name']];
            $value->save();
        }

        $this->repository->save($server);
    }
}