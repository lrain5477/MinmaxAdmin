<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuArticleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        // 刪除預設資料
        $this->deleteDatabase();
    }

    /**
     * Insert default data
     *
     * @return void
     */
    public function insertDatabase()
    {
        $timestamp = date('Y-m-d H:i:s');

        // 建立權限物件
        $permissionsData = [];
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'articleNews', '新聞稿', 201));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'articleStatic', '靜態頁面', 202));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'articleCategory', '內容類別管理', 211));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuClassId = DB::table('admin_menu')->where('uri', 'root-module')->value('id')) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '內容管理',
                    'uri' => 'control-article',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClassId,
                    'link' => null,
                    'icon' => 'icon-file-text',
                    'permission_key' => null,
                    'sort' => 201, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '新聞稿',
                    'uri' => 'article-news',
                    'controller' => 'ArticleNewsController',
                    'model' => 'ArticleNews',
                    'parent_id' => $menuParentId,
                    'link' => 'article-news',
                    'icon' => null,
                    'permission_key' => 'articleNewsShow',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '靜態頁面',
                    'uri' => 'article-static',
                    'controller' => 'ArticleStaticController',
                    'model' => 'ArticleStatic',
                    'parent_id' => $menuParentId,
                    'link' => 'article-static',
                    'icon' => null,
                    'permission_key' => 'articleStaticShow',
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '內容類別管理',
                    'uri' => 'article-category',
                    'controller' => 'ArticleCategoryController',
                    'model' => 'ArticleCategory',
                    'parent_id' => $menuParentId,
                    'link' => 'article-category',
                    'icon' => null,
                    'permission_key' => 'articleCategoryShow',
                    'sort' => 11, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-article', 'article-category'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();
    }
}
