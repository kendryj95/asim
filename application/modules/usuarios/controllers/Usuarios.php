<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MX_Controller{

    private $user;

    function __construct(){
        parent::__construct();
        $this->load->model('usuariosModel');
        $this->user = $this->session->userdata('logged_in');
        if(! ini_get('date.timezone'))
        {
            date_default_timezone_set('America/Caracas');
        }
    }

    public function index()
    {
        if($this->session->userdata('logged_in'))
        {

            $usuarios               =  $this->usuariosModel->obtenerListaDeUsuarios();

            $header['session']      = $this->user;
            $header['red']          = $this->generalModel->obtenerMenuRed();
            $data['usuarios']       = $this->listarUsuarios($usuarios);

            $this->load->view('include/header',$header);
            $this->load->view('usuariosView',$data);
            $this->load->view('include/footer');
            $this->load->view('usuariosScript');
        }
        else
        {
            //If no session, redirect to login page
            redirect(base_url('login'), 'refresh');
        }


    }



     public function procesarNuevoUsuario(){

        $data = array (
            "nombre"        => $this->input->post('nombre'),
            "email"         => $this->input->post('email'),
            "password"      => $this->input->post('password'),
            "tipo"      => $this->input->post('tipo')
        );

        $response           =   $this->usuariosModel->guardarNuevoUsuario($data);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $usuariosDbObject           =   $this->usuariosModel->obtenerListaDeUsuarios();
            $arrayResponse["usuarios"]  =   $this->listarUsuarios($usuariosDbObject);
        }

        echo json_encode($arrayResponse);

    }

    public function procesarEditarUsuario() {

        $data = array (
            "nombre" => $this->input->post('nombre'),
            "email" => $this->input->post('email'),
            "tipo" => $this->input->post('tipo')
        );

        if($this->input->post('password') != "")
        {
            $data['password'] = $this->input->post('password');
        }

        $response = $this->usuariosModel->editarUsuario($data,$this->input->post('id'));


        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $usuariosDbObject           =   $this->usuariosModel->obtenerListaDeUsuarios();
            $arrayResponse["usuarios"]  =   $this->listarUsuarios($usuariosDbObject);
        }

        echo json_encode($arrayResponse);

    }


    public function eliminarUsuario(){

        $response = $this->usuariosModel->eliminarUsuario($this->input->post('id'));


        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $usuariosDbObject           =   $this->usuariosModel->obtenerListaDeUsuarios();
            $arrayResponse["usuarios"]  =   $this->listarUsuarios($usuariosDbObject);
        }

        echo json_encode($arrayResponse);
    }

    // listado de permisos, aqui se usa la función para ver las empresas asignadas

    public function obtenerListadoPermisos(){

        $response = $this->obtenerEmpresasAsigDis($this->input->post('id'));
        echo json_encode($response);
    }

    // función que extrae las empresas asignadas a un usuario

    private function obtenerEmpresasAsigDis($id){
        $response = array();

        $response['empresas'] = $this->usuariosModel->obtenerEmpresasDisponibles($id);
        $response['empresasAsignadas'] = $this->usuariosModel->obtenerEmpresasAsignadas($id);

        return $response;
    }

    public function  procesarAsignadoDeEmpresa(){

        $idUsuario = $this->user['id'];
        $idEmpresa = $this->input->post('empresas_disponibles');

        $this->usuariosModel->guardarUsuarioEmpresa($idUsuario,$idEmpresa);

    }



    public function procesarGuardarEmpresaAsignada(){

        $data = array(
            'id_empresa' => $this->input->post('empresas_disponibles'),
            'id_user' => $this->input->post('id_user')
        );


        $response  = $this->usuariosModel->guardarPermisos($data);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $usuariosDbObject           =   $this->usuariosModel->obtenerListaDeUsuarios();
            $arrayResponse["usuarios"]  =   $this->listarUsuarios($usuariosDbObject);
            $arrayResponse['empresas'] = $this->usuariosModel->obtenerEmpresasDisponibles($this->input->post('id_user'));
            $arrayResponse['empresasAsignadas'] = $this->usuariosModel->obtenerEmpresasAsignadas($this->input->post('id_user'));

        }

        echo json_encode($arrayResponse);

    }

    public function procesarEliminarPermisosAsignados(){


        $id_empresa     = $this->input->post('id_empresa');
        $id_user        = $this->input->post('id_user');

        $response = $this->usuariosModel->eliminarPermisos($id_empresa,$id_user);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $usuariosDbObject           =   $this->usuariosModel->obtenerListaDeUsuarios();
            $arrayResponse["usuarios"]  =   $this->listarUsuarios($usuariosDbObject);
        }

        echo json_encode($arrayResponse);
    }


    private function listarUsuarios($usuariosDbResult){

        $table = "<table class='table table-bordered table-striped tabla'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Permisos</th>
                            <th width='20px'></th>
                        </tr>
                    </thead>
                    <tbody>";

        if($usuariosDbResult){
            foreach($usuariosDbResult as $row){

                $asignadas = $this->usuariosModel->obtenerEmpresasAsignadas($row->id);

                $tipo = ($row->tipo == '1') ? 'Gerente/ administrador':'Usuario/ digitador';

                $table .= "<tr>
                            <td>".$row->id."</td>
                            <td>".$row->nombre."</td>
                            <td>".$row->email."</td>
                            <td>".$tipo."</td>
                            <td>";
                            if($asignadas != false){

                                foreach($asignadas as $asignado){

                                    $table .= ' <span class="badge badge-light">'.$asignado['empresa'].'<a href="javascript:void(0)" class="quitar-permisos" data-id_empresa="'.$asignado['id'].'" data-id_user="'.$row->id.'"> <span style="color:white;" class="glyphicon glyphicon-remove"></span> </a></span> ';

                                }

                            }else{
                                $table .= 'No hay empresas asignadas';
                            }

                $table .= "</td>
                            <td width='20px'>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a title='Asignar Permisos de Empresas' href='javascript:void(0)' class='asignar' data-id='".$row->id."'>
                                                    <span class='glyphicon glyphicon-cog'></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a title='Editar' href='javascript:void(0)' class='edit' data-id='".$row->id."' data-nombre='".$row->nombre."' data-email='".$row->email."' data-tipo='".$row->tipo."'>
                                                    <span class='glyphicon glyphicon-edit '></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a title='Eliminar' href='javascript:void(0)' class='eliminar' data-id='".$row->id."'>
                                                    <span class='glyphicon glyphicon-remove' ></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            </tr>";
            }
        }

        $table .= "</tbody>
                    </table>";


        return $table;
    }



} 