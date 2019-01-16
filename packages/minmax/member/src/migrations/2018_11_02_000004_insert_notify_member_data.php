<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Minmax\Base\Helpers\Seeder as SeederHelper;

class InsertNotifyMemberData extends Migration
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
        $languageResourceData = [];

        try {
            $templateCustomEditorRegister = view('MinmaxMember::templates.data-notify-email-custom-editor-registered')->render();
            $templateAdminEditorRegister = view('MinmaxMember::templates.data-notify-email-admin-editor-registered')->render();
        } catch (\Throwable $e) {
            $templateCustomEditorRegister = '';
            $templateAdminEditorRegister = '';
        }

        $receivers = [];
        if ($webData = DB::table('web_data')->where('guard', 'web')->first()) {
            $receivers[] = "web_data.system_email.{$webData->id}";
            $receivers[] = "web_data.contact.{$webData->id}.email";
        }
        foreach (DB::table('admin')->where('username', '!=', 'sysadmin')->get() as $adminData) {
            $receivers[] = "admin.email.{$adminData->id}";
        }

        $insertNotifyEmailData = [
            [
                'code' => 'registered',
                'title' => 'notify_email.title.1',
                'notifiable' => true,
                'receivers' => json_encode($receivers),
                'custom_subject' => 'notify_email.custom_subject.1',
                'custom_preheader' => 'notify_email.custom_preheader.1',
                'custom_editor' => 'notify_email.custom_editor.1',
                'custom_mailable' => '\Minmax\Member\Mails\MemberRegisteredCustom',
                'admin_subject' => 'notify_email.admin_subject.1',
                'admin_preheader' => 'notify_email.admin_preheader.1',
                'admin_editor' => 'notify_email.admin_editor.1',
                'admin_mailable' => '\Minmax\Member\Mails\MemberRegisteredAdmin',
                'replacements' => 'notify_email.replacements.1',
                'queueable' => false,
                'sort' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        DB::table('notify_email')->insert($insertNotifyEmailData);

        // 多語系
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('notify_email', [
            [
                'title' => '會員註冊 - 註冊完成通知信',
                'custom_subject' => '恭喜您完成註冊！',
                'custom_preheader' => '恭喜！您的會員帳號已經啟用成功，現在就立刻登入會員中心開始使用我們為您提供的服務。',
                'custom_editor' => $templateCustomEditorRegister,
                'admin_subject' => '恭喜有一名新會員完成註冊！',
                'admin_preheader' => '恭喜！新會員帳號已經啟用成功，安排活動讓客戶更喜歡來你的網站吧。',
                'admin_editor' => $templateAdminEditorRegister,
                'replacements' => json_encode([
                    'name' => '客戶名稱',
                    'websitePhone' => '客服電話', 'websiteEmail' => '客服信箱', 'websiteName' => '網站名稱', 'websiteUrl' => '網站網址'
                ])
            ]
        ], 1));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('notify_email', [
            [
                'title' => '会员注册 - 注册完成通知信',
                'custom_subject' => '恭喜您完成注册！',
                'custom_preheader' => '恭喜！您的会员帐号已经启用成功，现在就立刻登入会员中心开始使用我们为您提供的服务。',
                'custom_editor' => $templateCustomEditorRegister,
                'admin_subject' => '恭喜有一名新会员完成注册！',
                'admin_preheader' => '恭喜！新会员帐号已经启用成功，安排活动让客户更喜欢来你的网站吧。',
                'admin_editor' => $templateAdminEditorRegister,
                'replacements' => json_encode([
                    'name' => '客户名称',
                    'websitePhone' => '客服电话', 'websiteEmail' => '客服邮箱', 'websiteName' => '网站名称', 'websiteUrl' => '网站网址'
                ])
            ]
        ], 2));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('notify_email', [
            [
                'title' => '会員登録 - 登録完了通知',
                'custom_subject' => '登録完了おめでとう！',
                'custom_preheader' => 'おめでとうございます。 あなたの会員アカウントは正常にアクティベートされました、そしてあなたは会員センターにログインして私たちがあなたに提供するサービスを使い始めることができます。',
                'custom_editor' => $templateCustomEditorRegister,
                'admin_subject' => '新規会員登録完了おめでとう！',
                'admin_preheader' => 'おめでとうございます。 新しいメンバーアカウントは正常にアクティブ化されました、そしてイベントは顧客があなたのウェブサイトに来ることを好むように手配します。',
                'admin_editor' => $templateAdminEditorRegister,
                'replacements' => json_encode([
                    'name' => '顧客名',
                    'websitePhone' => 'サービス電話', 'websiteEmail' => 'サービスメール', 'websiteName' => 'サイト名', 'websiteUrl' => 'サイトリンク'
                ])
            ]
        ], 3));
        $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('notify_email', [
            [
                'title' => 'Register - Registration Completed',
                'custom_subject' => 'Congratulations! Your registration completed!',
                'custom_preheader' => 'Congratulations! Your member account has been successfully activated, and you can log in to the member center and start using the services we provide for you.',
                'custom_editor' => $templateCustomEditorRegister,
                'admin_subject' => 'Congratulations! A new member joined！',
                'admin_preheader' => 'Congratulations! The new member account has been successfully activated. Arranging event to make customer prefer to come back.',
                'admin_editor' => $templateAdminEditorRegister,
                'replacements' => json_encode([
                    'name' => 'Customer Name',
                    'websitePhone' => 'Service Phone', 'websiteEmail' => 'Service Email', 'websiteName' => 'Site Name', 'websiteUrl' => 'Site Link'
                ])
            ]
        ], 4));

        DB::table('language_resource')->insert($languageResourceData);
    }

    public function deleteDatabase()
    {
        DB::table('notify_email')->get()
            ->each(function ($item) {
                DB::table('language_resource')->where('key', $item->title)->delete();
                DB::table('language_resource')->where('key', $item->custom_subject)->delete();
                DB::table('language_resource')->where('key', $item->custom_preheader)->delete();
                DB::table('language_resource')->where('key', $item->custom_editor)->delete();
                DB::table('language_resource')->where('key', $item->admin_subject)->delete();
                DB::table('language_resource')->where('key', $item->admin_preheader)->delete();
                DB::table('language_resource')->where('key', $item->admin_editor)->delete();
                DB::table('language_resource')->where('key', $item->replacements)->delete();
            });
    }
}
