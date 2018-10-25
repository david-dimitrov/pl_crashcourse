<?php
require_once 'smarty/Smarty.class.php';
require_once 'smtemplate_config.php';

class SMTemplate extends Smarty{
    
    function __construct(){
        parent:: __construct();
        
        global $smtemplate_config;
        $this->template_dir = $smtemplate_config['template_dir'];
        $this->compile_dir = $smtemplate_config['compile_dir'];
        $this->cache_dir = $smtemplate_config['cache_dir'];
        $this->config_dir = $smtemplate_config['config_dir'];
    }
    
    function render($template){
        $this->display($template.'.tpl');
    }
}
?>