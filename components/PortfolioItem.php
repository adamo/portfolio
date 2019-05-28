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
        $this->item = Portfolio::where ( 'slug',$slug )->first (  );
        if ($this->item->meta_title != '')
            $this->page->title = $this->item->meta_title;
        else $this->page->title = $this->item->title;

        if ($this->item->meta != '') $this->page->meta_description = $this->item->meta;
    }


    public function defineProperties()
    {
        return [];
    }

}