<?php

namespace tiagomichaelsousa\LaravelFilters\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use tiagomichaelsousa\LaravelFilters\Traits\Filterable;

/**
 * Class Post
 *
 * @package tiagomichaelsousa\LaravelFilters\Tests\Models
 *
 * @property integer id
 * @property string name
 * @property string last_name
 */
class User extends Model
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'last_name'];
}
