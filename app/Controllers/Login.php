<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\RestClient;

class Login extends Controller{

    private $api;

    function __construct() {
        $this->api = new RestClient([
			//LOCAL
            // 'base_url' => 'http://localhost/api/public/api',
            //API V2 PRODUCCION
            'base_url' => 'https://api.lamat.pro/public/api',
            'headers' => ['Ephylone'=>'apu'],'format' => ""]);
    }

    public function index(){
        echo view('login/login');
    }

    public function validar(){
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'usuarios','condicion[email]'=>$usuario,'condicion[activo]'=>1))->response);
        // var_dump($res);
        if($res->totalregistros>0){
            if(password_verify($password,$res->resultado[0]->password)){
                $session = session();
                $session->set('usuario_id',$res->resultado[0]->id);
                $session->set('nombre',$res->resultado[0]->nombre);
                $session->set('email',$res->resultado[0]->email);
                header('Location: '.base_url().'Administracion');
                exit;
            }
            else{
                header('Location: '.base_url().'login');
                exit;    
            }
        }
        else{
            header('Location: '.base_url().'login');
            exit;
        }
    }

    public function aviso(){
        echo view('previos/aviso');
    }

    public function salir(){
        $session = session();
        $session->destroy();
        echo view('funciones');
        echo '<script>setlocal("titulo",""); location.href="'.base_url().'/login" </script>';
        exit;
    }
}

///FALTA VALIDAR EL TIPO DE PÊRSONA Y MOSTRAR LOS GEMNERALES PARA GAURDAR SUS DATOS