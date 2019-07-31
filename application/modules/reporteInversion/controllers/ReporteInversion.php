<?php if(!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class ReporteInversion extends MX_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('reporteInversionModel','model');
        $this->user = $this->session->userdata('logged_in');
        if(! ini_get('date.timezone'))
        {
            date_default_timezone_set('America/Caracas');
        }
    }

    public function index(){

        if($this->session->userdata('logged_in'))
        {

            $idEmpresa          = $this->uri->segment(2);

            if($this->generalModel->tienePermiso($this->user['id'],$this->user['tipo'],$idEmpresa)){
                $empresa            = $this->model->obtenerInfoEmpresa($idEmpresa);

                if($empresa){

                    $data               = array();

                    $yearsDbObject              =   $this->model->obtenerYears();
                    $data['empresa']    = $empresa;
                    $data['registros']  = $this->generarListadoRegistros($idEmpresa);
                    $data['years']              = $this->construirYears($yearsDbObject);

                    $header['session']      = $this->user;
                    $header['red']          = $this->generalModel->obtenerMenuRed();

                    $this->load->view('include/header',$header);
                    $this->load->view('reporteInversionView',$data);
                    $this->load->view('include/footer');
                    $this->load->view('reporteInversionScript');

                }
            }else{
                $this->load->view('errors/prohibido');
            }
        }
        else
        {
            //If no session, redirect to login page
            redirect(base_url('login'), 'refresh');
        }


    }

    public function procesarGuardarComentario(){

        $data =  array(
            'comentario_reporte_inversion' => $this->input->post('texto')
        );

        $response = $this->model->actualizarComentario($data,$this->input->post('id_empresa'));

        $arrayResponse = array('response' => $response);

        echo json_encode($arrayResponse);
    }

    public function procesarGuardarRegistroDeInversion(){

        //primera parte, guardando el registro de inversión

            $dataRI = array(
                'id_empresa' => $this->input->post('idEmpresa'),
                'fecha' => formato_fecha_entrada($this->input->post('fecha1'))
            );

            $idRegistroIversion = $this->model->guardarReporteInversion($dataRI);

        //fin de primera parte

        $data = array();

        for($i = 1; $i <= 3; $i++){

            $data[] = array(
                'id_reporte_inversiones' => $idRegistroIversion,
                'fecha' => formato_fecha_entrada($this->input->post('fecha'.$i)),
                'detalle_glosa' => $this->input->post('detalle_glosa'.$i),
                'monto' => formato_entrada($this->input->post('monto'.$i)),
                'tipo' => $this->input->post('tipo'.$i),
                'orden' => $i
            );

        }


        $response  =   $this->model->guardarRegistroReporteInversion($data);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $arrayResponse["registros"]  =  $this->generarListadoRegistros($this->input->post('idEmpresa'));
        }

        echo json_encode($arrayResponse);
    }

    public function procesarEditarRegistroDeInversion(){

        //primera parte, editando el reporte de inversión

        $dataRI = array(
            'fecha' => formato_fecha_entrada($this->input->post('fecha1'))
        );

        $this->model->actualizarReporteInversion($dataRI,$this->input->post('idReporte'));

        //fin de primera parte

        $data   = array();
        $dataId =  array();

        for($i = 1; $i <= 3; $i++){

            $dataId[] = $this->input->post('id'.$i);

            $data[] = array(
                'fecha' => formato_fecha_entrada($this->input->post('fecha'.$i)),
                'detalle_glosa' => $this->input->post('detalle_glosa'.$i),
                'monto' => formato_entrada($this->input->post('monto'.$i)),
                'tipo' => $this->input->post('tipo'.$i)
            );

        }


        $response  =   $this->model->actualizarRegistroReporteInversion($data,$dataId);

        $arrayResponse = array('response' => $response);

        if($response == "success"){
            $arrayResponse["registros"]  =  $this->generarListadoRegistros($this->input->post('idEmpresa'));
        }

        echo json_encode($arrayResponse);

    }


    public function obtenerDatosRegistroDeInversion(){

        $response = array();

        $registros = $this->model->obtenerRegistrosReporteDeInversion($this->input->post('id'));

        if($registros){
            $response['status'] = 'success';
            $response['registro'] = (array)$registros;

            echo json_encode($response);
        }else{
            $response['status'] = 'failed';
        }
    }

    public function procesarEliminarRegistroDeInversion(){

        $response['response'] = $this->model->eliminarRegistroDeInversion($this->input->post('id'));

        if($response['response'] == 'success'){
            $response["registros"]  =  $this->generarListadoRegistros($this->input->post('idEmpresa'));
        }

        echo json_encode($response);
    }

    public function construirYears($yearsDb){
        $string = '';

        if($yearsDb){
            foreach($yearsDb as $row){

                $selected = ($row->fecha == date('Y')) ? 'selected':'';

                $string .= '<option value="'.$row->fecha.'" '.$selected.'>'.$row->fecha.'</option>';
            }
        }

        return $string;
    }

    public function obtenerAcordeon(){

        $html = $this->generarListadoRegistros($this->input->post('id_empresa'),$this->input->post('year'));

        if($html == ''){
            $html = '<b>No se encontraron registros!</b>';
        }

        $arrayResponse = array('response' => 'success');
        $arrayResponse['registros'] = $html;

        echo json_encode($arrayResponse);

    }


    private function generarListadoRegistros($id_empresa,$year = null){

        $html = '';
        $year = ($year == null) ? date('Y'):$year;


        for($i = 1; $i <= 12 ; $i++){

            $reportes = $this->model->obtenerReportesDeInversion($id_empresa,$i,$year);
            $in = ($i == date('n')) ? ' in':'';
            if($reportes){
                $html .= '<div class="panel panel-default">
                    <div style="background-color: #001F3F;color: white;" class="panel-heading" role="tab" id="heading'.$i.'">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                '.meses_espanol($i).'
                            </a>
                        </h4>
                    </div>
                    <div id="collapse'.$i.'" class="panel-collapse collapse '.$in.'" role="tabpanel" aria-labelledby="heading'.$i.'">
                        <div class="panel-body">
                        <table class="table tabla">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Detalle Glosa</th>
                                    <th>Ingreso</th>
                                    <th>Egreso</th>
                                    <th width="20px"></th>
                                </tr>
                            </thead>
                            <tbody>';

                foreach($reportes as $row){

                    $registros = $this->model->obtenerRegistrosReporteDeInversion($row->id);

                    if($registros){

                        $count = 1;

                        foreach($registros as $row2){

                            $style = ($count == 3) ? "style='border-bottom:solid 5px grey';":'';
                            $fecha = ($row2->fecha != '0000-00-00') ? date('d/m/Y',strtotime($row2->fecha)) : '';

                            $html .= "<tr ".$style.">
                            <td>".$fecha."</td>
                            <td>".$row2->detalle_glosa."</td>";

                            if($row2->tipo == 1){
                                $html .= "<td>".formato_salida($row2->monto)."</td>";
                                $html .= "<td></td>";
                            }else{
                                $html .= "<td></td>";
                                $html .= "<td>".formato_salida($row2->monto)."</td>";
                            }

                            $html .= "</td>
                            <td width='20px'>";

                                if($count == 1){
                                    $html .= "<table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a title='Editar' href='javascript:void(0)' class='edit' data-id='".$row->id."'>
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
                                </table>";
                                }

                            $html .="</td>
                            </tr>";

                            $count++;
                        }

                    }

                }


            $html .= ' </tbody>
                        </table>
                    </div>
                    </div>
                </div>';
            }
        }

        return $html;
    }

} 