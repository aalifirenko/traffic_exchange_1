<?php
namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class WidgetsServiceProvider extends ServiceProvider {

	public function boot() {
		View::composer('*', 'App\Widgets\Navbar');
	}

	public function register() {

	}
}