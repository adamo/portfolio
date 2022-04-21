<?php namespace Depcore\Portfolio\Components;

use Depcore\Portfolio\Models\PortfolioItem;
use Depcore\Portfolio\Models\Category;
use Cms\Classes\ComponentBase;

class PortfolioList extends ComponentBase
{

    public $portfolioItems;

    public function componentDetails()
    {
        return [
            'name'        => 'depcore.portfolio::lang.components.portfoliolist.name',
            'description' => 'depcore.portfolio::lang.components.portfoliolist.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'url' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.url',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.url_description',
                'default'           => 'portfolio/case',
                'type'              => 'dropdown',
                'required'          => true,
                'validationMessage' => 'depcore.portfolio::lang.components.portfoliolist.url_required',
            ],
            'slug' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.slug',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.slug_description',
                'default'           => ':slug',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'depcore.portfolio::lang.components.portfoliolist.slug_required',
            ],
            'maxItems' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.max_items',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.max_items_description',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'depcore.portfolio::lang.components.portfoliolist.max_items_numeric',
            ],
            'randomize' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.randomize',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.randomize_description',
                'type'              => 'checkbox',
            ],
            'includeCategories' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.include_categories',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.include_categories_description',
                'type'              => 'checkbox',
                'group'             => 'depcore.portfolio::lang.components.portfoliolist.url'
            ],
            'categoryUrl' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.url',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.url_description',
                'default'           => 'portfolio/case',
                'type'              => 'dropdown',
                'validationMessage' => 'depcore.portfolio::lang.components.portfoliolist.url_required',
                'group'             => 'depcore.portfolio::lang.components.portfoliolist.url'
            ],
            'categorySlug' => [
                'title'             => 'depcore.portfolio::lang.components.portfoliolist.slug',
                'description'       => 'depcore.portfolio::lang.components.portfoliolist.slug_description',
                'default'           => ':slug',
                'type'              => 'string',
                'validationMessage' => 'depcore.portfolio::lang.components.portfoliolist.slug_required',
                'group'             => 'depcore.portfolio::lang.components.portfoliolist.url'
            ],

        ];
    }

    /**
     *  get all published portfolioitems list in sort order
     *
     *  @return void
     *  @author Adam
     *
     **/
    public function onRun()
    {
        $this->property('slug');
        $this->portfolioItems = PortfolioItem::published();
        if ( is_int($this->property('categorySlug'))) $this->portfolioItems = Category::find( $this->property('categorySlug') )->items(  );

        if ($this->property( 'maxItems' ) !='')
            $this->portfolioItems = $this->portfolioItems->take( $this->property( 'maxItems' ) );

        // if ($this->property( 'randomize' ))
        //     $this->portfolioItems = $this->portfolioItems->get()->random($this->property( 'maxItems' ));
        // else
        $this->portfolioItems = $this->portfolioItems->get();

    }

    public function getUrlOptions()
    {
        return \Cms\Classes\Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getCategoryUrlOptions()
    {
        return \Cms\Classes\Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @param int $modelId
     * @return array $categories
     * @todo
     **/
    public function getCategoriesAsArray($modelId)
    {
        return Model::find( $id )->categories(  )->get()->toArray(  );
    }

}