<?php

namespace core;

class View
{
    public static $folder = 'views';

    private static $renderFile = '';

    public static $params = [];


    public static function render($file, $variables = array())
    {
        self::$params = array_merge($variables, self::$params);
        self::$renderFile = App::$data->appDir . '/' . self::$folder . '/' . $file . '.php';


        extract($variables);
        ob_start();

        include App::$data->appDir . '/' . self::$folder . '/layout.php';
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    public static function renderFile()
    {
        return self::$renderFile;
    }

    public static function renderWithVariables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if(file_exists($filePath)){
            // Extract the variables to a local namespace
            extract($variables);

            // Start output buffering
            ob_start();

            // Include the template file
            include $filePath;

            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;

    }
}