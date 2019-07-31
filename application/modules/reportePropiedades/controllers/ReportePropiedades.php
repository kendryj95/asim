<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ReportePropiedades extends MX_Controller{

    private $user;

    function __construct(){
        parent::__construct();
        $this->load->model('reportePropiedadesModel');
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

            $reporte_propiedades                =  $this->reportePropiedadesModel->obtenerListaDeReporte_propiedades();

            $header['session']                  = $this->user;
            $header['red']                      = $this->generalModel->obtenerMenuRed();
            $data['reporte_propiedades']        = $this->listarReporte_propiedades($reporte_propiedades);

            $this->load->view('include/header',$header);
            $this->load->view('reportePropiedadesView',$data);
            $this->load->view('include/footer');
            $this->load->view('reportePropiedadesScript');
        }
        else
        {
            //If no session, redirect to login page
            redirect(base_url('login'), 'refresh');
        }


    }



     public function procesarNuevoReporte_propiedade(){

        $data = array (
            "fecha_registro"    => formato_fecha_entrada($this->input->post("fecha_registro")),
            "rental"            => $this->input->post("rental"),
            "rol"               => $this->input->post("rol"),
            "fecha_compra"      => formato_fecha_entrada($this->input->post("fecha_compra")),
            "folio"             => $this->input->post("folio"),
            "notaria"           => $this->input->post("notaria"),
            "deuda_uf"          => formato_entrada($this->input->post("deuda_uf")),
            "banco"             => $this->input->post("banco"),
            "dividendo"         => $this->input->post("dividendo"),
            "monto_uf"          => formato_entrada($this->input->post("monto_uf")),
            "fecha_vencimiento"  => formato_fecha_entrada($this->input->post("fecha_vencimiento"))
        );

        $response           =   $this->reportePropiedadesModel->guardarNuevoReporte_propiedade($data);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $reporte_propiedadesDbObject           =   $this->reportePropiedadesModel->obtenerListaDeReporte_propiedades();
            $arrayResponse["reporte_propiedades"]  =   $this->listarReporte_propiedades($reporte_propiedadesDbObject);
        }

        echo json_encode($arrayResponse);

    }

    public function procesarEditarReporte_propiedade() {

        $data = array (
            "fecha_registro"    => formato_fecha_entrada($this->input->post("fecha_registro")),
            "rental"            => $this->input->post("rental"),
            "rol"               => $this->input->post("rol"),
            "fecha_compra"      => formato_fecha_entrada($this->input->post("fecha_compra")),
            "folio"             => $this->input->post("folio"),
            "notaria"           => $this->input->post("notaria"),
            "deuda_uf"          => formato_entrada($this->input->post("deuda_uf")),
            "banco"             => $this->input->post("banco"),
            "dividendo"         => $this->input->post("dividendo"),
            "monto_uf"          => formato_entrada($this->input->post("monto_uf")),
            "fecha_vencimiento"  => formato_fecha_entrada($this->input->post("fecha_vencimiento"))
        );


        $response = $this->reportePropiedadesModel->editarReporte_propiedade($data,$this->input->post('id'));

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $reporte_propiedadesDbObject           =   $this->reportePropiedadesModel->obtenerListaDeReporte_propiedades();
            $arrayResponse["reporte_propiedades"]  =   $this->listarReporte_propiedades($reporte_propiedadesDbObject);
        }

        echo json_encode($arrayResponse);

    }


    public function eliminarReporte_propiedade(){

        $response = $this->reportePropiedadesModel->eliminarReporte_propiedade($this->input->post('id'));


        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $reporte_propiedadesDbObject           =   $this->reportePropiedadesModel->obtenerListaDeReporte_propiedades();
            $arrayResponse["reporte_propiedades"]  =   $this->listarReporte_propiedades($reporte_propiedadesDbObject);
        }

        echo json_encode($arrayResponse);
    }


    private function listarReporte_propiedades($reporte_propiedadesDbResult){

        $table = "<table class='table table-striped table-bordered tabla'>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha Registro</th>
                            <th>Nombre Propiedad</th>
                            <th>Rol</th>
                            <th width='20px'></th>
                        </tr>
                    </thead>
                    <tbody>";

        if($reporte_propiedadesDbResult){
            foreach($reporte_propiedadesDbResult as $row){


                $table .= "<tr>
                            <td>".$row->id."</td>
                            <td>".formato_fecha_salida($row->fecha_registro)."</td>
                            <td>".$row->rental."</td>
                            <td>".$row->rol."</td>";

                $table .= "<td width='20px'>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a title='Ver información completa' href='javascript:void(0)' class='ver-mas'
                                                data-id='".$row->id."'
                                                    data-fecha_registro='".formato_fecha_salida($row->fecha_registro)."'
                                                    data-rental='".$row->rental."'
                                                    data-rol='".$row->rol."'
                                                    data-fecha_compra='".formato_fecha_salida($row->fecha_compra)."'
                                                    data-folio='".$row->folio."'
                                                    data-notaria='".$row->notaria."'
                                                    data-deuda_uf='".formato_salida($row->deuda_uf)."'
                                                    data-banco='".$row->banco."'
                                                    data-dividendo='".$row->dividendo."'
                                                    data-monto_uf='".formato_salida($row->monto_uf)."'
                                                    data-fecha_vencimiento='".formato_fecha_salida($row->fecha_vencimiento)."'>
                                                    <span class='glyphicon glyphicon-search'></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a title='Editar' href='javascript:void(0)' class='edit'
                                                    data-id='".$row->id."'
                                                    data-fecha_registro='".formato_fecha_salida($row->fecha_registro)."'
                                                    data-rental='".$row->rental."'
                                                    data-rol='".$row->rol."'
                                                    data-fecha_compra='".formato_fecha_salida($row->fecha_compra)."'
                                                    data-folio='".$row->folio."'
                                                    data-notaria='".$row->notaria."'
                                                    data-deuda_uf='".formato_salida($row->deuda_uf)."'
                                                    data-banco='".$row->banco."'
                                                    data-dividendo='".$row->dividendo."'
                                                    data-monto_uf='".formato_salida($row->monto_uf)."'
                                                    data-fecha_vencimiento='".formato_fecha_salida($row->fecha_vencimiento)."'>
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