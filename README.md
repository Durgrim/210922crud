# 210922crud
# Fullstack challenge

### Pre-requisitos
_Para poder utilizar la aplicación tienes que tener instalado los siguientes programas y paquetes de PHP:_
* PHP 8
* Symfony
* Composer
* Bootstrap

### Instalación y despliegue
_Para descargar el proyecto e instalar las dependencias_
``` git clone https://github.com/Durgrim/210922crud.git ```
``` composer install ```

_Desplegarlo en xampp local (BBDD de mysql configurada con la tabla productos)_
_Crear la BBDD_
```sql
CREATE DATABASE catalog;
CREATE TABLE product (
    uuid INT NOT NULL AUTO_INCREMENT,
    product_type VARCHAR(50) NOT NULL,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(250) NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT pk_product_idproduct PRIMARY KEY(uuid)
    );
```

_Iniciar servidor de Symfony_
symfony sever:start

## Construido con las siguientes herramientas
* [PHP](https://www.php.net/) - PHP: Hypertext Preprocessor
* [Symfony](https://symfony.com/) - PHP web application framework
* [Composer](https://getcomposer.org/) - Gestor de paquetes para PHP
* [Bootstrap](https://getbootstrap.com/) - Responsive CSS framework 


## Autor ✒️
* **Javier Rodrigo** - [Durgrim](https://github.com/durgrim)
---
[Durgrim](https://github.com/durgrim)