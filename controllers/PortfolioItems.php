<?php namespace Depcore\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;
use Depcore\Portfolio\Models\PortfolioItem;
use Depcore\Portfolio\Models\Industry;
use Depcore\Portfolio\Models\Client;

/**
 * Portfolio Items Back-end Controller
 */
class PortfolioItems extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController',
        'Backend.Behaviors.RelationController',
        // 'ReaZzon.Gutenberg.Behaviors.GutenbergController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Depcore.Portfolio', 'portfolio', 'portfolioitems');
        $this->industryFormWidget = $this->onLoadCreateIndustryFormWidget(  );

    }

    protected $industryFormWidget;

    /**
     * create a industry form for backend relation
     *
     * @return Object
     * @author Adam
     **/
    public function onLoadCreateIndustryForm()
    {
        $this->vars['industryFormWidget'] = $this->industryFormWidget;
        $this->vars['clientId'] = post( 'manage_id' );

        return $this->makePartial( 'industry_create_form' );

    }

    /**
     * Create an industry form for relation
     *
     * @return widget
     * @author Adam
     **/
    protected function onLoadCreateIndustryFormWidget()
    {
        $config = $this->makeConfig( '$/depcore/portfolio/models/industry/fields.yaml' );
        $config->alias = 'IndustryForm';
        $config->arrayName = 'Industry';
        $config->model = new Industry;
        $widget = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $widget->bindToController(  );
        return $widget;
    }

    /**
     * Create industry via ajax
     *
     * @return items list
     * @author Adam
     **/
    protected function onCreateIndustry()
    {
        $data = $this->industryFormWidget->getSaveData();
        $model = new Industry;
        $model->fill( $data );
        $model->save();

        $client = $this->getClientModel();
        $client->industries()->add( $model, $this->industryFormWidget->getSessionKey(  ) );
        return $this->refreshClientIndustriesList(  );
    }

    /**
     * Refresh the list on popup[]
     *
     * @return array
     * @author Adam
     **/
    protected function refreshClientIndustriesList()
    {
        $industries = $this->getClientModel()->industries()->withDeferred( $this->industryFormWidget->getSessionkey(  ) )->get(  );

        $this->vars['industries'] = $industries;

        return ['#industriesList' => $this->makePartial( 'industries_list' )];
    }

    /**
     * Get client that we're adding
     *
     * @return object
     * @author Adam
     **/
    protected function getClientModel()
    {
        $manageId = post( 'manage_id' );
        $client = $manageId
            ? Client::find( $manageId )
            : new Client;
        return $client;
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
