<?php
require_once './models/recitalesModel.php';
require_once './views/api.view.php';
require_once './helpers/auth-api.helper.php';
class RecitalApiController {
    private $model;
    private $view;
    private $limit_default;
    private $data;
    

    public function __construct() {
        $this->model = new RecitalesModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->limit_default = 30;
        // lee el body del request (traeme lo que te mandaron del body)
        $this->data = file_get_contents("php://input");
    }

 //----------------------------Funcion getData--------------------//
    private function getData() {
        return json_decode($this->data); //convertir el string recibido a json
    }

 //----------------------------Funcion getAll---------------------------//
    public function getRecitales($params = null) {
        try {
            $filtercolumn = $_GET["filtercolumn"] ?? null; //el valor puede ser null
            $filtervalue = $_GET["filtervalue"] ?? null;
            $orderBy = $_GET["orderBy"] ?? "id_recital";
            $order = $_GET["order"] ?? "asc";
            $page =  $_GET["page"] ?? 1;
            $limit = $_GET["limit"] ?? $this->limit_default;

            $this->verifyParams($filtercolumn, $filtervalue, $orderBy, $order, $page, $limit);

            if (($filtercolumn != null)&& ($filtervalue != null)) {
                $recitales = $this->model->getAllByColumn($orderBy, $order, $limit, $page, $filtercolumn, $filtervalue);
            } elseif ($filtercolumn == null) {
                $recitales = $this->model->getAll($orderBy, $order, $page, $limit);
            }
            if ($recitales != 0){
                return $this->view->response($recitales, 200);
            }else{
                $this->view->response("No hay Recitales", 204);
            }
        } catch (Exception) {
            return $this->view->response("Internal Server Error", 500);
        }
    }
    //----------------------------Funcion verifyParams----------------------------//
    private function verifyParams($filtercolumn,$filtervalue, $orderBy, $order, $page, $limit) {
        $columns = [
            "id_recital", 
            "fecha", 
            "lugar", 
            "artista_id"
        ];

        if ($filtercolumn != null && !in_array(strtolower($filtercolumn), $columns)) {
            $this->view->response("Parámetro de consulta incorrecto filtercolumn: $filtercolumn en solicitud GET", 400);
            die;
        }
        if ($filtercolumn != null && $filtervalue == null) {
            $this->view->response("Parametro de filtervalue incorrecto o faltante en la solicitud", 400);
            die;
        }

        if ($orderBy != null && !in_array(strtolower($orderBy), $columns)) {
            $this->view->response("Parámetro de consulta incorrecto orderBy: $orderBy en solicitud GET", 400);
            die;
        }

        if ($order != null && $order != "asc" && $order != "desc") {
            $this->view->response("Orden de parámetro de consulta incorrecto en la solicitud GET", 400);
            die;
        }

        if ($page != null && (!is_numeric($page) || $page <= 0)) {
            $this->view->response("Página de consulta incorrecta en la solicitud GET", 400);
            die;
        }

        if ($limit != null && (!is_numeric($limit) || $limit <= 0)) {
            $this->view->response("Límite de parámetro de consulta incorrecto en la solicitud GET", 400);
            die;
        }
    }
    
 //----------------------------Funcion get--------------------//
    public function getrecitalById($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $recital = $this->model->getrecitalById($id);

        // si no existe devuelvo 404
        if ($recital)
            $this->view->response($recital, 200);
        else 
            $this->view->response("El recital con el id=$id no existe", 404);
    }

     //----------------------------Funcion delete--------------------//
    public function deleteRecital($params = null) {
        $id = $params[':ID'];
        $recital = $this->model->getrecitalById($id);

        if ($recital) {
            $this->model->delete($id);
            $this->view->response("El recital $id fue eliminado correctamente", 200);
        } else 
            $this->view->response("El recital con el id=$id no existe", 404);
    }


    //----------------------------Funcion insert--------------------//
    public function insertRecital($params = null) {
        $recital = $this->getData();
        try{
            if (empty($recital->fecha) || empty($recital->lugar) || empty($recital->artista_id)) {
                $this->view->response("Todos los campos deben estar completos", 400);
            } else {
                $id = $this->model->insert($recital->fecha, $recital->lugar, $recital->artista_id);
                $recital = $this->model->getrecitalById($id);
                $this->view->response("El recital $id fue añadido correctamente", 201);
        }
        } catch (Exception){
        $this->view->response("El servidor no pudo interpretar la solicitud dada una sintaxis invalida", 400);
        }
    }

     //----------------------------Funcion edit--------------------//
    public function updateRecital($params = null){
        $recital = $this->getData();
        $recital_id = $params[':ID'];
        try{
            if ($recital){
            if (empty($recital->fecha) || empty($recital->lugar) || empty($recital->artista_id)){
                $this->view->response("Todos los campos deben estar completos",400);
          }else {
            $recital = $this->model->update($recital_id,$recital->fecha,$recital->lugar,$recital->artista_id);
            $this->view->response("Recital con id: $recital_id actualizada con exito",200);
           }
        }
        }catch (Exception) {
            $this->view->response("El servidor no pudo interpretar la solicitud dada una sintaxis invalida", 400);
        }
      }


}