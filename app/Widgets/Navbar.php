<?php
namespace App\Widgets;

use Route;
use Illuminate\Contracts\View\View;

class Navbar {

	protected $currentRoute = null;

	public function compose(View $view){
		$this->currentRoute = Route::currentRouteName();

		$view->with('navbar', $this);
	}

	public function create($configs){
		return view('widgets/navbar', ['menu' => $configs]);
	}

}