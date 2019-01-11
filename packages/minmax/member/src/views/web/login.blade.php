<?php
/**
 * @var \Minmax\Base\Models\WebData $webData
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $webData->website_name }} | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta charset="UTF-8" />
</head>
<body>
    <form method="post" action="{{ langRoute('web.login') }}">
        @csrf
        <input type="text" autocomplete="off" name="username" required />
        <input type="password" autocomplete="off" name="password" required />
        <input type="text" autocomplete="off" name="captcha" required />
        <img src="{{ langRoute('web.captcha', ['name' => 'login']) }}" style="width:100px;height:auto;cursor:pointer;" alt="" />
        <input type="checkbox" name="remember" value="1" /> @lang('MinmaxMember::web.login.remember')
        <button type="submit">@lang('MinmaxMember::web.login.login_submit')</button>
    </form>
</body>
</html>