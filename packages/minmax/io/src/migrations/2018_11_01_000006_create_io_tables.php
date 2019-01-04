<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateIoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // IoConstruct 資料匯入匯出結構
        Schema::create('io_construct', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('資料處理名稱');
            $table->string('uri')->comment('Uri');
            $table->boolean('import_enable')->default(true)->comment('匯入啟用');
            $table->boolean('export_enable')->default(true)->comment('匯出啟用');
            $table->string('import_view')->nullable()->comment('匯入視圖');
            $table->string('export_view')->nullable()->comment('匯出視圖');
            $table->string('controller')->comment('Controller');
            $table->string('example')->nullable()->comment('範例檔案');
            $table->string('filename')->nullable()->comment('檔案名稱');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // IoRecord 資料匯入匯出紀錄
        Schema::create('io_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('資料處理名稱');
            $table->string('uri')->comment('Uri');
            $table->string('type', 16)->index()->comment('資料處理類型');
            $table->json('errors')->nullable()->comment('錯誤紀錄');
            $table->integer('total')->default(0)->comment('資料數');
            $table->integer('success')->default(0)->comment('成功數量');
            $table->boolean('result')->default(true)->comment('操作結果');
            $table->string('file')->nullable()->comment('檔案路徑');
            $table->timestamp('created_at')->useCurrent();
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

        Schema::dropIfExists('io_record');
        Schema::dropIfExists('io_construct');
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
            ['code' => 'import_enable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'export_enable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '匯入啟用'], ['title' => '匯出啟用']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '汇入启用'], ['title' => '汇出启用']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '輸入有効'], ['title' => '輸出有効']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Import Enable'], ['title' => 'Export Enable']
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
        DB::table('system_parameter_group')->whereIn('code', ['import_enable', 'export_enable'])->delete();

        DB::table('language_resource')->where('title', 'like', 'system_parameter_group.title.%')->delete();
        DB::table('language_resource')->where('title', 'like', 'system_parameter_item.label.%')->delete();
    }
}
