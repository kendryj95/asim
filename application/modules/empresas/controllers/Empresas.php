<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Empresas extends MX_Controller{

    private $user;

    function __construct(){
        parent::__construct();
        $this->load->model('empresasModel');
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

            $empresas           =  $this->empresasModel->obtenerListaDeEmpresas();

            $header['session']      = $this->user;
            $header['red']              = $this->generalModel->obtenerMenuRed();
            $data['empresas']   = $this->listarEmpresas($empresas);

            $this->load->view('include/header',$header);
            $this->load->view('empresasView',$data);
            $this->load->view('include/footer');
            $this->load->view('empresasScript');
        }
        else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    }



     public function procesarNuevoEmpresa(){

         $data = array (
             "empresa" => $this->input->post('empresa'),
             "participacion" => $this->input->post('participacion'),
             "inversor" => $this->input->post('inversor'),
             "comentario_reporte_empresa" => $this->input->post('comentario_reporte_empresa'),
             "comentario_reporte_inversion" => $this->input->post('comentario_reporte_inversion'),
             "ghost" => $this->input->post('ghost'),
             "parent_id" => $this->input->post('parent_id')
         );

        $response           =   $this->empresasModel->guardarNuevoEmpresa($data);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $empresasDbObject           =   $this->empresasModel->obtenerListaDeEmpresas();
            $arrayResponse["empresas"]  =   $this->listarEmpresas($empresasDbObject);
            $arrayResponse['red']       =   $this->generalModel->obtenerMenuRed();
        }

        echo json_encode($arrayResponse);

    }

    public function procesarEditarEmpresa() {

        $data = array (
            "empresa" => $this->input->post('empresa'),
            "participacion" => $this->input->post('participacion'),
            "inversor" => $this->input->post('inversor'),
            "comentario_reporte_empresa" => $this->input->post('comentario_reporte_empresa'),
            "comentario_reporte_inversion" => $this->input->post('comentario_reporte_inversion'),
            "ghost" => $this->input->post('ghost'),
             "parent_id" => $this->input->post('parent_id')
        );


        $response = $this->empresasModel->editarEmpresa($data,$this->input->post('id'));


        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $empresasDbObject           =   $this->empresasModel->obtenerListaDeEmpresas();
            $arrayResponse["empresas"]  =   $this->listarEmpresas($empresasDbObject);
            $arrayResponse['red']       =   $this->generalModel->obtenerMenuRed();
        }

        echo json_encode($arrayResponse);

    }

    public function eliminarEmpresa(){

        $response = $this->empresasModel->eliminarEmpresa($this->input->post('id'));


        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $empresasDbObject           =   $this->empresasModel->obtenerListaDeEmpresas();
            $arrayResponse["empresas"]  =   $this->listarEmpresas($empresasDbObject);
            $arrayResponse['red']       =   $this->generalModel->obtenerMenuRed();
        }

        echo json_encode($arrayResponse);
    }


    private function listarEmpresas($empresasDbResult){

        $table = "<table class='table table-bordered table-striped tabla'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Participación</th>
                            <th>Inversión</th>
                            <th>Comentario Reporte de Empresa</th>
                            <th>Comentario Reporte de Inversión</th>
                            <th width='20px'></th>
                        </tr>
                    </thead>
                    <tbody>";

        if($empresasDbResult){
            foreach($empresasDbResult as $row){

                $inversor = ($row->inversor) ? 'Si':'No';

                $table .= "<tr>
                            <td>".$row->id."</td>
                            <td>".$row->empresa."</td>
                            <td>".$row->participacion."</td>
                            <td>".$inversor."</td>
                            <td>".substr($row->comentario_reporte_empresa,0,120)."...</td>
                            <td>".substr($row->comentario_reporte_inversion,0,120)."...</td>
                            <td width='20px'>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a title='Editar' href='javascript:void(0)' class='edit'
                                                    data-id='".$row->id."'
                                                    data-empresa='".$row->empresa."'
                                                    data-participacion='".$row->participacion."'
                                                    data-inversor='".$row->inversor."'
                                                    data-ghost='".$row->ghost."'
                                                    data-parent_id='".$row->parent_id."'
                                                    data-comentario_reporte_empresa='".$row->comentario_reporte_empresa."'
                                                    data-comentario_reporte_inversion='".$row->comentario_reporte_inversion."'>
                                                    <span class='glyphicon glyphicon-edit '></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a title='Eliminar' href='javascript:void(0)' class='eliminar' data-id='".$row->id."'>
                                                    <span class='glyphicon glyphicon-remove '></span>
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


    public function crearTodosLosRegistros(){

        $this->empresasModel->crearTodos();
    }


    public function obtenerDatosNuevoRegistro(){

        $arrayResponse =  array();

        $arrayResponse['empresas'] = (array)$this->empresasModel->obtenerListaDeEmpresas();

        echo json_encode($arrayResponse);
    }

} 