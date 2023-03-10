<h1 align="center">Prueba técnica Hello Digital</h1>
<p align="center">Aplicación de administración de materias con inicio de sesión</p>

## Instalación y configuración

> Antes de instalar el proyecto es necesario clonar el proyecto de github y abrir una linea de comandos en el directorio del proyeco

1. Instalar las dependencias de composer 

```sh
   composer install
```

2. Instalar las dependencias de NPM

```sh
   npm install
```

3. Crear una copia del archivo env

```sh
   cp .env.example .env
```

4. Generar una nueva llave de cifrado
  
```sh
   php artisan key:generate
```

5. Modficar el archivo .env con los datos que coincidan con la base de datos que utilizará en su dispositivo.

    Los campos esenciales de modificar son `DB_HOST`, `DB_PORT`,`DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`

6. Migrar la base de datos

```sh
   php artisan migrate
```

7. Sembrar la base de datos

```sh
   php artisan db:seed
```

## Ejecución para pruebas

1. Ejecutar el servidor de Laravel

```sh
   php artisan serve
```

2. Ejecutar el servidor de Node

```sh
   npm run dev
```

3. Ir a la dirección indicada en la consola del servidor de Laravel