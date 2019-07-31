<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class ReporteEmpresa extends MX_Controller{



    function __construct(){

        $this->load->model('reporteEmpresaModel','model');

        $this->user = $this->session->userdata('logged_in');

        if(! ini_get('date.timezone'))

        {

            date_default_timezone_set('America/Caracas');

        }

    }





    public function index(){



        if($this->user)

        {

            $idEmpresa                  = $this->uri->segment(2);



            if($this->generalModel->tienePermiso($this->user['id'],$this->user['tipo'],$idEmpresa)){

                $data = array();





                $empresas                   = $this->model->obtenerEmpresasNoInversoras();

                $cajasDbObject              =   $this->model->obtenerListaDeCajas($idEmpresa);

                $favoresDbObject            =   $this->model->obtenerListaDeFavores($idEmpresa);

                $contrasDbObject            =   $this->model->obtenerListaDeContras($idEmpresa);

                $balanceDbObject            =   $this->model->obtenerBalances($idEmpresa);

                $yearsDbObject              =   $this->model->obtenerYears();



                $header['session']          = $this->user;

                $data['session']            = $this->user;

                $header['red']              = $this->generalModel->obtenerMenuRed();

                $data['empresa']            = $this->model->obtenerEmpresas($idEmpresa);

                $data['listadoEmpresas']    = $this->listarEmpresas($empresas);

                $data['reporteEmpresas']    = $this->generarListadoRegistros($idEmpresa);

                $data['years']              = $this->construirYears($yearsDbObject);

                // cajas



                $data["cajas"]              =   $this->listarCajas($cajasDbObject);

                $data["favores"]              =   $this->listarFavores($favoresDbObject);

                $data["contras"]              =   $this->listarContras($contrasDbObject);

                $data['balance']                = $this->listarBalances($balanceDbObject);



                $this->load->view('include/header',$header);

                $this->load->view('reporteEmpresaView',$data);

                $this->load->view('modales',$data);

                $this->load->view('modalesCajas',$data);

                $this->load->view('modalesFavores',$data);

                $this->load->view('modalesContra',$data);

                $this->load->view('include/footer');

                $this->load->view('reporteEmpresaScript');

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

            'comentario_reporte_empresa' => $this->input->post('texto')

        );



        $response = $this->model->actualizarComentario($data,$this->input->post('id_empresa'));



        $arrayResponse = array('response' => $response);



        echo json_encode($arrayResponse);

    }



    public function procesarEditarBalanceGeneral(){



        $data = array(

            'activo_fecha' => formato_fecha_entrada($this->input->post('activo_fecha')),

            'activo_saldo' => formato_entrada($this->input->post('activo_saldo')),

            'pasivo_patrimonio_fecha' => formato_fecha_entrada($this->input->post('pasivo_patrimonio_fecha')),

            'pasivo_patrimonio_saldo' => formato_entrada($this->input->post('pasivo_patrimonio_saldo')),

            'resultado_perdida_fecha' => formato_fecha_entrada($this->input->post('resultado_perdida_fecha')),

            'resultado_perdida_saldo' => formato_entrada($this->input->post('resultado_perdida_saldo')),

            'resultado_ganancia_fecha' => formato_fecha_entrada($this->input->post('resultado_ganancia_fecha')),

            'resultado_ganancia_saldo' => formato_entrada($this->input->post('resultado_ganancia_saldo')),

            'utilidad_fecha' => formato_fecha_entrada($this->input->post('utilidad_fecha'))

        );





        $response  =   $this->model->actualizarRegistroDeBalanceGeneral($data,$this->input->post('id'));



        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $balanceDbObject            =   $this->model->obtenerBalances($this->input->post('id_empresa'));

            $arrayResponse["registros"]  =  $this->listarBalances($balanceDbObject);

        }



        echo json_encode($arrayResponse);

    }



    private function listarBalances($balances){



        $table = "<table class='table'>

                    <thead>

                        <tr>

                            <th>Balance General</th>

                            <th>Fecha Cierre</th>

                            <th>Saldo Final</th>

                            <th width='20px'></th>

                        </tr>

                    </thead>

                    <tbody>";



        if($balances){



             $table .= "<tr>

                            <td>ACTIVOS</td>

                            <td>".formato_fecha_salida($balances->activo_fecha)."</td>

                            <td>".formato_salida($balances->activo_saldo)."</td>

                            <td width='20px'>

                                <table>

                                    <tbody>

                                        <tr>

                                            <td>

                                                <a title='Editar' href='javascript:void(0)' class='edit-balance-general'

                                                    data-id='".$balances->id."'

                                                    data-id_empresa='".$balances->id_empresa."'

                                                    data-activo_fecha='".$balances->activo_fecha."'

                                                    data-activo_saldo='".formato_salida($balances->activo_saldo)."'

                                                    data-pasivo_patrimonio_fecha='".$balances->pasivo_patrimonio_fecha."'

                                                    data-pasivo_patrimonio_saldo='".formato_salida($balances->pasivo_patrimonio_saldo)."'

                                                    data-resultado_perdida_fecha='".$balances->resultado_perdida_fecha."'

                                                    data-resultado_perdida_saldo='".formato_salida($balances->resultado_perdida_saldo)."'

                                                    data-resultado_ganancia_fecha='".$balances->resultado_ganancia_fecha."'

                                                    data-resultado_ganancia_saldo='".formato_salida($balances->resultado_ganancia_saldo)."'

                                                    data-utilidad_fecha='".$balances->utilidad_fecha."'>

                                                    <span class='glyphicon glyphicon-edit '></span>

                                                </a>

                                            </td>

                                         </tr>



                                    </tbody>

                                </table>

                            </td>

                            </tr>";



            $table .= "<tr>

                            <td>PASIVOS + PATRIMONIO</td>

                            <td>".formato_fecha_salida($balances->pasivo_patrimonio_fecha)."</td>

                            <td>".formato_salida($balances->pasivo_patrimonio_saldo)."</td>

                            <td width='20px'></td>

                            </tr>";



            $table .= "<tr>

                            <td>RESULTADO PERDIDA</td>

                            <td>".formato_fecha_salida($balances->resultado_perdida_fecha)."</td>

                            <td>".formato_salida($balances->resultado_perdida_saldo)."</td>

                            <td width='20px'></td>

                            </tr>";

            $table .= "<tr>

                            <td>RESULTADO GANANCIA</td>

                            <td>".formato_fecha_salida($balances->resultado_ganancia_fecha)."</td>

                            <td>".formato_salida($balances->resultado_ganancia_saldo)."</td>

                            <td width='20px'></td>

                            </tr>";



            $total_w = $balances->resultado_ganancia_saldo + $balances->resultado_perdida_saldo;



            $total_w = (string)$total_w;



            $table .= "<tr>

                            <td>UTILIDAD</td>

                            <td>".formato_fecha_salida($balances->utilidad_fecha)."</td>

                            <td>".formato_salida($total_w)."</td>

                            <td width='20px'></td>

                        </tr>";





                    }



        $table .= "</tbody>

                    </table>";





        return $table;





    }





    /* *****************************************************************************************************************

    *******************************************************************************************************************

     * ***************************************************************************************************************

     * *****************************transacciones y comprimisos ******************************************************

     * ****************************************************************************************************************

     * ****************************************************************************************************************

     * *****************************************************************************************************************

     * *************************************************************************************************************** */





    private function listarEmpresas($empresas){



        $html = '<option value="X"> TERCEROS.. </option>';



        if($empresas){



            foreach($empresas as $row){



                $html .= '<option value="'.$row->id.'">'.$row->empresa.'</option>';

            }

        }



        return $html;

    }



    public function procesarGuardarRegistroDeEmpresa(){





        $dataA = array(

            'id_empresa' => $this->input->post('id_empresa'),

            'descripcion' => $this->input->post('descripcion'),

            'origen' => $this->input->post('origen'),

            'destino' => $this->input->post('destino'),

            'monto' => formato_entrada($this->input->post('monto')),

            'fecha_realizacion' => formato_fecha_entrada($this->input->post('fecha-realizacion')),

            'fecha_limite' => formato_fecha_entrada($this->input->post('fecha-limite'))

        );







        $desc = $this->input->post('descripcion');



        switch($desc){

            case '1':

                $desc = '2';

                $id_empresa = $this->input->post('origen');

                break;

            case '2':

                $desc = '1';

                $id_empresa = $this->input->post('destino');

                break;

            case '3':

                $desc = '4';

                $id_empresa = $this->input->post('origen');

                break;

            case '4';

                $desc = '3';

                $id_empresa = $this->input->post('destino');

                break;

        }



        $dataB = array(

            'id_empresa' => $id_empresa,

            'descripcion' => $desc,

            'origen' => $this->input->post('origen'),

            'destino' => $this->input->post('destino'),

            'monto' => formato_entrada($this->input->post('monto')),

            'fecha_realizacion' => formato_fecha_entrada($this->input->post('fecha-realizacion')),

            'fecha_limite' => formato_fecha_entrada($this->input->post('fecha-limite'))

        );





        $response  =   $this->model->guardarPares($dataA,$dataB);



        $arrayResponse = array('response' => $response);





        if($response == "success"){

            $arrayResponse["registros"]  =  $this->generarListadoRegistros($this->input->post('id_empresa'));

        }



        echo json_encode($arrayResponse);



    }



    public function procesarEditarRegistroDeEmpresa(){



        $data = array(

            'monto' => formato_entrada($this->input->post('monto')),

            'fecha_realizacion' => formato_fecha_entrada($this->input->post('fecha-realizacion')),

            'fecha_limite' => formato_fecha_entrada($this->input->post('fecha-limite'))

        );



        $idA = $this->input->post('id');

        $idB = $this->input->post('par_id');





        $response  =   $this->model->actualizarRegistroDeEmpresa($data,$idA,$idB);



        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $arrayResponse["registros"]  =  $this->generarListadoRegistros($this->input->post('id_empresa'));

        }



        echo json_encode($arrayResponse);

    }



    public function procesarEliminarRegistroDeEmpresa(){



        $response['response'] = $this->model->eliminarRegistroDeEmpresa($this->input->post('id'),$this->input->post('idPar'));



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



    // LISTAR REGISTRO DE TRANSACCIONES Y COMPROMISOS



    private function generarListadoRegistros($id_empresa, $year = null){



        $html = '';

        $year = ($year == null) ? date('Y'):$year;





        for($i = 1; $i <= 12 ; $i++){



            $reportes = $this->model->obtenerReportesDeEmpresa($id_empresa,$i,$year);



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

                    <div id="collapse'.$i.'" class="panel-collapse collapse'.$in.'" role="tabpanel" aria-labelledby="heading'.$i.'">

                        <div class="panel-body">

                        <table class="table tabla">

                            <thead>

                                <tr>

                                    <th>Descripción</th>

                                    <th>Origen</th>

                                    <th>Destino</th>

                                    <th>Monto</th>

                                    <th>Fecha Realización</th>

                                    <th>Fecha Limite</th>

                                    <th>Alarma (Días Limite)</th>

                                    <th width="20px"></th>

                                </tr>

                            </thead>

                            <tbody>';



                            foreach($reportes as $row){



                                switch($row->descripcion){

                                    case '1':

                                        $descripcion = "Ingreso";

                                        break;

                                    case '2':

                                        $descripcion = "Egreso";

                                        break;

                                    case '3':

                                        $descripcion = "Devolución Préstamo";

                                        break;

                                    case '4':

                                        $descripcion = "Préstamo";

                                        break;

                                }



                                $fechaLimite = '';

                                $alarma = '';

                                $td = '';



                                // aqui se genera el <td> de la alarma donde primero se revisa si es una fecha nula, luego convertir la fecha

                                // en un formato latino para mostrarlo

                                // y dependiendo de la resta entre la fecha limite y el dia presete, se colocan los colores.



                                if($row->descripcion == '3' || $row->descripcion == '4'){



                                    $fechaLimite = ($row->fecha_limite == '0000-00-00') ? '':date('d/m/Y',strtotime($row->fecha_limite));

                                    $alarma = floor((strtotime($row->fecha_limite) - strtotime(date('Y/m/d'))) / (60 * 60 * 24)); ;



                                    if($alarma > 45){

                                        $td = '<td class="text-center" style="background-color: #49E83E;color: #ffffff">'.$alarma.'</td>';

                                    }

                                    if($alarma >= 20 && $alarma <= 45){

                                        $td = '<td class="text-center" style="background-color: #FFD432;color: #000000">'.$alarma.'</td>';

                                    }

                                    if($alarma < 20){

                                        $td = '<td class="text-center" style="background-color: #E84B30;color: #ffffff">'.$alarma.'</td>';

                                    }



                                }else{

                                    $td = '<td></td>';

                                }





                                $html .= '<tr>

                                            <td>'.$descripcion.'</td>

                                            <td>'.$this->model->obtenerNombreEmpresa($row->origen).'</td>

                                            <td>'.$this->model->obtenerNombreEmpresa($row->destino).'</td>

                                            <td>'.formato_salida($row->monto).'</td>

                                            <td>'.date('d/m/Y',strtotime($row->fecha_realizacion)).'</td>

                                            <td>'.$fechaLimite.'</td>

                                            '.$td.'

                                            <td>

                                                <table>

                                                    <tbody>

                                                        <tr>

                                                            <td>

                                                                <a title="Editar" href="javascript:void(0)" class="edit"

                                                                    data-id="'.$row->id.'"

                                                                    data-registro_transaccion="'.$row->registro_transaccion.'"

                                                                    data-origen="'.$this->model->obtenerNombreEmpresa($row->origen).'"

                                                                    data-destino="'.$this->model->obtenerNombreEmpresa($row->destino).'"

                                                                    data-monto="'.formato_salida($row->monto).'"

                                                                    data-descripcion="'.$descripcion.'"

                                                                    data-descripcion_id="'.$row->descripcion.'"

                                                                    data-fecha_realizacion="'.$row->fecha_realizacion.'"

                                                                    data-fecha_limite="'.$row->fecha_limite.'"

                                                                    data-pares="'.$row->pares.'" >

                                                                    <span class="glyphicon glyphicon-edit "></span>

                                                                </a>

                                                            </td>

                                                            <td>

                                                                <a title="Eliminar" href="javascript:void(0)" class="eliminar" data-id="'.$row->id.'" data-pares="'.$row->pares.'">

                                                                    <span class="glyphicon glyphicon-remove" ></span>

                                                                </a>

                                                            </td>

                                                        </tr>

                                                    </tbody>

                                                </table>

                                            </td>

                                          </tr>';



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





    /* *****************************************************************************************************************

    *******************************************************************************************************************

     * ***************************************************************************************************************

     * ***************************************CAJAS**************************************************

     * ****************************************************************************************************************

     * ****************************************************************************************************************

     * *****************************************************************************************************************

     * *************************************************************************************************************** */



    public function procesarGuardarCaja(){



        $data = array (

            "caja"                  => $this->input->post('caja'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "id_empresa"            => $this->input->post('id_empresa'),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );



        $response           =   $this->model->guardarNuevoCaja($data);



        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $cajasDbObject           =   $this->model->obtenerListaDeCajas($this->input->post('id_empresa'));

            $arrayResponse["cajas"]  =   $this->listarCajas($cajasDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function procesarEditarCaja() {



        $data = array (

            "caja"                  => $this->input->post('caja'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );





        $response = $this->model->editarCaja($data,$this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $cajasDbObject           =   $this->model->obtenerListaDeCajas($this->input->post('id_empresa'));

            $arrayResponse["cajas"]  =   $this->listarCajas($cajasDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function eliminarCaja(){



        $response = $this->model->eliminarCaja($this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $cajasDbObject           =   $this->model->obtenerListaDeCajas($this->input->post('id_empresa'));

            $arrayResponse["cajas"]  =   $this->listarCajas($cajasDbObject);

        }



        echo json_encode($arrayResponse);

    }



    private function listarCajas($cajasDbResult){



        $table = "<table class='table'>

                    <thead>

                        <tr>

                            <th>Caja</th>

                            <th>Fecha Emisión</th>

                            <th>Saldo</th>

                            <th width='20px'></th>

                        </tr>

                    </thead>

                    <tbody>";



        if($cajasDbResult){

            foreach($cajasDbResult as $row){





                $table .= "<tr>

                            <td>".$row->caja."</td>

                            <td>".date('d/m/Y',strtotime($row->fecha_emision))."</td>

                            <td>".formato_salida($row->saldo)."</td>

                            <td width='20px'>

                                <table>

                                    <tbody>

                                        <tr>

                                            <td>

                                                <a title='Editar' href='javascript:void(0)' class='edit-caja' data-id='".$row->id."' data-caja='".$row->caja."' data-fecha_emision='".$row->fecha_emision."' data-saldo='".formato_salida($row->saldo)."'>

                                                    <span class='glyphicon glyphicon-edit '></span>

                                                </a>

                                            </td>

                                            <td>

                                            <a title='Eliminar' href='javascript:void(0)' class='eliminar-caja' data-id='".$row->id."' data-id_empresa='".$row->id_empresa."'>

                                                <span class='glyphicon glyphicon-remove' ></span>

                                            </a>

                                        </td>                                        </tr>



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



    /* *****************************************************************************************************************

   *******************************************************************************************************************

    * ***************************************************************************************************************

    * ****************************************************************************************************************

    * *****************************************FAVORES*******************************************************

    * ****************************************************************************************************************

    * *****************************************************************************************************************

    * *************************************************************************************************************** */





    public function procesarGuardarFavor(){



        $data = array (

            "favor"                  => $this->input->post('favor'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "id_empresa"            => $this->input->post('id_empresa'),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );



        $response           =   $this->model->guardarNuevoFavor($data);



        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $favoresDbObject           =   $this->model->obtenerListaDeFavores($this->input->post('id_empresa'));

            $arrayResponse["favores"]  =   $this->listarFavores($favoresDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function procesarEditarFavor() {



        $data = array (

            "favor"                  => $this->input->post('favor'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );





        $response = $this->model->editarFavor($data,$this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $favoresDbObject           =   $this->model->obtenerListaDeFavores($this->input->post('id_empresa'));

            $arrayResponse["favores"]  =   $this->listarFavores($favoresDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function eliminarFavor(){



        $response = $this->model->eliminarFavor($this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $favoresDbObject           =   $this->model->obtenerListaDeFavores($this->input->post('id_empresa'));

            $arrayResponse["favores"]  =   $this->listarFavores($favoresDbObject);

        }



        echo json_encode($arrayResponse);

    }



    private function listarFavores($favoresDbResult){



        $table = "<table class='table'>

    <thead>

    <tr>

        <th>Favor </th>

        <th>Fecha Emisión</th>

        <th>Saldo</th>

        <th width='20px'></th>

    </tr>

    </thead>

    <tbody>";



        if($favoresDbResult){

            foreach($favoresDbResult as $row){





                $table .= "<tr>

        <td>".$row->favor."</td>

        <td>".date('d/m/Y',strtotime($row->fecha_emision))."</td>

        <td>".formato_salida($row->saldo)."</td>

        <td width='20px'>

            <table>

                <tbody>

                <tr>

                    <td>

                        <a title='Editar' href='javascript:void(0)' class='edit-favor' data-id='".$row->id."' data-favor='".$row->favor."' data-fecha_emision='".$row->fecha_emision."' data-saldo='".formato_salida($row->saldo)."'>

                            <span class='glyphicon glyphicon-edit '></span>

                        </a>

                    </td>

                    <td>

                        <a title='Eliminar' href='javascript:void(0)' class='eliminar-favor' data-id='".$row->id."' data-id_empresa='".$row->id_empresa."'>

                            <span class='glyphicon glyphicon-remove' ></span>

                        </a>

                    </td>                                        </tr>



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





    /* *****************************************************************************************************************

   *******************************************************************************************************************

    * ***************************************************************************************************************

    * ****************************************************************************************************************

    * ***************************************** CONTRAS  *******************************************************

    * ****************************************************************************************************************

    * *****************************************************************************************************************

    * *************************************************************************************************************** */







    public function procesarGuardarContra(){



        $data = array (

            "contra"                => $this->input->post('contra'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "id_empresa"            => $this->input->post('id_empresa'),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );



        $response           =   $this->model->guardarNuevoContra($data);



        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $contrasDbObject           =   $this->model->obtenerListaDeContras($this->input->post('id_empresa'));

            $arrayResponse["contras"]  =   $this->listarContras($contrasDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function procesarEditarContra() {



        $data = array (

            "contra"                  => $this->input->post('contra'),

            "fecha_emision"         => formato_fecha_entrada($this->input->post('fecha_emision')),

            "saldo"                 => formato_entrada($this->input->post('saldo'))

        );





        $response = $this->model->editarContra($data,$this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $contrasDbObject           =   $this->model->obtenerListaDeContras($this->input->post('id_empresa'));

            $arrayResponse["contras"]  =   $this->listarContras($contrasDbObject);

        }



        echo json_encode($arrayResponse);



    }



    public function eliminarContra(){



        $response = $this->model->eliminarContra($this->input->post('id'));





        $arrayResponse = array('response' => $response);



        if($response == "success"){

            $contrasDbObject           =   $this->model->obtenerListaDeContras($this->input->post('id_empresa'));

            $arrayResponse["contras"]  =   $this->listarContras($contrasDbObject);

        }



        echo json_encode($arrayResponse);

    }



    private function listarContras($contrasDbResult){



        $table = "<table class='table'>

    <thead>

    <tr>

        <th>Contra</th>

        <th>Fecha Emisión</th>

        <th>Saldo</th>

        <th width='20px'></th>

    </tr>

    </thead>

    <tbody>";



        if($contrasDbResult){

            foreach($contrasDbResult as $row){





                $table .= "<tr>

                    <td>".$row->contra."</td>

                    <td>".date('d/m/Y',strtotime($row->fecha_emision))."</td>

                    <td>".formato_salida($row->saldo)."</td>

                    <td width='20px'>

                        <table>

                            <tbody>

                            <tr>

                                <td>

                                    <a title='Editar' href='javascript:void(0)' class='edit-contra' data-id='".$row->id."' data-contra='".$row->contra."' data-fecha_emision='".$row->fecha_emision."' data-saldo='".formato_salida($row->saldo)."'>

                                        <span class='glyphicon glyphicon-edit '></span>

                                    </a>

                                </td>

                                <td>

                                    <a title='Eliminar' href='javascript:void(0)' class='eliminar-contra' data-id='".$row->id."' data-id_empresa='".$row->id_empresa."'>

                                        <span class='glyphicon glyphicon-remove' ></span>

                                    </a>

                                </td>                                        </tr>



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

}?>