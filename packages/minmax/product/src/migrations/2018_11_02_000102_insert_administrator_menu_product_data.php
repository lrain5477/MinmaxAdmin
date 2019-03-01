<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdministratorMenuProductData extends Migration
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

        // 管理員選單 - 分類
        if ($menuClassId = DB::table('administrator_menu')->where('uri', 'root-module')->value('id')) {
            $administratorMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'parent_id' => $menuClassId,
                    'title' => '商品管理',
                    'uri' => 'control-product',
                    'controller' => null,
                    'model' => null,
                    'link' => null,
                    'icon' => 'icon-codepen',
                    'sort' => 205, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '品項管理',
                    'uri' => 'product-item',
                    'controller' => 'ProductItemController',
                    'model' => 'ProductItem',
                    'link' => 'product-item',
                    'icon' => null,
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '商品管理',
                    'uri' => 'product-set',
                    'controller' => 'ProductSetController',
                    'model' => 'ProductSet',
                    'link' => 'product-set',
                    'icon' => null,
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '價格組合',
                    'uri' => 'product-package',
                    'controller' => 'ProductPackageController',
                    'model' => 'ProductPackage',
                    'link' => 'product-package',
                    'icon' => null,
                    'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '商品分類',
                    'uri' => 'product-category',
                    'controller' => 'ProductCategoryController',
                    'model' => 'ProductCategory',
                    'link' => 'product-category',
                    'icon' => null,
                    'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '品牌管理',
                    'uri' => 'product-brand',
                    'controller' => 'ProductBrandController',
                    'model' => 'ProductBrand',
                    'link' => 'product-brand',
                    'icon' => null,
                    'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'parent_id' => $menuParentId,
                    'title' => '賣場管理',
                    'uri' => 'product-market',
                    'controller' => 'ProductMarketController',
                    'model' => 'ProductMarket',
                    'link' => 'product-market',
                    'icon' => null,
                    'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('administrator_menu')->insert($administratorMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-product', 'product-item', 'product-set', 'product-package', 'product-category', 'product-market', 'product-brand'];

        DB::table('administrator_menu')->whereIn('uri', $uriSet)->delete();
    }
}
