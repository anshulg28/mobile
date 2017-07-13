<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class UPI
 * @property dashboard_model $dashboard_model
 */

class Upi extends MY_Controller {

	public function index()
	{
        echo 'Nothing Here';
	}
	public function upiCallBackRes()
    {
        $this->load->model('dashboard_model');
        $post = $this->input->post();

        $details = array(
            'dumpTxt' => json_encode($post),
            'insertedDateTime' => date('Y-m-d H:i:s')
        );
        $this->dashboard_model->saveUpiDump($details);
    }
}
