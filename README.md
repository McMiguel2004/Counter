#!/bin/bash

# Nombre del proyecto
PROJECT_NAME="Counter"

# Crear el archivo README.md y escribir el contenido
cat <<EOL > README.md
# $PROJECT_NAME

![Counter Logo](assets/imagenes_productos/logo.png)

## Descripción

$PROJECT_NAME es una aplicación web dinámica desarrollada en PHP que permite gestionar, visualizar y editar datos obtenidos mediante técnicas de web scraping con Selenium en Python. El proyecto incorpora autenticación segura mediante tokens JWT, un panel de administración protegido y soporte para múltiples idiomas, garantizando una experiencia de usuario moderna y responsiva gracias al uso de Bootstrap y TWIG.

## Tecnologías Utilizadas

- **Front-end:** Bootstrap, TWIG
- **Back-end:** PHP, autenticación con JWT
- **Base de Datos:** MySQL
- **Scraping de Datos:** Selenium con Python
- **Internacionalización:** Gettext
- **Visualización de Datos:** Chart.js, Google Maps / OpenStreetMap

## Características Principales

- **Autenticación Segura:** Implementación de autenticación mediante JWT, asegurando que solo usuarios autorizados puedan acceder al panel de administración y gestionar datos sensibles.
- **Scraping de Datos:** Uso de Selenium en Python para extraer datos de fuentes externas, que luego se almacenan en la base de datos para su gestión y visualización.
- **Panel de Administración:** Interfaz protegida para la gestión de productos, permitiendo la edición, actualización y eliminación de datos de manera sencilla.
- **Internacionalización:** Soporte para múltiples idiomas (español e inglés) utilizando la biblioteca Gettext, facilitando la adaptación de la aplicación a diferentes regiones.
- **Visualización de Datos:** Integración de librerías como Chart.js y servicios de mapas como Google Maps o OpenStreetMap para representar la información de manera gráfica y geolocalizada.
- **Arquitectura Modular:** Estructura del código organizada en módulos claros y separados, facilitando la mantenibilidad y escalabilidad del proyecto.

## Estructura del Proyecto

\`\`\`
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
\`\`\`

## Instalación y Configuración

### 1. Clonar el Repositorio

\`\`\`bash
git clone https://github.com/McMiguel2004/Counter.git
cd Counter
\`\`\`

### 2. Configurar la Base de Datos

- Crear una base de datos en MySQL.
- Importar el archivo \`db/schema.sql\` que contiene la estructura de las tablas.
- Editar el archivo \`db/conexion.php\` con las credenciales de acceso a la base de datos.

### 3. Configurar el Servidor

Asegúrate de tener instalado un servidor web como Apache y PHP. Configura un host virtual para \`Counter\` en \`/var/www/html/\` o utiliza soluciones como XAMPP o LAMP.

### 4. Instalar Dependencias

Ejecuta Composer para instalar las dependencias necesarias, incluyendo la biblioteca para JWT:

\`\`\`bash
composer install
\`\`\`

### 5. Configurar Variables de Entorno

Crea un archivo \`.env\` en la raíz del proyecto con las siguientes variables:

\`\`\`
DB_HOST=localhost
DB_USER=usuario
DB_PASS=contraseña
DB_NAME=counter
JWT_SECRET=clave_secreta
\`\`\`

### 6. Ejecutar el Script de Scraping

Ejecuta el script de scraping desarrollado en Python para extraer y almacenar los datos en la base de datos:

\`\`\`bash
python3 scraping.py
\`\`\`

## Uso del Proyecto

1. **Página Principal:** Accede a la página principal para visualizar los productos obtenidos mediante scraping.
2. **Registro e Inicio de Sesión:** Regístrate e inicia sesión para acceder a funcionalidades adicionales.
3. **Panel de Administración:** Gestiona los productos desde el panel de administración, disponible solo para usuarios autenticados.
4. **Cambio de Idioma:** Cambia el idioma de la interfaz entre español e inglés según tu preferencia.
5. **Visualización de Datos:** Explora las representaciones gráficas y mapas disponibles para una mejor comprensión de la información.

## Capturas de Pantalla

![Página Principal](assets/imagenes_productos/home.png)
*Figura 1: Vista de la página principal mostrando los productos.*

![Panel de Administración](assets/imagenes_productos/admin.png)
*Figura 2: Panel de administración para la gestión de productos.*

## Contribuciones

Si deseas contribuir al proyecto, sigue estos pasos:

1. Realiza un **fork** del repositorio.
2. Crea una nueva rama con la funcionalidad o mejora que deseas implementar.
3. Envía un **pull request** detallando los cambios realizados.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo \`LICENSE\` para más detalles.

---

**Desarrollado por [McMiguel2004](https://github.com/McMiguel2004)** 🚀
EOL

# Mensaje de confirmación
echo "README.md ha sido generado exitosamente."
