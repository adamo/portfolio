<?php namespace Depcore\Portfolio;

use Backend;
use Event;
use System\Classes\PluginBase;
use Depcore\Portfolio\Models\PortfolioItem;

/**
 * portfolio Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'depcore.portfolio::lang.plugin.name',
            'description' => 'depcore.portfolio::lang.plugin.description',
            'author'      => 'depcore',
            'icon'        => 'icon-portfolio'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

        Event::listen('pages.menuitem.listTypes', function () {
            return [
                'portfolio-item' => 'depcore.portfolio::lang.portfolioitem.label' ,
                'all-portfolio-items' => 'depcore.portfolio::lang.portfolioitems.menu_label',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function ($type) {
            if ($type === 'portfolio-item' or $type == 'all-portfolio-items') {
                return PortfolioItem::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function ($type, $item, $url, $theme) {
            if ($type === 'portfolio-item' or $type == 'all-portfolio-items') {
                return PortfolioItem::resolveMenuItem($item, $url, $theme);
            }
        });

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Depcore\Portfolio\Components\PortfolioList' => 'PortfolioList',
            'Depcore\Portfolio\Components\PortfolioItem' => 'PortfolioItem',
            'Depcore\Portfolio\Components\PortfolioNavigation' => 'PortfolioNavigation',
            'Depcore\Portfolio\Components\ClientsList' => 'brandsClientsList',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'depcore.portfolio.create_portfolios' => [
                'tab' => 'depcore.portfolio::lang.plugin.name',
                'label' => 'depcore.portfolio::lang.permissions.manage_portfolios'
            ],
            'depcore.portfolio.access_industries' => [
                'tab' => 'depcore.portfolio::lang.plugin.name',
                'label' => 'depcore.portfolio::lang.permissions.access_industries'
            ],
            'depcore.portfolio.access_clients' => [
                'tab' => 'depcore.portfolio::lang.plugin.name',
                'label' => 'depcore.portfolio::lang.permissions.access_clients'
            ],
            'depcore.portfolio.access_categories' => [
                'tab' => 'depcore.portfolio::lang.plugin.name',
                'label' => 'depcore.portfolio::lang.permissions.access_categories'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'portfolio' => [
                'label'       => 'depcore.portfolio::lang.plugin.name',
                'url'         => Backend::url('depcore/portfolio/portfolioitems'),
                'icon'        => 'icon-briefcase',
                'permissions' => ['depcore.portfolio.manage_portfolios'],
                'order'       => 500,
                'sideMenu' => [
                    'items' => [
                        'label'       => 'depcore.portfolio::lang.portfolioitem.label',
                        'icon'        => 'icon-briefcase',
                        'url'         => Backend::url('depcore/portfolio/portfolioitems'),
                        'permissions' => ['depcore.portfolio.manage_portfolios'],
                    ],
                    'create_portfolio' => [
                        'label'       => 'depcore.portfolio::lang.portfolioitem.new',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('depcore/portfolio/portfolioitems/create'),
                        'permissions' => ['depcore.portfolio.manage_portfolios'],
                    ],
                    'categories' => [
                        'label'       => 'depcore.portfolio::lang.category.label',
                        'icon'        => 'icon-inbox',
                        'url'         => Backend::url('depcore/portfolio/categories'),
                        'permissions' => ['depcore.portfolio.access_categories'],
                    ],
                    'clients' => [
                        'label'       => 'depcore.portfolio::lang.client.label',
                        'icon'        => 'icon-user',
                        'url'         => Backend::url('depcore/portfolio/clients'),
                        'permissions' => ['depcore.portfolio.access_clients']
                    ],
                    'industries' => [
                        'label'       => 'depcore.portfolio::lang.industry.label',
                        'icon'        => 'icon-briefcase',
                        'url'         => Backend::url('depcore/portfolio/industries'),
                        'permissions' => ['depcore.portfolio.access_industries']
                    ],
                    'settings' => [
                        'label'       => 'depcore.portfolio::lang.menu.secondary.settings',
                        'icon'        => 'icon-cog',
                        'url'         => Backend::url('system/settings/update/depcore/portfolio/form'),
                        'permissions' => ['depcore.portfolio.access_settings']
                    ],
                ], // side menu ends
            ],
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'getClassIdAndStyle' => [$this, 'extractStyle']
            ],

        ];
    }

    /**
     * Return combined attributes for the section or content objects
     *
     * @return string
     * @author Adam
     * @todo Invoke media manager for background images
     **/
    public function extractStyle($div)
    {
        if (is_array($div)) {
            $style = '';
            if ( array_key_exists('class', $div) and $div['class'] != '') $style .= "class='{$div['class']}' ";
            if ( array_key_exists('id', $div) and $div['id'] != '' ) $style .= "id='{$div['id']}' ";
            if ( array_key_exists('backgroundImage', $div) and $div['backgroundImage'] != ''  ) {
                $image = \Config::get('cms.storage.media.path').$div['backgroundImage'];
                $div['style'] .= "background-image: url($image)";
            }
            if (array_key_exists('style', $div) and $div['style'] != '' ) $style .= "style='{$div['style']}'";
            return $style;
        }
    }

    public function registerStormedModels()
    {
        return [
            '\Depcore\Portfolio\Models\PortfolioItem' => [
                'placement' => 'tabs',
            ],
        ];
    }

}