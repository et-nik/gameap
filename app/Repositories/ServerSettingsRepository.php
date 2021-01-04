<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Models\ServerSetting;

class ServerSettingsRepository extends Repository
{
    public function saveSettings(Server $server, array $settings): void
    {
        $existsSettings = $this->getExistsSettings($server);

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

        $this->removeSettingItems($server, $saveSettings);
    }

    private function getExistsSettings(Server $server): array
    {
        $existsSettings = [];
        foreach ($server->settings as $setting) {
            $existsSettings[$setting->name] = $setting;
        }

        return $existsSettings;
    }

    private function removeSettingItems(Server $server, $settings): void
    {
        foreach ($server->settings as $setting) {
            if (!array_key_exists($setting['name'], $settings)) {
                $setting->delete();
            }
        }
    }
}
