<?php namespace Depcore\Portfolio\Models;

use Model;

/**
 * Category Model
 */
class Category extends Model
{

    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Validation;

    protected $slugs = ['slug' => 'name'];

    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'depcore_portfolio_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name'];

    /**
     * @var array Relations
     */

    public $belongsToMany = [
        'items'=>'\Depcore\Portfolio\Models\PortfolioItem',
    ];

}
