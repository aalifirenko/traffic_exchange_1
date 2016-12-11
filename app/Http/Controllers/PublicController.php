<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('update.statistic');
        $this->menu_config_name = 'menu.public';
    }

    /**
     * Show homepage with Altezza.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public/home', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with supra.
     *
     * @return \Illuminate\Http\Response
     */
    public function supra()
    {
        return view('public/supra', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with chaser.
     *
     * @return \Illuminate\Http\Response
     */
    public function chaser()
    {
        return view('public/chaser', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with cresta.
     *
     * @return \Illuminate\Http\Response
     */
    public function cresta()
    {
        return view('public/cresta', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with GT 86.
     *
     * @return \Illuminate\Http\Response
     */
    public function gt86()
    {
        return view('public/gt86', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with laurel.
     *
     * @return \Illuminate\Http\Response
     */
    public function laurel()
    {
        return view('public/laurel', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with mark 2.
     *
     * @return \Illuminate\Http\Response
     */
    public function mark2()
    {
        return view('public/mark2', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with silvia.
     *
     * @return \Illuminate\Http\Response
     */
    public function silvia()
    {
        return view('public/silvia', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with skyline.
     *
     * @return \Illuminate\Http\Response
     */
    public function skyline()
    {
        return view('public/skyline', ['menu_config_name' => $this->menu_config_name]);
    }

    /**
     * Show page with verossa.
     *
     * @return \Illuminate\Http\Response
     */
    public function verossa()
    {
        return view('public/verossa', ['menu_config_name' => $this->menu_config_name]);
    }
}
