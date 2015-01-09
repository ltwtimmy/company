<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DuckEngine
 *
 * 基于CodeIgniter开源框架实现的简单内容管理系统
 *
 * @package		DuckEngine
 * @author		LiTianWen
 * @copyright	Copyright (c) 2006 - 2013, LiTianWen.
 * @license		http://DuckEngine.com/license.html
 * @link		http://DuckEngine.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * DuckEngine 后台控制器基类
 *
 * @package		DuckEngine	
 * @subpackage	core
 * @category	core
 * @author		LiTianWen
 * @link		http://DuckEngine.com
 */
class Admin_Controller extends CI_Controller{

	/**
	 * 保存当前用户信息
	 *
	 * @var object
	 * @access public
	 */
	public $_admininfo;
	public $tpl_data;

	public function __construct(){
		parent::__construct();
		//开启调试信息
		$this->output->enable_profiler(TRUE);
	}

	/**
	 * 显示提示信息跳转页面
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	public function _show_msg($msg, $url = '', $time = 3000){
		if($url == ''){
			$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
		}
		$data['msg'] = $msg;
		$data['url'] = $url;
		$data['time'] = $time;
		$this->load->view('message', $data);
	}

	/**
	 * ajax返回提示信息
	 *
	 * @access	public
	 * @param	string
	 * @param	bool
	 * @param	string
	 * @param	int
	 * @return	mixed
	 */
	public function _ajax_msg($msg, $isSuccess = TRUE, $url = '', $time = 3000){

		$data['isSuccess'] = $isSuccess;
		$data['text'] = $msg;
		$data['url'] = $url;
		$data['time'] = $time;
		$this->_ajax_return($data);
	}

	/**
	 * ajax返回信息
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function _ajax_return($msg){
		$this->output->enable_profiler(FALSE);
		if(is_array($msg)){
			echo json_encode($msg);
		}else{
			echo $msg;
		}
	}
}
// END Admin_Controller CLASS

/* End of file Duck_Controller.php */
/* Location: ./admin/core/Duck_Controller.php */
