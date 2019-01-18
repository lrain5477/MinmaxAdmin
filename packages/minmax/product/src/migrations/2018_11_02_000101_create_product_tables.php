<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateProductTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 品牌
        Schema::create('product_brand', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title')->comment('品牌名稱');
            $table->json('pic')->nullable()->comment('品牌圖片');
            $table->string('details')->nullable()->comment('說明細節');     // {description, editor}
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 品項
        Schema::create('product_item', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('sku')->unique()->comment('品項貨號');
            $table->string('serial')->nullable()->comment('原廠貨號');
            $table->string('title')->comment('品項名稱');
            $table->json('pic')->nullable()->comment('品項圖片');
            $table->json('cost')->nullable()->comment('成本金額');          // {currency: price}
            $table->json('price')->nullable()->comment('參考單價');         // {currency: price}
            $table->json('quantity')->nullable()->comment('庫存設定');      // {control, safety}
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 品項庫存
        Schema::create('product_quantity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_id')->comment('品項ID');
            $table->integer('amount')->comment('變動數量');
            $table->text('remark')->nullable()->comment('變動說明');
            $table->integer('summary')->comment('結算數量');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('item_id')->references('id')->on('product_item')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 商品
        Schema::create('product_set', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('sku')->unique()->comment('商品貨號');
            $table->string('serial')->nullable()->comment('原廠貨號');
            $table->string('title')->comment('商品名稱');
            $table->json('pic')->nullable()->comment('商品圖片');
            $table->string('editor')->nullable()->comment('產品簡介');              // {feature, detail, specification, video, accessory}
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->string('brand_id')->nullable()->comment('品牌ID');
            $table->unsignedInteger('rank')->default(0)->comment('評價分數');       // 0 表示自動計算
            $table->string('spec_group')->nullable()->comment('群組代碼');
            $table->json('tags')->nullable()->comment('關聯標籤');                  // id list of parameter (tag)
            $table->string('seo')->nullable()->comment('SEO');                     // {meta_description, meta_keywords}
            $table->boolean('searchable')->default(true)->comment('搜尋顯示');      // 1:顯示 0:隱藏
            $table->boolean('visible')->default(true)->comment('前臺顯示');         // 1:顯示 0:隱藏
            $table->json('properties')->nullable()->comment('自訂屬性');            // id list of parameter (property)
            $table->json('ec_parameters')->nullable()->comment('購物車參數');
            //{
            //  payment_types: [], delivery_types: [],
            //  billing: int, shipping: int, maximum: int,
            //  continued: bool, additional: bool, wrapped: bool, returnable: bool, rewarded: bool,
            //}
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 組合 / 商品-品項 (Many-to-Many)
        Schema::create('product_package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('set_sku');
            $table->string('item_sku');
            $table->unsignedInteger('amount')->default(1)->comment('組合數量');
            $table->unsignedInteger('limit')->nullable()->comment('商品限量');
            $table->string('description')->nullable()->comment('簡短說明');
            $table->json('price_advice')->nullable()->comment('建議售價');      // {currency: price}
            $table->json('price_sell')->nullable()->comment('優惠售價');        // {currency: price}
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');

            $table->foreign('set_sku')->references('sku')->on('product_set')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('item_sku')->references('sku')->on('product_item')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 分類
        Schema::create('product_category', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title')->comment('分類標題');
            $table->string('details')->nullable()->comment('說明細節');             // {description, editor, pic}
            $table->string('parent_id')->nullable()->comment('上層分類');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 分類-商品 (Many-to-Many)
        Schema::create('product_category_set', function (Blueprint $table) {
            $table->string('category_id');
            $table->string('set_id');

            $table->primary(['category_id', 'set_id']);

            $table->foreign('category_id')->references('id')->on('product_category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('set_id')->references('id')->on('product_set')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 分類-會員 (Many-to-Many)
        Schema::create('product_category_role', function (Blueprint $table) {
            $table->string('category_id');
            $table->unsignedInteger('role_id');

            $table->primary(['category_id', 'role_id']);

            $table->foreign('category_id')->references('id')->on('product_category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 建立系統參數資料
        //$this->insertSiteParameters();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除系統參數資料
        //$this->deleteSiteParameters();

        Schema::dropIfExists('product_category_role');
        Schema::dropIfExists('product_category_set');
        Schema::dropIfExists('product_category');
        Schema::dropIfExists('product_package');
        Schema::dropIfExists('product_set');
        Schema::dropIfExists('product_quantity');
        Schema::dropIfExists('product_item');
        Schema::dropIfExists('product_brand');
    }

    /**
     * Insert system parameters for this module.
     *
     * @return void
     */
    public function insertSiteParameters()
    {
        //$timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $lastGroupId = DB::table('system_parameter_group')->latest('id')->value('id') ?? 0;

        $startGroupId = $lastGroupId + 1;
        $systemGroupData = [
            ['code' => 'notifiable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'queueable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '通知用戶'], ['title' => '啟用佇列']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '通知用户'], ['title' => '启用伫列']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'お客通知する'], ['title' => '行列有効']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Notify User'], ['title' => 'Queueable']
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
    public function deleteSiteParameters()
    {
        $parameterCodeSet = ['notifiable', 'queueable'];

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('system_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('title', 'like', 'system_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('title', 'like', 'system_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->delete();
    }
}
