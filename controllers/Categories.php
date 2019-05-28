<?php namespace Depcore\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;
use Depcore\Portfolio\Models\Category;

/**
 * Categories Back-end Controller
 */
class Categories extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Depcore.Portfolio', 'portfolio', 'categories');
    }

    /**
     * Deleted checked categories.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $categoryId) {
                if (!$category = Category::find($categoryId)) continue;
                $category->delete();
            }

            Flash::success(Lang::get('depcore.portfolio::lang.categories.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('depcore.portfolio::lang.categories.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
