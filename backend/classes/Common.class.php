<?php

/**
 * Common Class
 *
 * @category  General
 * @package   Common
 * @author    Salman Khimani <sk.salman.khimani@gmail.com>
 * @copyright Copyright (c) 2010-2018
 * @version   0.1
 */

class Common
{

    /**
     * Check Auth
     * @return null
     */
    public function checkAuth()
    {

        return isset($_SESSION['auth']) ? $_SESSION['auth'] : NULL;
    }

    /**
     * View
     * get contents of file in a buffer and return as a string
     * @param $view_file
     */
    public function view($view_file, $data = [])
    {
        // extract data to be accessible for view
        extract($data);
        // render view
        ob_start();
        include getcwd() . '/' . DIR_VIEWS . $view_file . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }


}

// END class
