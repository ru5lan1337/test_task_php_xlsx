<?php

namespace App\Controllers;


class MainController extends Controller
{
    public function index()
    {

        return $this->response->render('main.index', ['msg'=>'hi']);
    }


}