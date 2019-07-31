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
            $data['table'] = $this->generarTabla($empresas);

            

            $this->load->view('include/header',$header);
            $this->load->view('resumenSaldoView', $data);
            $this->load->view('include/footer');
            //$this->load->view('dashboardScript');
        }else{
            redirect(base_url() , 'refresh');
        }

    }

    private function generarTabla($empresas){
        $html = '';
        $idsEmpresasCol = array();

        $html .= "<table class='table table-bordered'>";

        $html .= "<tr><th style='background: #1A2226'></th>";

        foreach ($empresas as $empresa) {
            array_push($idsEmpresasCol, $empresa->id);
            $html .= "<th colspan='2' style='background: grey; text-align: center'>".$empresa->empresa." (".$empresa->id.")</th>";
        }

        $html .= "</tr><tr><td style='background: #1A2226'></td>";

        foreach ($empresas as $empresa) {
            $html .= "<td align='center' style='background: #D9D9D9'>FAVOR</td><td align='center' style='background: #D9D9D9'>CONTRA</td>";
        }

        $html .= "</tr>";

        foreach ($empresas as $empresa) {
            $html .= "<tr><td style='background: grey; text-align: center; font-weight: bold'>" . $empresa->empresa . " (".$empresa->id.")</td>";
            for ($i=0; $i < count($idsEmpresasCol) ; $i++) { 
                $favor = $this->getFavor($empresa->id, $idsEmpresasCol[$i]);
                $html .= "<td>$favor</td>";
                $contra = $this->getContra($empresa->id, $idsEmpresasCol[$i]);
                #$html .= "<td>---</td>";
                $html .= "<td>$contra</td>";
            }
            $html .= "</tr>";
        }

        $html .= "</table>";

        return $html;

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