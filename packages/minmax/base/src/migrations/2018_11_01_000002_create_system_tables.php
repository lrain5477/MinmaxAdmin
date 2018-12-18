<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 系統參數群組
        Schema::create('system_parameter_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('群組代碼');
            $table->string('title')->comment('群組名稱');
            $table->json('options')->nullable()->comment('群組設定');
            $table->boolean('active')->default(true)->comment('啟用狀態');
        });

        // 系統參數項目
        Schema::create('system_parameter_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')->comment('群組ID');
            $table->string('value')->comment('參數數值');
            $table->string('label')->comment('參數名稱');
            $table->json('options')->nullable()->comment('參數設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');

            $table->unique(['group_id', 'value'], 'idx-group_id-value');

            $table->foreign('group_id')->references('id')->on('system_parameter_group')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 網站參數群組
        Schema::create('site_parameter_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('群組代碼');
            $table->string('title')->comment('群組名稱');
            $table->json('options')->nullable()->comment('群組設定');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->boolean('editable')->default(true)->comment('可否編輯');
        });

        // 網站參數項目
        Schema::create('site_parameter_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')->comment('群組ID');
            $table->string('value')->comment('參數數值');
            $table->string('label')->comment('參數名稱');
            $table->json('options')->nullable()->comment('參數設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');

            $table->unique(['group_id', 'value'], 'idx-group_id-value');

            $table->foreign('group_id')->references('id')->on('site_parameter_group')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 網站資訊
        Schema::create('web_data', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('guard', 16)->comment('平台');
            $table->string('website_name')->comment('網站名稱');
            $table->string('system_language')->comment('預設語系');
            $table->string('system_email')->comment('系統信箱');
            $table->string('system_url')->comment('網站網址');
            $table->json('system_logo')->nullable()->comment('網站Logo');
            $table->string('company')->comment('公司資訊');                 // {name, name_en, id}
            $table->string('contact')->comment('聯絡資訊');                 // {[phone, fax, email, address, map, lng, lat]}
            $table->json('social')->nullable()->comment('社群連結');        // {facebook, instagram, youtube}
            $table->string('seo')->comment('搜尋引擎');                     // {meta_description, meta_keywords, og_image}
            $table->json('options')->nullable()->comment('網站設定');       // {head, body, foot}
            $table->string('offline_text')->comment('網站離線訊息');
            $table->boolean('active')->default(true)->comment('網站狀態');
            $table->timestamps();
        });

        // 防火牆
        Schema::create('firewall', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 16)->comment('平台');
            $table->ipAddress('ip')->comment('IP 位址');
            $table->boolean('rule')->default(false)->comment('規則');     // 1:允許 0:禁止
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();

            $table->unique(['guard', 'ip', 'rule'], 'idx-guard-ip-rule');
        });

        // 系統紀錄
        Schema::create('system_log', function (Blueprint $table) {
            $table->string('guard', 16)->comment('平台');
            $table->string('uri')->comment('操作網址');
            $table->string('action', 64)->comment('動作');
            $table->text('id')->comment('項目ID');
            $table->string('username', 255)->comment('帳號');
            $table->ipAddress('ip')->comment('IP 位置');
            $table->text('remark')->nullable()->comment('文字說明');
            $table->boolean('result')->default(true)->comment('狀態');
            $table->timestamp('created_at')->useCurrent();
        });

        // 登入紀錄
        Schema::create('login_log', function (Blueprint $table) {
            $table->string('guard', 16)->comment('平台');
            $table->string('username', 255)->comment('帳號');
            $table->ipAddress('ip')->comment('IP 位置');
            $table->text('remark')->nullable()->comment('文字說明');
            $table->boolean('result')->default(true)->comment('狀態');
            $table->timestamp('created_at')->useCurrent();
        });

        // Laravel 佇列
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        // 文字編輯器模板
        Schema::create('editor_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guard', 16)->comment('平台');
            $table->string('category')->comment('使用類別');
            $table->string('title')->comment('名稱');
            $table->text('description')->comment('敘述');
            $table->longText('editor')->comment('HTML內容');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 建立預設資料
        $this->insertDatabase();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editor_template');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('login_log');
        Schema::dropIfExists('system_log');
        Schema::dropIfExists('firewall');
        Schema::dropIfExists('web_data');
        Schema::dropIfExists('site_parameter_item');
        Schema::dropIfExists('site_parameter_group');
        Schema::dropIfExists('system_parameter_item');
        Schema::dropIfExists('system_parameter_group');
    }

    /**
     * Insert default data
     *
     * @return void
     */
    public function insertDatabase()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        // 系統參數
        $groupIndex = 1;
        $itemIndex = 1;
        $systemParameterGroupData = [];
        $systemParameterItemData = [];

        array_push($systemParameterGroupData, ['code' => 'active', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'danger']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'secondary']), 'sort' => 2],
        ]);
        array_push($systemParameterGroupData, ['code' => 'result', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'success']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'danger']), 'sort' => 2],
        ]);
        array_push($systemParameterGroupData, ['code' => 'rule', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'success']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'danger']), 'sort' => 2],
        ]);
        array_push($systemParameterGroupData, ['code' => 'top', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'info']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'waring']), 'sort' => 2],
        ]);
        array_push($systemParameterGroupData, ['code' => 'visible', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'danger']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'secondary']), 'sort' => 2],
        ]);
        array_push($systemParameterGroupData, ['code' => 'editable', 'title' => 'system_parameter_group.title.' . $groupIndex++]);
        $systemParameterItemData = array_merge($systemParameterItemData, [
            ['group_id' => $groupIndex - 1, 'value' => '1', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'danger']), 'sort' => 1],
            ['group_id' => $groupIndex - 1, 'value' => '0', 'label' => 'system_parameter_item.label.' . $itemIndex++, 'options' => json_encode(['class' => 'secondary']), 'sort' => 2],
        ]);

        DB::table('system_parameter_group')->insert($systemParameterGroupData);
        DB::table('system_parameter_item')->insert($systemParameterItemData);

        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '啟用狀態'], ['title' => '操作結果'], ['title' => '防火牆規則'], ['title' => '置頂狀態'], ['title' => '顯示狀態'], ['title' => '可否編輯']
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '启用状态'], ['title' => '操作结果'], ['title' => '防火墙规则'], ['title' => '置顶状态'], ['title' => '显示状态'], ['title' => '可否编辑']
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '有効状態'], ['title' => '操作結果'], ['title' => 'ルール'], ['title' => '頂上状態'], ['title' => '表示状態'], ['title' => '変更可能']
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Active'], ['title' => 'Result'], ['title' => 'Rule'], ['title' => 'Top'], ['title' => 'Visible'], ['title' => 'Editable']
        ], 4));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '啟用'], ['label' => '停用'],
            ['label' => '成功'], ['label' => '失敗'],
            ['label' => '允許'], ['label' => '禁止'],
            ['label' => '正常'], ['label' => '置頂'],
            ['label' => '顯示'], ['label' => '隱藏'],
            ['label' => '啟用'], ['label' => '停用'],
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '启用'], ['label' => '停用'],
            ['label' => '成功'], ['label' => '失败'],
            ['label' => '允许'], ['label' => '禁止'],
            ['label' => '正常'], ['label' => '置顶'],
            ['label' => '显示'], ['label' => '隐藏'],
            ['label' => '启用'], ['label' => '停用'],
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '有効'], ['label' => '無効'],
            ['label' => '成功'], ['label' => '失敗'],
            ['label' => '許可'], ['label' => '禁止'],
            ['label' => '一般'], ['label' => '頂上'],
            ['label' => '表示'], ['label' => '隠す'],
            ['label' => '有効'], ['label' => '無効'],
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'On'], ['label' => 'Off'],
            ['label' => 'Success'], ['label' => 'Failed'],
            ['label' => 'Allowed'], ['label' => 'Denied'],
            ['label' => 'Default'], ['label' => 'Top'],
            ['label' => 'Show'], ['label' => 'Hide'],
            ['label' => 'On'], ['label' => 'Off'],
        ], 4));

        // 全球化 - 語言
        $webData = [
            [
                'id' => $webDataId1 = uuidl(),
                'guard' => 'administrator',
                'website_name' => "web_data.website_name.{$webDataId1}",
                'system_language' => 'zh-Hant',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/administrator',
                'system_logo' => json_encode([['path' => '/admin/images/logo-b.png']]),
                'company' => "web_data.company.{$webDataId1}",
                'contact' => "web_data.contact.{$webDataId1}",
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'instagram' => 'https://www.instagram.com',
                    'youtube' => 'https://www.youtube.com',
                ]),
                'seo' => "web_data.seo.{$webDataId1}",
                'options' => "web_data.options.{$webDataId1}",
                'offline_text' => "web_data.offline_text.{$webDataId1}",
                'active' => true,
                'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'id' => $webDataId2 = uuidl(),
                'guard' => 'admin',
                'website_name' => "web_data.website_name.{$webDataId2}",
                'system_language' => 'zh-Hant',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url') . '/siteadmin',
                'system_logo' => json_encode([['path' => '/admin/images/logo-b.png']]),
                'company' => "web_data.company.{$webDataId2}",
                'contact' => "web_data.contact.{$webDataId2}",
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'instagram' => 'https://www.instagram.com',
                    'youtube' => 'https://www.youtube.com',
                ]),
                'seo' => "web_data.seo.{$webDataId2}",
                'options' => "web_data.options.{$webDataId2}",
                'offline_text' => "web_data.offline_text.{$webDataId2}",
                'active' => true,
                'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'id' => $webDataId3 = uuidl(),
                'guard' => 'web',
                'website_name' => "web_data.website_name.{$webDataId3}",
                'system_language' => 'zh-Hant',
                'system_email' => config('mail.from.address'),
                'system_url' => config('app.url'),
                'system_logo' => json_encode([['path' => '/admin/images/logo-b.png']]),
                'company' => "web_data.company.{$webDataId3}",
                'contact' => "web_data.contact.{$webDataId3}",
                'social' => json_encode([
                    'facebook' => 'https://www.facebook.com',
                    'youtube' => 'https://www.youtube.com',
                    'instagram' => 'https://www.instagram.com',
                ]),
                'seo' => "web_data.seo.{$webDataId3}",
                'options' => "web_data.options.{$webDataId3}",
                'offline_text' => "web_data.offline_text.{$webDataId3}",
                'active' => true,
                'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
        ];

        DB::table('web_data')->insert($webData);

        // 多語系
        $webDataLanguage = [
            [
                'id' => $webDataId1,
                'website_name' => '總後臺管理系統',
                'company' => json_encode(['name' => config('app.author'), 'name_en' => config('app.author_en'), 'id' => '24252151']),
                'contact' => json_encode([
                    'phone' => '04-24350749', 'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62', 'lng' => '', 'lat' => ''
                ]),
                'seo' => json_encode(['meta_description' => '', 'meta_keywords' => '']),
                'options' => json_encode(['head' => '', 'body' => '', 'foot' => '']),
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
            ],
            [
                'id' => $webDataId2,
                'website_name' => '後臺管理系統',
                'company' => json_encode(['name' => config('app.author'), 'name_en' => config('app.author_en'), 'id' => '24252151']),
                'contact' => json_encode([
                    'phone' => '04-24350749', 'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62', 'lng' => '', 'lat' => ''
                ]),
                'seo' => json_encode(['meta_description' => '', 'meta_keywords' => '']),
                'options' => json_encode(['head' => '', 'body' => '', 'foot' => '']),
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
            ],
            [
                'id' => $webDataId3,
                'website_name' => config('app.author'),
                'company' => json_encode(['name' => config('app.author'), 'name_en' => config('app.author_en'), 'id' => '24252151']),
                'contact' => json_encode([
                    'phone' => '04-24350749', 'fax' => '',
                    'email' => 'info@ecreative.tw',
                    'address' => '臺中市北屯區東山路一段147巷49號',
                    'map' => 'https://goo.gl/maps/CRMLfK3xWA62', 'lng' => '', 'lat' => ''
                ]),
                'seo' => json_encode(['meta_description' => '', 'meta_keywords' => '']),
                'options' => json_encode(['head' => '', 'body' => '', 'foot' => '']),
                'offline_text' => '網站正在維護中，很快就會回來，請稍候一下。',
            ],
        ];
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_data', $webDataLanguage, 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_data', $webDataLanguage, 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_data', $webDataLanguage, 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('web_data', $webDataLanguage, 4));

        DB::table('language_resource')->insert($languageResourceData);
    }
}
