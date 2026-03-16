CREATE TABLE bodegas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE sucursales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INTEGER REFERENCES bodegas(id)
);

CREATE TABLE monedas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    simbolo VARCHAR(10)
);

CREATE TABLE materiales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INTEGER REFERENCES bodegas(id),
    sucursal_id INTEGER REFERENCES sucursales(id),
    moneda_id INTEGER REFERENCES monedas(id),
    precio NUMERIC(10,2) NOT NULL,
    descripcion TEXT
);

CREATE TABLE producto_material (
    producto_id INTEGER REFERENCES productos(id),
    material_id INTEGER REFERENCES materiales(id),
    PRIMARY KEY (producto_id, material_id)
);


INSERT INTO bodegas (nombre) VALUES
('Bodega 1'),
('Bodega Norte'),
('Bodega Sur');

INSERT INTO sucursales (nombre, bodega_id) VALUES
('Sucursal 1',1),
('Sucursal 2',1),
('Sucursal Norte',2),
('Sucursal Sur',3);

INSERT INTO monedas (nombre, simbolo) VALUES
('Peso Chileno','$'),
('Dólar','USD'),
('Euro','€');

INSERT INTO materiales (nombre) VALUES
('Plástico'),
('Metal'),
('Madera'),
('Vidrio'),
('Textil');