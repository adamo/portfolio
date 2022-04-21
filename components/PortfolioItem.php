<?php namespace Depcore\Portfolio\Components;

use Depcore\Portfolio\Models\PortfolioItem as Portfolio;
use Cms\Classes\ComponentBase;

class PortfolioItem extends ComponentBase
{
    public $item;

    public function componentDetails()
    {
        return [
            'name'        => 'depcore.portfolio::lang.components.portfolioitem.name',
            'description' => 'depcore.portfolio::lang.components.portfolioitem.description'
        ];
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function onRun()
    {
        $slug = $this->param('slug');
        $this->item = Portfolio::transWhere ( 'slug',$slug )->first (  );
        $this->page['portfolio'] = $this->item;
    }


    public function defineProperties()
    {
        return [];
    }

}