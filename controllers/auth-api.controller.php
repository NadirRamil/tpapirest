<?php
require_once './views/api.view.php';
require_once './helpers/auth-api.helper.php';
require_once './models/UserModel.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class AuthApiController {
    private $model; 
    private $view;
    private $authHelper;
    private $data;

    public function __construct() {
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->model = new UserModel();
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getToken($params = null) {
        // Obtener "Basic base64(user:pass)
        $basic = $this->authHelper->getAuthHeader();
        
        if(empty($basic)){
            $this->view->response('No autorizado', 401);
            return;
        }
        $basic = explode(" ",$basic); // ["Basic" "base64(user:pass)"]
        if($basic[0]!="Basic"){
            $this->view->response('La autenticación debe ser Basic', 401);
            return;
        }

        //validar usuario:contraseña
        $userpass = base64_decode($basic[1]); // email:pass
        $userpass = explode(":", $userpass);
        $email = $userpass[0];
        $password = $userpass[1];
         //trae users de la base de datos
        $userDB = $this->model->getUserByEmail($email);
        //Se verifica que el usuario existe en DB y la contaseña coincide
        if(($email!=null)&&($password!=null)){
            if($email == $userDB->email && password_verify($password, $userDB->password)) {
            //  crear un token
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => $userDB->id,
                'name' => $userDB->name,
                'exp' => time()+3600
            );
            //Los codificamos en json osea pasa de ser un objeto a ser un string
            //y ese string lo codificamos en base 64
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", "Clave1234", true);
            $signature = base64url_encode($signature);
            $token = "$header.$payload.$signature";
            //devolver el token
             $this->view->response($token, 200);
        }else{
            $this->view->response('No autorizado', 401);
        }
     }
    }
}