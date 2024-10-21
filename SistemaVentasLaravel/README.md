## SISTEMA DE PUNTO DE VENTA CON LARAVEL

Gestión de Punto de Venta y Facturación construido con Laravel 10 y MySql.

![image](https://github.com/user-attachments/assets/2d4a4b4d-c2e2-4906-96ac-dd0826283e52)

## 😎 Características
- POS
- Órdenes
  - Órdenes Pendientes
  - Órdenes Completas
  - Pendiente de Pago
- Gestión de Inventario
- Productos
  - Productos
  - Categorías
- Empleados
- Clientes
- Proveedores
- Salario
  - Adelanto de Salario
  - Pago de Salario
  - Historial de Pagos de Salario
- Asistencia
- Rol y Permiso
- Gestión de Usuarios
- Copia de Seguridad de la Base de Datos

## 🚀 Cómo Utilizar

1. **Clonar Repositorio o Descargar**

    ```bash
    git clone  
    ```

2. **Configuración**
    # Ingresar al repositorio
    ```bash
    cd laravel-point-of-sale
    ```

    # Instalar dependencias
    ```bash
    composer install
    ```
    
    # Abrir con tu editor de texto
    ```bash
    code .
    ```

3. **.ENV**

    Renombra o copia el archivo `.env.example` a `.env`
    # Generar clave de la aplicación
    ```bash
    php artisan key:generate
    ```

4. **Configuración Personalizada de Faker Locale**

    Para establecer Faker Locale, agrega esta línea de código al final del archivo `.env`.
    # En este caso, el locale está establecido en indonesio
    ```bash
    FAKER_LOCALE="id_ID"
    ```

5. **Configuración de la Base de Datos**

    Configura las credenciales de tu base de datos en tu archivo `.env`.

6. **Seed de la Base de Datos**
    ```bash
    php artisan migrate:fresh --seed
    ```

7. **Crear Enlace de Almacenamiento**

    ```bash
    php artisan storage:link
    ```

8. **Ejecutar Servidor**

    ```bash
    php artisan serve
    ```

9. **Inicio de Sesión**

    Intenta iniciar sesión con el nombre de usuario: `admin` y la contraseña: `password`

## 🚀 Configuración
1. **Configuración del Gráfico**

    Abre el archivo `./config/cart.php`. Puedes establecer impuestos, formato de números, etc.
    > Para más detalles, visita este enlace [hardevine/shoppingcart](https://packagist.org/packages/hardevine/shoppingcart).

2. **Crear Enlace de Almacenamiento**

    ```bash
    php artisan storage:link
    ```

3. **Ejecutar Servidor**

    ```bash
    php artisan serve
    ```

4. **Inicio de Sesión**

    Intenta iniciar sesión con el nombre de usuario: `admin` y la contraseña: `password`

    o nombre de usuario: `user` y contraseña: `password`
