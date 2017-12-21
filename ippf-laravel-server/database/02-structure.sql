
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS features;

DROP TABLE IF EXISTS pais;
DROP TABLE IF EXISTS partido;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS provincia;




CREATE TABLE IF NOT EXISTS `places` (
  `placeId` int(11) NOT NULL AUTO_INCREMENT,
  -- "establecimiento":"Hospital Dr. Juan Noé Crevanni (Arica)",
  `establecimiento` varchar(50) NOT NULL,
  -- "tipo":"Hospital",
  `tipo` varchar(50) NOT NULL,
    -- "calle":"Calle 18 de Septiembre",
  `calle` varchar(50) DEFAULT NULL,
   -- "altura":"1000",
  `altura` varchar(50) DEFAULT NULL,
  -- "piso_depto":"",
  `piso_dpto` varchar(50) DEFAULT NULL,
  -- "cruce":"",
  `cruce` varchar(300) DEFAULT NULL,
  -- "barrio_localidad":"",
  `barrio_localidad` varchar(300) DEFAULT NULL,
  -- "partido_comuna":"Arica",
  `idPartido` int(11) DEFAULT NULL,
  -- "provincia_region":"Arica y Parinacota",
  `idProvincia` int(11) DEFAULT NULL,
  -- "pais":"CHILE",
  `idPais` int(11) DEFAULT NULL,  
  `aprobado` tinyint DEFAULT NULL,
  `observacion` varchar(1000) DEFAULT NULL,
  `formattedAddress` varchar(200) DEFAULT NULL,
  `latitude` VARCHAR(30) DEFAULT NULL,
  `longitude` VARCHAR(30) DEFAULT NULL,
  `confidence` float DEFAULT NULL,
  `fail` varchar(200) DEFAULT NULL,

  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `habilitado` tinyint DEFAULT NULL,
  `vacunatorio` tinyint DEFAULT NULL,
  `infectologia` tinyint DEFAULT NULL,
  `condones` tinyint DEFAULT NULL,
  `prueba` tinyint DEFAULT NULL,


        -- "tel_distrib":"",
    `tel_testeo` varchar(50) DEFAULT NULL,  
    -- "mail_distrib":"",
    `mail_testeo` varchar(50) DEFAULT NULL,
    -- "horario_distrib":"",
    `horario_testeo` varchar(100) DEFAULT NULL,
    -- "responsable_distrib":"",
    `responsable_testeo` varchar(100) DEFAULT NULL,
    -- "web_distrib":"",
    `web_testeo` varchar(100) DEFAULT NULL,
    -- "ubicacion_distrib":"",
    `ubicacion_testeo` varchar(100) DEFAULT NULL,
    -- "comentarios_distrib":"",
    `observaciones_testeo` varchar(500) DEFAULT NULL,

        -- "tel_distrib":"",
    `tel_distrib` varchar(50) DEFAULT NULL,  
    -- "mail_distrib":"",
    `mail_distrib` varchar(50) DEFAULT NULL,
    -- "horario_distrib":"",
    `horario_distrib` varchar(100) DEFAULT NULL,
    -- "responsable_distrib":"",
    `responsable_distrib` varchar(100) DEFAULT NULL,
    -- "web_distrib":"",
    `web_distrib` varchar(100) DEFAULT NULL,
    -- "ubicacion_distrib":"",
    `ubicacion_distrib` varchar(100) DEFAULT NULL,
    -- "comentarios_distrib":"",
    `comentarios_distrib` varchar(500) DEFAULT NULL,

         -- "tel_distrib":"",
    `tel_infectologia` varchar(50) DEFAULT NULL,  
    -- "mail_distrib":"",
    `mail_infectologia` varchar(50) DEFAULT NULL,
    -- "horario_distrib":"",
    `horario_infectologia` varchar(100) DEFAULT NULL,
    -- "responsable_distrib":"",
    `responsable_infectologia` varchar(100) DEFAULT NULL,
    -- "web_distrib":"",
    `web_infectologia` varchar(100) DEFAULT NULL,
    -- "ubicacion_distrib":"",
    `ubicacion_infectologia` varchar(100) DEFAULT NULL,
    -- "comentarios_distrib":"",
    `comentarios_infectologia` varchar(500) DEFAULT NULL,



           -- "tel_distrib":"",
    `tel_vac` varchar(50) DEFAULT NULL,  
    -- "mail_distrib":"",
    `mail_vac` varchar(50) DEFAULT NULL,
    -- "horario_distrib":"",
    `horario_vac` varchar(100) DEFAULT NULL,
    -- "responsable_distrib":"",
    `responsable_vac` varchar(100) DEFAULT NULL,
    -- "web_distrib":"",
    `web_vac` varchar(100) DEFAULT NULL,
    -- "ubicacion_distrib":"",
    `ubicacion_vac` varchar(100) DEFAULT NULL,
    -- "comentarios_distrib":"",
    `comentarios_vac` varchar(500) DEFAULT NULL,
  
  PRIMARY KEY (`placeId`),
  KEY `fk_provincia_idx` (`idProvincia`),
  KEY `fk_partido_idx` (`idPartido`),
  KEY `fk_pais_idx` (`idPais`),
  CONSTRAINT `fk_partido` FOREIGN KEY (`idPartido`) REFERENCES `partido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=106122 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase` varchar(45)  NOT NULL,
    -- "tel_distrib":"",
    `tel` varchar(50) DEFAULT NULL,  
    -- "mail_distrib":"",
    `mail` varchar(50) DEFAULT NULL,
    -- "horario_distrib":"",
    `horario` varchar(100) DEFAULT NULL,
    -- "responsable_distrib":"",
    `responsable` varchar(100) DEFAULT NULL,
    -- "web_distrib":"",
    `web_url` varchar(100) DEFAULT NULL,
    -- "ubicacion_distrib":"",
    `ubicacion` varchar(100) DEFAULT NULL,
    -- "comentarios_distrib":"",
    `comentarios` varchar(500) DEFAULT NULL,
  
  `habilitado` tinyint DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `idPlaces` int(11) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_location_feature_idx` (`idPlaces`),
  CONSTRAINT `id_location_feature` FOREIGN KEY (`idPlaces`) REFERENCES `places` (`placeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19642 DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `partido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_partido` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `habilitado` tinyint DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `idProvincia` int(11) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_partido_pais_idx` (`idPais`),
  KEY `fk_partido_provincia_idx` (`idProvincia`),
  CONSTRAINT `fk_partido_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_partido_provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19642 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_pais` varchar(45) DEFAULT NULL,
   `habilitado` tinyint DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_provincia` varchar(45) DEFAULT NULL,
  `habilitado` tinyint DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `peso` int(11) DEFAULT '0',
  `idPais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_provincia_pais_idx` (`idPais`),
  CONSTRAINT `fk_provincia_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2583 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;