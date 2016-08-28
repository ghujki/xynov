<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use eYaf\Request;
use eYaf\Layout;

class Bootstrap extends Yaf_Bootstrap_Abstract
{

    public function _initErrorHandler(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->setErrorHandler(array(get_class($this),'error_handler'));
    }

    public function _initConfig(Yaf_Dispatcher $dispatcher)
    {
        $this->config = Yaf_Application::app()->getConfig();
    }

    public function _initRequest(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->setRequest(new Request());
    }

    public function _initDatabase(Yaf_Dispatcher $dispatcher)
    {

    }

    public function _initPlugins(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->registerPlugin(new LogPlugin());

        $this->config->application->protect_from_csrf &&
            $dispatcher->registerPlugin(new AuthTokenPlugin());

    }

    public function _initLoader(Yaf_Dispatcher $dispatcher)
    {
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        $config = new Yaf_Config_Ini(APP_PATH . '/config/routing.ini');
        $dispatcher->getRouter()->addConfig($config);
    }

    /**
     * Custom init file for modules.
     *
     * Allows to load extra settings per module, like routes etc.
     */
    public function _initModules(Yaf_Dispatcher $dispatcher)
    {
        $app = $dispatcher->getApplication();

        $modules = $app->getModules();
        foreach ($modules as $module) {
            if ('index' == strtolower($module)) continue;

            require_once $app->getAppDirectory() . "/modules" . "/$module" . "/_init.php";
        }
    }

    public function _initLayout(Yaf_Dispatcher $dispatcher)
    {
        $layout = new Layout($this->config->application->layout->directory);
        $dispatcher->setView($layout);
    }

    /**
     * Custom error handler.
     *
     * Catches all errors (not exceptions) and creates an ErrorException.
     * ErrorException then can caught by Yaf\ErrorController.
     *
     * @param integer $errno   the error number.
     * @param string  $errstr  the error message.
     * @param string  $errfile the file where error occured.
     * @param integer $errline the line of the file where error occured.
     *
     * @throws ErrorException
     */
    public static function error_handler($errno, $errstr, $errfile, $errline)
    {
        // Do not throw exception if error was prepended by @
        //
        // See {@link http://www.php.net/set_error_handler}
        //
        // error_reporting() settings will have no effect and your error handler 
        // will be called regardless - however you are still able to read 
        // the current value of error_reporting and act appropriately. 
        // Of particular note is that this value will be 0 
        // if the statement that caused the error was prepended 
        // by the @ error-control operator.
        //
        if (error_reporting() === 0) return;

        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}
