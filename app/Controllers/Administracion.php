<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\RestClient;

class Administracion extends Controller{

    private $api;
    private $base;

    //Funcion de consutrccion de api
    public function __construct() {
        $this->api = new RestClient([
			//API Base
            'base_url' => 'https://api.lamat.pro/public/api',
            'headers' => ['Ephylone'=>'apu'],'format' => ""]);
    }

    //Metodo de seguridad para denegar accesos a apps o usuario no autorizados
    private function seguridad(){      
        $session = session();
        if(!$session->email != null || !$session->email != ''){
            $this->salir();
        }
    }

    public function salir(){
        $session = session();
        $session->destroy();
        header('Location: '.base_url().'login');
        exit;
    }

    public function index(){
        redirect($this->apuestas());
    }

    //Funcion para corroborar la conexion a esta plataforma
    public function usuarios(){
        $this->seguridad();
        $data['titulo'] = 'Usuario';
        $data['icono'] = 'people';
        $data['m_usuarios'] = 'active';
        $data['perfiles_opc'] = $this->api->post('crea_select',array('tabla'=>'c_perfiles','condicion'=>' activo=1 ORDER BY nombre'))['opciones'];
        $data['promotorias_opc'] = $this->api->post('crea_select',array('tabla'=>'c_promotorias','condicion'=>' activo=1 ORDER BY nombre'))['opciones'];
        echo view("header",$data);
        echo view("administracion/usuarios");
        echo view("funciones");
        echo view("footer");
    }

    public function consulta_usuarios(){
        $this->seguridad();
        echo $this->api->post('consulta_tabla',array('tabla'=>'vw_usuarios'))->response;
    }

    public function catalogos(){
        $data['titulo'] = 'Catálogos';
        $data['icono'] = 'assignment';
        $data['m_cata'] = 'active';
        echo view("header",$data);
        echo view("administracion/catalogos");
        echo view("funciones");
        echo view("footer");
    }

    public function canales(){
        $data['titulo'] = 'Catálogos - Canales';
        $data['icono'] = 'assignment';
        $data['m_cata'] = 'active';
        echo view("header",$data);
        echo view("administracion/canales");
        echo view("funciones");
        echo view("footer");
    }
    public function lista_canales(){
        echo $this->api->post('consulta_tabla',array('tabla'=>'canales'))->response;
    }
    public function edicion($id=null){
        $data['icono'] = 'assignment';
        $data['m_cata'] = 'active';
        if($id != null){
            $data['titulo'] = 'Catálogos - Canales - Edición';
            $data['resultado'] = json_encode(json_decode($this->api->post('consulta_tabla',array('tabla'=>'canales','condicion[id]'=>$id))->response,true)['resultado'][0]);
        }
        else{
            $data['titulo'] = 'Catálogos - Canales - Nuevo';
            $data['resultado'] = json_encode(array(''));
        }
        echo view("header",$data);
        echo view("administracion/edicion");
        echo view("funciones");
        echo view("footer");
    }

    public function save_canal(){
        // var_dump($_POST);
        if($_POST['id'] != ''){
            echo $this->api->post('actualizar/canales',array('datos'=>$_POST,'condicion[id]'=>$_POST['id']))->response;
        }
        else{
            unset($_POST['id']);
            echo $this->api->post('insertar/canales',$_POST)->response;
        }
    }
 
    public function apuestas(){
        $data['titulo'] = 'Apuestas Activas';
        $data['icono'] = 'developer_board';
        $data['m_apu'] = 'active';
        echo view("header",$data);
        echo view("administracion/apuestas");
        echo view("funciones");
        echo view("footer");
    }

    public function apuestas_historial(){
        $data['titulo'] = 'Apuestas Cerradas';
        $data['icono'] = 'developer_board';
        $data['m_apuh'] = 'active';
        $data['canales_opc'] = $this->api->post('crea_select',array('tabla'=>'canales','condicion'=>'1=1 ORDER BY nombre'))['opciones'];
        echo view("header",$data);
        echo view("administracion/apuestas_historial");
        echo view("funciones");
        echo view("footer");
    }

    public function lista_apuestas(){
        echo $this->api->post('consulta_tabla',array('tabla'=>'vw_apuestas','condicion'=>'resultado = "" ORDER BY id DESC'))->response;
    }

    public function lista_apuestas_historial($ide=null){
        $condicion = ($ide!=null)?' AND canal_id = '.$ide.'':'';
        echo $this->api->post('consulta_tabla',array('tabla'=>'vw_apuestas','condicion'=>'resultado != "" '.$condicion.' ORDER BY id DESC'))->response;
    }

    public function edicion_apuesta($id=null){
        $session = session();
        $data['fecha_evento'] = date('Y-m-d');
        if($id != ''){
            $data['titulo'] = 'Apuestas - Edición';
            $data['resultado'] = json_encode(json_decode($this->api->post('consulta_tabla',array('tabla'=>'apuestas','condicion[id]'=>$id))->response,true)['resultado'][0]);
        }
        else{
            $data['titulo'] = 'Apuestas - Nueva';
            $data['resultado'] = json_encode(array());
        }
        $data['icono'] = 'developer_board';
        $data['m_apu'] = 'active';
        if(isset($session->fecha_evento)){
            $data['fecha_evento'] = $session->fecha_evento;
        }        
        $data['deportes_opc'] = $this->api->post('crea_select',array('tabla'=>'deportes','condicion'=>'1=1 ORDER BY id'))['opciones'];
        $data['canales_opc'] = $this->api->post('crea_select',array('tabla'=>'canales','condicion'=>'1=1 ORDER BY nombre'))['opciones'];
        echo view("header",$data);
        echo view("administracion/edicion_apuesta");
        echo view("funciones");
        echo view("footer");
    }

    public function save_apuesta(){
        $session = session();
        $session->set('fecha_evento',$_POST['fecha_evento']);
        if($_POST['id'] != ''){
            echo $this->api->post('actualizar/apuestas',array('datos'=>$_POST,'condicion[id]'=>$_POST['id']))->response;
        }
        else{
            unset($_POST['id']);
            echo $this->api->post('insertar/apuestas',$_POST)->response;
        }
    }

    public function elimina_apuesta($id){
        echo $this->api->post('eliminar/apuestas',array('condicion[id]'=>$id))->response;
    }

    public function elimina_canal($id){
        echo $this->api->post('eliminar/canales',array('condicion[id]'=>$id))->response;
    }
}