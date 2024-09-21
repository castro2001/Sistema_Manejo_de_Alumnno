-- Active: 1719858241057@@127.0.0.1@3306@u531517694_controlescolar
DROP DATABASE u531517694_controlescolar;
CREATE DATABASE u531517694_controlescolar;
USE u531517694_controlescolar;

-- TABLA BBDD
CREATE TABLE `usuario`(
    id INT AUTO_INCREMENT NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    password VARCHAR(100),
    rol VARCHAR(100), -- Puedes reconsiderar si ENUM es necesario aquí
    PRIMARY KEY (id)
);

CREATE TABLE `tutor`(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    n_celular VARCHAR(10) NOT NULL,
    ocupacion TEXT,
    PRIMARY KEY(id)
);

CREATE TABLE `alumno`(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    n_celular VARCHAR(10) NOT NULL,
    escuela_procedencia VARCHAR(255) NOT NULL,
    situacion_academica TEXT,
    id_tutor INT,
    status TINYINT(1) DEFAULT 1, -- 1 = activo, 0 = inactivo
    PRIMARY KEY (id),
    FOREIGN KEY (id_tutor) REFERENCES tutor(id)
);

CREATE TABLE `materia`(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    docente VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (id)
);
CREATE TABLE `alumno_materia_horarios`(
    id INT AUTO_INCREMENT ,
    id_alumno INT,
    id_materia INT,
    dia_semana ENUM('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes','Sabado','Domingo'),
    hora_inicio TIME,
    hora_fin TIME,
    PRIMARY KEY(id),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id),
    FOREIGN KEY (id_materia) REFERENCES materia(id)
) COMMENT 'Maestro detalle';

CREATE TABLE `pagos` (
    id INT AUTO_INCREMENT NOT NULL,
    codigo VARCHAR(100) UNIQUE, -- Código del pago único
    id_alumno INT,
    metodo_pago ENUM('Efectivo', 'Transferencia'),
    monto DECIMAL(10,2), -- Monto inicial
    descuentos INT, -- Descuento aplicado
    observacion TEXT,
    total DECIMAL(10,2),
    
    status TINYINT(1) DEFAULT 0, -- 0 = pendiente, 1 = pagado
    PRIMARY KEY(id),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id)
);


-- DATOS POR DEFECTOS


-- Insertar datos en la tabla `tutor`
INSERT INTO usuario(usuario,password,rol) VALUES('Administrador','Admin4578','Administrador');

INSERT INTO tutor (nombre, n_celular, ocupacion) VALUES 
('Carlos Pérez', '0987654321', 'Ingeniero'),
('Ana Martínez', '0986543210', 'Docente'),
('Luis Sánchez', '0985432109', 'Abogado'),
('Alexis Gomez', '0985432109', 'Albañil');

-- Insertar datos en la tabla `alumno`
INSERT INTO alumno (nombre, fecha_nacimiento, direccion,foto, n_celular, escuela_procedencia, situacion_academica, id_tutor) VALUES 
('Juan López', '2010-03-12', 'Av. Principal 123','1726579500_66e9832c62d0d.jpg' ,'0981234567', 'Escuela Central', 'Buen rendimiento académico', 1),
('María Gómez', '2009-07-24', 'Calle Secundaria 456','1726538541_66e8e32dcf8e0.webp', '0982345678', 'Escuela Secundaria', 'Regular rendimiento académico', 2),
('Pedro Ramírez', '2011-01-30', 'Av. Tercera 789', '1726540221_66e8e9bdc931f.jpg','0983456789', 'Escuela Sur', 'Excelente rendimiento académico', 3),
('Marcos López', '2010-03-12', 'Av. Principal 123', '1726540386_66e8ea62e0e67.jpeg','0981234567', 'Escuela Central', 'Buen rendimiento académico', 4);

-- Insertar datos en la tabla `materia`

INSERT INTO materia (nombre, docente, descripcion) VALUES 
('Matemáticas', 'Dr. Fernando Torres', 'Introducción a las matemáticas básicas'),
('Ciencias', 'Lic. Laura Castro', 'Estudio de las ciencias naturales'),
('Historia', 'Prof. Juan Paredes', 'Historia del Ecuador y el mundo'),
('Progrmación', 'Prof. Juan Paredes', 'Historia del Ecuador y el mundo');

INSERT INTO alumno_materia_horarios (id_alumno, id_materia,dia_semana,hora_inicio,hora_fin) VALUES 
(1, 1,'Lunes', '08:00', '10:00'), -- Juan López está inscrito en Matemáticas
(2, 4,'Miércoles', '11:00', '13:30'), -- Juan López está inscrito en Ciencias
(3, 2,'Martes', '9:00', '10:40'), -- María Gómez está inscrita en Ciencias
(4,3,'Jueves', '15:00', '18:30'); -- María Gómez está inscrita en Ciencias
-- Insertar datos en la tabla `pagos`
INSERT INTO pagos (codigo, id_alumno, metodo_pago, monto, descuentos,observacion, total, status) 
VALUES 
('PAG001', 1, 'Efectivo', 150.00, 10, "Pago del primer semestre",149.99, 1), -- Juan López pagó el semestre con efectivo
('ERF004',2,'Transferencia', 150.00, 5, 'Pago Pendiente',00.00,0), -- María Gómez tiene un pago pendiente
(  'ERF008',3,'Efectivo', 150.00,3, 'Pago Pendiente del primer semestre', 0.00,0); 
-- Insertar datos en la tabla `alumno_materia`





-- Acctualizar incremmenntte aa 1 solo debe poner la tabla correspondiente
ALTER TABLE materia AUTO_INCREMENT =1;


    
