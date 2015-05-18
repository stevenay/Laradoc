<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DocumentRequest;
use App\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller {

    /**
     * Show All Document Articles
     *
     * @return \Illuminate\View\View IndexPage
     */
    public function index()
	{
        return view('documents.index');
	}

    /**
     * Show the form to create new Document Article
     *
     * @return \Illuminate\View\View CreateFormPage
     */
    public function create()
    {
        return view('documents.create');
    }

    public function store(DocumentRequest $request)
    {
        $document = Document::create($request->all());
        return $document;
    }
}
