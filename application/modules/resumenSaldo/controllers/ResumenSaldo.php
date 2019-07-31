<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ResumenSaldo extends MX_Controller{

    private $user;

    function __construct(){
        parent::__construct();
        $this->load->model('ResumenSaldoModel','model');
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

            $empresas = $this->model->obtenerEmpresasNoInversoras();
            $data['empresas'] = $empresas;
            $data['table'] = $this->generarTabla($empresas);

            $this->load->view('include/header',$header);
            $this->load->view('resumenSaldoView', $data);
            $this->load->view('include/footer');
            $this->load->view('resumenSaldoScript');
        }else{
            redirect(base_url() , 'refresh');
        }

    }

    public function detallesSaldo(){

        $detalles = '';
        $json = '';

        switch ($this->input->post('op')) {
            case '1':
                $detalles = $this->model->obtenerResumenSaldoFavor($this->input->post('origen'), $this->input->post('destino'));
                break;
            
            case '2':
                $detalles = $this->model->obtenerResumenSaldoContra($this->input->post('origen'), $this->input->post('destino'));
                break;
        }

        $json = array('data' => $detalles);
        
        echo json_encode($json);
    }

    private function generarTabla($empresas){
        $html = '';
        $idsEmpresasCol = array();
        $totalFavorContra = array(); // inicializandolo

        if ($empresas) {
            $html .= "<table class='table tabla table-striped table-bordered table-hover' id='tablaResumen'>";

            $html .= "<thead>";

            $html .= "<tr><th></th>";

            foreach ($empresas as $empresa) {
                array_push($idsEmpresasCol, $empresa->id);
                $html .= "<th colspan='2' style='text-align: center'>".$empresa->empresa."</th>";
            }

            $html .= "</tr><tr class='encabezado'><td></td>";

            foreach ($empresas as $empresa) {
                $html .= "<td align='center' style='background: #D9D9D9'>FAVOR</td><td align='center' style='background: #D9D9D9'>CONTRA</td>";
            }

            $html .= "</tr></thead><tbody>";

            foreach ($empresas as $empresa) {
                $html .= "<tr><td style='text-align: center; font-weight: bold'>" . $empresa->empresa ."</td>";
                for ($i=0; $i < count($idsEmpresasCol) ; $i++) { 
                    $favor = $this->getFavor($empresa->id, $idsEmpresasCol[$i]);
                    if ($favor == 0) {
                        $html .= "<td align='center'>".$favor."</td>";
                    }else {
                        $html .= "<td align='center'><a class='detalleSaldo' href='#' data-toggle='modal' data-target='#view-resumen-saldo' data-op='1' data-origen='".$empresa->id."' data-destino='".$idsEmpresasCol[$i]."' nombre-origen='".$this->model->obtenerNombreEmpresa($empresa->id)."' nombre-destino='".$this->model->obtenerNombreEmpresa($idsEmpresasCol[$i])."'>".formato_salida($favor)."</a></td>";
                    }
                    $contra = $this->getContra($empresa->id, $idsEmpresasCol[$i]);
                    if ($contra == 0) {
                        $html .= "<td align='center'>".$contra."</td>";
                    }else {
                        #$html .= "<td>---</td>";
                        $html .= "<td align='center'><a class='detalleSaldo' href='#' data-toggle='modal' data-target='#view-resumen-saldo' data-op='2' data-origen='".$empresa->id."' data-destino='".$idsEmpresasCol[$i]."' nombre-origen='".$this->model->obtenerNombreEmpresa($empresa->id)."' nombre-destino='".$this->model->obtenerNombreEmpresa($idsEmpresasCol[$i])."'>".formato_salida($contra)."</a></td>";
                    }

                    if (!array_key_exists($i, $totalFavorContra)) { // Construyendo array para sumas total por columnas
                        $totalFavorContra[$i]["favor"] = $favor;
                        $totalFavorContra[$i]["contra"] = $contra;
                    } else {
                        $totalFavorContra[$i]["favor"] += $favor;
                        $totalFavorContra[$i]["contra"] += $contra;
                    }

                }
                $html .= "</tr>";
            }


            $html .= "<tr class='total'><td align='center'><b>SUMA TOTAL</b></td>";
            for ($i=0; $i < count($empresas); $i++) { // Haciendo ciclo para imprimir valores de suma total
                if ($totalFavorContra[$i]["favor"] == 0) {
                    $html .= "<td align='center'>".$totalFavorContra[$i]["favor"]."</td>";
                } else { 
                    $html .= "<td align='center'>".formato_salida($totalFavorContra[$i]["favor"])."</td>";
                }
                if ($totalFavorContra[$i]["contra"] == 0) {
                    $html .= "<td align='center'>".$totalFavorContra[$i]["contra"]."</td>";
                } else {
                    $html .= "<td align='center'>".formato_salida($totalFavorContra[$i]["contra"])."</td>";
                }
            }

            $html .= "</tr><tr>";

            $html .= "<td align='center'><b>SALDO</b></td>";

            for ($i=0; $i < count($empresas); $i++) { // Haciendo ciclo para imprimir valores de saldos
                $saldo = $totalFavorContra[$i]["favor"] - $totalFavorContra[$i]["contra"];
                if ($saldo == 0) {
                    $html .= "<td align='right'>".$saldo."</td><td></td>";
                }else {
                    $html .= "<td align='right'>".formato_salida($saldo)."</td><td></td>";
                }
            }

            $html .= "</tr>";


            $html .= "</tbody></table>";
        }

        

        return $html;

    }

    public function perEmpresa(){
        $html = '';
        $idsEmpresasCol = array();
        $totalFavorContra = array(); // inicializandolo
        $idEmpresa = $this->input->get('emp');
        $empresas = $this->model->obtenerEmpresasNoInversoras();


        if ($idEmpresa != 0) {
            $html .= "<table class='table tabla table-striped table-bordered table-hover'>";

            $html .= "<thead>";

            $html .= "<tr><th></th>";

                array_push($idsEmpresasCol, $idEmpresa);
                $html .= "<th colspan='2' style='text-align: center'>".$this->model->obtenerNombreEmpresa($idEmpresa)."</th>";

            $html .= "</tr><tr class='encabezado'><td></td>";

            $html .= "<td align='center' style='background: #D9D9D9'>FAVOR</td><td align='center' style='background: #D9D9D9'>CONTRA</td>";

            $html .= "</tr></thead><tbody>";

            foreach ($empresas as $empresa) {
                $html .= "<tr><td style='text-align: center; font-weight: bold; width: 110px'>" . $empresa->empresa ."</td>";
                for ($i=0; $i < count($idsEmpresasCol) ; $i++) { 
                    $favor = $this->getFavor($empresa->id, $idsEmpresasCol[$i]);
                    if ($favor == 0) {
                        $html .= "<td align='center'>".$favor."</td>";
                    }else {
                        $html .= "<td align='center'><a class='detalleSaldo' href='#' data-toggle='modal' data-target='#view-resumen-saldo' data-op='1' data-origen='".$empresa->id."' data-destino='".$idsEmpresasCol[$i]."' nombre-origen='".$this->model->obtenerNombreEmpresa($empresa->id)."' nombre-destino='".$this->model->obtenerNombreEmpresa($idsEmpresasCol[$i])."'>".formato_salida($favor)."</a></td>";
                    }
                    $contra = $this->getContra($empresa->id, $idsEmpresasCol[$i]);
                    if ($contra == 0) {
                        $html .= "<td align='center'>".$contra."</td>";
                    }else {
                        #$html .= "<td>---</td>";
                        $html .= "<td align='center'><a class='detalleSaldo' href='#' data-toggle='modal' data-target='#view-resumen-saldo' data-op='2' data-origen='".$empresa->id."' data-destino='".$idsEmpresasCol[$i]."' nombre-origen='".$this->model->obtenerNombreEmpresa($empresa->id)."' nombre-destino='".$this->model->obtenerNombreEmpresa($idsEmpresasCol[$i])."'>".formato_salida($contra)."</a></td>";
                    }

                    if (!array_key_exists($i, $totalFavorContra)) { // Construyendo array para sumas total por columnas
                        $totalFavorContra[$i]["favor"] = $favor;
                        $totalFavorContra[$i]["contra"] = $contra;
                    } else {
                        $totalFavorContra[$i]["favor"] += $favor;
                        $totalFavorContra[$i]["contra"] += $contra;
                    }

                }
                $html .= "</tr>";
            }


            $html .= "<tr class='total'><td align='center'><b>SUMA TOTAL</b></td>";
            for ($i=0; $i < count($idsEmpresasCol); $i++) { // Haciendo ciclo para imprimir valores de suma total
                if ($totalFavorContra[$i]["favor"] == 0) {
                    $html .= "<td align='center'>".$totalFavorContra[$i]["favor"]."</td>";
                } else { 
                    $html .= "<td align='center'>".formato_salida($totalFavorContra[$i]["favor"])."</td>";
                }
                if ($totalFavorContra[$i]["contra"] == 0) {
                    $html .= "<td align='center'>".$totalFavorContra[$i]["contra"]."</td>";
                } else {
                    $html .= "<td align='center'>".formato_salida($totalFavorContra[$i]["contra"])."</td>";
                }
            }

            $html .= "</tr><tr>";

            $html .= "<td align='center'><b>SALDO</b></td>";

            for ($i=0; $i < count($idsEmpresasCol); $i++) { // Haciendo ciclo para imprimir valores de saldos
                $saldo = $totalFavorContra[$i]["favor"] - $totalFavorContra[$i]["contra"];
                if ($saldo == 0) {
                    $html .= "<td align='right'>".$saldo."</td><td></td>";
                }else {
                    $html .= "<td align='center' colspan='2'>".formato_salida($saldo)."</td>";
                }
            }

            $html .= "</tr>";


            $html .= "</tbody></table>";

            $data['table']          = $html;
            $data['empresas']       = $empresas;
            $header['session']      = $this->user;
            $header['red']          = $this->generalModel->obtenerMenuRed();

            $this->load->view('include/header',$header);
            $this->load->view('resumenSaldoView', $data);
            $this->load->view('include/footer');
            $this->load->view('resumenSaldoScript');
        } else {
            redirect('resumenSaldo');
        }

    }

    private function getFavor($empOrigen, $empDestino){
        $sumaFavor = 0;
        $resultFavor = $this->model->obtenerResumenSaldoFavor($empOrigen, $empDestino);

        if ($resultFavor) {
            foreach ($resultFavor as $m) {
                $sumaFavor += $m->monto;
            }
            return $sumaFavor;
        } else {
            return 0;
        }
    }

    private function getContra($empOrigen, $empDestino){
        $sumaContra = 0;
        $resultContra = $this->model->obtenerResumenSaldoContra($empOrigen, $empDestino);

        if ($resultContra) {
            foreach ($resultContra as $m) {
                $sumaContra += $m->monto;
            }
            return $sumaContra;
        } else {
            return 0;
        }
    }

} 