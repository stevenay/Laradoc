<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CategoriesController extends Controller {

    /**
     * Create new instance of CategoryController
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show List of Categories
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('categories.index', compact('categories'));
    }
    
    /**
     * Show the form to create new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
	{
        return view('categories.create');
	}

    /**
     * Save the category into the database (including Validation Logic).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // this is just one validation rule
        // so I run it on controller
        // rather than creating another RequestObject
        $this->validate($request, [
            'category_name' => 'required|min:3'
        ]);

        Category::create($request->all());
        return redirect('documents');
    }

    /**
     * Show the edit form for Category
     *
     * @param Category $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the Category into the Database
     *
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Category $category, Request $request)
    {
        $category->update($request->all());
        return redirect('categories');
    }

    /**
     * Delete the Category
     *
     * @param $id
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }

}
