<?php namespace Depcore\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;
use Depcore\Portfolio\Models\Client;

/**
 * Clients Back-end Controller
 */
class Clients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Depcore.Portfolio', 'portfolio', 'clients');
    }

    /**
     * Deleted checked clients.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $clientId) {
                if (!$client = Client::find($clientId)) continue;
                $client->delete();
            }

            Flash::success(Lang::get('depcore.portfolio::lang.clients.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('depcore.portfolio::lang.clients.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
