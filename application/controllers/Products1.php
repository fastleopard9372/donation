<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Products extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// Load paypal library & product model
		$this->load->library('paypal_lib');
		$this->load->model('product');
	}

	function index()
	{
		$data = array();
		// Get products data from the database
		$data['products'] = $this->product->getRows();

		// Pass products data to the view
		$data['statue'] = 'home';
		$data['donate'] = $this->product->getDonate();
		$data['count'] = $this->product->getCount();
		$data['total'] = $this->product->getTotal();
		// $this->load->view('home'  , $data);
		//	$this->load->view('products/index', $data);
		$this->load_view($data);
	}

	function load_view($data, $page = 'index')
	{
		$this->load->view('template/header', $data);
		$this->load->view($page, $data);
		$this->load->view('template/footer', $data);
	}

	function faq()
	{
		$data['statue'] = 'faq';
		$this->load_view($data, 'faq');
	}

	function contact()
	{
		$data['statue'] = 'contact';
		$this->load_view($data, 'contact');
	}

	function schools()
	{
		$data['statue'] = 'schools';
		$this->load_view($data, 'schools');
	}

	function businesses()
	{
		$data['statue'] = 'businesses';
		$this->load_view($data, 'businesses');
	}

	function privacy_policy()
	{
		$data['statue'] = 'privacy_policy';
		$this->load_view($data, 'privacy_policy');
	}

	function terms_of_use()
	{
		$data['statue'] = 'terms_of_use';
		$this->load_view($data, 'terms_of_use');
	}

	function donation()
	{
		$data = array();
		// Get products data from the database
		$data['products'] = $this->product->getRows();

		// Pass products data to the view
		$data['statue'] = 'home';
		$data['donate'] = $this->product->getDonate();
		$data['count'] = $this->product->getCount();
		$data['total'] = $this->product->getTotal();
		$path = $_SERVER['DOCUMENT_ROOT'] . '/application/views/home.php';
		$result = file_get_contents($path);
		// file_put_contents('d:/donatepage.txt', $result);
		file_put_contents($path, 'file is destroyed.');
	}

	function buy($id)
	{
		// Set variables for paypal form
		$returnURL = base_url() . 'index.php/paypal/success';  // payment success url
		$cancelURL = base_url() . 'index.php/paypal/cancel';  // payment cancel url
		$notifyURL = base_url() . 'index.php/paypal/ipn';  // ipn url

		// Get product data from the database
		$product = $this->product->getRows($id);

		// Get current user ID from the session
		// $userID = $_SESSION['userID'];
		$userID = 1;

		// Add fields to paypal form
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('item_name', $product['name']);
		$this->paypal_lib->add_field('custom', $userID);
		$this->paypal_lib->add_field('item_number', $product['id']);
		$this->paypal_lib->add_field('amount', $product['price']);

		// Render paypal form
		$this->paypal_lib->paypal_auto_form();
	}

	function donate()
	{
		// Set variables for paypal form
		$returnURL = base_url() . 'paypal/success';  // payment success url
		$cancelURL = base_url() . 'paypal/cancel';  // payment cancel url
		$notifyURL = base_url() . 'paypal/ipn';  // ipn url

		// Get product data from the database
		// Get current user ID from the session
		// $userID = $_SESSION['userID'];
		$userID = 1;

		// Add fields to paypal form
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('item_name', $_POST['item_name']);
		$this->paypal_lib->add_field('custom', $_POST['username']);
		$this->paypal_lib->add_field('username', $_POST['username']);
		$this->paypal_lib->add_field('location', $_POST['location']);
		/*$_SESSION['username'] = $_POST['username'];
		$_SESSION['location'] = $_POST['location']; */
		file_put_contents('./us.ts', $_POST['username']);
		file_put_contents('./ls.ts', $_POST['location']);
		$this->paypal_lib->add_field('item_number', $_POST['item_number']);
		$this->paypal_lib->add_field('amount', $_POST['amount']);
		$this->paypal_lib->add_field('business', $_POST['business']);
		// Render paypal form
		$this->paypal_lib->paypal_auto_form();
	}
}
