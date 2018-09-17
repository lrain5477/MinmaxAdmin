<p align="center"><img src="https://raw.githubusercontent.com/pikachujeff/MinmaxAdmin/develop/public/admin/images/logo-b.png" height="48"></p>

<p align="center">Laravel 5.6</p>

## Project Install

### Initial project

```bash
> cp .env.example .env
> vim .env                          # Change database, analytic view id, and some else.

> composer install

> php artisan key:generate
> php artisan migrate
> php artisan db:seed
```

### Useful commands

```bash
> composer dump-autoload            # Update class autoload
> php artisan cache:clear           # Clear all cache (Especial language cache)
> php artisan migrate:fresh --seed  # Refresh migration and build seed data
> php artisan ide-helper:generate   # Generate new ide-helper mapping file
> php artisan crud:generate [name]  # Generate new feature all crud files
```

### Site url

```
(your site)                         # Frontend Website
(your site)/siteadmin               # Admin Backend
(your site)/administrator           # Super Admin manager
```

## Project Construct

### Folder `App`
```
Http/Controllers
# Each feature has their own controller.

Http/Requests
# Each modle has their own requset rule with different method.

Models
# Put database connection here, one model one table. Also set table relation here.

Repositories
# The logic for model using. If there are columns with multi language,
# please put column name into $languageColumns array.

Presenters
# This is for view components. Form fields, selection item, all define here.
# You need make for model using. It's more easy to customize each model show up style.

Transformers
# This is for datatable list data.

Helpers
# Useful functions. If you make one is not class, please regist to HelperServiceProvider.

Mails
# Here is mailer. Please check Laravel offical documents.
```

### Special `Model`
```
GoogleAnalyticsClient
# This model is usage for Google Analytics Api.
# You must put api credential json file at 'storge/app/analytics'
# and setting analytics config file.
```

### Manage `Route`
```
\app\Providers\RouteServiceProvider
# Group platform's route setting. Default with four platforms.

Default with four routes:
\routes\administrator   -> (url)\administrator
\routes\admin           -> (url)\siteadmin
\routes\web             -> (url)

# route file is already with auth middleware. (user login system)
```

## Notice

1. Using `php artisan crud:generate` to easy create a new feature crud need files include Controller, Request, Model, Repository, Presenter, Transformer, and View files.

## Links

* https://laravel.com/docs/5.6
* https://docs.laravel-dojo.com/laravel/5.5
* Icon List: /admin/css/fonts/icon/demo.html

## License

Made by Jeff Chen (Jeffy).

The Minmax Laravel project is powered by MINMAX company, all rights reserved.
