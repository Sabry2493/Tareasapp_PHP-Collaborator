<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function menu(): string
    {
        /* return view('welcome_message'); */
        return view('menu');
    }
}
