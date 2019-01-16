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
                                <td style="text-align:right"><span style="font-size:18px"><strong>系統通知 - 會員帳號註冊完成</strong></span></td>
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
                                                <div style="font-size:18px;display:block;padding-bottom:15px;padding-top:15px"><strong>親愛的 <span style="color:#125773">管理員</span> ，您好</strong></div>
                                                <div style="width:100%;border-top:dashed #ccc 1px;border-left:none;border-right:none"></div>
                                                <p>您的網站有新的會員註冊並啟用成功，敬請關心並提供優良的服務體驗。</p>
                                                <p>通知來自 {[websiteName]}<br/>敬祝 順利 平安</p>
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
