SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `debitos_sigep` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ultimo_archivo_id` bigint(20) NOT NULL,
  `pdv_numero` bigint(20) NOT NULL,
  `importe` decimal(9,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

TRUNCATE TABLE `debitos_sigep`;

INSERT INTO `debitos_sigep` (`id`, `ultimo_archivo_id`, `pdv_numero`, `importe`, `status`) VALUES
(1, 160, 0, 123456.00, 'OK');