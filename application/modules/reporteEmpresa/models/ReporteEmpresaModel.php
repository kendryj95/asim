<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ReporteEmpresaModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function obtenerYears(){

        $result = $this->db->query("SELECT YEAR(fecha_realizacion) AS fecha FROM `reporte_empresas` WHERE YEAR(fecha_realizacion) != '0' AND YEAR(fecha_realizacion) != 'NULL' GROUP BY YEAR(fecha_realizacion)");

        if($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
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

    function obtenerEmpresas($id = null){

        if($id){
            $this->db->where('id',$id);
        }
        $this->db->where('status','1');
        $result = $this->db->get('empresas');

        if($result->num_rows() > 0){
            if($id){
                return $result->row();
            }else{
                return $result->result();
            }
        }else{
            return false;
        }

    }



    function obtenerEmpresasNoInversoras(){

        $string = "SELECT *
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

    function guardarPares( $dataA = null, $dataB = null ){
        $this->db->trans_start();

        $this->db->query('INSERT INTO `identificardor_pares` VALUES ()');
        $idPar = $this->db->insert_id();

        $dataA['registro_transaccion'] = $idPar.'-A';
        $dataB['registro_transaccion'] = $idPar.'-B';

        //guardando los 2 registros
        $this->db->insert('reporte_empresas',$dataA);
        $idA = $this->db->insert_id();

        if($dataB['origen'] != 'X' && $dataB['destino'] != 'X'){
            $this->db->insert('reporte_empresas',$dataB);
            $idB = $this->db->insert_id();
        }


        //actualizando los pares con los id's
        $this->db->where('id', $idA);
        $this->db->update('reporte_empresas',array('pares'=> $idB));

        if($dataB['origen'] != 'X' && $dataB['destino'] != 'X') {
            $this->db->where('id', $idB);
            $this->db->update('reporte_empresas', array('pares' => $idA));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function obtenerReportesDeEmpresa($idEmpresa,$month,$year){

        $string = "SELECT *
                    FROM reporte_empresas
                    WHERE id_empresa = '".$idEmpresa."'
                    AND YEAR(fecha_realizacion) = '".$year."'
                    AND MONTH(fecha_realizacion) = '".$month."'";


        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return $dbObject->result();

        }else{
            return false;
        }
    }

    function obtenerNombreEmpresa($idEmpresa){

        if($idEmpresa != 'X'){
            $this->db->where('id',$idEmpresa);
            $result = $this->db->get('empresas');

            if($result->num_rows() > 0)
                return $result->row()->empresa;
            else{
                return '';
            }
        }else{
            return 'TERCEROS..';
        }

    }

    function actualizarRegistroDeEmpresa($data,$idA,$idB){
        $this->db->trans_start();


        $this->db->where('id',$idA);
        $this->db->update('reporte_empresas',$data);

        if($idB != ''){
            $this->db->where('id',$idB);
            $this->db->update('reporte_empresas',$data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarRegistroDeEmpresa($idA,$idB){

        $this->db->trans_start();

        $this->db->where('id',$idA);
        $this->db->delete('reporte_empresas');


        if($idB != ''){
            $this->db->where('id',$idB);
            $this->db->delete('reporte_empresas');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }


    /*  **************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
     */
    function obtenerListaDeCajas($id = null){

        $this->db->where('id_empresa',$id);

        $result = $this->db->get('cajas');

        if($result->num_rows() > 0){

            return $result->result();

        }else{
            return false;
        }

    }

    function guardarNuevoCaja($data){

        $this->db->trans_start();
        $this->db->insert('cajas',$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function editarCaja($data,$id){
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('cajas', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarCaja($id){
        $this->db->trans_start();
        $this->db->delete('cajas', array('id' => $id));
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    /*  **************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
     */


    function obtenerListaDeFavores($id = null){

        $this->db->where('id_empresa',$id);

        $result = $this->db->get('favores');

        if($result->num_rows() > 0){

            return $result->result();

        }else{
            return false;
        }

    }

    function guardarNuevoFavor($data){

        $this->db->trans_start();
        $this->db->insert('favores',$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function editarFavor($data,$id){
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('favores', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarFavor($id){
        $this->db->trans_start();
        $this->db->delete('favores', array('id' => $id));
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }


    /*  **************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
    ******************************************************************************************************************
     */




    function obtenerListaDeContras($id = null){

        $this->db->where('id_empresa',$id);

        $result = $this->db->get('contras');

        if($result->num_rows() > 0){

            return $result->result();

        }else{
            return false;
        }

    }

    function guardarNuevoContra($data){

        $this->db->trans_start();
        $this->db->insert('contras',$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function editarContra($data,$id){
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('contras', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarContra($id){
        $this->db->trans_start();
        $this->db->delete('contras', array('id' => $id));
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }



    function obtenerBalances($id_empresa){

        $this->db->where('id_empresa',$id_empresa);
        $this->db->limit(1);
        $result = $this->db->get('balance_generale');


        if($result->num_rows() > 0){
            return $result->row();
        }else{
            return false;
        }
    }


    function actualizarRegistroDeBalanceGeneral($data,$id){
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('balance_generale', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }
}?>
