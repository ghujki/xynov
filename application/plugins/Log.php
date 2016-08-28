<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use eYaf\Logger;

class LogPlugin extends Yaf_Plugin_Abstract
{

    public function routerStartup(Yaf_Request_Abstract $request , 
        Yaf_Response_Abstract $response
    ){
        Logger::startLogging();

        Logger::getLogger()->log("[{$request->getRequestUri()}]");
    }

    public function routerShutdown(Yaf_Request_Abstract $request, 
        Yaf_Response_Abstract $response 
    ){
        Logger::getLogger()->logRequest($request);
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, 
        Yaf_Response_Abstract $response 
    ){
    
    }

    public function preDispatch(Yaf_Request_Abstract $request , 
        Yaf_Response_Abstract $response 
    ){
    
    }
    
    public function postDispatch(Yaf_Request_Abstract $request, 
        Yaf_Response_Abstract $response 
    ){
    }
        
    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, 
        Yaf_Response_Abstract $response
    ){
        Logger::stopLogging();
    }
    

    public function preResponse(Yaf_Request_Abstract $request, 
        Yaf_Response_Abstract $response 
    ){
    
    }
}
