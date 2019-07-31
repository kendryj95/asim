<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller{

    private $user;

    function __construct(){
        parent::__construct();
        $this->load->model('dashboardModel','model');
        $this->user = $this->session->userdata('logged_in');
        if(! ini_get('date.timezone'))
        {
            date_default_timezone_set('America/Caracas');
        }
    }

    public function index(){
        
        if($this->user){

            $header['session']      = $this->user;
            $header['red']          = $this->generalModel->obtenerMenuRed();

            $verdes = $this->model->obtenerVerdes();
            $data['nVerdes'] = $verdes[0];
            $data['verdes'] = $this->generaTabla($verdes[1]);

            $amarillos = $this->model->obtenerAmarillos();
            $data['nAmarillos'] = $amarillos[0];
            $data['amarillos'] = $this->generaTabla($amarillos[1]);

            $rojos = $this->model->obtenerRojos();
            $data['nRojos'] = $rojos[0];
            $data['rojos'] = $this->generaTabla($rojos[1]);

            $this->load->view('include/header',$header);
            $this->load->view('dashboardView',$data);
            $this->load->view('include/footer');
            $this->load->view('dashboardScript');
        }else{
            redirect(base_url() , 'refresh');
        }

    }



    private function generaTabla($reportes){

        $html = '';

        $html .= '<table class="table tabla">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Monto</th>
                                    <th>Fecha Realización</th>
                                    <th>Fecha Limite</th>
                                    <th>Alarma (Días Limite)</th>
                                </tr>
                            </thead>
                            <tbody>';

                            if($reportes){
                                foreach($reportes as $row){

                                    switch($row->descripcion){
                                        case '1':
                                            $descripcion = "Devolución Préstamo (Ingreso)";
                                            break;
                                        case '2':
                                            $descripcion = "Devolución Préstamo (Egreso)";
                                            break;
                                        case '3':
                                            $descripcion = "Ingreso Préstamo";
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
                                          </tr>';

                                }
                            }


                $html .= ' </tbody>
                        </table>';


        return $html;

    }


} 