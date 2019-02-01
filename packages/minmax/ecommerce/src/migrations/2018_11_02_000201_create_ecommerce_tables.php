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

        // 建立系統參數資料
        $this->insertSystemParameters();

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

        // 刪除系統參數資料
        $this->deleteSystemParameters();

        Schema::dropIfExists('ec_payment');
        Schema::dropIfExists('ec_delivery');
        Schema::dropIfExists('ec_config');
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
            ['code' => 'continued', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'additional', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'wrapped', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'returnable', 'title' => 'system_parameter_group.title.' . $startGroupId++],
            ['code' => 'rewarded', 'title' => 'system_parameter_group.title.' . $startGroupId++],
        ];

        DB::table('system_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '無庫存狀態'], ['title' => '加購限定'], ['title' => '額外包裝'], ['title' => '可否退貨'], ['title' => '計算紅利']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '无库存状态'], ['title' => '加购限定'], ['title' => '额外包装'], ['title' => '可否退货'], ['title' => '计算红利']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => '在庫切れの状態'], ['title' => 'プラス購入限られた'], ['title' => 'その他の包装'], ['title' => '返す可能'], ['title' => 'ボーナスを計算']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_group', [
            ['title' => 'Empty Status'], ['title' => 'Additional Only'], ['title' => 'Extra Packaging'], ['title' => 'Returnable'], ['title' => 'Has Reward']
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
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 5,
                'value' => '1',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'danger']),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 5,
                'value' => '0',
                'label' => 'system_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'secondary']),
                'sort' => 2,
            ],
        ];

        DB::table('system_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '顯示補貨中'], ['label' => '前臺不顯示'],
            ['label' => '不限'], ['label' => '僅限加購'],
            ['label' => '不計包裝'], ['label' => '另計包裝'],
            ['label' => '可以退貨'], ['label' => '不可退貨'],
            ['label' => '計算紅利'], ['label' => '不計紅利']
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '显示补货中'], ['label' => '前台不显示'],
            ['label' => '不限'], ['label' => '仅限加购'],
            ['label' => '不计包装'], ['label' => '另计包装'],
            ['label' => '可以退货'], ['label' => '不可退货'],
            ['label' => '计算红利'], ['label' => '不计红利']
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => '補充を表示する'], ['label' => '前景が表示されない'],
            ['label' => '無制限'], ['label' => '購入を追加限られた'],
            ['label' => '計算しない'], ['label' => '計算価格'],
            ['label' => '返す可能'], ['label' => '返す無効'],
            ['label' => '計算ボーナス'], ['label' => '計算しない']
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('system_parameter_item', [
            ['label' => 'Replenishment'], ['label' => 'Hide'],
            ['label' => 'No Limit'], ['label' => 'Additional Only'],
            ['label' => 'Disable'], ['label' => 'Enable'],
            ['label' => 'Enable'], ['label' => 'Disable'],
            ['label' => 'Enable'], ['label' => 'Disable']
        ], 4, $lastItemId + 1));


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
        $systemGroupData = [
            ['code' => 'payment_type', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'editable' => true],
            ['code' => 'delivery_type', 'title' => 'site_parameter_group.title.' . $startGroupId++, 'editable' => true],
            ['code' => 'billing', 'title' => 'system_parameter_group.title.' . $startGroupId++, 'editable' => true],
            ['code' => 'shipping', 'title' => 'system_parameter_group.title.' . $startGroupId++, 'editable' => true],
        ];

        DB::table('site_parameter_group')->insert($systemGroupData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '金流類型'], ['title' => '物流類型'], ['title' => '付款說明'], ['title' => '運送說明']
        ], 1, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '金流类型'], ['title' => '物流类型'], ['title' => '付款说明'], ['title' => '运送说明']
        ], 2, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => '支払いタイプ'], ['title' => '発送タイプ'], ['title' => '支払い説明'], ['title' => '発送説明']
        ], 3, $lastGroupId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_group', [
            ['title' => 'Payment Type'], ['title' => 'Delivery Type'], ['title' => 'About Billing'], ['title' => 'About Shipping']
        ], 4, $lastGroupId + 1));


        $lastItemId = DB::table('site_parameter_item')->latest('id')->value('id') ?? 0;

        $startItemId = $lastItemId + 1;
        $systemItemData = [
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'cash',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'bank',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 1,
                'value' => 'credit',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 3,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'store',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 2,
                'value' => 'delivery',
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode(['class' => 'info']),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 2,
            ],
            [
                'group_id' => $lastGroupId + 3,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode([]),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 1,
            ],
            [
                'group_id' => $lastGroupId + 4,
                'value' => null,
                'label' => 'site_parameter_item.label.' . $startItemId++,
                'options' => json_encode([]),
                'details' => 'site_parameter_item.details.' . ($startItemId - 1),
                'sort' => 1,
            ],
        ];

        DB::table('site_parameter_item')->insert($systemItemData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '現金付款', 'details' => json_encode([])], ['label' => '銀行轉帳', 'details' => json_encode([])], ['label' => '信用卡', 'details' => json_encode([])],
            ['label' => '門市取貨', 'details' => json_encode([])], ['label' => '宅配到府', 'details' => json_encode([])],
            ['label' => '通用付款說明', 'details' => json_encode([])], ['label' => '通用運送說明', 'details' => json_encode([])]
        ], 1, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '现金付款', 'details' => json_encode([])], ['label' => '银行转帐', 'details' => json_encode([])], ['label' => '信用卡', 'details' => json_encode([])],
            ['label' => '门市取货', 'details' => json_encode([])], ['label' => '配送到府', 'details' => json_encode([])],
            ['label' => '通用付款说明', 'details' => json_encode([])], ['label' => '通用运送说明', 'details' => json_encode([])]
        ], 2, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => '現金払い', 'details' => json_encode([])], ['label' => '銀行振込', 'details' => json_encode([])], ['label' => 'クレジット', 'details' => json_encode([])],
            ['label' => '店で拾う', 'details' => json_encode([])], ['label' => '宅配配達', 'details' => json_encode([])],
            ['label' => '一般支払い説明', 'details' => json_encode([])], ['label' => '一般発送説明', 'details' => json_encode([])]
        ], 3, $lastItemId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('site_parameter_item', [
            ['label' => 'Cash', 'details' => json_encode([])], ['label' => 'Bank Transfer', 'details' => json_encode([])], ['label' => 'Credit Card', 'details' => json_encode([])],
            ['label' => 'Store Pickup', 'details' => json_encode([])], ['label' => 'Delivery', 'details' => json_encode([])],
            ['label' => 'General Billing', 'details' => json_encode([])], ['label' => 'General Shipping', 'details' => json_encode([])]
        ], 4, $lastItemId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Delete system parameters for this module.
     *
     * @return void
     */
    public function deleteSystemParameters()
    {
        $parameterCodeSet = ['continued', 'additional', 'wrapped', 'returnable', 'rewarded'];

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

    /**
     * Delete site parameters for this module.
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
