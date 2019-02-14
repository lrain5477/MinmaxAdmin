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
            $table->unsignedInteger('sort')->default(1)->comment('排序');
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
            $table->string('details')->nullable()->comment('產品簡介');     // {description, editor}
            $table->json('cost')->nullable()->comment('成本金額');          // {currency: price}
            $table->json('price')->nullable()->comment('安全單價');         // {currency: price}
            $table->boolean('qty_enable')->default(false)->comment('庫存管理');
            $table->unsignedInteger('qty_safety')->default(0)->comment('安全庫存');
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
            $table->string('details')->nullable()->comment('產品簡介');             // {feature, detail, specification, video, accessory}
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->string('brand_id')->nullable()->comment('品牌ID');
            $table->unsignedInteger('rank')->default(0)->comment('評價分數');       // 0 表示自動計算
            $table->string('spec_group')->nullable()->comment('群組代碼');
            $table->json('specifications')->nullable()->comment('產品規格');        // id list of parameter (spec)
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
            $table->string('set_sku')->comment('商品貨號');
            $table->string('item_sku')->comment('品項貨號');
            $table->unsignedInteger('amount')->default(1)->comment('組合數量');
            $table->unsignedInteger('limit')->nullable()->comment('商品限量');
            $table->string('description')->nullable()->comment('簡短說明');
            $table->json('price_advice')->nullable()->comment('建議售價');      // {currency: price}
            $table->json('price_sell')->nullable()->comment('優惠售價');        // {currency: price}
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();

            $table->foreign('set_sku')->references('sku')->on('product_set')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('item_sku')->references('sku')->on('product_item')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 賣場
        Schema::create('product_market', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('code')->unique()->comment('賣場代碼');
            $table->string('title')->comment('賣場名稱');
            $table->string('admin_id')->nullable()->comment('管理員ID');
            $table->string('details')->nullable()->comment('說明細節');     // {editor, pic}
            $table->json('options')->nullable()->comment('參數設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 賣場-商品組合 (Many-to-Many)
        Schema::create('product_market_package', function (Blueprint $table) {
            $table->string('market_id')->comment('賣場ID');
            $table->unsignedInteger('package_id')->comment('組合ID');

            $table->foreign('market_id')->references('id')->on('product_market')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('product_package')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 分類
        Schema::create('product_category', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title')->comment('分類標題');
            $table->string('details')->nullable()->comment('說明細節');             // {description, editor, pic}
            $table->string('parent_id')->nullable()->comment('上層分類');
            $table->boolean('visible')->default(true)->comment('前臺顯示');         // 1:顯示 0:隱藏
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
        $this->insertSystemParameters();

        // 建立網站參數資料
        $this->insertSiteParameters();

        // 建立匯入匯出項目
        $this->insertIoConstructs();

        // 建立商品管理預設資料
        $this->insertProductData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除匯入匯出項目
        $this->deleteIoConstructs();

        // 刪除網站參數資料
        $this->deleteSiteParameters();

        // 刪除系統參數資料
        $this->deleteSystemParameters();

        Schema::dropIfExists('product_category_role');
        Schema::dropIfExists('product_category_set');
        Schema::dropIfExists('product_category');
        Schema::dropIfExists('product_market_package');
        Schema::dropIfExists('product_market');
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
    public function insertSystemParameters()
    {
        //$timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $lastGroupId = DB::table('system_parameter_group')->latest('id')->value('id') ?? 0;

        $startGroupId = $lastGroupId + 1;
        $systemGroupData = [
            ['code' => 'qty_enable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '庫存管理']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '库存管理']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '在庫管理']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Manage Quantity']
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
        ];

        DB::table('system_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '啟用'], ['label' => '停用']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '启用'], ['label' => '停用']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '有効'], ['label' => '無効']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'Enable'], ['label' => 'Disable']
        ], 4, $lastItemId + 1));

        // 欄位擴充
        $lastExtensionId = DB::table('column_extension')->latest('id')->value('id') ?? 0;
        $columnExtensionData = [
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'description', 'sort' => 1, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 1), 'options' => json_encode(['method' => 'getFieldTextarea'])],
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'feature', 'sort' => 2, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 2), 'options' => json_encode(['method' => 'getFieldEditor'])],
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'detail', 'sort' => 3, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 3), 'options' => json_encode(['method' => 'getFieldEditor'])],
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'specification', 'sort' => 4, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 4), 'options' => json_encode(['method' => 'getFieldEditor'])],
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'video', 'sort' => 5, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 5), 'options' => json_encode(['method' => 'getFieldEditor'])],
            ['table_name' => 'product_set', 'column_name' => 'details', 'sub_column_name' => 'accessory', 'sort' => 6, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 6), 'options' => json_encode(['method' => 'getFieldEditor'])],
        ];

        DB::table('column_extension')->insert($columnExtensionData);

        // 多語系
        $columnExtensionLanguage = [
            ['title' => '簡短敘述'], ['title' => '商品特色'], ['title' => '詳細介紹'],
            ['title' => '規格資訊'], ['title' => '影音資訊'], ['title' => '配件說明'],
        ];
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 1, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 2, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 3, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 4, $lastExtensionId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Insert site parameters for this module.
     *
     * @return void
     */
    public function insertSiteParameters()
    {
        //$timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $lastGroupId = DB::table('site_parameter_group')->latest('id')->value('id') ?? 0;

        $startGroupId = $lastGroupId + 1;
        $siteGroupData = [
            ['code' => 'rank', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'category' => null, 'editable' => false],
            ['code' => 'property', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'category' => null, 'editable' => false],
            ['code' => 'color', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'category' => 'spec', 'editable' => true],
            ['code' => 'tags', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'category' => null, 'editable' => true],
        ];

        DB::table('site_parameter_group')->insert($siteGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '評價分數'], ['title' => '綜合屬性'], ['title' => '顏色'], ['title' => '標籤']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '评价分数'], ['title' => '综合属性'], ['title' => '颜色'], ['title' => '标签']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '評価スコア'], ['title' => '総合属性'], ['title' => '色'], ['title' => 'タグ']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => 'Rank Score'], ['title' => 'Property'], ['title' => 'Color'], ['title' => 'Tag']
        ], 4, $lastGroupId + 1));


        $lastItemId = DB::table('site_parameter_item')->latest('id')->value('id') ?? 0;

        $startItemId = $lastItemId + 1;
        $siteItemData = [
            [
                'group_id' => $lastGroupId + 1,
                'value' => '0',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '1',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '2',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '3',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 4,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '4',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 5,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => '5',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 6,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'top',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'hot-sell',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'selected-recommend',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'category-recommend',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 4,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'sort' => 3,
            ],
        ];

        DB::table('site_parameter_item')->insert($siteItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '自動'], ['label' => '一星評價'], ['label' => '二星評價'], ['label' => '三星評價'], ['label' => '四星評價'], ['label' => '五星評價'],
            ['label' => '置頂'], ['label' => '熱門商品'], ['label' => '嚴選推薦'], ['label' => '分類推薦'],
            ['label' => '紅色'], ['label' => '黃色'], ['label' => '藍色'],
            ['label' => '10歲'], ['label' => '新品'], ['label' => '日韓風']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '自动'], ['label' => '一星评价'], ['label' => '二星评价'], ['label' => '三星评价'], ['label' => '四星评价'], ['label' => '五星评价'],
            ['label' => '置顶'], ['label' => '热门商品'], ['label' => '严选推荐'], ['label' => '分类推荐'],
            ['label' => '红色'], ['label' => '黄色'], ['label' => '蓝色'],
            ['label' => '10岁'], ['label' => '新品'], ['label' => '日韩风']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '自動'], ['label' => '1つ星評価'], ['label' => '2つ星評価'], ['label' => '3つ星評価'], ['label' => '4つ星評価'], ['label' => '5つ星評価'],
            ['label' => '頂上'], ['label' => '人気販売'], ['label' => '特別な推奨'], ['label' => '分類の推奨'],
            ['label' => '赤'], ['label' => 'イエロー'], ['label' => 'ブルー'],
            ['label' => '10歳'], ['label' => '新品'], ['label' => '日韓スタイル']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => 'Auto'], ['label' => '1 Star'], ['label' => '2 Stars'], ['label' => '3 Stars'], ['label' => '4 Stars'], ['label' => '5 Stars'],
            ['label' => 'Top'], ['label' => 'Hot Sell'], ['label' => 'Selected Recommend'], ['label' => 'Category Recommend'],
            ['label' => 'Red'], ['label' => 'Yellow'], ['label' => 'Blue'],
            ['label' => '10 years old'], ['label' => 'New arrival'], ['label' => 'J&K POP']
        ], 4, $lastItemId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Insert IO config setting for product.
     *
     * @return void
     */
    public function insertIoConstructs()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $lastItemId = DB::table('io_construct')->latest('id')->value('id') ?? 0;
        $startItemId = $lastItemId;

        $ioConfigData = [
            [
                'title' => 'io_construct.title.' . ($startItemId + 1),
                'uri' => 'product-item',
                'import_enable' => true,
                'export_enable' => true,
                'import_view' => 'MinmaxProduct::admin.product-item.import',
                'export_view' => 'MinmaxProduct::admin.product-item.export',
                'controller' => 'Minmax\Product\Io\ProductItemController',
                'example' => 'controller',
                'filename' => 'io_construct.filename.' . ($startItemId + 1),
                'sort' => $startItemId + 1, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ]
        ];

        DB::table('io_construct')->insert($ioConfigData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('io_construct', [
            ['title' => '商品管理 - 品項資料', 'filename' => null]
        ], 1, $startItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('io_construct', [
            ['title' => '商品管理 - 品项资料', 'filename' => null]
        ], 2, $startItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('io_construct', [
            ['title' => '商品管理 - 項目情報', 'filename' => null]
        ], 3, $startItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('io_construct', [
            ['title' => 'Product Manage / Item Data', 'filename' => null]
        ], 4, $startItemId + 1));

        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Insert product default data.
     *
     * @return void
     */
    public function insertProductData()
    {
        //$timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $productMarketData = [
            [
                'id' => $marketId = uuidl(),
                'code' => 'default',
                'title' => "product_market.title.{$marketId}",
                'details' => "product_market.details.{$marketId}"
            ],
        ];

        DB::table('product_market')->insert($productMarketData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_market', [
            ['id' => $marketId, 'title' => '預設賣場', 'details' => json_encode(['editor' => null, 'pic' => []])]
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_market', [
            ['id' => $marketId, 'title' => '预设卖场', 'details' => json_encode(['editor' => null, 'pic' => []])]
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_market', [
            ['id' => $marketId, 'title' => '既定店舗', 'details' => json_encode(['editor' => null, 'pic' => []])]
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_market', [
            ['id' => $marketId, 'title' => 'Default', 'details' => json_encode(['editor' => null, 'pic' => []])]
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Delete system parameters for this module.
     *
     * @return void
     */
    public function deleteSystemParameters()
    {
        $parameterCodeSet = ['qty_enable'];

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('system_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('key', 'system_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('key', 'system_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('system_parameter_group')->whereIn('code', $parameterCodeSet)->delete();

        $columnExtensionTableSet = ['product_set'];

        DB::table('column_extension')->whereIn('table_name', $columnExtensionTableSet)->delete();
    }

    /**
     * Delete site parameters for this module.
     *
     * @return void
     */
    public function deleteSiteParameters()
    {
        $parameterCodeSet = ['property', 'color'];

        DB::table('site_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('site_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('key', 'site_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('key', 'site_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('site_parameter_group')->whereIn('code', $parameterCodeSet)->delete();
    }

    /**
     * Delete IO constructs for this module.
     *
     * @return void
     */
    public function deleteIoConstructs()
    {
        $ioUriSet = ['product-item'];

        DB::table('io_construct')->whereIn('uri', $ioUriSet)->get()
            ->each(function ($item) {
                DB::table('language_resource')
                    ->where('key', 'io_construct.title.' . $item->id)
                    ->orWhere('key', 'io_construct.filename.' . $item->id)
                    ->delete();
            });

        DB::table('io_construct')->whereIn('uri', $ioUriSet)->delete();
    }
}
