<?php
class Contact extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    // Load form validation library
    $this->load->library('form_validation');

    $this->load->helper(array('email'));
    $this->load->library(array('email'));
  }

  public function index()
  {
    $data = $formData = array();

    // If contact request is submitted
    if ($this->input->post('hidden')) {
      // Get the form data
      $formData = $this->input->post();
      // Form field validation rules
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('subject', 'Subject', 'required');
      $this->form_validation->set_rules('message', 'Message', 'required');

      // Validate submitted form data
      if ($this->form_validation->run() == true) {
        // Define email data
        $mailData = array(
          'name' => $formData['name'],
          'email' => $formData['email'],
          'subject' => $formData['subject'],
          'message' => $formData['message']
        );

        // Send an email to the site admin
        $send = $this->sendEmail($mailData);

        // Check email sending status
        if ($send) {
          // Unset form data
          $formData = array();

          $data['status'] = array(
            'type' => 'success',
            'msg' => 'Your contact request has been submitted successfully.'
          );
        } else {
          $data['status'] = array(
            'type' => 'error',
            'msg' => 'Some problems occured, please try again.'
          );
        }
      }
    }

    // Pass POST data to view
    $data['postData'] = $formData;

    // Pass the data to view
    $data['statue'] = 'contact';
    $this->load->view('template/header', $data);
    $this->load->view('contact', $data);
    $this->load->view('template/footer', $data);
  }

  private function sendEmail($mailData)
  {
    // Load the email library

    $this->load->config('email');
    $config = $this->config->item('email_config');
    $server_email = $this->config->item('server_email');
    $this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->set_mailtype('html');
    $server_email = $this->config->item('server_email');
    // Mail config
    $to = 'support@booktopiabookclub.org';
    $from = $server_email;
    $fromName = $server_email;
    $mailSubject = 'Contact Request Submitted by ' . $mailData['name'];

    // Mail content
    $mailContent = '
            <h2>Contact Request Submitted</h2>
            <p><b>Name: </b>' . $mailData['name'] . '</p>
            <p><b>Email: </b>' . $mailData['email'] . '</p>
            <p><b>Subject: </b>' . $mailData['subject'] . '</p>
            <p><b>Message: </b>' . $mailData['message'] . '</p>
        ';

    $this->email->to($to);
    $this->email->from($from, $fromName);
    $this->email->subject($mailSubject);
    $this->email->message($mailContent);

    // Send email & return status
    return $this->email->send() ? true : false;
  }
}
