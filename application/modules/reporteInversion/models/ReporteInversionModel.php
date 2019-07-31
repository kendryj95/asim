<?php if(!defined('BASEPATH'))  exit('No direct script access allowed');

class reporteInversionModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function obtenerYears(){

        $result = $this->db->query("SELECT YEAR(fecha) AS fecha FROM `reporte_inversiones` WHERE YEAR(fecha) != '0' AND YEAR(fecha) != 'NULL' GROUP BY YEAR(fecha)");

        if($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
        }

    }

    function guardarReporteInversion($data){

        $this->db->insert('reporte_inversiones',$data);

        return $this->db->insert_id();
    }

    function obtenerInfoEmpresa($id){

        $this->db->where('id',$id);
        $dbObjectEmpresa = $this->db->get('empresas');


        if($dbObjectEmpresa->num_rows() > 0){

            return $dbObjectEmpresa->row();

        }else{
            return false;
        }
    }

    function guardarRegistroReporteInversion($data){

        $this->db->trans_start();
        $this->db->insert_batch('registro_reporte_inversiones',$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }


    function actualizarRegistroReporteInversion($data,$dataId){

        $this->db->trans_start();

        for($i = 0;$i < 3; $i++){
            $this->db->where('id',$dataId[$i]);
            $this->db->update('registro_reporte_inversiones',$data[$i]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function actualizarReporteInversion($data,$id){

        /* aquí actualizo el reporte de inversión al momento de editar un registro */

        $this->db->where('id',$id);
        $this->db->update('reporte_inversiones',$data);

    }

    function obtenerReportesDeInversion($idEmpresa,$month,$year){

        $string = "SELECT *
                    FROM reporte_inversiones
                    WHERE id_empresa = '".$idEmpresa."'
                    AND YEAR(fecha) = '".$year."'
                    AND MONTH(fecha) = '".$month."'";


        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return $dbObject->result();

        }else{
            return false;
        }
    }

    function obtenerRegistrosReporteDeInversion($idReporte){

        $string = "SELECT *
                    FROM registro_reporte_inversiones
                    WHERE id_reporte_inversiones = '".$idReporte."'
                    ORDER BY orden ASC";
        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return $dbObject->result();

        }else{
            return false;
        }
    }


    function eliminarRegistroDeInversion($id){

        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->delete('reporte_inversiones');

        $this->db->where('id_reporte_inversiones',$id);
        $this->db->delete('registro_reporte_inversiones');


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }


    function actualizarComentario($data,$id){

        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('empresas', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

} 