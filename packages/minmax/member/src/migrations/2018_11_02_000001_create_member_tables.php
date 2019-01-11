<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateMemberTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Member 會員帳號
        Schema::create('member', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('username')->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->rememberToken();
            $table->string('name')->nullable()->comment('姓名');
            $table->string('email')->nullable()->comment('Email');
            $table->timestamp('expired_at')->nullable()->comment('過期時間');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
            $table->softDeletes();
        });

        // MemberDetail 會員資料
        Schema::create('member_detail', function (Blueprint $table) {
            $table->string('member_id')->primary()->comment('會員ID');
            $table->json('name')->comment('會員姓名');                          // {full_name, family_name, given_name, nickname}
            $table->json('contact')->nullable()->comment('聯絡資訊');           // {email, mobile, tel, country, state, county, zip, city, address}
            $table->json('social')->nullable()->comment('社群連結');            // {facebook, instagram, twitter, ...}
            $table->json('profile')->nullable()->comment('個人資料');           // {avatar, gender, birthday, occupation, company, income, ...}
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('member')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // MemberRecord 會員紀錄
        Schema::create('member_record', function (Blueprint $table) {
            $table->string('member_id')->index()->comment('會員ID');
            $table->string('code')->comment('狀態代碼');
            $table->json('details')->nullable()->comment('詳細記錄');           // {tag, remark, ...}
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('member_id')->references('id')->on('member')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // MemberAuthentication 會員認證狀態
        Schema::create('member_authentication', function (Blueprint $table) {
            $table->string('member_id')->index()->comment('會員ID');
            $table->string('type')->comment('認證類型');
            $table->string('token')->primary()->comment('認證金鑰');
            $table->boolean('authenticated')->default(false)->comment('認證狀態');
            $table->timestamp('authenticated_at')->nullable()->comment('認證時間');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('member_id')->references('id')->on('member')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // MemberTerm
        Schema::create('member_term', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('title')->comment('標題');
            $table->longText('editor')->nullable()->comment('條款內容');
            $table->timestamp('start_at')->nullable()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
            $table->softDeletes();
        });

        $this->insertMemberTerm();

        $this->insertMemberRole();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->deleteMemberRole();

        Schema::dropIfExists('member_term');
        Schema::dropIfExists('member_authentication');
        Schema::dropIfExists('member_record');
        Schema::dropIfExists('member_detail');
        Schema::dropIfExists('member');
    }

    protected function insertMemberTerm()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        try {
            $templateTermEditor = view('MinmaxMember::templates.data-member-term-editor')->render();
        } catch (\Throwable $e) {
            $templateTermEditor = '';
        }

        $insertTermData = [
            [
                'id' => $termId = uuidl(),
                'title' => 'member_term.title.' . $termId,
                'editor' => 'member_term.editor.' . $termId,
                'start_at' => $timestamp,
                'end_at' => null,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        DB::table('member_term')->insert($insertTermData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('member_term', [
            ['id' => $termId, 'title' => '會員服務條款', 'editor' => $templateTermEditor]
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('member_term', [
            ['id' => $termId, 'title' => '会员服务条款', 'editor' => $templateTermEditor]
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('member_term', [
            ['id' => $termId, 'title' => '会員の利用規約', 'editor' => $templateTermEditor]
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('member_term', [
            ['id' => $termId, 'title' => 'Terms of Service', 'editor' => $templateTermEditor]
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }

    public function insertMemberRole()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        if ($lastId = DB::table('roles')->orderByDesc('id')->value('id')) {

            // 新增權限角色
            $rolesData = [
                [
                    'guard' => 'web', 'name' => 'default', 'display_name' => 'roles.display_name.' . ($lastId + 1),
                    'description' => 'roles.description.' . ($lastId + 1), 'created_at' => $timestamp, 'updated_at' => $timestamp
                ],
            ];
            DB::table('roles')->insert($rolesData);

            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
                ['display_name' => '一般會員', 'description' => '一般會員']
            ], 1, $lastId + 1));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
                ['display_name' => '一般会员', 'description' => '一般会员']
            ], 2, $lastId + 1));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
                ['display_name' => '一般会員', 'description' => '一般会員']
            ], 3, $lastId + 1));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('roles', [
                ['display_name' => 'Default', 'description' => 'Default member']
            ], 4, $lastId + 1));

            DB::table('language_resource')->insert($languageResourceData);
        }
    }

    public function deleteMemberRole()
    {
        $uriSet = ['default'];

        DB::table('admin_menu')->where('guard', 'web')->whereIn('name', $uriSet)->delete();
    }
}
