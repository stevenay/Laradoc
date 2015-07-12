<?php namespace App\Providers;

use App\Category;
use App\Document;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		$router->bind('documents', function ($slug_title) {
			$categories = Category::all(['id','category_name']);
			$category_id = 0;

			foreach ($categories as $category)
			{
				$category_name = str_slug($category->category_name);
				if (stripos($slug_title, $category_name) !== false) {
					$category_id = $category->id;
					$slug_title = str_replace($category_name . "-", "", $slug_title);
					break;
				}

			}

			$normal_title = ucwords(str_replace('-', ' ', $slug_title));

			return Document::where('title', $normal_title)->where('category_id', $category_id)->firstOrFail();
		});

		$router->bind('categories', function($id) {
			return Category::findOrFail($id);
		});

		// $router->model('documents', 'App\Document');
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
