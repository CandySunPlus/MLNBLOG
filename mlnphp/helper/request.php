<?php
namespace MLNPHP\Helper;

/**
 * Request请求类
 * 
 * @package MLNPHP
 */
class Request
{
	private $_vars;

	const GET = 'GET';
	const POST = 'POST';

	/**
	 * 取出Request的实例
	 * 
	 * @return Request
	 */
	public static function getInstance()
	{
		static $instance;
		if (empty($instance)) {
			$instance = new self();
		}
		return $instance;
	}

	private function __construct()
	{
		$this->_vars = array();

		foreach ($_GET as $key => $value) {
			$this->_vars[Request::GET][$key] = $value;
			unset($_GET[$key]);
		}
		foreach ($_POST as $key => $value) {
			$this->_vars[Request::POST][$key] = $value;
			unset($_POST[$key]);
		}
	}

	/**
	 * 设置POST或GET信息
	 * 
	 * @param array $values 信息数组
	 * @param string $type 信息类型
	 * 
	 * @return void
	 */
	public function set($values, $type = Request::GET)
	{
		foreach ($values as $key => $value) {
			$this->_vars[$type][$key] = $value;
		}
	}

	/**
	 * 获取GET信息
	 * 
	 * @param string $key 信息名称
	 * @param mixed $default 默认信息
	 * 
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		$value = isset($this->_vars[Request::GET][$key]) ? 
			$this->_vars[Request::GET][$key] :
			$default;
		return $value;
	}

	/**
	 * 获取POST信息
	 * 
	 * @param string $key 信息名称
	 * @param mixed $default 默认信息
	 * 
	 * @return mixed
	 */
	public function post($key, $default = null)
	{
		$value = isset($this->_vars[Request::POST][$key]) ? 
			$this->_vars[Request::POST][$key] :
			$default;
		return $value;
	}
}