<?php namespace Depcore\Portfolio\Components;

use Cms\Classes\ComponentBase;
use Depcore\Portfolio\Models\Industry;

class ClientsList extends ComponentBase
{
    /** @var array $clients list of queried clients */
    public $clients;

    /** @var array $industries all industries */
    public $industries = null;

    /** @var string $title page title */
    public $title;

    public function componentDetails()
    {
        return [
            'name'        => 'depcore.portfolio::lang.components.clientslist.name',
            'description' => 'depcore.portfolio::lang.components.clientslist.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'limit' => [
                'title' => 'depcore.portfolio::lang.components.clientslist.limit',
                'description' => 'depcore.portfolio::lang.components.clientslist.limit_description',
                'default' => 9999,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'depcore.portfolio::lang.components.clientslist.limit_error'
            ],
            'url' => [
                'title'             => 'depcore.portfolio::lang.components.clientslist.url',
                'description'       => 'depcore.portfolio::lang.components.clientslist.url_description',
                'default'           => 'portfolio/case',
                'type'              => 'dropdown',
                'required'          => true,
                'validationMessage' => 'depcore.portfolio::lang.components.clientslist.url_required',
            ],
            'slug' => [
                'title'             => 'depcore.portfolio::lang.components.clientslist.slug',
                'description'       => 'depcore.portfolio::lang.components.clientslist.slug_description',
                'default'           => ':slug',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'depcore.portfolio::lang.components.clientslist.slug_required',
            ],
        ];
    }

    /**
     * on run
     *
     * Get clients list based on slug or if slug is missing get the first one
     *
     * @return null
     **/
    public function onRun()
    {
        $limit = $this->property('limit');

        $slug = $this->param('slug');
        $this->industries = Industry::all();
        $industry = $slug ? Industry::transWhere('slug', $slug)->first() : Industry::all()->first();

        if ($industry) {
            $this->clients = $industry->clients->take($limit);
            $this->title = $industry->name;
        }
    }

       public function getUrlOptions()
    {
        return \Cms\Classes\Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

}