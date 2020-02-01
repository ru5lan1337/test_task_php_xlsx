<?php

namespace App\Core;

class Response
{
    const LAYOUT_FILE = 'layout.php';

    private $headers = [];
    private $body;

    public function send()
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->body;
        exit;
    }


    public function view($value)
    {
        $this->body = $value;

        return $this;
    }


    public function notFound()
    {
        $this->setHeader('HTTP/1.0 404 Not Found');
        $this->render('error.404');

        return $this;
    }


    public function error($status, $message)
    {
        $this->setHeader('HTTP/1.0 ' . $status . ' ' . $message);

        $this->body = $status . '. ' . $message;
        return $this;
    }


    public function setHeader($header)
    {
        $this->headers[] = $header;

        return $this;
    }


    public function render($template, $arResult = [])
    {
        $template_path = VIEWS .
            str_replace('.', '/', $template) . '.php';



        ob_start();
        include $template_path;
        $content = ob_get_clean();

        ob_start();
        include VIEWS . self::LAYOUT_FILE;
        $this->body = ob_get_clean();

        return $this;
    }
}