@extends('emails.layouts.member')

@section('preHeader', '請點擊重設密碼連結已重設您的登入密碼')

@section('content')
<table border="0" align="center" cellpadding="0" cellspacing="0" class="swe-header" style="width:680px;margin-top:35px;">
    <tbody>
    <tr>
        <td><img alt="{{ $webData->website_name }}" src="{{ asset('admin/images/logo-mail.png') }}" style="height:46px" /></td>
        <td style="text-align:right"><span style="font-size:18px"><strong>忘記密碼 - 重設密碼連結通知信</strong></span></td>
    </tr>
    </tbody>
</table>
<table border="0" align="center" cellpadding="0" cellspacing="0"  style="margin:15px 0 15px 0;background-color: #fff; width:100%;padding:0;border: 1px solid #cecece;border-top-color:#e1e1e1;border-bottom-color:#b4b4b4;border-radius:7px">
    <tbody>
    <tr>
        <td style="text-align:right">
            <table border="0" align="center" cellpadding="0" cellspacing="0" class="swe-header" style="width:650px;margin:15px auto;">
                <tbody>
                <tr>
                    <td style="text-align:left">
                        <div style="font-size:18px;display: block;padding-bottom:15px;padding-top:15px;"><strong>親愛的會員，您好</strong></div>
                        <div style="width:100%;border-top: dashed #ccc 1px; border-left: none; border-right: none;"></div>
                        <p>您在{{ $webData->website_name }}使用了忘記密碼功能，請點擊重設密碼按鈕，以繼續密碼重設的操作。</p>
                        <p><a href="{{ $resetUrl }}" style="display: inline-block;padding: .6em 1.8em;background:#229cff;color:#fff;text-decoration:none;border-radius:7px;">重設密碼</a></p>
                        <p>如果您誤收此郵件，請忽略本封信件。此帳戶將不會啟用，且您不會再收到任何其他的電子郵件。</p>
                        <div style="width:100%;border-top: dashed #ccc 1px; border-left: none; border-right: none;margin-top:25px;"></div>
                        <p>客服專線：{{ $webData->phone }}<br/>客服信箱：{{ $webData->email }}</p>
                        <p>謝謝您對{{ $webData->website_name }}的支持<br/>敬祝 順利 平安</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection