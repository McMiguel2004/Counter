# Counter

## Descripción del Proyecto

Counter es una aplicación web dinámica desarrollada en PHP que permite gestionar, visualizar y editar datos extraídos mediante web scraping con Selenium en Python. El proyecto incluye autenticación segura con JWT, un panel de administración protegido y soporte multilenguaje.

## Características Principales

- **Front-end moderno** con Bootstrap y sistema de plantillas TWIG.
- **Scraping de datos** mediante Selenium en Python.
- **Gráficas interactivas** con librerías como Chart.js o D3.js.
- **Geolocalización** con Google Maps o OpenStreetMap.
- **Sistema de routing** en PHP para organizar las rutas de la aplicación.
- **Panel de administración** protegido con JWT.
- **Internacionalización** con gettext (español/inglés).
- **Gestón de sesiones y cookies** para mantener la sesión abierta.

## Tecnologías Utilizadas

- **Back-end**: PHP, MySQL, JWT
- **Front-end**: Bootstrap, TWIG, JavaScript
- **Scraping**: Python, Selenium
- **Gráficas y mapas**: Chart.js, D3.js, Google Maps API, OpenStreetMap

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

## Instalación y Configuración

### Requisitos Previos

- PHP 8+
- MySQL
- Composer
- Node.js (para dependencias del front-end)
- Python 3+ con Selenium instalado

### Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/McMiguel2004/Counter.git
   cd Counter
   ```

2. Instalar dependencias de PHP:
   ```bash
   composer install
   ```

3. Instalar dependencias del front-end:
   ```bash
   npm install
   ```

4. Configurar la base de datos:
   - Crear una base de datos en MySQL.
   - Importar el archivo `database.sql` en MySQL.

5. Configurar el entorno:
   - Copiar el archivo `.env.example` a `.env` y configurar las credenciales.

6. Configurar Selenium:
   - Instalar Selenium con pip:
     ```bash
     pip install selenium
     ```
   - Descargar el WebDriver correspondiente a tu navegador.

7. Iniciar el servidor:
   ```bash
   php -S localhost:8000 -t public/
   ```

## Uso del Proyecto

### Autenticación
- Registro de usuarios: `/src/Sesion/registrar.php`
- Inicio de sesión: `/src/Sesion/login.php`
- Cierre de sesión: `/src/Sesion/logout.php`

### Scraping de Datos
Ejecutar el script en Python para extraer datos:
```bash
python scripts/scraping.py
```

### Administración
Acceso al panel de administración para modificar los datos scrapeados: `/src/Panel/Modificar-productos.php`

## Contribución
Si deseas contribuir, por favor realiza un fork del repositorio y envía un pull request con tus mejoras.

## Licencia
Este proyecto está bajo la licencia MIT. Para más información, consulta el archivo `LICENSE`.

## Autor
**McMiguel2004**
GitHub: [McMiguel2004](https://github.com/McMiguel2004)
