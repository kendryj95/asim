<?php if(!defined('BASEPATH')) exit('Not Direct Script Access Allowed');

class ReportePropiedadesModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }


    function obtenerListaDeReporte_propiedades(){

        $usersDbObject = $this->db->get('reporte_propiedades');

        if($usersDbObject->num_rows() > 0){
            return $usersDbObject->result();
        }else{
            return false;
        }

    }


    function guardarNuevoReporte_propiedade($data){

        $this->db->trans_start();
        $this->db->insert('reporte_propiedades',$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function guardarPermisos($data){

        $this->db->trans_start();
        $this->db->insert('permisos_emps_users',$data);
        $this->db->where('id',$data['id_empresa']);
        $dbObj = $this->db->get('empresas');

        if($dbObj->num_rows() > 0){

            $empresaActual = $dbObj->row();

            if($empresaActual->have_children == 1){

                $this->db->where('parent_id',$empresaActual->id);
                $dbObjChilds = $this->db->get('empresas');

                if($dbObjChilds->num_rows() > 0){

                    foreach($dbObjChilds->result() as $row){

                        $data = array(
                            'id_empresa' => $row->id,
                            'id_user' => $data['id_user']
                        );

                        self::guardarPermisos($data);

                    }

                }

            }


        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }


    function eliminarPermisos($id_empresa,$id_user){

        $this->db->trans_start();

        $this->db->where('id_empresa',$id_empresa);
        $this->db->where('id_user',$id_user);
        $this->db->delete('permisos_emps_users');

        $this->db->where('id',$id_empresa);
        $dbObj = $this->db->get('empresas');

        if($dbObj->num_rows() > 0){

            $empresaActual = $dbObj->row();

            if($empresaActual->have_children == 1){

                $this->db->where('parent_id',$empresaActual->id);
                $dbObjChilds = $this->db->get('empresas');

                if($dbObjChilds->num_rows() > 0){

                    foreach($dbObjChilds->result() as $row){

                        self::eliminarPermisos($row->id,$id_user);

                    }

                }

            }


        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }


    function editarReporte_propiedade($data,$id){
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('reporte_propiedades', $data);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarReporte_propiedade($id){
        $this->db->trans_start();
        $this->db->delete('reporte_propiedades', array('id' => $id));
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }


    function obtenerEmpresasDisponibles($id){

        // primero saco los permisos asignados actualmente al reporte_propiedade de permisos_emps_users
        $this->db->where('id_user',$id);
        $dbObjectPermisos = $this->db->get('permisos_emps_users');

        $andString = "";

        if($dbObjectPermisos->num_rows() > 0){
            foreach($dbObjectPermisos->result() as $row){

                $andString .= ' AND id != "'.$row->id_empresa.'" ';

            }
        }

        $query = "SELECT id,empresa FROM empresas WHERE status = '1' ".$andString;

        $bdObject = $this->db->query($query);

        if($bdObject->num_rows() > 0){
            return $bdObject->result_array();
        }else{
            return false;
        }

    }

    function obtenerEmpresasAsignadas($id){

        $string = "SELECT empresa,empresas.id
                    FROM permisos_emps_users
                    LEFT JOIN empresas
                    ON permisos_emps_users.id_empresa = empresas.id
                    WHERE empresas.status = '1'
                    AND permisos_emps_users.id_user = '".$id."'";

        $dbObject = $this->db->query($string);

        if($dbObject->num_rows() > 0){
            return $dbObject->result_array();
        }else{
            return false;
        }

    }

} 