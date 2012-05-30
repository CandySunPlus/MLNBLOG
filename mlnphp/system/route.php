<?php
namespace MLNPHP\System;

use \MLNPHP\System\HttpApplication;
/**
 * 路由分析类
 * 
 * @package MLNPHP
 */
class Route
{
	private $_routers;
	private $_pathInfo;
	private $_routerMatch;
	public function __construct($routers, $pathInfo)
	{
		$this->_routers = $routers;
		$this->_pathInfo = trim($pathInfo, '/');
	}

	/**
	 * 比对PATH_INFO是否有对应规则
	 * 
	 * @param string $router 规则
	 * @param string $pathInfo PATH_INFO
	 * 
	 * @return bool
	 */
	private function _compare($router, $pathInfo)
	{
		$rulerPattern = $this->_parseRuler($router);
		$result = preg_match($rulerPattern, $pathInfo, $match);

		if (0 === $result) {
			return false;
		} else {			
			$this->_routerMatch = $match;
			return true;
		}
	}

	/**
	 * 解析规则成正则表达式
	 * 
	 * @param string $ruler 规则
	 * 
	 * @return string
	 */
	private function _parseRuler($ruler)
	{
		$orginRuters = array('{%d}', '{%s}');
		$regRuters = array('([0-9]+)', '([A-Za-z]+)');
		$rulerKeywordPattern = '/\{\%[ds]{1}\}/';

		preg_match_all($rulerKeywordPattern, $ruler, $match);
		$rulerInfo = preg_split($rulerKeywordPattern, $ruler);

		//转换规则关键字
		foreach ($match[0] as &$value) {
			$value = str_replace($orginRuters, $regRuters, $value);
		}
		//转换正则关键字
		foreach ($rulerInfo as $key => &$value) {
			$value = preg_quote($value, '/');
			if (isset($match[0][$key])) {
				$value .= $match[0][$key];
			}			
		}

		$rulerPattern = implode('', $rulerInfo);
		return '/^' . $rulerPattern . '$/';
	}

	/**
	 * 分析PATH_INFO返回相应的CAP
	 * 
	 * @param string $pathInfo PATH_INFO
	 * 
	 * @return array
	 */
	private function _parsePathInfo($pathInfo)
	{
		$pathInfoMetadata = explode('/', $pathInfo);

		switch (count($pathInfoMetadata)) {
			case 1:
				return array(
					'controller' => array_shift($pathInfoMetadata),
					'action' => HttpApplication::defaultAction,
					'params' => array()
				);
				break;
			case 2:
				return array(
					'controller' => array_shift($pathInfoMetadata),
					'action' => array_shift($pathInfoMetadata),
					'params' => array()
				);
				break;
			default:
				return array(
					'controller' => array_shift($pathInfoMetadata),
					'action' => array_shift($pathInfoMetadata),
					'params' => $this->_parseParams($pathInfoMetadata)
				);
				break;
		}
	}

	/**
	 * 通过分析PATH_INFO元数据来给GET参数赋值
	 * 
	 * @param array $pathInfoMetadata PATH_INFO元数据
	 * 
	 * @return array
	 */
	private function _parseParams($pathInfoMetadata)
	{
		$params = array();
		
		for ($i = 0, $count = count($pathInfoMetadata); $i < $count; $i += 2) { 
			if (empty($pathInfoMetadata[$i])) {
				break;
			} else {
				$params[$pathInfoMetadata[$i]] = isset($pathInfoMetadata[$i + 1]) ?
					$pathInfoMetadata[$i + 1] :
					null;
			}			
		}
		return $params;
	}

	/**
	 * 分析URL参数
	 * 
	 * @return array
	 */
	private function _parseUrl()
	{
		if (empty($this->_pathInfo) && !isset($_GET['c'])) {
			//无任何参数
			return array(
				'controller' => HttpApplication::defaultController,
				'action' => HttpApplication::defaultAction,
				'params' => array()
			);
		} elseif (!empty($this->_pathInfo)) {
			//PATH_INFO模式
			return $this->_parsePathInfo($this->_pathInfo);
		} else {
			//非PATH_INFO模式
			$controller = isset($_GET['c']) ? $_GET['c'] : HttpApplication::defaultController;
			$action = isset($_GET['a']) ? $_GET['a'] : HttpApplication::defaultAction;
			unset($_GET['c'], $_GET['a']);
			$params = $_GET;
			return array(
				'controller' => $controller,
				'action' => $action,
				'params' => $params
			);
		}
	}

	/**
	 * 开始路由解析
	 * 
	 * @return array
	 */
	public function parse()
	{
		$replaceStr = array('/\$([0-9]+)/e');	
		$replace = array('$this->_routerMatch["\\1"]');	
		foreach ($this->_routers as $router => $CAP) {
			if (false !== $this->_compare($router, $this->_pathInfo)) {	
				$CAP = $CAP->toArray();
				$params = array_pop($CAP);
				//替换控制器和动作				
				$CA = preg_replace($replaceStr, $replace, $CAP);
				//由于params是个数组，所以取出单独进行替换
				$params = preg_replace($replaceStr, $replace, $params);
				//重新组合CAP
				$CAP = array_merge($CA, array('params' => $params));
				return $CAP;
			}
		}
		return $this->_parseUrl();
	}
}