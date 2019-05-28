<?php namespace Depcore\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;
use Depcore\Portfolio\Models\PortfolioItem;

/**
 * Portfolio Items Back-end Controller
 */
class PortfolioItems extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        // 'ReaZzon.Gutenberg.Behaviors.GutenbergController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Depcore.Portfolio', 'portfolio', 'portfolioitems');
    }

    /**
     * Deleted checked portfolioitems.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $portfolioitemId) {
                if (!$portfolioitem = PortfolioItem::find($portfolioitemId)) continue;
                $portfolioitem->delete();
            }

            Flash::success(Lang::get('depcore.portfolio::lang.portfolioitems.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('depcore.portfolio::lang.portfolioitems.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
