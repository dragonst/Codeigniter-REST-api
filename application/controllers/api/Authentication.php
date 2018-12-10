<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller{

  function __construct()
  {
      // Construct the parent class
      parent::__construct();

      $this->load->library('session');
      $this->load->helper('url');
  }


  public function login()
  {

      /*if($this->input->post('username') == 'admin'&& $this->input->post('password') == '1234')
      {
        $this->session->set_userdata("user_logged", 1);

        //$this->load->helper('url');

        //$this->load->view('rest_server');

      }
      else
      {
         $this->session->set_flashdata('error_msg', '<div class="alert alert-danger text-center">Incorrect e-mail or password.</div>');
        redirect('api/example/login');
      }*/
      if($_POST['data']['username'] == 'admin'&& $_POST['data']['password'] == '1234')
      {
          $this->session->set_userdata("user_logged", 1);
          echo 'logged in';
      }
      else{echo 'error';}
      //var_dump($_POST['data']);
    //$this->load->view('login');
  }


  public function logout()
  {
    $this->session->unset_userdata("user_logged");
    echo 'logged out';

  }


}
