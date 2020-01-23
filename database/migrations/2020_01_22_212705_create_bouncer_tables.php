<?php

use Silber\Bouncer\Database\Models;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBouncerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('roles')) {
            Schema::rename('roles', 'roles_old');
        }

        if (Schema::hasTable('permissions')) {
            Schema::rename('permissions', 'permissions_old');
        }

        Schema::create(Models::table('abilities'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('only_owned')->default(false);
            $table->text('options')->nullable();
            $table->integer('scope')->nullable()->index();
            $table->timestamps();
        });

        Schema::create(Models::table('roles'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->integer('level')->unsigned()->nullable();
            $table->integer('scope')->nullable()->index();
            $table->timestamps();

            $table->unique(
                ['name', 'scope'],
                'roles_name_unique'
            );
        });

        Schema::create(Models::table('assigned_roles'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->integer('entity_id')->unsigned();
            $table->string('entity_type');
            $table->integer('restricted_to_id')->unsigned()->nullable();
            $table->string('restricted_to_type')->nullable();
            $table->integer('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'assigned_roles_entity_index'
            );

            $table->foreign('role_id')
                  ->references('id')->on(Models::table('roles'))
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create(Models::table('permissions'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ability_id')->unsigned()->index();
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('forbidden')->default(false);
            $table->integer('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'permissions_entity_index'
            );

            $table->foreign('ability_id')
                  ->references('id')->on(Models::table('abilities'))
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('roles_old')) {
            $oldRoles = DB::table('roles_old')->get();

            foreach ($oldRoles as $role) {
                DB::table('roles')->insert(
                    [
                        'name' => $role->name,
                        'created_at' => $role->created_at,
                        'updated_at' => $role->updated_at,
                    ]
                );
            }

            Schema::drop(Models::table('roles_old'));
        }

        if (Schema::hasTable('permissions_old')) {
            // If permissions_old have not items you should call seeder manually
            if (DB::table('permissions_old')->exists()) {
                Artisan::call('db:seed', [
                    '--class' => PermissionsSeeder::class,
                ]);
            }

            Schema::drop('permissions_old');
        }

        if (Schema::hasTable('model_has_roles')) {
            $rolesRelationships = DB::table('model_has_roles')->get();

            foreach ($rolesRelationships as $relationship) {
                DB::table('assigned_roles')->insert(
                    [
                        'role_id' => $relationship->role_id,
                        'entity_type' => $relationship->model_type,
                        'entity_id' => $relationship->model_id,
                    ]
                );
            }
        }

        if (Bouncer::role()->where(['name' => 'admin'])->exists()) {
            DB::table('roles')
                ->where(['name' => 'admin'])
                ->update(
                    [
                        'title' => 'Administrator',
                    ]
                );

            Bouncer::allow('admin')->to(Bouncer::role()->all());
        }

        if (Bouncer::role()->where(['name' => 'user'])->exists()) {
            DB::table('roles')
                ->where(['name' => 'user'])
                ->update(
                    [
                        'title' => 'User',
                    ]
                );
        }

        Schema::drop('role_has_permissions');
        Schema::drop('model_has_roles');
        Schema::drop('model_has_permissions');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::drop(Models::table('permissions'));
        Schema::drop(Models::table('assigned_roles'));
        Schema::drop(Models::table('roles'));
        Schema::drop(Models::table('abilities'));

        Schema::enableForeignKeyConstraints();

        $tableNames = config('permission.table_names');
        $foreignKeys = config('permission.foreign_keys');

        Schema::create($tableNames['permissions'] ?? 'permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'] ?? 'roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'] ?? 'model_has_permissions',
            function (Blueprint $table) use ($tableNames, $foreignKeys) {
                $table->integer('permission_id')->unsigned();
                $table->morphs('model');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'] ?? 'permissions')
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'model_id', 'model_type']);
            }
        );

        Schema::create($tableNames['model_has_roles'] ?? 'model_has_roles',
            function (Blueprint $table) use ($tableNames, $foreignKeys) {
                $table->integer('role_id')->unsigned();
                $table->morphs('model');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'] ?? 'roles')
                    ->onDelete('cascade');

                $table->primary(['role_id', 'model_id', 'model_type']);
            }
        );

        Schema::create($tableNames['role_has_permissions'] ?? 'role_has_permissions',
            function (Blueprint $table) use ($tableNames) {
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'] ?? 'permissions')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'] ?? 'roles')
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);
            }
        );
    }
}
