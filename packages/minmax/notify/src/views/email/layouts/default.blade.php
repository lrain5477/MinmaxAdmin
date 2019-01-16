<?php
/**
 * @var array $notifyData
 */
?>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $notifyData['subject'] }}</title>
</head>
<body style="background-color:#f5f5f5;margin:0;font-size:13px;font-family: Tahoma, Geneva, sans-serif">
    <span class="preheader" style="color:transparent;display:none;width:0;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden">{{ $notifyData['perheader'] }}</span>
    {!! $notifyData['editor'] !!}
</body>
</html>