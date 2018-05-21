<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditorTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editor_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 64);
            $table->string('lang', 100);
            $table->string('guard', 32)->comment('網站群組');
            $table->string('category', 64)->comment('使用類別');
            $table->string('title', 100)->comment('名稱');
            $table->text('description')->comment('敘述');
            $table->text('editor')->comment('HTML內容');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->enum('active', [1, 0])->default(1)->comment('狀態');
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
        Schema::dropIfExists('editor_template');
    }
}
