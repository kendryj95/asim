<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class LoginModel extends CI_Model
{
    function login($user,$password)
    {
        $this -> db -> select('id, nombre, email,tipo');
        $this -> db -> from('usuarios');
        $this -> db -> where('email', $user);
        $this -> db -> where('password', $password);
        $this -> db -> where('status', '1');
        $this -> db -> limit(1);

        $query = $this -> db -> get();

        if($query -> num_rows() == 1){
            return $query->row();
        }
        else{
            return false;
        }
    }
}
?>