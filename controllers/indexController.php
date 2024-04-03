<?php

class indexController
{
    public $view_folder;
    public $view_disabled;

    public function queryAction()
    {
        $this->viewing([], 'query');
        $this->view_disabled = false;
    }
    public function get_include_contents($filename, $variables)
    {
        if (is_file($filename)) {
            ob_start();
            foreach ($variables as $key => $value) {
                $$key = $value;
            }
            include $filename;
            return ob_get_clean();
        }
        return false;
    }

    public function viewing($variables, $view = "Index")
    {
        //set variables and invoke the file passing those variables to the view

        $filepath = 'C:/some/path/'.$this->view_folder.'/'. $view . '.php';
        if (file_exists($filepath) && $this->view_disabled == false) {
            $file_contents = $this->get_include_contents($filepath, $variables);
            echo $file_contents;
        } else {
            echo "View not found";
        }
    }
}
