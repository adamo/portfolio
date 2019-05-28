<?php namespace Depcore\Portfolio\Components;

use Depcore\Portfolio\Models\PortfolioItem as Portfolio;
use Cms\Classes\ComponentBase;

class PortfolioNavigation extends ComponentBase
{

    public $item;

    public function componentDetails()
    {
        return [
            'name'        => 'depcore.portfolio::lang.components.portfolionavigation.name',
            'description' => 'depcore.portfolio::lang.components.portfolionavigation.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * get current item and apply links
     *
     * @return object
     * @author Adam
     **/
    public function onRun()
    {
        $slug = $this->param('slug');
        $this->item = Portfolio::where ( 'slug', $slug )->first (  );
    }

}