# Argus 2.3.0
Framework propio programado con PHP, OPP, MVC y MySQL para realizar proyectos freelance de una manera mas rapida y sencilla, ya que cuenta con las herramientas, clases y elementos que habitualmente ocupo al desarrollar un nuevo sistema, y con cada sistema que realizo con este framework poco a poco voy agregando mas funcionalidades a la base del mismo.

## configuracion en un entorno local
### Pre-requisitos
- [LANDO](https://lando.dev/)

### Configuracion
1. iniciar el proyecto con el comando `lando start`
2. configurar el proyecto con el comando `lando dev`

despues seguir todos los pasos ya se puede iniciar session con los siguientes datos `usuario: admin` `password: adminroot`

## configuracion en un servidor remoto
### Pre-requisitos
- php8.1
- composer
- npm
- mysql

### Configuracion
1. crear archivo `.env` basado en `example.env`

2. crear un `usuario: user_argus` con la `contraseña: pass_argus` en mysql

3. crear una `base de datos con el nombre argus` en mysql

4. asignar el usuario` user_argus` a la base de datos `argus`

4. ejecutar el comando `composer install`

5. ejecutar el comando `npm install`

6. ejecuater el comando `npm run dev`

7. importar en la base de datos el archivo `base.sql`

despues seguir todos los pasos ya se puede iniciar session con los siguientes datos `usuario: admin` `password: adminroot`

## Licencia
[MIT license](https://opensource.org/licenses/MIT).
