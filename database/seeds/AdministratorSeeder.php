<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultLanguage = 'tw';
        $timestamp = date('Y-m-d H:i:s');

        $administratorData = [
            [
                'guid' => Str::uuid(),
                'username' => 'sysadmin',
                'password' => Hash::make('a24252151-A'),
                'name' => '超級管理員',
                'active' => '1',
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ],
        ];
        DB::table('administrator')->insert($administratorData);

        $administratorMenuData = [
            [
                'title' => '系統選單管理',
                'uri' => 'menu-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-folder',
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '管理員選單類別',
                'uri' => 'admin-menu-class',
                'controller' => null,
                'model' => 'AdminMenuClass',
                'class' => 'system',
                'parent' => 'menu-control',
                'link' => 'admin-menu-class',
                'icon' => 'icon-cog',
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '管理員選單目錄',
                'uri' => 'admin-menu-item',
                'controller' => 'AdminMenuItemController',
                'model' => 'AdminMenuItem',
                'class' => 'system',
                'parent' => 'menu-control',
                'link' => 'admin-menu-item',
                'icon' => null,
                //'filter' => '',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '經銷商選單類別',
                'uri' => 'merchant-menu-class',
                'controller' => null,
                'model' => 'MerchantMenuClass',
                'class' => 'system',
                'parent' => 'menu-control',
                'link' => 'merchant-menu-class',
                'icon' => null,
                //'filter' => '',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '經銷商選單目錄',
                'uri' => 'merchant-menu-item',
                'controller' => 'MerchantMenuItemController',
                'model' => 'MerchantMenuItem',
                'class' => 'system',
                'parent' => 'menu-control',
                'link' => 'merchant-menu-item',
                'icon' => null,
                //'filter' => '',
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '權限管理',
                'uri' => 'permission-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-group',
                //'filter' => '',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '權限物件管理',
                'uri' => 'permission',
                'controller' => null,
                'model' => 'Permission',
                'class' => 'system',
                'parent' => 'permission-control',
                'link' => 'permission',
                'icon' => null,
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '權限角色管理',
                'uri' => 'role',
                'controller' => 'RoleController',
                'model' => 'Role',
                'class' => 'system',
                'parent' => 'permission-control',
                'link' => 'role',
                'icon' => null,
                //'filter' => '',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '語系管理',
                'uri' => 'language',
                'controller' => null,
                'model' => 'Language',
                'class' => 'system',
                'parent' => '0',
                'link' => 'language',
                'icon' => 'icon-globe',
                //'filter' => '',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '網站基本資訊',
                'uri' => 'web-data',
                'controller' => null,
                'model' => 'WebData',
                'class' => 'system',
                'parent' => '0',
                'link' => 'web-data',
                'icon' => 'icon-cog',
                //'filter' => '',
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '編輯器模板管理',
                'uri' => 'editor-template',
                'controller' => null,
                'model' => 'EditorTemplate',
                'class' => 'system',
                'parent' => '0',
                'link' => 'editor-template',
                'icon' => 'icon-libreoffice',
                //'filter' => '',
                'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '操作紀錄',
                'uri' => 'system-log',
                'controller' => null,
                'model' => 'SystemLog',
                'class' => 'system',
                'parent' => '0',
                'link' => 'system-log',
                'icon' => 'icon-warning',
                //'filter' => '',
                'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('administrator_menu')->insert($administratorMenuData);
    }
}
