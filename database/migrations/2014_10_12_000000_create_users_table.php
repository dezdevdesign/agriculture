<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('contact')->nullable();
            $table->string('municipality');
            $table->string('position');
            $table->rememberToken();
            $table->timestamps();
        });

        //Super User
        DB::table('users')->insert(
            array([
                'name' => 'Super User',
                'username' => 'superuser',
                'password' => '$2y$10$JwJWSHxCxefgGd1tsmsaqeNZkvTiB4kvN0uPJ0c18eCRNzuPcZlqu',
                'contact' => '(0933) 444-1167',
                'municipality' => 'Bani',
                'position' => 'Admin'
            ])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
