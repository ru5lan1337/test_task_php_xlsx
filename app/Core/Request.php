<?php

namespace App\Core;

class Request
{
    public $get;
    public $post;
    public $path;
    public $file;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    }
}