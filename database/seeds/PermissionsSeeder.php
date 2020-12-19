<?php

namespace Database\Seeders;

use Bouncer;
use DB;
use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        if (Bouncer::role()->where(['name' => 'admin'])->exists()) {
            $roleAdmin = Bouncer::role()->firstOrCreate([
                'name' => 'admin',
            ]);
        } else {
            $roleAdmin = Bouncer::role()->firstOrCreate([
                'name' => 'admin',
                'title' => 'Administrator',
            ]);
        }

        if (Bouncer::role()->where(['name' => 'user'])->exists()) {
            $roleUser = Bouncer::role()->firstOrCreate([
                'name' => 'user',
            ]);
        } else {
            $roleUser = Bouncer::role()->firstOrCreate([
                'name' => 'user',
                'title' => 'User',
            ]);
        }

        // Game Servers permissions
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-common',
            'title' => 'Common Game Server Ability',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-start',
            'title' => 'Start Game Server',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-stop',
            'title' => 'Stop Game Server',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-restart',
            'title' => 'Restart Server',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-pause',
            'title' => 'Pause Game Server',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-update',
            'title' => 'Update Game Server',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-console-view',
            'title' => 'Access to read server console',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-console-send',
            'title' => 'Access to send console commands',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-files',
            'title' => 'Access to server filemanager',
            'entity_type' => Server::class,
        ]));
        Bouncer::allow($roleUser)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'game-server-settings',
            'title' => 'Access to server settings',
            'entity_type' => Server::class,
        ]));

        // Admin permissions
        Bouncer::allow($roleAdmin)->to([
            'game-server-common',
            'game-server-start',
            'game-server-stop',
            'game-server-restart',
            'game-server-pause',
            'game-server-update',
            'game-server-console-view',
            'game-server-console-send',
            'game-server-files',
            'game-server-settings',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'create',
            'title' => 'Create New Item Permission',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'view',
            'title' => 'View Items Permission',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'edit',
            'title' => 'Edit Items Permission',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'delete',
            'title' => 'Delete Items Permission',
        ]);

        Bouncer::allow($roleAdmin)->to(Bouncer::ability()->firstOrCreate([
            'name' => 'admin roles & permissions',
            'title' => 'Common Admininstator Permissions',
        ]));

        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete']);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], Server::class);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], ClientCertificate::class);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], DedicatedServer::class);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], Game::class);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], GameMod::class);
        Bouncer::allow($roleAdmin)->to(['create', 'view', 'edit', 'delete'], User::class);

        $admin = User::Find(1);
        Bouncer::assign('admin')->to($admin);
        Bouncer::assign('user')->to($admin);
    }
}
