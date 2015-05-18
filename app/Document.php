<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    /**
     * Fillable fields for Document
     *
     * @var array
     */
	protected $fillable = [
        'title',
        'content'
    ];

}
