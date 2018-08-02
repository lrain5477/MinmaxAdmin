<html>
<body style="background-color: #f5f5f5;margin: 0;font-size: 13px;font-family: Tahoma, Geneva, sans-serif;">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;line-height:1.5;background-color: #f5f5f5;font-family: Tahoma, Geneva, 'Microsoft JhengHei', sans-serif;">
    <tbody>
    <tr>
        <td>
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">@yield('preHeader')</span>
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:700px">
                <tbody>
                <tr>
                    <td>
                        @yield('content')

                        <table border="0" align="center" cellpadding="0" cellspacing="0" style="margin:15px 0 35px 0;background-color: #fff; width:100%;padding:0;border: 1px solid #cecece;border-top-color:#e1e1e1;border-bottom-color:#b4b4b4;border-radius:7px">
                            <tbody>
                            <tr>
                                <td style="text-align:right">
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" class="swe-header" style="width:650px;margin:15px auto;">
                                        <tbody>
                                        <tr>
                                            <td style="text-align:center">
                                                <div style="display:block;line-height:1.5;font-size:16px"><span style="color:#c0392b"><strong>本信件為系統自動發出，請勿直接回覆！</strong></span></div>
                                                <div style="display:block;line-height:1.5;font-size:12px;text-align:center"><span style="font-family: Tahoma, Geneva, sans-serif;font-size:12px;color:#666;">Copyright &copy; <a href="{{ $webData->system_url }}">{{ $webData->website_name }}</a>, All rights reserved.</span></div>
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
</body>
</html>