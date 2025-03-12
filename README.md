# 📌 Desarrollo de una Página Web Dinámica en PHP

## 📋 Objetivo
El objetivo de esta práctica es desarrollar una página web dinámica en PHP que permita gestionar, visualizar y editar datos obtenidos mediante **web scraping** con Selenium en Python. Además, incluirá autenticación segura con **JWT**, una interfaz de administración protegida y soporte para **múltiples idiomas**.

---

## 🚀 Especificaciones Técnicas

### 🖥️ Front-end con Bootstrap y TWIG
- Implementación con **Bootstrap** para un diseño **responsive** y moderno.
- Uso de **TWIG** como sistema de plantillas para representar los datos scrapeados.
- Funcionalidades de búsqueda y filtrado de datos en la interfaz.

### 📊 Gráficas y Mapas
- Visualización de datos mediante librerías como **Chart.js, D3.js** o **Highcharts**.
- Uso de **GoogleMaps** o **OpenStreetMap** para la representación geolocalizada de datos.

### 🛣️ Routing en PHP
- Implementación de un sistema de **routing** que administre rutas como:
  - Página principal
  - Página de administración
  - Autenticación
- Código modular y mantenible.

### 🔐 Panel de Administración
- Accesible solo para usuarios **autenticados**.
- Permite la **gestión y edición** de los datos scrapeados.
- Datos almacenados en **MySQL**.

### 🔑 Autenticación con API y JWT
- Implementación de un sistema de **autenticación con JWT**.
- Uso de **cookies y sesiones** para mantener al usuario conectado.
- Protección de rutas sensibles.

### 🌍 Internacionalización
- Soporte para **múltiples idiomas** con **gettext**.
- Implementación mínima de **español** e **inglés**.

### 🕵️‍♂️ Scraping de Datos con Selenium y Python
- Extracción de datos de una web pública.
- Almacenamiento intermedio en **CSV o XML**.
- Inserción estructurada de datos en **MySQL**.

### 🗄️ Modelo de Datos en Base de Datos
- Estructura de datos **relacionada** con al menos **tres tablas**.
- Modelo flexible para futuras ampliaciones.
- Presentación previa del modelo antes del scraping.

### 🔄 Gestión de Sesiones y Cookies
- Implementación de sesiones y cookies para mantener la autenticación.
- Permite la persistencia de la sesión incluso tras cerrar el navegador.
  
## 🛠️ Instalación y Configuración

### 1️⃣ Clonar el Repositorio
```sh
git clone https://github.com/usuario/proyecto.git
cd proyecto
```

### 2️⃣ Instalar Dependencias
#### 📌 Backend (PHP)
```sh
composer install
```

#### 📌 Frontend (JavaScript y CSS)
```sh
npm install
```

### 3️⃣ Configurar Variables de Entorno
Crea un archivo `.env` en la raíz y añade:
```env
DB_HOST=localhost
DB_NAME=nombre_base
DB_USER=usuario
DB_PASS=contraseña
JWT_SECRET=secreto_super_seguro
```

### 4️⃣ Ejecutar el Scraping
```sh
python3 scripts/scraper.py
```

### 5️⃣ Iniciar el Servidor PHP
```sh
php -S localhost:8000
```

---

## 📌 Uso y Funcionalidades
- Accede a la página principal en `http://localhost:8000`
- Inicia sesión en `http://localhost:8000/login.php`
- Accede al panel de administración en `http://localhost:8000/admin.php`
- Cambia de idioma en la interfaz desde el menú de configuración

---

## 📜 Licencia
Este proyecto está bajo la licencia **MIT**.

---

## 📞 Contacto y Contribución
Si deseas contribuir, abre un **issue** o un **pull request** en GitHub. Para consultas, contáctame en [email@example.com](mailto:email@example.com).

---

¡Disfruta desarrollando! 🚀
