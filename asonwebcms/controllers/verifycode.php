<?php
class Verifycode extends CI_Controller{

	public function index() {
		$conf['name'] = 'verify_code'; //作为配置参数
        $this->load->library('checkcode', $conf);
        $this->checkcode->show();
	}
}
