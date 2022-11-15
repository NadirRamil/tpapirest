<?php

class RecitalesModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tpespecial;charset=utf8', 'root', '');
    }

    //----------------------------Function getAll --------------------//
    public function getAll($orderBy, $order, $page, $limit){
        $offset = $page * $limit - $limit;
        $query = $this->db->prepare("SELECT * FROM recitales
                                     ORDER BY $orderBy $order 
                                     LIMIT $limit OFFSET $offset");
        $query->execute();
        $recitales = $query->fetchAll(PDO::FETCH_OBJ); 
        return $recitales;
    }
    //----------------------------Function getAllColumns--------------------//
    public function getAllByColumn($orderBy, $order, $limit, $page, $filtercolumn, $filtervalue){
        $offset = $page * $limit - $limit;
        $params = []; 
        $query = $this->db->prepare("SELECT * FROM recitales WHERE $filtercolumn = ? 
                  ORDER BY $orderBy $order LIMIT $limit OFFSET $offset");
        array_push($params, $filtervalue);
        $query->execute($params);
        $recitales = $query->fetchAll(PDO::FETCH_OBJ); 
        return $recitales;
    }
                                                                   
    //----------------------------Function get --------------------//
    public function getrecitalById($id){
        $query = $this->db->prepare("SELECT a.*, b.* FROM recitales a 
                                     INNER JOIN artistas b ON a.artista_id = b.artista_id
                                     WHERE id_recital = ?");
        $query->execute(array($id));
        $recital = $query->fetch(PDO::FETCH_OBJ);
        return $recital;
    }

    //----------------------------Funcion delete--------------------//
    public function delete($id){
        $sentencia = $this->db->prepare("DELETE FROM recitales WHERE id_recital = ?");
        $response = $sentencia->execute(array($id));
    }

     //----------------------------Funcion insert--------------------//
    public function insert($fecha, $lugar, $artista_id){
        $query = $this->db->prepare("INSERT INTO recitales (fecha, lugar, artista_id) VALUES (?, ?, ?)");
        $query->execute([$fecha, $lugar, $artista_id]);

        return $this->db->lastInsertId();
    }

    //----------------------------Funcion edit --------------------//
    public function update($id, $fecha, $lugar, $artista_id){
        $query = $this->db->prepare("UPDATE recitales SET fecha= ?, lugar = ?, artista_id = ? 
                                     WHERE id_recital = ?");
        $query->execute([$fecha, $lugar, $artista_id, $id]);
    }
    
    
}