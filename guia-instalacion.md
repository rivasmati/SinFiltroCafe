Para instalar la base de datos se deben seguir los siguientes pasos:
1- Entrar a "localhost/phpmyadmin"
2- Crear una base de datos con nombre "cafeteria"
3- Ir a la ventana "Importar"
4- Hacer click en "Seleccionar archivo" y seleccionar el archivo "cafeteria.sql"
5- Hacer click en "Importar"

En caso de tener problemas, se puede pegar la siguiente sentencia sql a una base de datos con el nombre "cafeteria".


-- Creación de la tabla Categorias
CREATE TABLE Categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255)
);

-- Creación de la tabla Productos
CREATE TABLE Productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    categoria_id INT,
    imagen VARCHAR(55),  -- Campo para almacenar la ruta o nombre de la imagen
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

-- Creación de la tabla Clientes con los nuevos campos "telefono" y "fecha_registro"
CREATE TABLE Clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    fecha_registro DATE DEFAULT CURRENT_DATE
);

-- Creación de la tabla Pedidos sin el campo "tipo_consumo"
CREATE TABLE Pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    medio_pago ENUM('Efectivo', 'Tarjeta', 'App') NOT NULL,
    estado_pedido ENUM('Pendiente', 'Preparado', 'Entregado', 'Cancelado') NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id)
);

-- Creación de la tabla Detalle_Pedido
CREATE TABLE Detalle_Pedido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES Productos(id)
);

-- Creación de la tabla Usuarios
CREATE TABLE Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

INSERT INTO Usuarios (usuario, contrasena) VALUES
    ('admin', 'admin'),  -- Usuario administrador 1
    ('user', '123456');  -- Usuario administrador 2

INSERT INTO Categorias (id, nombre, descripcion) VALUES
    (1, 'Café', 'Productos a base de café'),
    (2, 'Bebidas', 'Bebidas no alcohólicas'),
    (3, 'Dulce', 'Productos de pastelería y dulces'),
    (4, 'Salado', 'Snacks y productos salados');

INSERT INTO Productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES
    -- Café (categoria_id = 1)
    ('Café Americano', 'Café negro de origen', 2.50, 50, 1, 'cafe-americano.png'),
    ('Café Expresso', 'Café expreso intenso', 3.00, 40, 1, 'cafe-expresso.png'),
    ('Café con Leche', 'Café suave con leche', 3.20, 30, 1, 'cafe-leche.png'),
    ('Capuchino', 'Capuchino espumoso con canela', 3.50, 25, 1, 'capuccino.png'),

    -- Bebidas (categoria_id = 2)
    ('Té Verde', 'Té verde con hojas frescas', 2.00, 35, 2, 'te-verde.png'),
    ('Té Negro', 'Té negro clásico', 2.00, 40, 2, 'te-negro.png'),
    ('Limonada', 'Limonada natural con menta', 2.80, 50, 2, 'limonada.png'),
    ('Jugo de Naranja', 'Jugo de naranja recién exprimido', 3.50, 45, 2, 'jugo-naranja.png'),

    -- Dulce (categoria_id = 3)
    ('Croissant de Chocolate', 'Croissant relleno de chocolate', 2.00, 20, 3, 'croissant.png'),
    ('Muffin de Arándanos', 'Muffin esponjoso con arándanos', 2.50, 25, 3, 'muffin-arandanos.png'),
    ('Tarta de Manzana', 'Tarta de manzana casera', 3.00, 15, 3, 'tarta-manzana.png'),

    -- Salado (categoria_id = 4)
    ('Avocado Toast', 'Tostada con aguacate y especias', 3.50, 10, 4, 'avocado-toast.png'),
    ('Sándwich de Jamón y Queso', 'Clásico sándwich de jamón y queso', 3.00, 30, 4, 'sandwich-jyq.png'),
    ('Bagel con Salmón', 'Bagel con salmón ahumado y queso crema', 4.00, 15, 4, 'bagel.png');

INSERT INTO Clientes (nombre, email, telefono, fecha_registro) VALUES
    ('Juan Pérez', 'juan.perez@example.com', '123456789', '2023-10-01'),
    ('Maria Lopez', 'maria.lopez@example.com', '987654321', '2023-10-05'),
    ('Carlos García', 'carlos.garcia@example.com', '555123456', '2023-10-10'),
    ('Ana Sánchez', 'ana.sanchez@example.com', '111222333', '2023-10-15');

ALTER TABLE detalle_pedido
DROP FOREIGN KEY detalle_pedido_ibfk_2;

ALTER TABLE detalle_pedido
ADD CONSTRAINT detalle_pedido_ibfk_2 FOREIGN KEY (producto_id)
REFERENCES productos(id)
ON DELETE CASCADE;

ALTER TABLE pedidos
DROP FOREIGN KEY pedidos_ibfk_1;

ALTER TABLE pedidos
ADD CONSTRAINT pedidos_ibfk_1 FOREIGN KEY (cliente_id)
REFERENCES clientes(id)
ON DELETE CASCADE;

ALTER TABLE detalle_pedido
DROP FOREIGN KEY detalle_pedido_ibfk_1;

ALTER TABLE detalle_pedido
ADD CONSTRAINT detalle_pedido_ibfk_1 FOREIGN KEY (pedido_id)
REFERENCES pedidos(id)
ON DELETE CASCADE;

INSERT INTO Pedidos (cliente_id, fecha_pedido, medio_pago, estado_pedido) VALUES
    (1, '2023-10-11 10:30:00', 'Efectivo', 'Entregado')