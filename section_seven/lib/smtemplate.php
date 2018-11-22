<?php
require_once 'smarty/Smarty.class.php';
require_once 'smtemplate_config.php';

class SMTemplate extends Smarty{
    
    function __construct()
    {
        parent::__construct();
         
        global $smtemplate_config;
        $this->template_dir = $smtemplate_config['template_dir'];
//        $this->addTemplateDir($smtemplate_config['layouts_dir']);
        $this->compile_dir = $smtemplate_config['compile_dir'];
        $this->cache_dir = $smtemplate_config['cache_dir'];
        $this->config_dir = $smtemplate_config['config_dir'];
    }
    
    function render($loginData = array(), $boolLogin, $contentData, $layout = 'layout_page')
    {
        foreach($loginData as $key => $value){
            $this->assign($key, $value);
        }
        $this->assign("contentData",$contentData);
        
        //Login Formular
        if ($boolLogin) //wenn 1 - Eingeloggt | 0 - nicht Eingeloggt
        {
            $content = $this->fetch('view_loginNameDisplay.tpl');
        }
        else 
        {
            $content = $this->fetch('view_loginForm.tpl');
        }
        $this->assign('__login', $content);
        
        //Warnschild
        $content = $this->fetch('view_warning.tpl');
        $this->assign('__warning', $content);

        //Content
        $content = $this->fetch('view_contents.tpl');
        $this->assign('__content', $content);
        //Comments
        $this->assign('__filmdetail', null);
        
        $this->display($layout . '.tpl');
    }
    
    function showContent($data = array(), $layout = 'layout_contentDisplay')
    {
        if (!isset($data))
        {
            return "";
        }
        foreach ($data as $key => $value)
        {
            $this->assign($key,$value);
        }
        
        return $this->fetch($layout.'.tpl');
    }
}
?>