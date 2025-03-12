# Counter

Este es un proyecto de página web dinámica en PHP que permite gestionar, visualizar y editar datos provenientes de una fuente externa mediante técnicas de web scraping con Selenium en Python. El proyecto implementa autenticación segura con JWT, un panel de administración protegido, e internacionalización para soportar múltiples idiomas.

## Tecnologías Utilizadas

- **PHP**: Backend para la lógica de la aplicación.
- **Selenium con Python**: Para realizar el scraping de datos.
- **JWT (JSON Web Tokens)**: Autenticación segura de usuarios.
- **MySQL**: Base de datos para almacenar los datos scrapeados.
- **Bootstrap**: Framework CSS para un diseño responsive y moderno.
- **TWIG**: Motor de plantillas para representar los datos dinámicamente.
- **JavaScript (Chart.js, D3.js, Google Maps)**: Para mostrar gráficas y mapas interactivos.
- **gettext**: Para implementar la internacionalización de la aplicación (soporta inglés y español).

## Estructura del Proyecto

La estructura del proyecto es la siguiente:

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
│   └── jwt.php
│   └── funciones.php
│   └── lang.php
├── api/
│   └── auth.php
└── vendor

