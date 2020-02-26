<p align="center">
    <img src="./docs/logo.png" alt="Laravel Filters">
</p>

<p align="center">
    <img src="https://img.shields.io/packagist/v/tiagomichaelsousa/laravelfilters.svg?style=flat-square" alt="Packagist Version">
    <img src="https://img.shields.io/packagist/dt/tiagomichaelsousa/laravelfilters.svg?style=flat-square" alt="Packagist Downloads">
    <img src="https://img.shields.io/travis/tiagomichaelsousa/laravelfilters/master.svg?style=flat-square" alt="Build Status">
    <img src="https://github.styleci.io/repos/240133579/shield" alt="Style Status">
    <img src="https://poser.pugx.org/tiagomichaelsousa/laravelfilters/license?format=flat-square" alt="Licence">
    <img src="https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square" alt="All Contributors">
</p>

---

Laravel Filters is a package based in a [Laracasts](https://laracasts.com/) video made by [JeffreyWay](https://github.com/JeffreyWay).
This package allows to filter eloquent models in a clean and simple way.

## Installation

1. Install the package via Composer:

   ```sh
   $ composer require tiagomichaelsousa/laravelfilters
   ```

   The package will automatically register its service provider.

2. Optionally, publish the configuration file if you want to change any defaults:

   ```sh
   php artisan vendor:publish --provider="tiagomichaelsousa\LaravelFilters\LaravelFiltersServiceProvider" --tag="config"
   ```

## Usage

Create the filter

```bash
$ php artisan make:filter <name>
```

This command will create a new filter class in the namespace defined on the configuration file.

## Updating your Eloquent Models

Your models should use the Filterable trait, which has two scopes `filter()` and `resolve()`.

```php
use tiagomichaelsousa\LaravelFilters\Traits\Filterable;

class User extends Authenticatable
{
    use Filterable;
}
```

The `filter()` receives the query builder and the instance of the class responsible for the filter methods.

The `resolve()` method works like an helper. It verifies if the request has the query string `paginate=x` and if its present it return the response with pagination, otherwise it will return the data.

## Creating your Filters

When you make the request to an endpoint the `QueryFilter` class (that `UsersFilter` extends from) verifies if there is any method with the name that you sent in the request query string.

The `php artisan make:filter <name>` comes with a default method search that you can delete if you want. When you make a request to `/api/users?search=Foobar` the `QueryFilter` class will call the search method because the key `search` its present both in the request and in the `UserFilters` class.

```php
use tiagomichaelsousa\LaravelFilters\QueryFilters;

class UsersFilter extends QueryFilters
{
    /**
     * Search all.
     *
     * @param  string  $query
     * @return Builder
     */
    public function search($value = '')
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
}
```

The search method applies the queries to the builder instance. With that said you can combine multiple clauses. For example, if you want that the search method filter the data from the `name` and `last_name`fields on the db just add the `orWhere` clause.

```php
/**
 * Search all.
 *
 * @param  string  $query
 * @return Builder
 */
public function search($value = '')
{
    return $this->builder
                ->where('name', 'like', '%' . $value . '%')
                ->orWhere('last_name', 'like', '%' . $value . '%');
}
```

If you want to add more filters, just add a new method to the class, put the logic for the filter and sent it trough the request query string.

You can also filter data through eloquent relationships. For example, filter users from a country_code `/api/users?country=PT`

```php
/**
 * Filter by country.
 *
 * @param  string $country
 * @return Builder
 */
public function country($country)
    {
    return $this->builder->whereHas('address', function ($query) use ($country) {
        $query->where('country_code', $country);
    });
}
```

## Updating your Controllers

```php
class UserControllerAPI extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \App\Filters\UserFilters  $filters
     * @return \App\Http\Resources\Collections\UserCollection
     */
    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)->resolve();

        return new UserCollection($users);
    }
```

The `filter()` method can be called in every instance of a model that uses the `Filterable` Trait. So imagine that you have a model Meeting and these Meeting has many users. You can filter the users from the Meeting this way:

```php
class MeetingUsersControllerAPI extends Controller
{
    /**
     * Display a listing of the users from a meeting.
     *
     * @param  \App\Filters\UserFilters  $filters
     * @return \App\Http\Resources\Collections\UserCollection
     */
    public function index(Meeting $meeting, UserFilters $filters)
    {
        $users = $meeting->users()->filter($filters)->resolve();

        return new UserCollection($users);
    }
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

### With test coverage

```bash
$ composer test-report
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email the [author](mailto:tiagomichaelsousa@gmail.com) instead of using the issue tracker.

## Credits

- [@tiagomichaelsousa][link-author]
- [All Contributors][link-contributors]

## License

License MIT. Please see the [license file](license.md) for more information.

## Code Of Conduct

Please see the [code of conduct](code_of_conduct.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tiagomichaelsousa/laravelfilters.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tiagomichaelsousa/laravelfilters.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/tiagomichaelsousa/laravelfilters/master.svg?style=flat-square
[ico-styleci]: https://github.styleci.io/repos/240133579/shield
[link-packagist]: https://packagist.org/packages/tiagomichaelsousa/laravelfilters
[link-downloads]: https://packagist.org/packages/tiagomichaelsousa/laravelfilters
[link-travis]: https://travis-ci.org/tiagomichaelsousa/laravelfilters
[link-styleci]: https://styleci.io/repos/240133579
[link-author]: https://github.com/tiagomichaelsousa
[link-contributors]: ../../contributors

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/tiagomichaelsousa"><img src="https://avatars1.githubusercontent.com/u/28356381?v=4" width="100px;" alt=""/><br /><sub><b>tiagomichaelsousa</b></sub></a><br /><a href="https://github.com/tiagomichaelsousa/LaravelFilters/commits?author=tiagomichaelsousa" title="Code">💻</a> <a href="https://github.com/tiagomichaelsousa/LaravelFilters/commits?author=tiagomichaelsousa" title="Documentation">📖</a> <a href="#content-tiagomichaelsousa" title="Content">🖋</a> <a href="https://github.com/tiagomichaelsousa/LaravelFilters/pulls?q=is%3Apr+reviewed-by%3Atiagomichaelsousa" title="Reviewed Pull Requests">👀</a></td>
    <td align="center"><a href="http://www.xgeeks.io"><img src="https://avatars1.githubusercontent.com/u/15105462?v=4" width="100px;" alt=""/><br /><sub><b>Rafael Ferreira</b></sub></a><br /><a href="https://github.com/tiagomichaelsousa/LaravelFilters/commits?author=RafaelFerreiraTVD" title="Documentation">📖</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!
