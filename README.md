Counter

   

📌 Descripción

Counter es una aplicación web dinámica desarrollada en PHP que permite la gestión, visualización y edición de datos extraídos mediante web scraping con Selenium y Python. El proyecto incluye autenticación segura con JWT, un panel de administración protegido y soporte para múltiples idiomas.

📁 Estructura del Proyecto

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

🚀 Funcionalidades Principales

✅ Autenticación con JWT: Inicio de sesión seguro con persistencia de sesión mediante cookies y sesiones.
✅ Scraping con Selenium y Python: Extracción automatizada de datos desde una web pública.
✅ Internacionalización: Soporte para múltiples idiomas (Español e Inglés).
✅ Panel de Administración: Gestión de datos scrapeados con control de usuarios autenticados.
✅ Front-end moderno: Implementado con Bootstrap y Twig para un diseño responsive y dinámico.
✅ Gráficos y visualización: Integración de gráficos dinámicos con Chart.js u otra librería similar.

🛠️ Tecnologías Utilizadas

Back-end: PHP 8, JWT para autenticación.

Front-end: Bootstrap 5, Twig para plantillas dinámicas.

Base de datos: MySQL.

Scraping: Python con Selenium.

Internacionalización: JSON y gettext.

Gráficos: Chart.js, GoogleMaps, OpenStreetMap.

⚙️ Instalación y Configuración

📌 Requisitos Previos

PHP 8.0+

Composer

MySQL

Python 3 y Selenium

Servidor web (Apache o Nginx)

📥 Instalación

Clona el repositorio:

git clone https://github.com/McMiguel2004/Counter.git
cd Counter

Instala las dependencias de PHP:

composer install

Configura la base de datos en db/conexion.php.

Configura las claves JWT en includes/jwt.php.

Ejecuta el script de scraping en Python:

python scraping.py

Inicia el servidor web y accede a http://localhost/counter.

🔒 Seguridad

🔹 Uso de JWT para autenticación segura.
🔹 Restricción de acceso al panel de administración.
🔹 Gestión segura de sesiones y cookies.

📜 Licencia

Este proyecto está bajo la licencia MIT. Puedes ver más detalles en el archivo LICENSE.

✉️ Contacto

Proyecto desarrollado por McMiguel2004. Para dudas o sugerencias, abre un issue o contáctame directamente.

🚀 ¡Disfruta usando Counter! 🎮

