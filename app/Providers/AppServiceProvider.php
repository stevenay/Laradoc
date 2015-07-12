<?php namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Register categories variable

		view()->composer(['documents.index', 'documents.show', 'categories.index'], function($view) {
			// or 'articles.*' for all these views if needed
			$view->with('categories', Category::with('documents')->orderBy('order_index')->get());
		});

		view()->composer(['documents.create', 'documents.edit'], function($view) {
			// or 'articles.*' for all these views if needed
			$view->with('categories', Category::orderBy('category_name', 'asc')->lists('category_name', 'id'));
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
