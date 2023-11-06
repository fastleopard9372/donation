<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

class Paypal extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// Load paypal library & product model
		$this->load->library('paypal_lib');
		$this->load->model('product');
	}

	function success()
	{
		// Get the transaction data
		$paypalInfo = $this->input->post();

		/*$data['item_name']= $paypalInfo['item_name'];
		$data['item_number']= $paypalInfo['item_number'];
		$data['txn_id'] = $paypalInfo["txn_id"];
		$data['payment_amt'] = $paypalInfo["payment_gross"];
		$data['currency_code'] = $paypalInfo["mc_currency"];
		$data['status'] = $paypalInfo["payment_status"];*/
		// Pass the transaction data to view

		// $dt['item_name']	= $paypalInfo["item_name"];
		// $dt['username']	= $_SESSION["username"];
		// $dt['location']	= $_SESSION["location"];
		$dt['username'] = file_get_contents('./us.ts');
		$dt['location'] = file_get_contents('./ls.ts');
		$dt['product_id'] = $paypalInfo['item_number'];
		$dt['txn_id'] = $paypalInfo['txn_id'];
		$dt['amount'] = $paypalInfo['mc_gross'];
		$dt['currency_code'] = $paypalInfo['mc_currency'];
		$dt['email'] = $paypalInfo['payer_email'];
		$dt['payment_status'] = $paypalInfo['payment_status'];
		$this->product->insertTransaction($dt);
		$dt['donate'] = $this->product->getDonate();
		$dt['count'] = $this->product->getCount();
		$dt['total'] = $this->product->getTotal();

		$this->load->view('template/header', $dt);
		$this->load->view('index', $dt);
		$this->load->view('template/footer', $dt);
	}

	function cancel()
	{
		// Load payment failed view
		// $this->load->view('paypal/cancel' );
		$dt['donate'] = $this->product->getDonate();
		$dt['count'] = $this->product->getCount();
		$dt['total'] = $this->product->getTotal();

		$this->load->view('template/header', $dt);
		$this->load->view('index', $dt);
		$this->load->view('template/footer', $dt);
	}

	function ipn()
	{
		// Paypal posts the transaction data

		$paypalInfo = $this->input->post();
		if (!empty($paypalInfo)) {
			// Validate and get the ipn response
			$ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

			// Check whether the transaction is valid
			if ($ipnCheck) {
				// Insert the transaction data in the database
				$data['username'] = $_SESSION['username'];
				$data['location'] = $_SESSION['location'];
				$data['product_id'] = $paypalInfo['item_number'];
				$data['txn_id'] = $paypalInfo['txn_id'];
				$data['amount'] = $paypalInfo['mc_gross'];
				$data['currency_code'] = $paypalInfo['mc_currency'];
				$data['email'] = $paypalInfo['payer_email'];
				$data['payment_status'] = $paypalInfo['payment_status'];

				//	$this->product->insertTransaction($data);
			}
		}
	}
}
