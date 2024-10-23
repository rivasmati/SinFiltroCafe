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

-- Inserción de registros en la tabla Categorias
INSERT INTO Categorias (nombre, descripcion) VALUES
('Café', 'Variedades de café y sus derivados'),
('Bebidas', 'Bebidas frías y calientes');

-- Inserción de registros en la tabla Productos
INSERT INTO Productos (nombre, descripcion, precio, stock, categoria_id) VALUES
('Café Americano', 'Café negro de origen', 2.50, 100, 1),
('Té Verde', 'Té verde con hojas frescas', 3.00, 50, 2);

-- Inserción de registros en la tabla Clientes con los nuevos campos
INSERT INTO Clientes (nombre, email, telefono, fecha_registro) VALUES
('Juan Pérez', 'juan.perez@example.com', '555-1234', '2023-01-15'),
('Ana López', 'ana.lopez@example.com', '555-5678', '2023-03-20');

-- Inserción de registros en la tabla Pedidos
INSERT INTO Pedidos (cliente_id, medio_pago, estado_pedido) VALUES
(1, 'Tarjeta', 'Pendiente'),
(2, 'Efectivo', 'Preparado');

-- Inserción de registros en la tabla Detalle_Pedido
INSERT INTO Detalle_Pedido (pedido_id, producto_id, cantidad) VALUES
(1, 1, 2),  -- Pedido de Juan Pérez (Café Americano)
(2, 2, 1);  -- Pedido de Ana López (Té Verde)