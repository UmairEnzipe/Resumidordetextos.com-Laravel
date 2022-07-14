<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name', 60)->nullable();
            $table->string('tool_slug', 100)->nullable();
            $table->longText('tool_content')->nullable();
            $table->tinyInteger('tool_parent')->nullable();
            $table->string('tool_lang', 5)->nullable();
            $table->string('tool_meta_title', 255)->nullable();
            $table->string('tool_meta_description', 255)->nullable();
            $table->tinyInteger('is_home')->default(0);
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
        Schema::dropIfExists('tools');
    }
}
