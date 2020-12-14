# Argus


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