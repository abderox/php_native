<?php


namespace View;
use RenderException\RenderException;
include_once './App/Vendor/Exceptions/RenderException.php';
class render_
{
    private $data = array();
    private $render = FALSE;

    public function __construct($template)
    {
        try {
            $file = '' . strtolower($template) . '.php';

            if (file_exists($file)) {
                $this->render = $file;
            } else {
                throw new RenderException('Template ' . $template . ' not found/created !');
            }
        }
        catch (RenderException $e) {
            echo $e->FailedRendering();
        }
    }

    public function render($variable="", $value="")
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);

    }
}