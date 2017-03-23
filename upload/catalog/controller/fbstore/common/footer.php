<?php
class ControllerFBStoreCommonFooter extends Controller {
	 public function index(){
	 	$this->load->model('fbstore/fbstore');
	 	$data = array();
		return $this->model_fbstore_fbstore->getOutput('fbstore/common/footer', $data);
	 }
}