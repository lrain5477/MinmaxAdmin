<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('newsletter_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('電子報主題');
            $table->string('subject')->nullable()->comment('信件主旨');
            $table->longText('content')->nullable()->comment('信件內容');
            $table->timestamp('schedule_at')->useCurrent()->comment('排程時間');
            $table->text('groups')->nullable()->comment('發送類別');                // {[group]} 電子報類別
            $table->text('objects')->nullable()->comment('發送目標');               // {[group]} 會員類別
            $table->timestamps();
        });

        Schema::create('newsletter_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('電子報主題');
            $table->string('subject')->nullable()->comment('信件主旨');
            $table->longText('content')->nullable()->comment('信件內容');
            $table->timestamps();
        });

        Schema::create('newsletter_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('類別名稱');
            $table->timestamps();
        });

        Schema::create('newsletter_subscribe', function (Blueprint $table) {
            $table->string('email')->primary()->comment('Email');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('newsletter_record', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id')->comment('電子報ID');
            $table->string('email')->comment('Email');
            $table->string('action')->comment('動作');        // 'sent':已寄送 'open':已開信 'click':連結轉換
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('schedule_id')->references('id')->on('newsletter_schedule')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('newsletter_group_subscribe', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->string('subscribe_email');

            $table->foreign('group_id')->references('id')->on('newsletter_group')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subscribe_email')->references('email')->on('newsletter_subscribe')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['group_id', 'subscribe_email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_group_subscribe');
        Schema::dropIfExists('newsletter_record');
        Schema::dropIfExists('newsletter_subscribe');
        Schema::dropIfExists('newsletter_schedule');
        Schema::dropIfExists('newsletter_group');
        Schema::dropIfExists('newsletter_template');
    }
}
