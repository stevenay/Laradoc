<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * Fillable fields for a Category
     *
     * @var array
     */
	protected $fillable = [
        'category_name',
        'order_index'
    ];

    /**
     * A category can have many Documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

}
