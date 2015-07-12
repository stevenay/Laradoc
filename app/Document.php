<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Elasticquent\ElasticquentTrait;

class Document extends Model {
    use ElasticquentTrait;

    /**
     * Fillable fields for Document
     *
     * @var array
     */
	protected $fillable = [
        'title',
        'content',
        'category_id',
        'search_index_heading'
    ];

    /**
     * Mapping Properties for Elasticquent
     *
     * @var array
     */
    protected $mappingProperties = [
        'search_index_heading' => [
            'type' => 'string',
            'analyzer' => 'standard',
        ],
    ];

    /**
     * Create new Document by Business Term
     *
     * @param array $attrs
     * @return static
     */
    public static function open(array $attrs)
    {
        return new static($attrs);
    }

    public function getContentAttribute($value)
    {
        return $this->addLinkToH3($value);
    }

    /**
     * A document is owned by one Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    /**
     * Scoping Full Text Searching
     *
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query, $q)
    {
        return $query->whereRaw("MATCH(search_index_heading) AGAINST (? IN BOOLEAN MODE)", [$q]);
    }

    /**
     * Build SearchIndexHeading Column
     *
     * @param string $content
     * @return $this
     */
    public function buildSearchIndex($content)
    {
        $this->search_index_heading = $this->buildSearchIndexString($content);

        return $this;
    }

    /**
     * Inject <a> link before h3 tags into the Html
     *
     * @param $content
     * @return mixed 
     */
    public function addLinkToH3($content)
    {
        // Just only without a tag h3 version
        // "/(?<!><\/a><\/p>[\n])<h3>(.+?)<\/h3>/i",

        $html = preg_replace_callback(
            "/<h3>(.+?)<\/h3>/i",
            function ($m) {
                return "<p><a name='". str_slug($m[1]) ."'></a></p>$m[0]";
            }
            , $content);

        return $html;
    }

    /**
     * Build Search Index Heading String for Document's content
     *
     * @param $content
     * @return string
     */
    public function buildSearchIndexString($content)
    {
        $search_index = "";
        // store it into the Search_index_heading column
        if (preg_match_all("/(?:<h[2-3]>)(.+?)(?:<\/h[2-3]>)/i", $content, $matches)) {
            $search_index = implode( " ", $matches[1] );
        }

        return $search_index;
    }

    public function buildSearchIndexArray($content)
    {
        return ["search_index_heading" => $this->buildSearchIndexString( $content )];
    }

}
