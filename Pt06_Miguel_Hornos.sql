-- Creación de la base de datos
DROP DATABASE IF EXISTS pt06_miguel_hornos;
CREATE DATABASE IF NOT EXISTS `pt06_miguel_hornos` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt06_miguel_hornos`;


-- Creación de la tabla usuaris
CREATE TABLE `usuaris` (
    `ID` int(11) NOT NULL AUTO_INCREMENT, -- Clave primaria
    `nombreUsuario` varchar(50) NOT NULL, -- Nombre de usuario
    `contrasenya` varchar(255) NOT NULL, -- Contraseña
    `correo` varchar(100) NOT NULL, -- Correo
    `ciutat` varchar(100) NOT NULL, -- Ciudad
    `imatge` varchar(1024) DEFAULT NULL, -- Columna para almacenar la ruta de la imagen (opcional)
    `token` varchar(255) DEFAULT NULL, -- Nueva columna: Token para recuperación de contraseña
    `expiracio_token` datetime DEFAULT NULL, -- Nueva columna: Expiración del token
    `remember_token` varchar(255) DEFAULT NULL, -- Nueva columna: Token para recuperación de contraseña
    `remember_token_expiracio` datetime DEFAULT NULL, -- Nueva columna: Expiración del token
    PRIMARY KEY (`ID`), -- Clave primaria en el campo ID
    UNIQUE (`nombreUsuario`), -- El nombre de usuario debe ser único
    UNIQUE (`correo`) -- Aseguramos que no haya correos duplicados
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Inserción de datos en la tabla usuaris (asegúrate de tener usuarios para evitar errores)
INSERT INTO `usuaris` (`nombreUsuario`, `contrasenya`, `correo`, `ciutat`) VALUES
('Miguel', 'Contrasena1234_', 'miguel@gmail.com', 'Barcelona'),
('Frank', 'Contrasena1234_', 'frank@gmail.com', 'Madrid'),
('Hector', 'Contrasena1234_', 'hector@gmail.com', 'Lloret');

-- Creación de la tabla article
CREATE TABLE `article` (
  `ID` int(11) NOT NULL AUTO_INCREMENT, -- Clave primaria
  `marca` varchar(100) NOT NULL, -- Marca
  `model` varchar(100) NOT NULL, -- Modelo
  `any` int(4) NOT NULL,
  `color` varchar(50) NOT NULL, -- Color
  `matricula` varchar(20) NOT NULL, -- Matrícula
  `nom_usuari` varchar(50) DEFAULT NULL, -- Columna para el nombre de usuario que escribió el artículo
  `imatge` varchar(1024) DEFAULT NULL, -- Columna para almacenar la ruta de la imagen (opcional)
  PRIMARY KEY (`ID`), -- Clave primaria en el campo ID
  CONSTRAINT `fk_nomUsuari` FOREIGN KEY (`nom_usuari`) REFERENCES `usuaris` (`nombreUsuario`) ON DELETE CASCADE ON UPDATE CASCADE -- Relación entre article y usuaris
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserción de datos en la tabla article
INSERT INTO `article` (`marca`, `model`, `any`, `color`, `matricula`, `nom_usuari`,`imatge`) VALUES
('Toyota', 'Corolla', '1985', 'Blanc', '1234ABC', 'Miguel', 'https://noticias.coches.com/wp-content/uploads/2014/10/toyota_corolla-gt-s-sport-liftback-ae86-1985-86_r10.jpg'),
('Ford', 'Fiesta', '1988', 'Blau', '5678DEF', 'Miguel', 'https://tennants.blob.core.windows.net/stock/142185-0.jpg?v=63615747600000'),
('Honda', 'Civic', '1995', 'Verd', '9101GHI', 'Frank', 'https://live.staticflickr.com/2337/1870361700_31046bb363_c.jpg'),
('Volkswagen', 'Polo', '2008', 'Blau', '3568JMG', 'Hector', 'https://www.km77.com/media/fotos/volkswagen_polo_2005_1854_1.jpg'),
('BMW', 'e90 320d','2006', 'Negre', '6733DGS', 'Miguel', 'https://www.largus.fr/images/styles/max_1300x1300/public/images/top-ventes-occasion-2016-07.jpg?itok=qlbyDvaA'),
('Volkswagen', 'Kombi', '1966', 'Blau', '6434DSA', 'Frank', 'https://a.ccdn.es/cnet/2023/06/15/55373819/682216819_g.jpg'),
('Dodge', 'Challenger', '2015', 'Negre', '0954OIS', 'Frank', 'https://media.carsandbids.com/cdn-cgi/image/width=2080,quality=70/da4b9237bacccdf19c0760cab7aec4a8359010b0/photos/3zm5mLY4-NE0s9xv9qKZ2-Vx6AUT83DW.jpg?t=168629211529'),
('Mazda', 'Mx5', '1997', 'Vermell', '4321KKL', 'Hector', 'https://images.classic.com/vehicles/d6e13b05eef5cda655d726d7b4631f31.jpeg?ar=16%3A9&fit=crop&w=600'),
('Porsche', 'GT3 RS', '2019', 'Gris', '9999FSA', 'Miguel', 'https://bringatrailer.com/wp-content/uploads/2024/01/2019_porsche_911-gt3-rs_dsc00283_150fef-98211.jpg'),
('Lexus', 'LFA V10', '2011', 'Blanc', '1282AOI', 'Frank', 'https://periodismodelmotor.com/venta-lexus-lfa-2011-6-000-km/337385/venta-lexus-lfa-2011/');


-- Ajustes de AUTO_INCREMENT para las tablas
ALTER TABLE `article`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuaris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

-- Confirmar transacción
COMMIT;
