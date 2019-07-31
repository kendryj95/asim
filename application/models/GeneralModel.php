<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class GeneralModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function get()
    {
        $elements = array();

        $query = $this->db->query("SELECT * FROM empresas WHERE status = '1'");
        $elements["masters"] = $elements["childrens"] = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $element)
            {
                if($element["parent_id"] == 0)
                {
                    array_push($elements["masters"], $element);
                }
                else
                {
                    array_push($elements["childrens"], $element);
                }
            }
        }
        return $elements;
    }

    function nested($rows = array(), $parent_id = 0,$padre_nested = '',$padre_inversor = '',$ghost = '',$parent_parent_id = '')
    {
        $html = "";
        if(!empty($rows))
        {

            $html.="<ul class='treeview-menu'>";
            $i = 0;
            $a = 0;

            foreach($rows as $row)
            {
                if($row["parent_id"] == $parent_id)
                {

                    // este es el elemento padre, que se copia en el UL hijo
                    // la condición 0 es para que el elemento no se repita
                    if($i == 0 && $ghost != 1){
                        $html .= $this->obtenerElementoLista($padre_inversor,$parent_id,$padre_nested);
                        $i++;
                    }

                    // aqui pregunta si la empresa es inversora para determinar el link que usara
                    $base = ($row['inversor'] == 1) ? "reporteInversion":"reporteEmpresa";
                    // aqui pregunta si tiene hijos para determinar si colocar el icono de flecha hacia abajo
                    $link = ($row["have_children"] == 1) ? 'javascript:void(0)': base_url($base.'/'.$row["id"]);
                    $html.="<li>";
                    $html.="<a href='".$link."'>
                                <i class='fa fa-circle-o'></i>
                                    ".$row['empresa']." ";
                    // esto significa que si tiene hijos, le coloque la flecha para hacerlo desplegable nada mas
                    if($row["have_children"] == 1)
                    {
                        $html.="<i class='fa fa-angle-left pull-right'></i>";
                    }
                    $html .= "</a>";
                    $html.=self::nested($rows, $row["id"],$row['empresa'],$row['inversor'],$row['ghost']);
                    $html.="</li>";
                }else{
                    $a++;
                }
            }

            if($a == count($rows) && $ghost != 1 && $parent_parent_id == '0'){
                $html .= $this->obtenerElementoLista($padre_inversor,$parent_id,$padre_nested);
            }

            $html.="</ul>";
        }else{

            if( $ghost != 1 && $parent_parent_id == '0'){
                $html .= $this->obtenerElementoLista($padre_inversor,$parent_id,$padre_nested);
            }

        }

        return $html;
    }

    function obtenerElementoLista($padre_inversor,$parent_id,$padre_nested){
        $html = '';
        $basePadre   = ($padre_inversor == 1)? "reporteInversion":"reporteEmpresa";
        $html       .="<li>";
        $html       .="<a href='".base_url($basePadre.'/'.$parent_id)."'>
                                        <i class='fa fa-circle-o'></i>
                                        ".$padre_nested." </a>";
        $html       .="</li>";
        return $html;
    }

    function obtenerMenuRed(){

        $html = '';
        $elements = $this->get();
        $masters = $elements["masters"];
        $childrens = $elements["childrens"];

        foreach($masters as $master)
        {
            $html .= '
            <li class="treeview red-class-eliminar">
                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span> '.$master["empresa"].'</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>';

            $html .= $this->nested($childrens, $master["id"],$master["empresa"],$master['inversor'],$master['ghost'],$master['parent_id']);

            $html .= '</li>';

        }


        return $html;
    }



    function tienePermiso($id_usuario,$tipo_usuario,$id_empresa){

        if($tipo_usuario == 1){
            return true;
        }else{

            $this->db->where('id_user',$id_usuario);
            $this->db->where('id_empresa',$id_empresa);
            $result = $this->db->get('permisos_emps_users');

            if($result->num_rows() > 0){
                return true;
            }else{
                return false;
            }

        }

    }

} 