

CREATE TABLE `carrito` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `IDCLIENTE` int(10) NOT NULL,
  `IDPRODUCTO` int(10) NOT NULL,
  `PRECIO` double(20,2) NOT NULL,
  `CANTIDAD` int(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `PRECIO` (`PRECIO`),
  KEY `IDCLIENTE` (`IDCLIENTE`),
  KEY `IDPRODUCTO` (`IDPRODUCTO`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`IDCLIENTE`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`IDPRODUCTO`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;




CREATE TABLE `categoria` (
  `categoria_id` int(10) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO categoria VALUES("1","Computadoras","Equipos de computadoras y accesorios tecnológicos.","Habilitada");



CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL AUTO_INCREMENT,
  `cliente_nombre` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_apellido` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_genero` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(22) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_provincia` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cuenta_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cuenta_verificada` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO cliente VALUES("1","Arturo","Sojo","Masculino","0291042190","higuerote","safdsafsa","safsafsafsafs","arturosojovivas@gmail.com","Usuario","ZlhXMHZGSi9vRm1uMDFYOVFmelgzQT09","Avatar_default_female.png","Activa","No verificada");



CREATE TABLE `empresa` (
  `empresa_id` int(3) NOT NULL AUTO_INCREMENT,
  `empresa_tipo_documento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_numero_documento` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `metodos_de_pago` text COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;




CREATE TABLE `favorito` (
  `favorito_id` int(15) NOT NULL AUTO_INCREMENT,
  `favorito_fecha` date NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `producto_id` int(20) NOT NULL,
  PRIMARY KEY (`favorito_id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;




CREATE TABLE `imagen` (
  `imagen_id` int(30) NOT NULL AUTO_INCREMENT,
  `imagen_nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(20) NOT NULL,
  PRIMARY KEY (`imagen_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;




CREATE TABLE `notificaciones` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `receptor_id` int(20) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(1000) NOT NULL,
  `estado` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `receptor_id` (`receptor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

INSERT INTO notificaciones VALUES("1","1","Pedido Solicitado","2021-03-22","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("2","0","Pedido Solicitado","2021-03-22","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("3","1","Pedido Entregado","2021-03-22","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("4","0","Pedido Entregado","2021-03-22","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("5","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("6","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("7","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("8","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("9","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("10","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("11","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("12","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("13","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("14","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("15","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("16","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("17","1","Pedido Anulado","2013-01-01","Arturo, tu pedido ha sido eliminado.","Leído");
INSERT INTO notificaciones VALUES("18","0","Pedido Anulado","2013-01-01","El pedido de Arturo Sojo ha sido eliminado.","Leído");
INSERT INTO notificaciones VALUES("19","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("20","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("21","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("22","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("23","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("24","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("25","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Leído");
INSERT INTO notificaciones VALUES("26","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");
INSERT INTO notificaciones VALUES("27","1","Pedido Solicitado","2013-01-01","Arturo,  tu pedido ha sido solicitado exitosamente, en breve nos pondremos en contacto con usted para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("28","0","Pedido Solicitado","2013-01-01","El Cliente ArturoSojo ha solicitado uno de nuestros productos, contactelo para acordar el pago.","Leído");
INSERT INTO notificaciones VALUES("29","1","Pedido Entregado","2013-01-01","Arturo, tu pedido ha sido entregado, Gracias por comprar en nuestro sitio Web.","Sin leer");
INSERT INTO notificaciones VALUES("30","0","Pedido Entregado","2013-01-01","Enhorabuena, ya le hemos entregado el pedido que solicitó Arturo Sojo.","Leído");



CREATE TABLE `pedidos` (
  `pedido_id` int(20) NOT NULL AUTO_INCREMENT,
  `pedido_codigo` int(20) NOT NULL,
  `pedido_nombre` varchar(20) NOT NULL,
  `pedido_fecha` date NOT NULL,
  `pedido_tipo_envio` varchar(15) NOT NULL,
  `pedido_estado_envio` varchar(15) NOT NULL,
  `pedido_cantidad` int(10) NOT NULL,
  `pedido_costo` float(10,2) NOT NULL,
  `pedido_foto` varchar(100) NOT NULL,
  `cliente_id` int(20) NOT NULL,
  `producto_id` int(20) NOT NULL,
  `tipo_pago` varchar(30) NOT NULL,
  `referencia` int(20) NOT NULL,
  PRIMARY KEY (`pedido_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

INSERT INTO pedidos VALUES("16","432432","Laptop","2013-01-01","Domiciliario","Entregado","1","370.00","Y1P6N7I7M2-1.png","1","2","Seller","432121");
INSERT INTO pedidos VALUES("17","432432","Laptop","2013-01-01","Domiciliario","Entregado","1","370.00","Y1P6N7I7M2-1.png","1","2","Pago móvil","65476");



CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL AUTO_INCREMENT,
  `producto_codigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_sku` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_descripcion` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_stock` int(10) NOT NULL,
  `producto_stock_minimo` int(10) NOT NULL,
  `producto_precio_compra` decimal(30,2) NOT NULL,
  `producto_precio_venta` decimal(30,2) NOT NULL,
  `producto_costo_envio` float(20,2) NOT NULL,
  `producto_descuento` int(3) NOT NULL,
  `producto_tipo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_presentacion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_marca` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_modelo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_portada` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_id` int(10) NOT NULL,
  PRIMARY KEY (`producto_id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO producto VALUES("2","432432","324","Laptop","njsdanjdanjdsandjandjsanjsdnajdsandjasjadns dsja njdkan sdk akdjs akdsa","123","12","200.00","350.00","20.00","0","Fisico","Unidad","HP","HP white","Habilitado","Y1P6N7I7M2-1.png","1");



CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_telefono` varchar(22) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_genero` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cuenta_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO usuario VALUES("1","Administrador","Principal","00000000","Masculino","Administrador","Administrador","artlexweb@gmail.com","T1ZyUXBYZnRjWW56RXVvZ09UZDRBQT09","Activa","Avatar_Male_3.png");



CREATE TABLE `visitas` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(20) NOT NULL,
  `ultima_visita` datetime NOT NULL,
  `estado` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO visitas VALUES("1","1","2013-01-01 05:42:49","Desconectado");

