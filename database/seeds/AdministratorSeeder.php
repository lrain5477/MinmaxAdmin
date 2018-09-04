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
                'title' => '管理員選單目錄',
                'uri' => 'admin-menu',
                'controller' => 'AdminMenuController',
                'model' => 'AdminMenu',
                'class' => 'system',
                'parent' => 'menu-control',
                'link' => 'admin-menu',
                'icon' => null,
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'title' => '全球化管理',
                'uri' => 'world-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-sphere',
                //'filter' => '',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '語系管理',
                'uri' => 'world-language',
                'controller' => null,
                'model' => 'WorldLanguage',
                'class' => 'system',
                'parent' => 'world-control',
                'link' => 'world-language',
                'icon' => null,
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '國家管理',
                'uri' => 'world-country',
                'controller' => null,
                'model' => 'WorldCountry',
                'class' => 'system',
                'parent' => 'world-control',
                'link' => 'world-country',
                'icon' => null,
                //'filter' => '',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '行政區域',
                'uri' => 'world-state',
                'controller' => null,
                'model' => 'WorldState',
                'class' => 'system',
                'parent' => 'world-control',
                'link' => 'world-state',
                'icon' => null,
                //'filter' => '',
                'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '城市管理',
                'uri' => 'world-city',
                'controller' => null,
                'model' => 'WorldCity',
                'class' => 'system',
                'parent' => 'world-control',
                'link' => 'world-city',
                'icon' => null,
                //'filter' => '',
                'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'title' => '系統參數',
                'uri' => 'parameter-control',
                'controller' => null,
                'model' => null,
                'class' => 'system',
                'parent' => '0',
                'link' => 'javascript:void(0);',
                'icon' => 'icon-filter',
                //'filter' => '',
                'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '參數項目',
                'uri' => 'parameter-item',
                'controller' => null,
                'model' => 'ParameterItem',
                'class' => 'system',
                'parent' => 'parameter-control',
                'link' => 'parameter-item',
                'icon' => null,
                //'filter' => '',
                'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
            [
                'title' => '參數群組',
                'uri' => 'parameter-group',
                'controller' => null,
                'model' => 'ParameterGroup',
                'class' => 'system',
                'parent' => 'parameter-control',
                'link' => 'parameter-group',
                'icon' => null,
                //'filter' => '',
                'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
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
                'sort' => 7, 'updated_at' => $timestamp, 'created_at' => $timestamp
            ],
        ];
        DB::table('administrator_menu')->insert($administratorMenuData);
    }
}
