<?php


class extraController
{
    public $practice;

    public $start_date;

    public $end_date;

    public $date;

    public $code_insert;

    public $code_insert1;

    public $conn;

    public $view_disabled;

    public $view_folder;

    public $view_path;

    public $type;

    public $procedure;

    public function __construct()
    {
        $this->view_folder = "report";
        $this->view_path = "'../views/'.$this->view_folder.'/'";
    }

    public function init($location)
    {
        $user = "user";
        $pass = "password";
        $this->conn = odbc_connect($location, $user, $pass) or die("The database connection failed");
    }

    public function disconnect()
    {
        if (isset($this->conn)) {
            odbc_close($this->conn);
        }
    }

    public function query($query)
    {
        $result = odbc_exec($this->conn, $query);
        return $result;
    }

    public function indexAction()
    {
        echo "reportController::indexAction()";
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

    public function set_file_var($var, $value)
    {
    }

    public function afterExecute()
    {
        $this->disconnect();
    }

    public function return_json($odbc)
    {
        $data = array();
        while ($row = odbc_fetch_array($odbc)) {
            $data[] = $row;
        }
        //set header to json
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function dump_one_row($odbc)
    {
        $data = array();
        while ($row = odbc_fetch_array($odbc)) {
            $data[] = $row;
        }
        echo "<pre>";
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                echo "$key: $value<br>";
            }
            echo "-----------------------<br>";
        }
        echo "</pre>";
    }

    public function dump($odbc)
    {
        $data = array();
        while ($row = odbc_fetch_array($odbc)) {
            $data[] = $row;
        }
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

}
