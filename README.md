# Counter

**Counter** es un proyecto desarrollado en PHP con autenticación JWT, scraping de datos y una interfaz administrable.

## Objetivo

El objetivo de este proyecto es la creación de una página web dinámica en PHP que permita la gestión, visualización y edición de datos obtenidos de una fuente externa mediante web scraping. Además, se implementará autenticación segura con JWT, una interfaz de administración protegida y soporte para múltiples idiomas.

## Requisitos

Para que este proyecto funcione correctamente, primero debes clonar y configurar el proyecto [Scraping](https://github.com/McMiguel2004/Scraping), desarrollado en Python, que se encarga de extraer los datos necesarios.

Además, este proyecto está diseñado para ejecutarse en un servidor Apache, por lo que debes colocar la carpeta en `/var/www/`.

## Estructura del Proyecto

```
Counter/
├── src/
│   ├── Graficas/
│   │   └── graficas.php
│   ├── Home.php
│   ├── locales/
│   │   ├── en.json
│   │   └── es.json
│   ├── logs.txt
│   ├── Panel/
│   │   └── Modificar-productos.php
│   ├── Productos/
│   │   ├── comprar.php
│   │   └── productos.php
│   ├── Sesion/
│   │   ├── login.php
│   │   ├── logout.php
│   │   └── registrar.php
│   └── templates/
│       └── productos.twig
├── assets/
│   ├── css/
│   └── imagenes_productos/
├── db/
│   └── conexion.php
├── includes/
│   ├── jwt.php
│   ├── funciones.php
│   └── lang.php
├── api/
│   └── auth.php
└── vendor/
```

## Instalación

1. Clona este repositorio en `/var/www/`:
   ```sh
   cd /var/www/
   git clone https://github.com/McMiguel2004/Counter.git
   ```
2. Asegúrate de tener instalado Apache y PHP en tu sistema.
3. Configura los permisos adecuados para los archivos y carpetas.
4. Instala las dependencias necesarias ejecutando:
   ```sh
   composer install
   ```
5. Configura la base de datos en `db/conexion.php`.
6. Accede al proyecto desde tu navegador (`http://localhost/Counter`).

## Características

- **Autenticación JWT**: Protección de rutas y sesiones seguras.
- **Scraping de datos**: Integración con el proyecto Scraping para obtener información.
- **Gráficos y mapas**: Representación visual de datos con Chart.js o GoogleMaps.
- **Panel de administración**: Gestión de productos y datos scrapeados.
- **Internacionalización**: Soporte para múltiples idiomas (es/en).
- **Sistema de routing en PHP**: Separación de rutas para mejor mantenibilidad.
- **Gestión de sesiones y cookies**: Para mantener la autenticación de usuarios incluso tras cerrar el navegador.

## Tecnologías Utilizadas

- **PHP** con autenticación JWT.
- **Bootstrap y TWIG** para el diseño y la representación de datos.
- **Selenium con Python** para el scraping de datos.
- **MySQL** para la gestión de la base de datos.
- **Chart.js, D3.js o GoogleMaps/OpenStreetMap** para la visualización de datos.
- **gettext** para la internacionalización de la aplicación.

## Modelo de Datos en Base de Datos

El modelo de datos está estructurado para permitir futuras ampliaciones sin grandes modificaciones. Contará con al menos tres tablas relacionadas para almacenar la información scrapeada y gestionar usuarios.

## Contribuciones

Si deseas contribuir, haz un fork del repositorio y envía un pull request con tus mejoras.

## Licencia

Este proyecto está bajo la licencia MIT.

