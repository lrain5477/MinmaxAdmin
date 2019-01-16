<?php
/**
 * Replace tags:
 * {[name]}
 * {[websitePhone]}
 * {[websiteEmail]}
 * {[websiteName]}
 * {[websiteUrl]}
 */
?>
<div style="background-color:#f5f5f5;width:100%;margin:0;padding:0;font-size:13px;font-family: Tahoma, Geneva, sans-serif">
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;background-color:#f5f5f5">
    <tbody>
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:700px">
                <tbody>
                <tr>
                    <td>
                        <table border="0" align="center" cellpadding="0" cellspacing="0" class="" style="width:680px;margin-top:35px">
                            <tbody>
                            <tr>
                                <td><img src="{{ asset('static/admin/images/common/logo-mail.png') }}" alt="{[websiteName]}" style="height:46px; width:211px" /></td>
                                <td style="text-align:right"><span style="font-size:18px"><strong>會員註冊 - 會員帳號註冊完成通知信</strong></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table border="0" align="center" cellpadding="0" cellspacing="0" style="margin:15px 0;background-color:#fff;width:100%;padding:0;border-radius:7px;border-top:1px solid #e1e1e1;border-right:1px solid #cecece;border-left:1px solid #cecece;border-bottom:1px solid #b4b4b4">
                            <tbody>
                            <tr>
                                <td style="text-align:right">
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="width:650px;margin:15px auto">
                                        <tbody>
                                        <tr>
                                            <td style="text-align:left">
                                                <div style="font-size:18px;display:block;padding-bottom:15px;padding-top:15px"><strong>親愛的 <span style="color:#125773">{[name]}</span> ，您好</strong></div>
                                                <div style="width:100%;border-top:dashed #ccc 1px;border-left:none;border-right:none"></div>
                                                <p>歡迎加入{[websiteName]}會員，您的會員帳號已經啟用成功，現在就立刻登入會員中心開始使用我們為您提供的服務。如果您誤收此郵件，請忽略本封信件。</p>
                                                <p>客服專線：{[websitePhone]}<br/>客服信箱：{[websiteEmail]}</p>
                                                <p>謝謝您對 {[websiteName]} 的支持<br/>敬祝 順利 平安</p>
                                                <div style="width:100%;border-top:dashed #ccc 1px;border-left:none;border-right:none;margin-top:25px"></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table border="0" align="center" cellpadding="0" cellspacing="0" style="margin:15px 0 35px;background-color:#fff;width:100%;padding:0;border-radius:7px;border-top:1px solid #e1e1e1;border-right:1px solid #cecece;border-left:1px solid #cecece;border-bottom:1px solid #b4b4b4">
                            <tbody>
                            <tr>
                                <td style="text-align:right">
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="width:650px;margin:15px auto">
                                        <tbody>
                                        <tr>
                                            <td style="text-align:center">
                                                <div style="display:block;font-size:16px"><span style="color:#c0392b"><strong>本信件為系統自動發出，請勿直接回覆！</strong></span></div>
                                                <div style="display:block;font-size:12px;text-align:center"><span style="font-family: Tahoma, Geneva, sans-serif; font-size:12px;color:#666">Copyright &copy; <a href="{[websiteUrl]}">{[websiteName]}</a>, All rights reserved.</span></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</div>
