<?php if(!defined('BASEPATH')) exit('Not Direct Script Access Allowed');

class DashboardModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }


    function obtenerVerdes(){
        $string = "SELECT *, DATEDIFF(fecha_limite,DATE(NOW())) AS alarma
                    FROM `reporte_empresas`
                    WHERE DATEDIFF(fecha_limite,DATE(NOW())) != 'NULL'
                    AND DATEDIFF(fecha_limite,DATE(NOW())) > '45'";

        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return array($dbObject->num_rows(),$dbObject->result());

        }else{
            return array($dbObject->num_rows(),false);
        }
    }

    function obtenerAmarillos(){
        $string = "SELECT *, DATEDIFF(fecha_limite,DATE(NOW())) AS alarma
                    FROM `reporte_empresas`
                    WHERE DATEDIFF(fecha_limite,DATE(NOW())) != 'NULL'
                    AND DATEDIFF(fecha_limite,DATE(NOW())) >= '20'
                    AND DATEDIFF(fecha_limite,DATE(NOW())) <= '45'";

        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return array($dbObject->num_rows(),$dbObject->result());

        }else{
            return array($dbObject->num_rows(),false);
        }
    }

    function obtenerRojos(){
        $string = "SELECT re.*, DATEDIFF(re.fecha_limite,DATE(NOW())) AS alarma
                    FROM `reporte_empresas` AS re 
                    INNER JOIN empresas e ON e.id = re.id_empresa
                    WHERE DATEDIFF(re.fecha_limite,DATE(NOW())) != 'NULL'
                    AND DATEDIFF(re.fecha_limite,DATE(NOW())) < '20' 
                    AND e.status = 1";

        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0 ){

            return array($dbObject->num_rows(),$dbObject->result());

        }else{
            return array($dbObject->num_rows(),false);
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

}?>