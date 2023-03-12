# Laravel Prohibition

<p align="center"><img width="300" src="https://cdn-icons-png.flaticon.com/512/432/432594.png"/></p>
laravel package to add prohibition system to your application

# Installation
```shell
composer require joodek/laravel-prohibition 
```
# Configurations
 Add this middleware to your web middlewares group in `app/Http/Kernel.php`

```php
Joodek\Prohibition\Http\Middleware\BlockBannedUsersMiddleware::class;
```

make sure to add it exactly to `app/Http/Kernel::$middlewareGroup` property in web key , otherwise it won't work,

 publish the configurations using 
```shell
php artisan vendor:publish --provider="Joodek\Prohibition\ProhibitionServiceProvider"
```

 migrate the table 
```shell
php artisan migrate
```
# Usage
this package provides two prohibition phases, you can either ban the `User` model, or using the `ip` address, both
using the same syntax and the same features

### User model
to enable the model prohibition , you should use the `Bannable` trait on your User model like this : 
```php
use Joodek\Prohibition\Bannable;

class User extends Authenticatable
{
    use Bannable;
}

```
this will give you all you need to ban the user, here is an example 
```php
use App\Models\User;

$user = new User(['name' => 'foo', 'email' => 'baz']);

$user->ban()
```
this way the user will be banned forever , and will recieve 403 Forbidden error if he tries to access your application, you can customize that if you want , see the [Restriction section](#restriction) section to see how, 

its rare scynario to ban your registered users forever, often you want to only ban a user for a period of time, you can do that using one of the following available methods,
```php
$user->banForMinutes($minutes = 1);

$user->banForHours($hours = 1);

$user->banForDays($days = 1);

$user->banForWeeks($weeks = 1);

$user->banForMonths($months = 1);

$user->banForYears($years = 1);
```
you can also check if the user is banned or not
```php
$user->banned() // bool
```

you can also unban the users at any time using 
```php
$user->unban()
```

### IP address
you can ban non registered users using the `IP` address, all you need available on the `\Illuminate\Http\Request` class, here is how :

*using the dependency injection*
```php
use Illuminate\Http\Request;

/* ... */
    public function example_method(Request $request): View
    {
        $request->ban();
    }
/* ... */
```

*using the helper method*
```php
request()->ban();
```

this will ban the current ip address forever, but you can customize the period like the following :

```php
$request->banForMinutes($minutes = 1);

$request->banForHours($hours = 1);

$request->banForDays($days = 1);

$request->banForWeeks($weeks = 1);

$request->banForMonths($months = 1);

$request->banForYears($years = 1);
```
you can also check if the ip address is banned or not
```php
$request->banned() // bool
```

you can also unban the ip at any time using 
```php
$request->unban()
```

# Restriction
Banned users wether using the model or ip will by default recieve `403 Forbidden` error when trying to access your application,
but you can customize it using the `error` key in the `config/prohibition.php` config file, like this 
```php
/* ... */

"error" => [
        "code" => 403,
        "message" => "Forbidden !"
    ]
    
/* ... */
```
or you can disable the aborting at all,  by setting the `restriction` to `false` in the `config/prohibition.php` config file,
```php
/* ... */

 "restrict" => true,
    
/* ... */
```

and this way you should check if they're banned using the previous methods we've mentioned

# Licence
this package is open source project under MIT licence,

# Security
you can at anytime report any vulnerabilities or any security bugs to [yassinebenaide3@gmail.com](mailto://yassinebenaide3@gmail.com) 

# Contribution
all your feedback are welcome, if you noticed any improvement issues or need some new features that you think will raise our package quality, you can submit a pull request , or raise a new issue here on github or on my email [yassinebenaide3@gmail.com](mailto://yassinebenaide3@gmail.com) , I'll make sure to review all of them,
