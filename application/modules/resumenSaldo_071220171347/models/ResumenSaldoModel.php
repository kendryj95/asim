<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ResumenSaldoModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function obtenerEmpresasNoInversoras(){

        $string = "SELECT id,empresa
                    FROM empresas
                    WHERE status = '1'
                    AND inversor = '0'
                    AND ghost ='0'";

        $result = $this->db->query($string);

        if($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
        }

    }

    function obtenerResumenSaldoFavor($empOrigen, $empDestino){
        #$string = "SELECT monto FROM fitnessf_defontana.reporte_empresas WHERE id_empresa IN($empOrigen,$empDestino) AND descripcion IN (1,3) AND origen=$empOrigen AND destino=$empDestino";
        #$string = "SELECT * FROM fitnessf_defontana.reporte_empresas WHERE id_empresa IN($empOrigen,$empDestino) AND descripcion IN (1,4) AND ((origen=$empOrigen AND destino=$empDestino) OR (origen=$empDestino AND destino=$empOrigen))";
        $string = "SELECT * FROM fitnessf_defontana.reporte_empresas WHERE id_empresa=$empOrigen AND (descripcion=1 OR descripcion=4) AND ((origen=$empOrigen AND destino=$empDestino) OR (origen=$empDestino AND destino=$empOrigen))";

        $result = $this->db->query($string);

        if($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
        }
    }

    function obtenerResumenSaldoContra($empOrigen, $empDestino){
        #$string = "SELECT monto FROM fitnessf_defontana.reporte_empresas WHERE id_empresa IN($empOrigen,$empDestino) AND descripcion IN (2,4) AND origen=$empOrigen AND destino=$empDestino";
        #$string = "SELECT * FROM fitnessf_defontana.reporte_empresas WHERE id_empresa IN($empOrigen,$empDestino) AND descripcion IN (2,4) AND ((origen=$empOrigen AND destino=$empDestino) OR (origen=$empDestino AND destino=$empOrigen))";
        $string = "SELECT * FROM fitnessf_defontana.reporte_empresas WHERE id_empresa=$empOrigen AND (descripcion=2 OR descripcion=3) AND ((origen=$empOrigen AND destino=$empDestino) OR (origen=$empDestino AND destino=$empOrigen))";

        $result = $this->db->query($string);

        if($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
        }
    }

    
}
?>
