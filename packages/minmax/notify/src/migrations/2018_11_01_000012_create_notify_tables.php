<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateNotifyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // NotifyEmail 事件通知信件
        Schema::create('notify_email', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('通知代碼');
            $table->string('title')->comment('通知標題');
            $table->boolean('notifiable')->default(false)->comment('通知用戶');
            $table->json('receivers')->nullable()->comment('系統收件人');
            $table->string('custom_subject')->nullable()->comment('用戶信件主旨');
            $table->string('custom_preheader')->nullable()->comment('用戶信件簡述');
            $table->string('custom_editor')->nullable()->comment('用戶信件內容');
            $table->string('custom_mailable')->nullable()->comment('用戶信件服務');
            $table->string('admin_subject')->nullable()->comment('系統信件主旨');
            $table->string('admin_preheader')->nullable()->comment('系統信件簡述');
            $table->string('admin_editor')->nullable()->comment('系統信件內容');
            $table->string('admin_mailable')->nullable()->comment('系統信件服務');
            $table->string('replacements')->nullable()->comment('代碼說明');
            $table->boolean('queueable')->default(false)->comment('啟用佇列');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 建立系統參數資料
        $this->insertSystemParameters();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除系統參數資料
        $this->deleteSystemParameters();

        Schema::dropIfExists('notify_email');
    }

    /**
     * Insert system parameters for this module.
     *
     * @return void
     */
    public function insertSystemParameters()
    {
        //$timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $lastGroupId = DB::table('system_parameter_group')->latest('id')->value('id') ?? 0;

        $startGroupId = $lastGroupId + 1;
        $systemGroupData = [
            ['code' => 'notifiable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'queueable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '通知用戶'], ['title' => '啟用佇列']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '通知用户'], ['title' => '启用伫列']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'お客通知する'], ['title' => '行列有効']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Notify User'], ['title' => 'Queueable']
        ], 4, $lastGroupId + 1));


        $lastItemId = DB::table('system_parameter_item')->latest('id')->value('id') ?? 0;

        $startItemId = $lastItemId + 1;
        $systemItemData = [
            [
                'group_id' => $lastGroupId + 1,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 2,
            ],
        ];

        DB::table('system_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '啟用'], ['label' => '停用'], ['label' => '啟用'], ['label' => '停用']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '启用'], ['label' => '停用'], ['label' => '启用'], ['label' => '停用']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '有効'], ['label' => '無効'], ['label' => '有効'], ['label' => '無効']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'Enable'], ['label' => 'Disable'], ['label' => 'Enable'], ['label' => 'Disable']
        ], 4, $lastItemId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Delete system parameters for this module.
     *
     * @return void
     */
    public function deleteSystemParameters()
    {
        $parameterCodeSet = ['notifiable', 'queueable'];

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('system_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('title', 'like', 'system_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('title', 'like', 'system_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->delete();
    }
}
