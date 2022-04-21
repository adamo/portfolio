<?php namespace Depcore\Portfolio\Models;

use Model;

/**
 * Industry Model
 */
class Industry extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\Sluggable;

    protected $slugs = ['slug' => 'title'];

    public $rules = [
        'name' => 'required',
    ];

    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $translatable = [
        'name',
        ['slug', 'index' => true],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'depcore_portfolio_industries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['parent_id','name'];

    public $belongsToMany = [
        'clients' => [
            Client::class,
            'table'     => 'depcore_portfolio_companies_industries',
        ]
    ];

    public $attachOne = [
        'cover' => '\System\Models\File',
    ];

}