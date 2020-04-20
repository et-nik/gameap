<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Models\ServerSetting;

class ServerSettingsRepository extends Repository
{
    public function __construct(Server $server)
    {
        $this->model = $server;
    }

    /**
     * @param Server $server
     * @param array $settings
     * @throws \Exception
     */
    public function saveSettings(Server $server, array $settings)
    {
        $existsSettings = [];
        foreach ($server->settings as $setting) {
            $existsSettings[$setting->name] = $setting;
        }

        $saveSettings = [];
        foreach ($settings as $setting) {
            if (empty($setting['name']) || !isset($setting['value'])) {
                continue;
            }

            $saveSettings[$setting['name']] = $setting['value'];

            if (array_key_exists($setting['name'], $existsSettings)) {
                $existsSettings[$setting['name']]->value = $setting['value'];
                $existsSettings[$setting['name']]->save();
            } else {
                $serverSetting = new ServerSetting();

                $serverSetting->server_id = $server->id;
                $serverSetting->name = $setting['name'];
                $serverSetting->value = $setting['value'];
                $serverSetting->save();
                $existsSettings[$setting['name']] = $serverSetting;
            }
        }

        // Remove items
        foreach ($server->settings as $setting) {
            if (!array_key_exists($setting['name'], $saveSettings)) {
                $setting->delete();
            }
        }
    }

}