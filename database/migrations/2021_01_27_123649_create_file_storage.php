<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('images')->create('file_storage', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->index()->default(0);
            $table->timestamps();
            $table->string('md5', 32)->index()->comment('Хеш файла');
            $table->string('mime')->nullable();
            $table->integer('size')->comment('Размер в байтах');
            $table->integer('width')->nullable()->comment('Ширина');
            $table->integer('height')->nullable()->comment('Высота');
            $table->binary('raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('images')->dropIfExists('file_storage');
    }
}
