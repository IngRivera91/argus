# Argus
Framework propio programado con PHP, OPP, MVC y MySQL para realizar proyectos freelance de una manera mas rapida y sencilla, ya que cuenta con las herramientas, clases y elementos que habitualmente ocupo al desarrollar un nuevo sistema, y con cada sistema que realizo con este framework poco a poco voy agregando mas funcionalidades a la base del mismo.

Proyecto variables

### Pre-requisitos 
`Docker`

### Configuracion 


1. Crear el archivo `.env` con el contenido de `example.env`
2. abrir una terminal y ejecutar los siguientes comando:
```
docker-compose up -d
docker-compose exec -u webadmin web bash
cd /var/www/html/
composer install
php ./scripts/CrearDatabaseMySQL.php
```
3.  Acceder al sitio [localhost](http://localhost/ "localhost")

## Licencia
[MIT license](https://opensource.org/licenses/MIT).