<?php if(!defined('BASEPATH')) exit('Not Direct Script Access Allowed');

class EmpresasModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }


    function obtenerListaDeEmpresas(){

        $this->db->where('status','1');
        $usersDbObject = $this->db->get('empresas');

        if($usersDbObject->num_rows() > 0){
            return $usersDbObject->result();
        }else{
            return false;
        }

    }

    function crearTodos(){

        /* esta es una función que cree para crear los registros iniciales en cero
        para los balances generales. se debe ejecutar previo a utilizar la aplicación */

        $result = $this->db->get('empresas');

        foreach($result->result() as $row){

            $this->db->insert('balance_generale',array('id_empresa' => $row->id));
        }
    }

    function crearBalanceGralEmpresa($idEmpresa){
        $this->db->insert('balance_generale',array('id_empresa' => $idEmpresa));
    }


    function guardarNuevoEmpresa($data){

        $this->db->trans_start();

        $this->db->insert('empresas',$data);
        $idEmpresa = $this->db->insert_id();

        if ($data['inversor'] == '0') { //Si la empresa es no inversora se inicializa el balance gral.
            $this->crearBalanceGralEmpresa($idEmpresa);
        }

        if($data['parent_id'] != '0'){
            $this->db->where('id',$data['parent_id']);
            $this->db->update('empresas', array('have_children' => '1'));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }

    }

    function editarEmpresa($data,$id){
        $this->db->trans_start();
        // primero obtengo el parent id original antes de editar
        $this->db->where('id', $id);
        $result = $this->db->get('empresas');
        $empresa = $result->row();

        // luego edito
        $this->db->where('id', $id);
        $this->db->update('empresas', $data);

        // ahora consulto si la empresa padre original sigue teniendo hijos
        $this->db->where('parent_id', $empresa->parent_id);
        $result2 = $this->db->get('empresas', $data);

        // si la empresa padre original no tiene mas hijos, entonces have_childre para a ser 0
        if($result2->num_rows() == 0){

            $this->db->where('id',$empresa->parent_id);
            $this->db->update('empresas',array('have_children' => '0'));
        }

        // ahora la nueva empresa padre para tener un nuevo hijo, asi que have_children pasa a ser 1 obligatoriamente
        $this->db->where('id',$data['parent_id']);
        $this->db->update('empresas',array('have_children' => '1'));

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

    function eliminarEmpresa($id){
        $this->db->trans_start();

        // se obtien los datos de la empresa a eliminar
        $this->db->where('id',$id);
        $results = $this->db->get('empresas');

        if($results->num_rows() > 0){

            // se guardan los datos de la empresa a eliminar en una variable
            $empresaEliminando = $results->row();

            if($empresaEliminando->parent_id != '0'){
                // las empresas hijas de la empresa eliminando ahora tienen el parent id, de la empresa eliminando
                $this->db->where('parent_id',$empresaEliminando->id);
                $this->db->update('empresas',array('parent_id' => $empresaEliminando->parent_id));

                //se "elimina" la empresa, cambiando su status a 0. queda como inactiva
                $this->db->where('id',$id);
                $this->db->update('empresas', array('status' => '0') );

                // se obtienen las empresas hijas, de la empresa padre original
                // para ver si aun tiene otras hijas y ver si se deja have_children en 1 o 0
                $this->db->where('parent_id', $empresaEliminando->parent_id);
                $this->db->where('status','1');
                $results = $this->db->get('empresas');

                if($results->num_rows() == 0){
                    $this->db->where('id',$empresaEliminando->parent_id);
                    $this->db->update('empresas',array('have_children' => '0'));
                }
            }else{

                $this->db->where('parent_id',$empresaEliminando->id);
                $this->db->update('empresas',array('parent_id' => '0'));

                //se elimina la empresa
                $this->db->where('id',$id);
                $this->db->update('empresas', array('status' => '0') );

            }
        }


        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return "failed";
        } else {
            return "success";
        }
    }

} 