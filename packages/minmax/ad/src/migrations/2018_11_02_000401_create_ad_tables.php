<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateAdTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // AdvertisingCategory 廣告版位
        Schema::create('advertising_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('版位代碼');
            $table->string('title')->comment('版位名稱');                   // language
            $table->string('remark')->nullable()->comment('備註');          // language
            $table->string('ad_type')->nullable()->comment('廣告種類');
            $table->json('options')->nullable()->comment('版位設定');       // {width, height, speed}
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // Advertising 廣告管理
        Schema::create('advertising', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('category_id')->comment('版位ID');
            $table->string('title')->comment('廣告名稱');                       // language
            $table->string('target')->comment('目標視窗');
            $table->string('link')->comment('連結網址');                        // language
            $table->string('details')->nullable()->comment('詳細內容');         // language {pic, topic, description, editor}
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('advertising_category')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // AdvertisingTrack 廣告追蹤
        Schema::create('advertising_track', function (Blueprint $table) {
            $table->string('advertising_id')->index()->comment('廣告ID');
            $table->ipAddress('ip')->comment('IP位址');
            $table->date('click_at')->comment('點擊日期');
            $table->timestamp('created_at')->useCurrent()->comment('建立時間');

            $table->unique(['advertising_id', 'ip', 'click_at']);

            $table->foreign('advertising_id')->references('id')->on('advertising')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        $this->insertSystemParameters();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->deleteSystemParameters();

        Schema::dropIfExists('advertising_track');
        Schema::dropIfExists('advertising');
        Schema::dropIfExists('advertising_category');
    }

    /**
     * Insert system parameters for this module.
     *
     * @return void
     */
    public function insertSystemParameters()
    {
        $languageResourceData = [];

        $startGroupId = $lastGroupId = DB::table('system_parameter_group')->latest('id')->value('id') ?? 0;
        $systemGroupData = [
            ['code' => 'ad_type', 'title' => 'system_parameter_group.title.' . ++$startGroupId],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '廣告種類']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '广告种类']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '広告種類']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Type']
        ], 4, $lastGroupId + 1));


        $startItemId = $lastItemId = DB::table('system_parameter_item')->latest('id')->value('id') ?? 0;
        $systemItemData = [
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'text',
                'label' => 'system_parameter_item.label.' . ++$startItemId,
                'options' => json_encode(['class' => 'secondary', 'details' => 'description']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'photo',
                'label' => 'system_parameter_item.label.' . ++$startItemId,
                'options' => json_encode(['class' => 'secondary', 'details' => 'pic']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'alert',
                'label' => 'system_parameter_item.label.' . ++$startItemId,
                'options' => json_encode(['class' => 'secondary', 'details' => 'pic,description']),
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'marquee',
                'label' => 'system_parameter_item.label.' . ++$startItemId,
                'options' => json_encode(['class' => 'secondary', 'details' => 'topic']),
                'sort' => 4,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'slide',
                'label' => 'system_parameter_item.label.' . ++$startItemId,
                'options' => json_encode(['class' => 'secondary', 'details' => 'pic,topic,description']),
                'sort' => 5,
            ],
        ];

        DB::table('system_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '文字廣告'], ['label' => '圖片廣告'], ['label' => '彈出式'], ['label' => '跑馬燈'], ['label' => '輪播式']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '文字广告'], ['label' => '图片广告'], ['label' => '弹出式'], ['label' => '跑马灯'], ['label' => '轮播式']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'テキスト広告'], ['label' => 'イメージ広告'], ['label' => '警報タイプ'], ['label' => 'マーキー'], ['label' => 'スライド']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'Text'], ['label' => 'Photo'], ['label' => 'Light Box'], ['label' => 'Marquee'], ['label' => 'Slide']
        ], 4, $lastItemId + 1));

        // 欄位擴充
        $lastExtensionId = DB::table('column_extension')->latest('id')->value('id') ?? 0;
        $columnExtensionData = [
            ['table_name' => 'advertising', 'column_name' => 'details', 'sub_column_name' => 'pic', 'sort' => 1, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 1), 'options' => json_encode(['method' => 'getFieldMediaImage'])],
            ['table_name' => 'advertising', 'column_name' => 'details', 'sub_column_name' => 'topic', 'sort' => 2, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 2), 'options' => json_encode(['method' => 'getFieldText'])],
            ['table_name' => 'advertising', 'column_name' => 'details', 'sub_column_name' => 'description', 'sort' => 3, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 3), 'options' => json_encode(['method' => 'getFieldTextarea'])],
            ['table_name' => 'advertising', 'column_name' => 'details', 'sub_column_name' => 'editor', 'sort' => 4, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 4), 'options' => json_encode(['method' => 'getFieldEditor'])],
        ];

        DB::table('column_extension')->insert($columnExtensionData);

        // 多語系
        $columnExtensionLanguage = [
            ['title' => '廣告圖片'], ['title' => '標題文字'], ['title' => '內容文字'], ['title' => '自訂內容']
        ];
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 1, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 2, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 3, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 4, $lastExtensionId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Delete system parameters for this module.
     *
     * @return void
     */
    public function deleteSystemParameters()
    {
        $parameterCodeSet = ['ad_type'];

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('system_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('key', 'system_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('key', 'system_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->delete();

        $columnExtensionTableSet = ['advertising'];

        DB::table('column_extension')->whereIn('table_name', $columnExtensionTableSet)->delete();
    }
}
