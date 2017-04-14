<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    private $roles = [
        'Admin' => [
            'roles.edit',
            'users.edit',
        ],
        'User' => [
            //
        ]
    ];

    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        foreach ($this->roles as $role => $permissions) {
            $roleId = DB::table('roles')->insertGetId([
                'name' =>  $role,
            ]);
            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    $permissionId = DB::table('permissions')->insertGetId([
                        'name' => $permission
                    ]);
                    DB::table('permission_role')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        Schema::drop('roles');
        Schema::drop('permissions');
        Schema::drop('permission_role');
    }
}
