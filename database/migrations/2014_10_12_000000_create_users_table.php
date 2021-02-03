<?php

use App\Models\User;
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
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->json('hashes')
                ->comment('Нужно как-то индентифицировать пользователей, чтобы они могли удалять или обновлять свои записи.');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        $user                = new User();
        $user->hashes        = [];
        $user->name          = 'admin';
        $user->last_login_at = \Carbon\Carbon::now();
        $user->save();
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
