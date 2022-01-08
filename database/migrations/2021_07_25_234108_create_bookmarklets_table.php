<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarkletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarklets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('javascript_code');
            $table->enum('status', ['ENABLED', 'ENABLED_ONLY_FOR_ADMINS', 'DISABLED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarklets');
    }
}
