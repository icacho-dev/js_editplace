-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 09-03-2011 a las 17:02:53
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `edit`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `admin`
-- 

CREATE TABLE `admin` (
  `id_admin` smallint(6) NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `pass` text NOT NULL,
  `user` char(2) NOT NULL,
  `estado` char(2) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_admin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `admin`
-- 

INSERT INTO `admin` (`id_admin`, `nombre`, `usuario`, `pass`, `user`, `estado`, `email`) VALUES 
(1, 'Administrador', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ad', '1', 'jrivera@stockergroup.com');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulos`
-- 

CREATE TABLE `modulos` (
  `id_modulo` smallint(6) NOT NULL auto_increment,
  `nombre` varchar(255) collate latin1_general_ci NOT NULL,
  `directorio` varchar(255) collate latin1_general_ci NOT NULL,
  `version` varchar(255) collate latin1_general_ci NOT NULL,
  `estado` smallint(1) NOT NULL,
  `variables` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_modulo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `modulos`
-- 

INSERT INTO `modulos` (`id_modulo`, `nombre`, `directorio`, `version`, `estado`, `variables`) VALUES 
(1, 'Contactenos', 'contactenos-flopy', '0.1', 1, ''),
(2, 'Galeria', 'galeria-flopy', '0.1', 1, ''),
(3, 'Pagina', 'pagina-flopy', '0.1', 1, '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `paginas`
-- 

CREATE TABLE `paginas` (
  `id` smallint(6) NOT NULL auto_increment,
  `id_modulo` smallint(6) NOT NULL,
  `titulo` varchar(255) collate latin1_general_ci NOT NULL,
  `url_amigable` varchar(255) collate latin1_general_ci NOT NULL,
  `contenido` text collate latin1_general_ci NOT NULL,
  `orden` smallint(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `paginas`
-- 

INSERT INTO `paginas` (`id`, `id_modulo`, `titulo`, `url_amigable`, `contenido`, `orden`) VALUES 
(1, 3, 'Quienes Somos', 'quienes-somos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas laoreet neque ut purus pretium sodales. Maecenas adipiscing diam nec orci feugiat sagittis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante tellus, pretium sit amet facilisis eget, porttitor adipiscing quam. Pellentesque magna mi, imperdiet et consectetur non, adipiscing et leo. Praesent consectetur quam sapien. Quisque eu lectus nec nisl porta iaculis. Donec pretium arcu in ipsum feugiat mollis. Etiam venenatis, nulla at vulputate semper, magna turpis sollicitudin quam, ac varius massa ligula et diam. Sed vitae enim odio. Praesent sed neque dui, nec hendrerit massa. Duis odio libero, luctus at pharetra at, elementum vel lacus. Sed eget libero nulla. Aliquam pretium condimentum erat non rutrum. Vestibulum vitae est dolor. In bibendum magna sed sapien tincidunt ac ornare ante bibendum. Aenean tincidunt molestie pharetra. Etiam dolor diam, ultrices ut consequat vitae, suscipit a massa.\r\n\r\nDonec at ante sem, ut ultricies dui. Pellentesque volutpat adipiscing mauris ut elementum. Morbi auctor odio ac erat aliquet suscipit. Pellentesque eget massa vitae nulla ullamcorper pharetra. Pellentesque non enim eget sapien porta pretium non eu justo. Aliquam sagittis vehicula auctor. Sed faucibus placerat euismod. Integer commodo interdum orci, quis scelerisque nisi vulputate vitae. Proin vitae orci massa, pretium iaculis enim. Nam vehicula purus ut nibh molestie ullamcorper. Donec ac sollicitudin est. Suspendisse rutrum ante eget magna venenatis interdum tincidunt metus fermentum.\r\n\r\nPhasellus eu lorem nisl. Donec mattis est a dolor sodales eu lacinia lectus cursus. Nulla vehicula tristique nisi non dictum. Donec nec magna a leo iaculis hendrerit. Duis consequat commodo dui, et dapibus risus euismod ut. Pellentesque lectus purus, tincidunt sed elementum at, facilisis non mauris. Suspendisse varius tortor sit amet nunc imperdiet sit amet aliquet augue feugiat. Proin urna turpis, ullamcorper eu tristique vitae, posuere id arcu. Aenean velit quam, convallis blandit gravida in, sollicitudin ac erat. Vivamus ut cursus magna. ', 1),
(2, 1, 'Contactenos', 'contactenos', 'Donec vitae ipsum enim. In vel nisl vitae risus iaculis hendrerit. Sed quis est tempus sapien hendrerit porta. Cras semper, arcu non sagittis congue, leo libero sodales orci, ut tincidunt erat tellus id urna. Curabitur vel ligula quam. Praesent luctus tortor eget lacus tempus eu scelerisque nisi pretium. Maecenas tellus tellus, luctus at varius vitae, congue in ipsum. Vivamus egestas sodales bibendum. Curabitur auctor, urna ut eleifend ultrices, augue justo dignissim felis, id adipiscing urna enim ac sapien. Donec pharetra luctus hendrerit. Praesent tempor adipiscing elit. Phasellus blandit odio sit amet nisi feugiat vel mollis orci pretium. Ut commodo odio in est facilisis nec aliquet dui hendrerit. Nullam convallis dignissim eros, sed consectetur erat gravida a. Maecenas elementum varius dolor, in venenatis mauris pharetra pulvinar. Etiam rutrum hendrerit mauris eget fermentum. Suspendisse vulputate, enim at lobortis luctus, ipsum enim semper felis, id semper magna sem vitae orci. Donec nibh metus, porttitor ut mattis a, laoreet quis mi. Duis dictum justo sed lorem facilisis et commodo turpis pharetra. ', 2),
(4, 3, 'La empresa', 'la-empresa', '', 3);
