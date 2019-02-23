<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class CreateArticleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ArticleCategory 內容類別管理
        Schema::create('article_category', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('uri')->nullable()->unique()->comment('自訂連結');
            $table->string('parent_id')->nullable()->comment('上層類別');
            $table->string('title')->comment('類別名稱');                           // language
            $table->string('details')->nullable()->comment('詳細內容');             // language {pic, topic, description, editor}
            $table->json('options')->nullable()->comment('類別設定');
            $table->string('seo')->nullable()->comment('SEO');                      // language {meta_description, meta_keywords}
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('editable')->default(true)->comment('可否編輯');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // ArticleNews 新聞稿
        Schema::create('article_news', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('uri')->nullable()->unique()->comment('自訂連結');
            $table->string('title')->comment('新聞標題');                        // language
            $table->string('description')->comment('簡短敘述');                  // language
            $table->string('editor')->comment('新聞內容');                       // language
            $table->json('pic')->nullable()->comment('新聞圖片');
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->string('seo')->nullable()->comment('SEO');                  // language {meta_description, meta_keywords}
            $table->boolean('top')->default(false)->comment('置頂狀態');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // news & category (Many-to-Many)
        Schema::create('article_news_category', function (Blueprint $table) {
            $table->string('news_id');
            $table->string('category_id');

            $table->unique(['news_id', 'category_id']);

            $table->foreign('news_id')->references('id')->on('article_news')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('article_category')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // ArticleStatic 靜態頁面
        Schema::create('article_page', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('uri')->nullable()->unique()->comment('自訂連結');
            $table->string('title')->comment('頁面標題');                        // language
            $table->string('details')->comment('頁面內容');                      // language {topic, description, editor}
            $table->json('pic')->nullable()->comment('新聞圖片');
            $table->timestamp('start_at')->useCurrent()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->string('seo')->nullable()->comment('SEO');                  // language {meta_description, meta_keywords}
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->boolean('active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });

        // static & category (Many-to-Many)
        Schema::create('article_page_category', function (Blueprint $table) {
            $table->string('page_id');
            $table->string('category_id');

            $table->unique(['page_id', 'category_id']);

            $table->foreign('page_id')->references('id')->on('article_page')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('article_category')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // ArticleTrack 點擊追蹤
        Schema::create('article_track', function (Blueprint $table) {
            $table->string('model')->index()->comment('Model');
            $table->string('object_id')->index()->comment('目標ID');
            $table->ipAddress('ip')->comment('IP位址');
            $table->date('click_at')->comment('點擊日期');
            $table->timestamp('created_at')->useCurrent()->comment('建立時間');

            $table->unique(['model', 'object_id', 'ip', 'click_at']);
        });

        $this->insertSystemParameters();

        $this->insertArticleCategories();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->deleteSystemParameters();

        Schema::dropIfExists('article_track');
        Schema::dropIfExists('article_news_category');
        Schema::dropIfExists('article_news');
        Schema::dropIfExists('article_category');
    }

    public function insertSystemParameters()
    {
        $languageResourceData = [];

        // 欄位擴充
        $lastExtensionId = DB::table('column_extension')->latest('id')->value('id') ?? 0;
        $columnExtensionData = [
            ['table_name' => 'article_category', 'column_name' => 'details', 'sub_column_name' => 'pic', 'sort' => 1, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 1), 'options' => json_encode(['method' => 'getFieldMediaImage'])],
            ['table_name' => 'article_category', 'column_name' => 'details', 'sub_column_name' => 'topic', 'sort' => 2, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 2), 'options' => json_encode(['method' => 'getFieldText'])],
            ['table_name' => 'article_category', 'column_name' => 'details', 'sub_column_name' => 'description', 'sort' => 3, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 3), 'options' => json_encode(['method' => 'getFieldTextarea'])],
            ['table_name' => 'article_category', 'column_name' => 'details', 'sub_column_name' => 'editor', 'sort' => 4, 'active' => true,
                'title' => 'column_extension.title.' . ($lastExtensionId + 4), 'options' => json_encode(['method' => 'getFieldEditor'])],
        ];

        DB::table('column_extension')->insert($columnExtensionData);

        // 多語系
        $columnExtensionLanguage = [
            ['title' => '圖片'], ['title' => '標題'], ['title' => '內容文字'], ['title' => '自訂內容']
        ];
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 1, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 2, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 3, $lastExtensionId + 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('column_extension', $columnExtensionLanguage, 4, $lastExtensionId + 1));


        DB::table('language_resource')->insert($languageResourceData);
    }

    /**
     * Insert system parameters for this module.
     *
     * @return void
     */
    public function insertArticleCategories()
    {
        $timestamp = date('Y-m-d H:i:s');
        $languageResourceData = [];

        $articleCategoryData = [
            [
                'id' => $categoryId1 = uuidl(),
                'uri' => 'article-news',
                'parent_id' => null,
                'title' => "article_category.title.{$categoryId1}",
                'details' => "article_category.details.{$categoryId1}",
                'options' => json_encode(['relation' => 'articleNews', 'details' => 'pic']),
                'seo' => "article_category.seo.{$categoryId1}",
                'sort' => 1, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $categoryId2 = uuidl(),
                'uri' => 'article-page',
                'parent_id' => null,
                'title' => "article_category.title.{$categoryId2}",
                'details' => "article_category.details.{$categoryId2}",
                'options' => json_encode(['relation' => 'articlePage']),
                'seo' => "article_category.seo.{$categoryId2}",
                'sort' => 2, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $categoryId3 = uuidl(),
                'uri' => 'article-faq',
                'parent_id' => null,
                'title' => "article_category.title.{$categoryId3}",
                'details' => "article_category.details.{$categoryId3}",
                'options' => json_encode(['relation' => 'articleFaq']),
                'seo' => "article_category.seo.{$categoryId3}",
                'sort' => 3, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $categoryId4 = uuidl(),
                'uri' => 'article-download',
                'parent_id' => null,
                'title' => "article_category.title.{$categoryId4}",
                'details' => "article_category.details.{$categoryId4}",
                'options' => json_encode(['relation' => 'articleDownload']),
                'seo' => "article_category.seo.{$categoryId4}",
                'sort' => 4, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
            [
                'id' => $categoryId5 = uuidl(),
                'uri' => 'article-activity',
                'parent_id' => null,
                'title' => "article_category.title.{$categoryId5}",
                'details' => "article_category.details.{$categoryId5}",
                'options' => json_encode(['relation' => 'articleActivity']),
                'seo' => "article_category.seo.{$categoryId5}",
                'sort' => 5, 'editable' => false, 'active' => true, 'created_at' => $timestamp, 'updated_at' => $timestamp
            ],
        ];

        DB::table('article_category')->insert($articleCategoryData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('article_category', [
            ['id' => $categoryId1, 'title' => '新聞稿'], ['id' => $categoryId2, 'title' => '靜態頁面'],
            ['id' => $categoryId3, 'title' => '常見問答'], ['id' => $categoryId4, 'title' => '檔案下載'],
            ['id' => $categoryId5, 'title' => '活動頁面'],
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('article_category', [
            ['id' => $categoryId1, 'title' => '新闻稿'], ['id' => $categoryId2, 'title' => '静态页面'],
            ['id' => $categoryId3, 'title' => '常见问答'], ['id' => $categoryId4, 'title' => '档案下载'],
            ['id' => $categoryId5, 'title' => '活动页面'],
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('article_category', [
            ['id' => $categoryId1, 'title' => '新聞記事'], ['id' => $categoryId2, 'title' => '静的ページ'],
            ['id' => $categoryId3, 'title' => 'よくある質問'], ['id' => $categoryId4, 'title' => 'ダウンロード'],
            ['id' => $categoryId5, 'title' => '活動ページ'],
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('article_category', [
            ['id' => $categoryId1, 'title' => 'News'], ['id' => $categoryId2, 'title' => 'Page'],
            ['id' => $categoryId3, 'title' => 'FAQ'], ['id' => $categoryId4, 'title' => 'Download'],
            ['id' => $categoryId5, 'title' => 'Activity'],
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
        $columnExtensionTableSet = ['article_category'];

        DB::table('column_extension')->whereIn('table_name', $columnExtensionTableSet)->delete();
    }
}
