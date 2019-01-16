<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_menu', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('parent_id', 64)->nullable()->comment('上層目錄');
            $table->string('title')->comment('選單名稱');
            $table->string('uri')->unique()->comment('Uri');
            $table->string('controller')->nullable()->comment('Controller 名稱');
            $table->string('model')->nullable()->comment('Model 名稱');
            $table->string('link')->nullable()->comment('項目連結');
            $table->string('icon')->nullable()->comment('圖示 Class');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->timestamps();
        });

        Schema::create('administrator', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('username')->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->rememberToken();
            $table->string('name')->nullable()->comment('姓名');
            $table->text('allow_ip')->nullable()->comment('IP白名單');
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
        Schema::dropIfExists('administrator');
        Schema::dropIfExists('administrator_menu');
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

        // 管理員帳號
        $administratorData = [
            [
                'id' => Str::uuid(), 'username' => 'sysadmin', 'password' => Hash::make('a24252151-A'),
                'name' => '超級管理員', 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];
        DB::table('administrator')->insert($administratorData);

        // 管理員選單 - 分類
        $administratorMenuData = [
            [
                'id' => $menuClassId1 = uuidl(), 'title' => 'Default', 'uri' => 'root-default',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => $menuClassId2 = uuidl(), 'title' => 'Module', 'uri' => 'root-module',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => $menuClassId3 = uuidl(), 'title' => 'System', 'uri' => 'root-system',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];

        // 管理員選單
        $administratorMenuData = array_merge($administratorMenuData, [
            // Default
            [
                'id' => uuidl(),
                'title' => '系統首頁',
                'uri' => 'home-administrator',
                'controller' => 'SiteController',
                'model' => null,
                'parent_id' => $menuClassId1,
                'link' => '/',
                'icon' => 'icon-home3',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '後臺首頁',
                'uri' => 'home-admin',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId1,
                'link' => config('app.url') . '/siteadmin',
                'icon' => 'icon-home3',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '網站首頁',
                'uri' => 'home-web',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId1,
                'link' => config('app.url'),
                'icon' => 'icon-home3',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            // System
            [
                'id' => $menuParentId1 = uuidl(),
                'title' => '控制臺',
                'uri' => 'control-configuration',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-cog',
                'sort' => 301, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '檔案總管',
                'uri' => 'file-manager',
                'controller' => 'FileManagerController',
                'model' => null,
                'parent_id' => $menuParentId1,
                'link' => 'file-manager',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => 'WebDataController',
                'model' => 'WebData',
                'parent_id' => $menuParentId1,
                'link' => 'web-data',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '後臺選單目錄',
                'uri' => 'admin-menu',
                'controller' => 'AdminMenuController',
                'model' => 'AdminMenu',
                'parent_id' => $menuParentId1,
                'link' => 'admin-menu',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '前臺選單目錄',
                'uri' => 'web-menu',
                'controller' => 'WebMenuController',
                'model' => 'WebMenu',
                'parent_id' => $menuParentId1,
                'link' => 'web-menu',
                'icon' => null,
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '網站參數項目',
                'uri' => 'site-parameter-item',
                'controller' => 'SiteParameterItemController',
                'model' => 'SiteParameterItem',
                'parent_id' => $menuParentId1,
                'link' => 'site-parameter-item',
                'icon' => null,
                'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '網站參數群組',
                'uri' => 'site-parameter-group',
                'controller' => 'SiteParameterGroupController',
                'model' => 'SiteParameterGroup',
                'parent_id' => $menuParentId1,
                'link' => 'site-parameter-group',
                'icon' => null,
                'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'id' => $menuParentId2 = uuidl(),
                'title' => '帳戶資訊',
                'uri' => 'control-account',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-group',
                'sort' => 302, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '後臺帳戶管理',
                'uri' => 'admin',
                'controller' => 'AdminController',
                'model' => 'Admin',
                'parent_id' => $menuParentId2,
                'link' => 'admin',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '權限角色管理',
                'uri' => 'role',
                'controller' => 'RoleController',
                'model' => 'Role',
                'parent_id' => $menuParentId2,
                'link' => 'role',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '權限物件管理',
                'uri' => 'permission',
                'controller' => 'PermissionController',
                'model' => 'Permission',
                'parent_id' => $menuParentId2,
                'link' => 'permission',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'id' => $menuParentId3 = uuidl(),
                'title' => '資訊安全',
                'uri' => 'control-security',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-shield',
                'sort' => 304, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '防火牆',
                'uri' => 'firewall',
                'controller' => 'FirewallController',
                'model' => 'Firewall',
                'parent_id' => $menuParentId3,
                'link' => 'firewall',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '操作紀錄',
                'uri' => 'system-log',
                'controller' => 'SystemLogController',
                'model' => 'SystemLog',
                'parent_id' => $menuParentId3,
                'link' => 'system-log',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '登入紀錄',
                'uri' => 'login-log',
                'controller' => 'LoginLogController',
                'model' => 'LoginLog',
                'parent_id' => $menuParentId3,
                'link' => 'login-log',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'id' => $menuParentId4 = uuidl(),
                'title' => '全球化管理',
                'uri' => 'control-world',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-sphere',
                'sort' => 305, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '語系管理',
                'uri' => 'world-language',
                'controller' => 'WorldLanguageController',
                'model' => 'WorldLanguage',
                'parent_id' => $menuParentId4,
                'link' => 'world-language',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'id' => $menuParentId5 = uuidl(),
                'title' => '系統參數',
                'uri' => 'root-parameter-control',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-filter',
                'sort' => 306, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '系統參數項目',
                'uri' => 'system-parameter-item',
                'controller' => 'SystemParameterItemController',
                'model' => 'SystemParameterItem',
                'parent_id' => $menuParentId5,
                'link' => 'system-parameter-item',
                'icon' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '系統參數群組',
                'uri' => 'system-parameter-group',
                'controller' => 'SystemParameterGroupController',
                'model' => 'SystemParameterGroup',
                'parent_id' => $menuParentId5,
                'link' => 'system-parameter-group',
                'icon' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '編輯器模板管理',
                'uri' => 'editor-template',
                'controller' => 'EditorTemplateController',
                'model' => 'EditorTemplate',
                'parent_id' => $menuParentId5,
                'link' => 'editor-template',
                'icon' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ]);
        DB::table('administrator_menu')->insert($administratorMenuData);
    }
}
