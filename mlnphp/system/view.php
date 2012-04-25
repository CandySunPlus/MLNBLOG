<?php
namespace MLNPHP\System;

use \MLNPHP\MLNPHP;
use \Exception;
/**
 * 视图类
 *
 * @author sunfengming
 */
class View {
    private $_vars;
    private $_app;
    
    const APP = 'APP';
    const SYS = 'SYS';
    const SYS_VIEW_PATH = 'MLNPHP\\View';
    
    public function __construct()
    {
        $this->_vars = array();
        $this->_app = MLNPHP::getApplication();
    }
    
    /**
     * 设置模板变量
     * 
     * @param string $key 变量名称
     * @param mixed $value 变量值
     * 
     * @return void
     */
    public function assgin($key, $value)
    {
        $this->_vars[$key] = $value;
    }
    
    /**
     * 批量导入模板变量
     * 
     * @param array $vars 模板变量 
     * 
     * @return void
     */
    public function loadVars($vars)
    {
        $this->_vars = $vars;
    }
    
    /**
     * 插入子模板
     * 
     * @param string $template 模板名称
     * @param string $type 模板类型（应用的还是框架内建的）
     * 
     * @return void 
     */
    public function import($template, $type = View::APP)
    {
        $view = new View();
        $view->loadVars($this->_vars);
        $viewContent = $view->render($template, $type);
        echo $viewContent;
    }
    
    /**
     * 获取模板文件路径
     * 
     * @param string $template 模板名
     * @param string $type 模板类型（应用的还是框架内建的）
     * 
     * @return string
     */
    private function _getTemplatePath($template, $type)
    {
        if ($type == View::APP) {
            $templateDir = $this->_app->conf->path['template'];
        } else {
            $templateDir = View::SYS_VIEW_PATH;
        }
        $pathInfo = explode('\\', $templateDir);
        $pathPrefix = MLNPHP::getPrefix(array_shift($pathInfo));
        $templatePath = $pathPrefix . DS;
        foreach ($pathInfo as $path) {
            $templatePath .= strtolower($path) . DS;
        }
        $templatePath .= $template . '.phtml';
        if (!file_exists($templatePath)) {
            throw new Exception(sprintf('模板文件%s不存在', $template));
        }
        return $templatePath;
    }
    
    /**
     * 渲染模板
     * 
     * @param string $template 模板名
     * @param string $type 模板类型（应用的还是框架内建的）
     * 
     * @return string 
     */
    public function render($template, $type = View::APP)
    {
        $templatePath = $this->_getTemplatePath($template, $type);        
        extract($this->_vars);
        ob_start();
        require $templatePath;
        return ob_get_clean();
    }
    
}

?>
