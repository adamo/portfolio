<?php namespace Depcore\Portfolio\Models;

use Model;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

/**
 * PortfolioItem Model
 */
class PortfolioItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Sortable;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $jsonable = ['content'];

    public $translatable = [
        'title',
        'short_description',
        'description',
        'content',
        'url',
        'meta_title',
        'meta',
        'slug',
    ];


    public $rules = [
        'client' => 'required',
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'url' => 'url',
        'meta_title' => 'max:70',
        'meta' => 'max:160',
    ];

    protected $slugs = ['slug' => 'title'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'depcore_portfolio_items';

    // public $implement = ['ReaZzon.Gutenberg.Behaviors.Gutenbergable'];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'client' => 'Depcore\Portfolio\Models\Client'
    ];

    public $belongsToMany = [
        'categories' => [
            'Depcore\Portfolio\Models\Category',
            'table' => 'depcore_portfolio_portfolio_items_categories',
        ]
    ];

    public $attachOne = [
        'cover' =>'\System\Models\File'
    ];

    /**
     * get published portfolio items and order them
     *
     * @return array
     * @author Adam
     **/
    public function scopePublished( $query )
    {
        return $query->whereNotNull('published')->where ( 'published',true )->orderBy( 'sort_order' );
    }

    /**
     * Get categories names as array
     *
     * @return array
     * @author Adam
     **/
    public function categoryNames(  )
    {
        $names = array();
        foreach( $this->categories as $category ){
            $names[] = $category->name;
        }
        return $names;
    }

    /**
     * insert not breaking space in content elements
     *
     * @return void
     * @author Adam
     * @todo implement behavior to insert
     **/
    // public function beforeSave()
    // {

    // }

    /**
     * Apply a constraint to the query to find the nearest sibling
     *
     *     // Get the next post
     *     Post::applySibling()->first();
     *
     *     // Get the previous post
     *     Post::applySibling(-1)->first();
     *
     *     // Get the previous post, ordered by the ID attribute instead
     *     Post::applySibling(['direction' => -1, 'attribute' => 'id'])->first();
     *
     * @param       $query
     * @param array $options
     * @return
     */
    public function scopeApplySibling($query, $options = [])
    {
        if (!is_array($options)) {
            $options = ['direction' => $options];
        }

        extract(array_merge([
            'direction' => 'next',
            'attribute' => 'sort_order'
        ], $options));

        $isPrevious = in_array($direction, ['previous', -1]);
        $directionOrder = $isPrevious ? 'asc' : 'desc';
        $directionOperator = $isPrevious ? '>' : '<';

        $query->where('id', '<>', $this->id);

        // if (!is_null($this->$attribute)) {
        //     $query->where($attribute, $directionOperator, $this->$attribute);
        // }

        return $query->orderBy($attribute, $directionOrder);
    }

    /**
     * Returns the next post, if available.
     * @return self
     */
    public function nextPortfolioItem(  )
    {
          return $this->published (  )->applySibling()->first (  );
    }

    /**
     * Returns the previous post, if available.
     * @return self
     */
    public function previousPortfolioItem()
    {
        return self::published()->applySibling(-1)->first();
    }

    public static function getMenuTypeInfo($type)
    {
        $result = [];

        if ($type == 'portfolio-item') {
            $references = [];

            $items = self::published()->orderBy('title')->get();
            foreach ($items as $item) {
                $references[$item->id] = $item->title;
            }

            $result = [
                'references'   => $references,
                'nesting'      => false,
                'dynamicItems' => false
            ];
        }


        if ($type == 'all-portfolio-items')
            $result = [
                'dynamicItems' => true
            ];


        if ($type == 'category-blog-posts') {
            $references = [];

            $categories = Category::orderBy('name')->get();
            foreach ($categories as $category) {
                $references[$category->id] = $category->name;
            }

            $result = [
                'references'   => $references,
                'dynamicItems' => true
            ];
        }

        if ($result) {
            $theme = Theme::getActiveTheme();

            $pages = CmsPage::listInTheme($theme, true);
            $cmsPages = [];

            foreach ($pages as $page) {
                if (!$page->hasComponent('PortfolioList')) continue;

                $properties = $page->getComponentProperties('PortfolioList');


                if (!isset($properties['url']) ||  !isset($properties['slug'])) continue;

                $cmsPages[] = $page;
            }

            $result['cmsPages'] = $cmsPages;
        }

        return $result;
    }

    public static function resolveMenuItem($item, $url, $theme)
    {
        $pageName = 'portfolio';

        $theme = Theme::getActiveTheme();

        $pages = CmsPage::listInTheme($theme, true);
        $cmsPages = [];

        foreach ($pages as $page) {
            if (!$page->hasComponent('PortfolioList')) continue;

            $properties = $page->getComponentProperties('PortfolioList');
            if (!isset($properties['url']) || !isset(  $properties['slug'])) continue;
            $pageName = strtolower($page->fileName);
        }

        $cmsPage = \Cms\Classes\Page::loadCached($theme, $pageName);

        $items = self::orderBy('created_at', 'DESC')->get()->map(function (self $item) use ($cmsPage, $url, $pageName) {
                $pageUrl = $cmsPage->url($pageName, ['slug' => $item->slug]);

                return [
                    'title'    => $item->title,
                    'url'      => $pageUrl.'/'.$item->slug,
                    'mtime'    => $item->updated_at,
                    'isActive' => $item->is_published,
                ];

            })->toArray();


        return [
            'items' => $items,
        ];
    }

}
