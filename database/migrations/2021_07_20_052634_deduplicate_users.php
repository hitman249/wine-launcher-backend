<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeduplicateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = DB::connection('sqlite')->table('users')->get(['id', 'name', 'hashes']);

        foreach ($users as $user) {
            foreach ($users as $user2) {
                if ($user->id !== $user2->id && $user->name === $user2->name) {
                    $hashes  = json_decode($user->hashes, true);
                    $hashes2 = json_decode($user2->hashes, true);

                    if (0 === count(array_diff($hashes, $hashes2))) {
                        DB::connection('sqlite')->table('users')->delete($user2->id);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
