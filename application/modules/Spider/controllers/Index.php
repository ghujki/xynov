<?php
/**
 * Created by PhpStorm.
 * User: ghujk
 * Date: 2016/7/31
 * Time: 10:59
 */

class IndexController extends ApplicationController {

    protected $layout = 'template';

    public function init()  {
        parent::init();

        $this->getView()->setLayoutPath(
            $this->getConfig()->application->directory
            . "/modules" . "/Spider" . "/views" . "/layouts"
        );
    }

    public function indexAction() {
        Yaf_Loader::import(Yaf_Registry::get("Module_path")."/models/Template.php");
        $templateModel = new dao\TemplateModel();
        $this->templates = $templateModel->fList();
        $this->title= "蜘蛛";
    }

    public function processAction() {

    }
}