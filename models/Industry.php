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

    public $rules = [
        'name' => 'required',
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
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'clients' => '\Depcore\Portfolio\Model\Client'
    ];


}
