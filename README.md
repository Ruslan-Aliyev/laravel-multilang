# Multi-Lingual

## Preliminary setup and check

Install Breeze (so that we can learn how to put auth routes and internationalized routes together)

Run `php artisan lang:publish`   
BUT: it doesn't work anymore, so we need to manually create the `lang` folder and its contents according to https://laravel.com/docs/11.x/localization#introduction   

Let's try a simple test. In `routes/web.php`:
```php
Route::get('/{locale}/greeting', function (string $locale) {
    if (! in_array($locale, ['en', 'cn'])) {
        abort(400);
    }
 
    App::setLocale($locale);

    print_r(__('key'));
 
    dd(App::currentLocale());
});
```

`http://127.0.0.1:8000/en/greeting` should work   
but `http://127.0.0.1:8000/xx/greeting` won't.    

## Getting into the details

- If you look into the `blade` files in `resources/views/auth/`, you will see that they already use `__()` method. You can redo them.
- `__()` uses `trans()` under the hood. `__()` is easier to use with `json` language files.
- The default locale is set in `config/app.php`'s `locale` field.

In `routes/web.php` & `routes/auth.php`: wrap all your routes with `Route::group(['prefix' => '{locale}'], function () { /* ALL YOUR ROUTES */ });`

`php artisan make:middleware SetLanguage`, add `\App\Http\Middleware\SetLanguage::class,` to `App/Http/Kernel.php`'s `middlewareGroups`'s `web` array

In that middleware, put the below code into the `handle` function, before `return $next($request)`
```php
if (! in_array($request->locale, ['', 'en', 'cn'])) 
{
    abort(400);
}

\App::setLocale($request->locale); // "locale" - same as the route group's prefix
```

In all the relevant `blade` files, eg `welcome.blade.php`: change `<a href="{{ route( 'register' }}"` to `<a href="{{ route( 'register', app()->getLocale() ) }}"`

In all the relevant Auth controllers, change every occurance of `RouteServiceProvider::HOME` to `Config::get('app.locale') . RouteServiceProvider::HOME`

Tutorials:
	- https://laravel.com/docs/11.x/localization
		- https://www.youtube.com/watch?v=KqzGKg8IxE4
			- https://www.youtube.com/watch?v=CFGjn3yKMNc
	- https://www.youtube.com/watch?v=xMP_-IbywCU
	- https://laravel-news.com/html-string-affixer-localization

---

# Non-Latin fonts in BarryVDH PDF generation

## With BarryVDH-PDF (DomPDF) and Latin characters

https://www.positronx.io/laravel-pdf-tutorial-generate-pdf-with-dompdf-in-laravel

1. `composer require barryvdh/laravel-dompdf`
2. In `config/app.php`:

	```php
	'providers' => [
		Barryvdh\DomPDF\ServiceProvider::class,
	],
	'aliases' => [
		'PDF' => Barryvdh\DomPDF\Facade::class,
	]
	```

3. `php artisan vendor:publish`
4. Make route, controller and view

## With non-Latin characters

Firstly: Make the necessary code in `routes/web.php`, the Multilingual controller and the "multilingual" blade files.

1. Have the font `ttf`
2. Have this script: https://github.com/dompdf/utils/blob/master/load_font.php
3. Make directory: `storage/fonts/`
4. Unzip `simsun.ttf.gz` and run: `php load_font.php simsun ./fonts/simsun.ttf`. You'll see `storage/fonts/` being populated.
5. Apply this font style in your HTML/CSS

May also need to run: `php artisan cache:clear` && `php artisan route:cache` && `php artisan route:clear`

If you get `Undefined array key "storage/fonts/font-name"`, then go into `storage/fonts/installed-fonts.json` and change all the `storage\/fonts\/font-name` to `font-name`.

Tutorials:
	- https://github.com/barryvdh/laravel-dompdf/issues/79
	- https://github.com/barryvdh/laravel-dompdf/issues/290
	- https://stackoverflow.com/questions/45714545/dompdf-package-other-languages-support-in-laravel
	- https://blog.kongnir.com/2017/11/28/laravel-dompdf-custom-font-to-support-simplified-chinese
	- https://bloglaptrinh.info/laravel-dompdf-font-issue

---

# Todo

- Export to CSV/Excel: https://www.youtube.com/playlist?list=PL1TrjkMQ8UbWeumS9QLpRWpkG7qIKHSqX
