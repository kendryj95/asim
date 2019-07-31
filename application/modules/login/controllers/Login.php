<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('loginModel');
    }

    public function index()
    {
        if($this->session->userdata('logged_in')){
            redirect(base_url('dashboard/'));
        }else{
            $this->load->view('loginView');
        }
    }


    public function authUser(){

        $username = $this->input->post('user');
        $password = $this->input->post('pass');

        echo json_encode($this->checkDatabase($username,$password));

    }


    private function checkDatabase($user = null,$password = null)
    {

        $row = $this->loginModel->login($user,$password);

        if($row)
        {

            $sess_array = array(
                'id'        => $row->id,
                'nombre'      => $row->nombre,
                'email'     => $row->email,
                'tipo'     => $row->tipo
            );

            $this->session->set_userdata('logged_in', $sess_array);

            return array(
                'status' => 'success'
            );
        }
        else
        {
            return array(
                'status' => 'failed',
                'reason'=> 'User not found'
            );
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url(),'refresh');

    }
}

?>
