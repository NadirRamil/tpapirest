# API REST para el recurso de recitales

## Importar la base de datos
- importar desde PHPMyAdmin (o cualquiera) database/tpespecial.sql

## INTRODUCCION:

El servicio permite listar los recitales cuya base de datos se encuentra almacenada en tpespecial. Permite agregar, editar y eliminar diferentes registros.Tambien, es posible realizar consultas filtrando por campo : id_recital, fecha, lugar,artista_id. Permitiendo realizar un paginado y un ordenamiento de forma ascendente o descendente.

## Pueba con postman
El endpoint de la API es: http://localhost/tpapirest/api/recitales


# Recurso	           Método	                Endpoint	                        status    
Get recitales 	    GET	      http://localhost/tpapirest/api/recitales/	  200  
Get recital by ID     GET	      http://localhost/tpapirest/api/recitales/:ID	  200
Create recital        POST	      http://localhost/tpapirest/api/recitales/	  201   
Update recital	    PUT	      http://localhost/tpapirest/api/recitales/:ID	  200
Delete recital	    DELETE	      http://localhost/tpapirest/api/recitales/:ID	  200



## CODIGOS DE RESPUESTA HTTP:
200 OK :
Se da cuando una solicitud realizada por el usuario tuvo éxito.

201 CREATED :
Es la respuesta cuando se ha modificado o creado un recurso exitosamente.

400 BAD REQUEST :
Indica que el servidor no puede o no procesara la petición debido a que algo es percibido como un error del cliente.

404 NOT FOUND :
Indica que una página buscada no puede ser encontrada aunque la petición este correctamente hecha.

500 INTERNAL SERVER ERROR :
Indica que el servidor encontró una condición inesperada que le impide completar la petición

## RECURSOS:

## GET Obtener lista de recitales:
http://localhost/tpapirest/api/recitales
Retorna la lista de todos los recitales que estan en la base de datos. 

## GET obtener un recital:
http://localhost/tpapirest/api/recitales/:ID
Retorna un único recital con el id indicado, mostrando mas detalladamente informacion sobre el artista

## POST un recital:
http://localhost/tpapirest/api/recitales

(Los parametros ID son autoincrementables no se tiene que pasar)
Agregar un nuevo recital.
Para cargar los datos, usamos la salida en formato JSON. Para ello, lo escribimos en el body de la solicitud.

  {
        "fecha": "2022-12-22",
        "lugar": "La Bombonera",
        "artista_id": 3
  }
    
-El "artista_id" tiene que tener un valor numerico que coincida con el id de algun item
de la tabla artista de la base de datos

## PUT un recital:
http://localhost/tpapirest/api/recitales/:ID

Editar un recital.
Para cargar los datos, usamos la salida en formato JSON. Para ello, lo escribimos en el body de la solicitud.

  {
        "fecha": "2022-12-22",
        "lugar": "La Bombonera",
        "artista_id": 3
  }

## EJEMPLOS:

Lista todos los recitales:
http://localhost/tpapirest/api/recitales

Filtrar por ID:
http://localhost/tpapirest/api/recitales/5

Order por fecha desc:
http://localhost/tpapirest/api/recitales?orderBy=fecha&order=desc
 
Order por fecha asc:
http://localhost/tpapirest/api/recitales?orderBy=lugar&order=asc

Filtrar por column "fecha" con el valor "2022-10-06" :
http://localhost/tpapirest/api/recitales?filtercolumn=fecha&filtervalue=2022-10-06

Order por fecha desc y page 2 (limit 3 por page):
http://localhost/tpapirest/api/recitales?orderBy=fecha&order=asc&page=2&limit=3

Filtrar por column "lugar"con el valor "Estadio José Amalfitani" orderBy "fecha" order desc - page 1 limit 3:
http://localhost/tpapirest/api/recitales?filtercolumn=lugar&filtervalue=Estadio José Amalfitani&orderBy=fecha&order=desc&page=1&limit=3

## PARAMETROS:

|Parámetro | Descripción |
| ------------ | ------------|
| filtercolumn | Indica la columna por la que se filtrarán los datos.|
| filtervalue | Indica el valor por el cual se filtrará.|
| orderBy | Indica la columna por la cual se ordenaran los datos.|
| order | Indica el tipo de ordenamiento asc o desc.|
| page | Página que se quiere observar.|
| limit | Indica la cantidad registros que se mostrarán por página.|


# Ordenar :
Los resultados se pueden ordenar agregando los parámetros orderBy (columna por ordenar) y order (asc o desc) a las solicitudes GET
asc= Ascendente
desc= Descendente

Por ejemplo:
Se mostrarán los recitales ordenados de manera ascendente considerando la fecha.

http://localhost/tpapirest/api/recitales?orderBy=fecha&order=asc

# Filtrar por condición :
Los resultados se pueden devolver filtrados por columna agregando los parámetros de consulta filtercolumn (campo para filtrar) y filtervalue a la solicitud GET.

Por ejemplo:
Se mostraran los recitales que en la columna fecha indique 2022-10-06.
http://localhost/tpapirest/api/recitales?filtercolumn=fecha&filtervalue=2022-10-06


## Paginacion: 
Podrá paginar los resultados agregando el límite y los parámetros de consulta de página a las solicitudes GET
Por ejemplo:
Se mostrarán los 4 recitales que se encuentran en la página 3.

http://localhost/tpapirest/api/recitales?page=3&limit=4




