<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertAdminMenuProductData extends Migration
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
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productItem', '品項管理', 251));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productSet', '商品管理', 252));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productPackage', '價格組合', 253));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productCategory', '商品分類', 254));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productBrand', '品牌管理', 255));
        $permissionsData = array_merge($permissionsData, SeederHelper::getPermissionArray('admin', 'productMarket', '賣場管理', 256));
        DB::table('permissions')->insert($permissionsData);

        // 管理員選單
        if ($menuClassId = DB::table('admin_menu')->where('uri', 'root-module')->value('id')) {
            $adminMenuData = [
                [
                    'id' => $menuParentId = uuidl(),
                    'title' => '商品管理',
                    'uri' => 'control-product',
                    'controller' => null,
                    'model' => null,
                    'parent_id' => $menuClassId,
                    'link' => null,
                    'icon' => 'icon-codepen',
                    'permission_key' => null,
                    'sort' => 205, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '品項管理',
                    'uri' => 'product-item',
                    'controller' => 'ProductItemController',
                    'model' => 'ProductItem',
                    'parent_id' => $menuParentId,
                    'link' => 'product-item',
                    'icon' => null,
                    'permission_key' => 'productItemShow',
                    'sort' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '商品管理',
                    'uri' => 'product-set',
                    'controller' => 'ProductSetController',
                    'model' => 'ProductSet',
                    'parent_id' => $menuParentId,
                    'link' => 'product-set',
                    'icon' => null,
                    'permission_key' => 'productSetShow',
                    'sort' => 2, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '價格組合',
                    'uri' => 'product-package',
                    'controller' => 'ProductPackageController',
                    'model' => 'ProductPackage',
                    'parent_id' => $menuParentId,
                    'link' => 'product-package',
                    'icon' => null,
                    'permission_key' => 'productPackageShow',
                    'sort' => 3, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '商品分類',
                    'uri' => 'product-category',
                    'controller' => 'ProductCategoryController',
                    'model' => 'ProductCategory',
                    'parent_id' => $menuParentId,
                    'link' => 'product-category',
                    'icon' => null,
                    'permission_key' => 'productCategoryShow',
                    'sort' => 4, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '品牌管理',
                    'uri' => 'product-brand',
                    'controller' => 'ProductBrandController',
                    'model' => 'ProductBrand',
                    'parent_id' => $menuParentId,
                    'link' => 'product-brand',
                    'icon' => null,
                    'permission_key' => 'productBrandShow',
                    'sort' => 5, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
                [
                    'id' => uuidl(),
                    'title' => '賣場管理',
                    'uri' => 'product-market',
                    'controller' => 'ProductMarketController',
                    'model' => 'ProductMarket',
                    'parent_id' => $menuParentId,
                    'link' => 'product-market',
                    'icon' => null,
                    'permission_key' => 'productMarketShow',
                    'sort' => 6, 'updated_at' => $timestamp, 'created_at' => $timestamp
                ],
            ];
            DB::table('admin_menu')->insert($adminMenuData);
        }
    }

    public function deleteDatabase()
    {
        $uriSet = ['control-product', 'product-item', 'product-set', 'product-package', 'product-category', 'product-market', 'product-brand'];

        DB::table('admin_menu')->whereIn('uri', $uriSet)->delete();
    }
}
