<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateEcommerceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 購物車設定
        Schema::create('ec_config', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('browse_history')->default(180)->comment('瀏覽紀錄保存(天)');
            $table->unsignedInteger('track_list')->default(180)->comment('追蹤清單保存(天)');
            $table->unsignedInteger('shipping_notify')->default(180)->comment('貨到通知保存(天)');
            $table->unsignedInteger('return_limit')->default(7)->comment('退貨有效期限(天)');
            $table->unsignedInteger('rank_limit')->default(30)->comment('退貨有效期限(天)');
            $table->unsignedInteger('less_quantity')->default(1)->comment('最低庫存警示(個)');
            $table->json('wrap_price')->nullable()->comment('額外包裝費用');     // {currency: price}
            $table->json('bonus_exchange')->nullable()->comment('折抵兌率');    // {currency: rate}
            $table->json('bonus_percent')->nullable()->comment('折抵比例');     // {currency: percent}
            $table->string('editor')->nullable()->comment('購物說明');          // {cart, checkout, billing, completed, cancel, return, rank}
            $table->timestamp('updated_at')->useCurrent();
        });

        // 賣場管理
        Schema::create('ec_market', function (Blueprint $table) {
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
        Schema::create('ec_market_package', function (Blueprint $table) {
            $table->string('market_id')->comment('賣場ID');
            $table->unsignedInteger('package_id')->comment('組合ID');

            $table->foreign('market_id')->references('id')->on('ec_market')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('product_package')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // 取貨方式
        Schema::create('ec_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('取貨代碼');
            $table->string('title')->comment('取貨名稱');
            $table->string('details')->nullable()->comment('說明細節');         // {description, editor, pic}
            $table->json('limits')->nullable()->comment('金額限制');
            $table->json('delivery_types')->nullable()->comment('物流類型');    // id list of parameter
            $table->json('options')->nullable()->comment('參數設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 付款方式
        Schema::create('ec_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('付款代碼');
            $table->string('title')->comment('付款名稱');
            $table->string('details')->nullable()->comment('說明細節');         // {description, editor, pic}
            $table->json('limits')->nullable()->comment('金額限制');
            $table->json('payment_types')->nullable()->comment('金流類型');     // id list of parameter
            $table->json('delivery_types')->nullable()->comment('物流類型');    // id list of parameter
            $table->json('options')->nullable()->comment('參數設定');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // 建立網站參數資料
        $this->insertSiteParameters();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除網站參數資料
        $this->deleteSiteParameters();

        Schema::dropIfExists('ec_payment');
        Schema::dropIfExists('ec_delivery');
        Schema::dropIfExists('ec_market_package');
        Schema::dropIfExists('ec_market');
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

        $lastGroupId = DB::table('site_parameter_group')->latest('id')->value('id') ?? 0;

        $startGroupId = $lastGroupId + 1;
        $systemGroupData = [
            ['code' => 'payment_type', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'editable' => false],
            ['code' => 'delivery_type', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'editable' => false],
        ];

        DB::table('site_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '金流類型'], ['title' => '物流類型']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '金流类型'], ['title' => '物流类型']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '支払いタイプ'], ['title' => '発送タイプ']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => 'Payment Type'], ['title' => 'Delivery Type']
        ], 4, $lastGroupId + 1));


        $lastItemId = DB::table('site_parameter_item')->latest('id')->value('id') ?? 0;

        $startItemId = $lastItemId + 1;
        $systemItemData = [
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'cash',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'bank',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'credit',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'store',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'delivery',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'sort' => 2,
            ],
        ];

        DB::table('site_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '現金付款'], ['label' => '銀行轉帳'], ['label' => '信用卡'],
            ['label' => '門市取貨'], ['label' => '宅配到府']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '现金付款'], ['label' => '银行转帐'], ['label' => '信用卡'],
            ['label' => '门市取货'], ['label' => '配送到府']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '現金払い'], ['label' => '銀行振込'], ['label' => 'クレジット'],
            ['label' => '店で拾う'], ['label' => '宅配配達']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => 'Cash'], ['label' => 'Bank Transfer'], ['label' => 'Credit Card'],
            ['label' => 'Store Pickup'], ['label' => 'Delivery']
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
        $parameterCodeSet = ['payment_type', 'delivery_type'];

        DB::table('site_parameter_group')->whereIn('code', $parameterCodeSet)->get()
            ->each(function ($group) {
                DB::table('site_parameter_item')->where('group_id', $group->id)->get()
                    ->each(function ($item) {
                        DB::table('language_resource')->where('title', 'like', 'site_parameter_item.label.' . $item->id)->delete();
                    });
                DB::table('language_resource')->where('title', 'like', 'site_parameter_group.title.' . $group->id)->delete();
            });

        DB::table('site_parameter_group')->whereIn('code', $parameterCodeSet)->delete();
    }
}
