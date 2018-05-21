<p align="center"><img src="https://raw.githubusercontent.com/pikachujeff/MinmaxAdmin/develop/public/admin/images/logo-b.png" height="48"></p>

<p align="center">Laravel 5.6</p>

## Project Install

```bash
> cp .env.example .env
> vim .env      // Change database, analytic view id, and some else.

> composer install

> php artisan generate
> php artisan migrate   // Update please use migrate:fresh
> php artisan db:seed
```

```
(your site)                 // Frontend Website
(your site)/merchant        // Merchant Backend
(your site)/siteadmin       // Admin Backend
(your site)/administrator   // Super Admin manager
```

## Project Construct

**Folder `App`**
```
Http/Controllers
# In default, run (Platform)/Controller. You can extend it and make your own controller.

Models
# Put database connection here, one model one table. Also set table relation here.

Repositories
# The logic for model using. Like data format, encrypt, image array, etc.
# If you make your own, you need make your controller, default controller isn't supported.

Presenters
# This is for view components. Datatables, Form fields, selection item, all define here.
# You need make for model using. It's more easy to customize each model show up style.

Helpers
# Useful functions. If you make one is not class, please regist to HelperServiceProvider.

Mails
# Here is mailer. Please check Laravel offical documents.
```

**Special `Model`**
```
Administrator
# This model is super admin account model.

Admin
# This model is admin account model with rbac setting, it's easy to check permission.

# you can fallow those construct to make other account model.

GoogleAnalyticsClient
# This model is usage for Google Analytics Api.
# You must put api credential json file at 'storge/app/analytics'
# and setting analytics config file.
```

**Manage `Route`**
```
\app\Providers\RouteServiceProvider
# Group platform's route setting. Default with four platforms.

Default with four routes:
\routes\administrator   -> (url)\administrator
\routes\admin           -> (url)\siteadmin
\routes\merchant        -> (url)\merchant
\routes\web             -> (url)

# route file is already with auth middleware. (user login system)
```

## Notice

none.

## Links

* https://laravel.com/docs/5.6
* https://docs.laravel-dojo.com/laravel/5.5
* Icon List: /admin/css/fonts/icon/demo.html

## License

Made by Jeff Chen (Jeffy).

The Minmax Laravel project is powered by MINMAX company, all rights reserved.
