@extends('emails.layouts.admin')

@section('preHeader', '聯絡我們系統通知')

@section('content')
<table border="0" align="center" cellpadding="0" cellspacing="0" class="swe-header" style="width:680px;margin-top:35px;">
    <tbody>
    <tr>
        <td><img alt="{{ $webData->website_name }}" src="{{ asset('admin/images/logo-mail.png') }}" style="height:46px" /></td>
        <td style="text-align:right"><span style="font-size:18px"><strong>系統通知 - 聯絡我們表單</strong></span></td>
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
                        <div style="font-size:18px;display: block;padding-bottom:15px;padding-top:15px;"><strong>親愛的 管理員，您好</strong></div>
                        <div style="width:100%;border-top: dashed #ccc 1px; border-left: none; border-right: none;"></div>
                        <p>您的網站有訪客提交了一份聯絡表單，簡易內容如下。您可以立即前往管理後台確認。</p>
                        <p><strong>姓名：</strong>{{ $contactName }}</p>
                        <p><strong>Email：</strong>{{ $contactEmail }}</p>
                        <p><strong>主題：</strong>{{ $contactSubject }}</p>
                        <p><strong>內容：</strong></p>
                        <p>{!! nl2br($contactComment) !!}</p>
                        <p><a href="{{ route('admin.home') }}" style="display: inline-block;padding: .6em 1.8em;background:#229cff;color:#fff;text-decoration:none;border-radius:7px;" target="_blank">前往管理後臺</a></p>
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
