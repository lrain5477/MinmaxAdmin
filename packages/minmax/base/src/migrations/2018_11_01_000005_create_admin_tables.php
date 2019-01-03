<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('parent_id', 64)->nullable()->comment('上層目錄');
            $table->string('title')->comment('選單名稱');
            $table->string('uri')->unique()->comment('Uri');
            $table->string('controller')->nullable()->comment('Controller 名稱');
            $table->string('model')->nullable()->comment('Model 名稱');
            $table->string('link')->nullable()->comment('項目連結');
            $table->string('icon')->nullable()->comment('圖示 Class');
            $table->string('permission_key', 128)->nullable()->comment('權限綁定代碼');
            $table->json('options')->nullable()->comment('選單設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('username')->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->rememberToken();
            $table->string('name')->nullable()->comment('姓名');
            $table->string('email')->nullable()->comment('Email');
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
        Schema::dropIfExists('admin');
        Schema::dropIfExists('admin_menu');
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
        $adminData = [
            [
                'id' => Str::uuid(), 'username' => 'sysadmin', 'password' => Hash::make('a24252151-A'),
                'name' => '超級管理員', 'email' => 'info@e-creative.tw',
                'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $adminId = uuidl(), 'username' => 'admin', 'password' => Hash::make('24252151'),
                'name' => '系統管理員', 'email' => 'design27@e-creative.tw',
                'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];
        DB::table('admin')->insert($adminData);


        // 新增權限角色-帳號對應 (admin)
        if ($adminModel = \Minmax\Base\Models\Admin::query()->where('username', 'admin')->first()) {
            $adminModel->attachRoles([1, 2]);
        }

        // 建立權限物件
        $permissionsData = [];
        //$permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterSchedule', '電子報管理'));
        //$permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterTemplate', '電子報範本'));
        //$permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterSubscribe', '電子報名單', ['R', 'D']));
        //$permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'newsletterGroup', '電子報類別'));
        $permissionsData[] = [
            'guard' => 'admin', 'group' => 'system',
            'name' => 'systemUpload', 'label' => '上傳', 'display_name' => '系統操作 [上傳]', 'description' => '系統操作 [上傳]',
            'sort' => 301, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
        ];
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'webData', '網站基本資訊', ['U'], 302));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'webMenu', '前臺選單目錄', 303));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'admin', '管理員帳戶', 311));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'role', '群組管理', 312));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'firewall', '防火牆', 371));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'loginLog', '後臺登入紀錄', ['R'], 372));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'systemLog', '後臺操作紀錄', ['R'], 373));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'siteParameterItem', '參數項目管理', 391));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'siteParameterGroup', '參數群組管理', 392));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單 - 分類
        $adminMenuData = [
            [
                'id' => $menuClassId1 = uuidl(), 'title' => 'Default', 'uri' => 'root-default',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null, 'permission_key' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => $menuClassId2 = uuidl(), 'title' => 'Module', 'uri' => 'root-module',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null, 'permission_key' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => $menuClassId3 = uuidl(), 'title' => 'System', 'uri' => 'root-system',
                'controller' => null, 'model' => null, 'parent_id' => null, 'link' => null, 'icon' => null, 'permission_key' => null,
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];

        $webData = DB::table('web_data')->where('guard', 'web')->first();

        // 管理員選單
        $adminMenuData = array_merge($adminMenuData, [
            // Default
            [
                'id' => uuidl(),
                'title' => '後臺首頁',
                'uri' => 'home-admin',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId1,
                'link' => '/',
                'icon' => 'icon-home3',
                'permission_key' => null,
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'permission_key' => null,
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'permission_key' => null,
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
                'permission_key' => 'systemUpload',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => 'WebDataController',
                'model' => 'WebData',
                'parent_id' => $menuParentId1,
                'link' => "web-data/{$webData->id}/edit",
                'icon' => null,
                'permission_key' => 'webDataEdit',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'permission_key' => 'webMenuShow',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'permission_key' => null,
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
                'permission_key' => 'adminShow',
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
                'permission_key' => 'roleShow',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'permission_key' => null,
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
                'permission_key' => 'firewallShow',
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
                'permission_key' => 'systemLogShow',
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
                'permission_key' => 'loginLogShow',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],

            [
                'id' => $menuParentId4 = uuidl(),
                'title' => '系統參數',
                'uri' => 'control-parameter',
                'controller' => null,
                'model' => null,
                'parent_id' => $menuClassId3,
                'link' => null,
                'icon' => 'icon-filter',
                'permission_key' => null,
                'sort' => 306, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '參數項目',
                'uri' => 'site-parameter-item',
                'controller' => 'SiteParameterItemController',
                'model' => 'SiteParameterItem',
                'parent_id' => $menuParentId4,
                'link' => 'site-parameter-item',
                'icon' => null,
                'permission_key' => 'siteParameterItemShow',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'id' => uuidl(),
                'title' => '參數群組',
                'uri' => 'site-parameter-group',
                'controller' => 'SiteParameterGroupController',
                'model' => 'SiteParameterGroup',
                'parent_id' => $menuParentId4,
                'link' => 'site-parameter-group',
                'icon' => null,
                'permission_key' => 'siteParameterGroupShow',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ]);
        DB::table('admin_menu')->insert($adminMenuData);
    }
}
