<?php namespace Depcore\Portfolio\Models;

use Model;

/**
 * Client Model
 */
class Client extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'name' => 'required',
        'website_url' => 'url',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'depcore_portfolio_clients';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name'];

    public $hasMany = [
        'items'=>'Depcore/Portfolio/Models/PortfolioItem'
    ];

    public $belongsToMany = [
        'industries' => [
            Industry::class,
            'table' => 'depcore_portfolio_companies_industries',
        ]
    ];


    /**
     * Get industreis as array
     *
     * @return array
     * @author Adam
     **/
    public function industrieNames()
    {
        $names = array (  );
        foreach ( $this->industries as $industry )
            $names[] = $industry->name;
        return $names;
    }
}