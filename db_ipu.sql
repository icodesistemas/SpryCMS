-- MySQL dump 10.13  Distrib 5.7.9, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: db_ipu
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_idiomas`
--

DROP TABLE IF EXISTS `tb_idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_idiomas` (
  `pk_idioma` varchar(3) NOT NULL,
  `nombre_idioma` varchar(60) NOT NULL,
  `status_idioma` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`pk_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_idiomas`
--

LOCK TABLES `tb_idiomas` WRITE;
/*!40000 ALTER TABLE `tb_idiomas` DISABLE KEYS */;
INSERT INTO `tb_idiomas` VALUES ('en','Ingles','A'),('es','Español','A');
/*!40000 ALTER TABLE `tb_idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_multimedia`
--

DROP TABLE IF EXISTS `tb_multimedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_multimedia` (
  `fk_pk_publicacion` int(11) NOT NULL,
  `url_archivo` varchar(200) NOT NULL,
  `tipo_archivo` varchar(100) NOT NULL,
  KEY `fk_multimedia_publicacion_idx` (`fk_pk_publicacion`),
  CONSTRAINT `fk_multimedia_publicacion` FOREIGN KEY (`fk_pk_publicacion`) REFERENCES `tb_publicaciones` (`pk_publicacion`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_multimedia`
--

LOCK TABLES `tb_multimedia` WRITE;
/*!40000 ALTER TABLE `tb_multimedia` DISABLE KEYS */;
INSERT INTO `tb_multimedia` VALUES (1,'/Cluster/1460387271.png','imagen');
/*!40000 ALTER TABLE `tb_multimedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_paginas`
--

DROP TABLE IF EXISTS `tb_paginas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_paginas` (
  `pk_pagina` int(11) NOT NULL AUTO_INCREMENT,
  `pagina` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descripcion` varchar(260) NOT NULL,
  `abrir` varchar(6) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `fk_idioma` varchar(3) DEFAULT NULL,
  `pk_pagina_padre` int(11) DEFAULT '0',
  PRIMARY KEY (`pk_pagina`),
  KEY `fk_idioma` (`fk_idioma`),
  CONSTRAINT `fk_idiomas` FOREIGN KEY (`fk_idioma`) REFERENCES `tb_idiomas` (`pk_idioma`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_paginas`
--

LOCK TABLES `tb_paginas` WRITE;
/*!40000 ALTER TABLE `tb_paginas` DISABLE KEYS */;
INSERT INTO `tb_paginas` VALUES (1,'Inicio','inicio','Inicio','as dasd asd dasd','','A','es',0),(7,'Ministerios','ministerios','Ministerios','Conoce los deferentes ministerios que operan en la ipu','','A','es',0);
/*!40000 ALTER TABLE `tb_paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_publicaciones`
--

DROP TABLE IF EXISTS `tb_publicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_publicaciones` (
  `pk_publicacion` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(400) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `fk_pk_pagina` int(11) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  PRIMARY KEY (`pk_publicacion`),
  KEY `index2` (`titulo`),
  KEY `indx3` (`fk_pk_pagina`),
  CONSTRAINT `fk_tb_publicaciones` FOREIGN KEY (`fk_pk_pagina`) REFERENCES `tb_paginas` (`pk_pagina`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_publicaciones`
--

LOCK TABLES `tb_publicaciones` WRITE;
/*!40000 ALTER TABLE `tb_publicaciones` DISABLE KEYS */;
INSERT INTO `tb_publicaciones` VALUES (1,'e fdgfdfd gfdgdf','<div id=\"mw-content-text\" class=\"mw-content-ltr\" dir=\"ltr\" lang=\"es\" style=\"direction: ltr; color: #252525; font-family: sans-serif; font-size: 14px; line-height: 22.4px;\">\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Overdrive.2Fdistorsi.C3.B3n\" class=\"mw-headline\"><a class=\"mw-disambig\" style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Overdrive\" href=\"https://es.wikipedia.org/wiki/Overdrive\">Overdrive</a>/<a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Distorsi&oacute;n arm&oacute;nica\" href=\"https://es.wikipedia.org/wiki/Distorsi%C3%B3n_arm%C3%B3nica#Distorsi.C3.B3n_arm.C3.B3nica_en_sonido\">distorsi&oacute;n</a></span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Overdrive/distorsi&oacute;n\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=3\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">BD-2 Blues Driver</li>\r\n<li style=\"margin-bottom: 0.1em;\">DS-1 Distortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">DS-2 Turbo Distortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">MD-2 Mega Distortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">SF-1 Super Distortion Feedbacker</li>\r\n<li style=\"margin-bottom: 0.1em;\">OS-2 OverDrive/Distortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">OD-3 OverDrive</li>\r\n<li style=\"margin-bottom: 0.1em;\">DA-2 Adaptive Distortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">SD-1 Super OverDrive</li>\r\n<li style=\"margin-bottom: 0.1em;\">SD-2 Dual OverDrive</li>\r\n<li style=\"margin-bottom: 0.1em;\">PW-2 Power Driver</li>\r\n<li style=\"margin-bottom: 0.1em;\">XT-2 Xtortion</li>\r\n<li style=\"margin-bottom: 0.1em;\">FZ-5 Fuzz</li>\r\n<li style=\"margin-bottom: 0.1em;\">FZ-2 Hyper Fuzz</li>\r\n<li style=\"margin-bottom: 0.1em;\">HM-2 Heavy Metal</li>\r\n<li style=\"margin-bottom: 0.1em;\">HM-3 Hyper Metal</li>\r\n<li style=\"margin-bottom: 0.1em;\">MZ-2 Digital Metalizer</li>\r\n<li style=\"margin-bottom: 0.1em;\">ML-2 Metal Core</li>\r\n<li style=\"margin-bottom: 0.1em;\">ML-1 Metal Zone</li>\r\n<li style=\"margin-bottom: 0.1em;\">MT-2 Metal Zone</li>\r\n<li style=\"margin-bottom: 0.1em;\">DN-2 Dyna Drive</li>\r\n<li style=\"margin-bottom: 0.1em;\">OD-20 Drive Zone</li>\r\n<li style=\"margin-bottom: 0.1em;\">FBM-1 Fender &rsquo;59 -&nbsp;<i>Simulador de un amplificador basado en el Fender Bassman de 1959</i></li>\r\n<li style=\"margin-bottom: 0.1em;\">FDR-1 Fender &rsquo;65 Deluxe -&nbsp;<i>Simulador de un amplificador basado en Fender Deluxe Reverb de 1965</i></li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Modulaci.C3.B3n\" class=\"mw-headline\">Modulaci&oacute;n</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Modulaci&oacute;n\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=4\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">CE-1 Chorus Ensemble</li>\r\n<li style=\"margin-bottom: 0.1em;\">CE-2 Chorus</li>\r\n<li style=\"margin-bottom: 0.1em;\">CE-3 Chorus</li>\r\n<li style=\"margin-bottom: 0.1em;\">CE-5 Chorus Ensemble</li>\r\n<li style=\"margin-bottom: 0.1em;\">CH-1 Super Chorus</li>\r\n<li style=\"margin-bottom: 0.1em;\">PH-1&nbsp;<a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Phaser\" href=\"https://es.wikipedia.org/wiki/Phaser\">Phaser</a></li>\r\n<li style=\"margin-bottom: 0.1em;\">PH-1r Phaser</li>\r\n<li style=\"margin-bottom: 0.1em;\">PH-2 Super Phaser</li>\r\n<li style=\"margin-bottom: 0.1em;\">PH-3 Phase Shifter</li>\r\n<li style=\"margin-bottom: 0.1em;\">VB-2&nbsp;<a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Vibrato\" href=\"https://es.wikipedia.org/wiki/Vibrato\">Vibrato</a></li>\r\n<li style=\"margin-bottom: 0.1em;\">TR-2&nbsp;<a class=\"mw-redirect\" style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Tremolo\" href=\"https://es.wikipedia.org/wiki/Tremolo\">Tremolo</a></li>\r\n<li style=\"margin-bottom: 0.1em;\">PN-2 Tremelo/Pan</li>\r\n<li style=\"margin-bottom: 0.1em;\">BF-3&nbsp;<a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Flanger\" href=\"https://es.wikipedia.org/wiki/Flanger\">Flanger</a></li>\r\n<li style=\"margin-bottom: 0.1em;\">DC-2 Dimension C</li>\r\n<li style=\"margin-bottom: 0.1em;\">DC-3 Digital Dimension</li>\r\n<li style=\"margin-bottom: 0.1em;\">DC-3 Digital Space D</li>\r\n<li style=\"margin-bottom: 0.1em;\">CE-20 Chorus Esemble</li>\r\n<li style=\"margin-bottom: 0.1em;\">RT-20 Rotary Sound Processor</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Reverberaci.C3.B3n_.28reverb.29_.2F_Retraso_.28delay.29\" class=\"mw-headline\">Reverberaci&oacute;n (reverb) / Retraso (delay)</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Reverberaci&oacute;n (reverb) / Retraso (delay)\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=5\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">RV-2 Digital Reverb</li>\r\n<li style=\"margin-bottom: 0.1em;\">RV-3 Reverb/Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">RV-5 Digital Reverb</li>\r\n<li style=\"margin-bottom: 0.1em;\">DSD-2 Digital Sampler Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DM-2 Analog Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DM-3 Analog Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-2 Digital Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-3 Digital Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-5 Digital Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-6 Digital Delay -&nbsp;<i>Pedal est&eacute;reo con m&aacute;s tiempo que el DD-3</i></li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-7 Digital Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-20 Giga Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">RE-20 Space Echo</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Ecualizadores.2FTonalidad\" class=\"mw-headline\">Ecualizadores/Tonalidad</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Ecualizadores/Tonalidad\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=6\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">AW-2 Auto Wah</li>\r\n<li style=\"margin-bottom: 0.1em;\">AW-3 Dynamic Wah</li>\r\n<li style=\"margin-bottom: 0.1em;\">FT-2 Dynamic Filter</li>\r\n<li style=\"margin-bottom: 0.1em;\">GE-6 Equalizer</li>\r\n<li style=\"margin-bottom: 0.1em;\">GE-7 Equalizer</li>\r\n<li style=\"margin-bottom: 0.1em;\">PQ-4 Parametric Equalizer</li>\r\n<li style=\"margin-bottom: 0.1em;\">SP-1 Spectrum</li>\r\n<li style=\"margin-bottom: 0.1em;\">AC-3 Acoustic Simulator</li>\r\n<li style=\"margin-bottom: 0.1em;\">AC-2 Acoustic Simulator</li>\r\n<li style=\"margin-bottom: 0.1em;\">EQ-20 Advanced EQ</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Moduladores_de_tono\" class=\"mw-headline\">Moduladores de tono</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Moduladores de tono\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=7\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">PS-3 Pitch Shifter/Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">PS-5 Super Shifter</li>\r\n<li style=\"margin-bottom: 0.1em;\">OC-2 Octave</li>\r\n<li style=\"margin-bottom: 0.1em;\">OC-3 Super Octave</li>\r\n<li style=\"margin-bottom: 0.1em;\">HR-2 Harmonist</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h4 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; line-height: 1.6; background: none;\"><span id=\"Otros\" class=\"mw-headline\">Otros</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Otros\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=8\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h4>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">CS-3 Compression Sustainer</li>\r\n<li style=\"margin-bottom: 0.1em;\">SP-1 Spectrum</li>\r\n<li style=\"margin-bottom: 0.1em;\">SG-1 Slow Gear</li>\r\n<li style=\"margin-bottom: 0.1em;\">LM-2 Limiter</li>\r\n<li style=\"margin-bottom: 0.1em;\">LS-2 Line Selector</li>\r\n<li style=\"margin-bottom: 0.1em;\">NS-2 Noise Suppressor</li>\r\n<li style=\"margin-bottom: 0.1em;\">RC-2 Loop Station</li>\r\n<li style=\"margin-bottom: 0.1em;\">TU-2 Chromatic Tuner</li>\r\n<li style=\"margin-bottom: 0.1em;\">TU-3 Chromatic Tuner</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h3 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; font-size: 1.2em; line-height: 1.6; background: none;\"><span id=\"Pedales_dobles_para_guitarra_el.C3.A9ctrica\" class=\"mw-headline\">Pedales dobles para guitarra el&eacute;ctrica</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Pedales dobles para guitarra el&eacute;ctrica\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=9\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h3>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">OD-20 Drive Zone</li>\r\n<li style=\"margin-bottom: 0.1em;\">CE-20 Chorus Ensemble</li>\r\n<li style=\"margin-bottom: 0.1em;\">EQ-20 Advanced EQ</li>\r\n<li style=\"margin-bottom: 0.1em;\">DD-20 Giga Delay</li>\r\n<li style=\"margin-bottom: 0.1em;\">RC-20XL Loop Station</li>\r\n<li style=\"margin-bottom: 0.1em;\">RT-20 Rotary Ensemble</li>\r\n<li style=\"margin-bottom: 0.1em;\">RE-20 Space Echo</li>\r\n<li style=\"margin-bottom: 0.1em;\">SL-20 Slicer</li>\r\n<li style=\"margin-bottom: 0.1em;\">WP-20G Wave Processor</li>\r\n<li style=\"margin-bottom: 0.1em;\">OC-20G Poly Octave</li>\r\n<li style=\"margin-bottom: 0.1em;\">GP-20 Amp Factory</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h3 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; font-size: 1.2em; line-height: 1.6; background: none;\"><span id=\"Pedales_sencillos_para_bajo\" class=\"mw-headline\">Pedales sencillos para bajo</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Pedales sencillos para bajo\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=10\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h3>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">ODB-3 Bass Overdrive</li>\r\n<li style=\"margin-bottom: 0.1em;\">CEB-3 Bass Chorus</li>\r\n<li style=\"margin-bottom: 0.1em;\">GEB-7 Bass Equalizer</li>\r\n<li style=\"margin-bottom: 0.1em;\">LMB-3 Bass Limiter Enhancer</li>\r\n<li style=\"margin-bottom: 0.1em;\">SYB-5 Bass Synthesizer</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h3 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; font-size: 1.2em; line-height: 1.6; background: none;\"><span id=\"M.C3.A1quina_de_ritmos\" class=\"mw-headline\">M&aacute;quina de ritmos</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: M&aacute;quina de ritmos\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=11\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h3>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">Boss Doctor Rhythm DR-110</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h3 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; font-size: 1.2em; line-height: 1.6; background: none;\"><span id=\"Pedales_multi-efectos\" class=\"mw-headline\">Pedales multi-efectos</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Pedales multi-efectos\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=12\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h3>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">GT-100 Procesador de Efectos para Guitarra</li>\r\n<li style=\"margin-bottom: 0.1em;\">GT-10 &amp; GT-10B Procesador de Efectos para Guitarra/Bajo</li>\r\n<li style=\"margin-bottom: 0.1em;\">GT-8 Procesador de Efectos para Guitarra</li>\r\n<li style=\"margin-bottom: 0.1em;\">GT-6B Procesador de Efectos para Bajo</li>\r\n<li style=\"margin-bottom: 0.1em;\">ME-70 - Nueva multiefectos sucesora de la serie ME-50.</li>\r\n<li style=\"margin-bottom: 0.1em;\">ME-50 &amp; ME-50B - Efectos m&uacute;ltiples para Guitarra y Bajo</li>\r\n<li style=\"margin-bottom: 0.1em;\">ME-20 &amp; ME-20B - Efectos m&uacute;ltiples para Guitarra y Bajo</li>\r\n<li style=\"margin-bottom: 0.1em;\">ME-25 - Efectos m&uacute;ltiples para Guitarra con conexi&oacute;n USB.</li>\r\n<li style=\"margin-bottom: 0.1em;\">GT-PRO Procesador de Efectos para Guitarra&nbsp;<i>(rack-mounted)</i></li>\r\n<li style=\"margin-bottom: 0.1em;\">RC-50 Loop Station</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<pre style=\"font-family: monospace, Courier; color: black; border: 1px solid #dddddd; padding: 1em; white-space: pre-wrap; line-height: 1.3em; background-color: #f9f9f9;\">* GT-5 Procesador de Efectos para Guitarra\r\n</pre>\r\n<h3 style=\"color: black; margin: 0.3em 0px 0.25em; overflow: hidden; padding-top: 0.5em; padding-bottom: 0px; border-bottom-style: none; font-size: 1.2em; line-height: 1.6; background: none;\"><span id=\"Pedales_de_grabaci.C3.B3n\" class=\"mw-headline\">Pedales de grabaci&oacute;n</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; font-weight: normal; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Pedales de grabaci&oacute;n\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=13\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h3>\r\n<dl style=\"margin-top: 0.2em; margin-bottom: 0.5em;\">\r\n<dd style=\"margin-left: 1.6em; margin-bottom: 0.1em; margin-right: 0px;\">\r\n<ul style=\"margin: 0.3em 0px 0px 1.6em; padding: 0px;\">\r\n<li style=\"margin-bottom: 0.1em;\">Boss Micro BR4 track</li>\r\n<li style=\"margin-bottom: 0.1em;\">Boss BR 532 4 track</li>\r\n<li style=\"margin-bottom: 0.1em;\">Boss BR 600 8 track</li>\r\n</ul>\r\n</dd>\r\n</dl>\r\n<h2 style=\"color: black; font-weight: normal; margin: 1em 0px 0.25em; overflow: hidden; padding: 0px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #aaaaaa; font-family: \'Linux Libertine\', Georgia, Times, serif; line-height: 1.3; background: none;\"><span id=\"Referencias\" class=\"mw-headline\">Referencias</span><span class=\"mw-editsection\" style=\"-webkit-user-select: none; font-size: small; margin-left: 1em; vertical-align: baseline; line-height: 1em; display: inline-block; white-space: nowrap; unicode-bidi: isolate; font-family: sans-serif;\"><span class=\"mw-editsection-bracket\" style=\"margin-right: 0.25em; color: #555555;\">[</span><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Editar secci&oacute;n: Referencias\" href=\"https://es.wikipedia.org/w/index.php?title=BOSS_(artefactos_musicales)&amp;action=edit&amp;section=14\">editar</a><span class=\"mw-editsection-bracket\" style=\"margin-left: 0.25em; color: #555555;\">]</span></span></h2>\r\n<div class=\"listaref\" style=\"font-size: 12.6px; margin-bottom: 0.5em; list-style-type: decimal;\">\r\n<ol class=\"references\" style=\"margin: 0.3em 0px 0.5em 3.2em; padding: 0px; list-style-image: none; font-size: 12.6px; list-style-type: inherit;\">\r\n<li id=\"cite_note-roland.co.jp-1\" style=\"margin-bottom: 0.1em;\"><span class=\"mw-cite-backlink\" style=\"-webkit-user-select: none;\">&uarr;&nbsp;<a style=\"text-decoration: none; color: #0b0080; background: none;\" href=\"https://es.wikipedia.org/wiki/BOSS_(artefactos_musicales)#cite_ref-roland.co.jp_1-0\"><span class=\"cite-accessibility-label\" style=\"-webkit-user-select: none; top: -99999px; clip: rect(1px 1px 1px 1px); overflow: hidden; position: absolute !important; padding: 0px !important; border: 0px !important; height: 1px !important; width: 1px !important;\">Saltar a:</span><sup style=\"line-height: 1em;\"><i><b>a</b></i></sup></a>&nbsp;<a style=\"text-decoration: none; color: #0b0080; background: none;\" href=\"https://es.wikipedia.org/wiki/BOSS_(artefactos_musicales)#cite_ref-roland.co.jp_1-1\"><sup style=\"line-height: 1em;\"><i><b>b</b></i></sup></a></span>&nbsp;<span class=\"reference-text\"><a class=\"external free\" style=\"text-decoration: none; color: #663366; padding-right: 13px; word-wrap: break-word; background: linear-gradient(transparent, transparent) 100% 50% no-repeat,  100% 50%;\" href=\"http://www.roland.co.jp/about/group_japan.html\" rel=\"nofollow\">http://www.roland.co.jp/about/group_japan.html</a>&nbsp;(Japanese page)</span></li>\r\n</ol>\r\n</div>\r\n</div>\r\n<div id=\"catlinks\" class=\"catlinks\" style=\"border: 1px solid #aaaaaa; padding: 5px; margin-top: 1em; clear: both; color: #252525; font-family: sans-serif; font-size: 14px; line-height: 22.4px; background-color: #f9f9f9;\" data-mw=\"interface\">\r\n<div id=\"mw-normal-catlinks\" class=\"mw-normal-catlinks\"><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Especial:Categor&iacute;as\" href=\"https://es.wikipedia.org/wiki/Especial:Categor%C3%ADas\">Categor&iacute;a</a>:&nbsp;\r\n<ul style=\"list-style: none none; margin: 0px; padding: 0px; display: inline;\">\r\n<li style=\"margin: 0.125em 0px; display: inline-block; line-height: 1.25em; border-left-style: none; padding: 0px 0.5em 0px 0.25em; zoom: 1;\"><a style=\"text-decoration: none; color: #0b0080; background: none;\" title=\"Categor&iacute;a:Empresas de fabricaci&oacute;n de guitarras\" href=\"https://es.wikipedia.org/wiki/Categor%C3%ADa:Empresas_de_fabricaci%C3%B3n_de_guitarras\">Empresas de fabricaci&oacute;n de guitarras</a></li>\r\n</ul>\r\n</div>\r\n</div>','e-fdgfdfd-gfdgdf','I',1,'2016-04-12');
/*!40000 ALTER TABLE `tb_publicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_user` (
  `pk_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A',
  PRIMARY KEY (`pk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES (2,'Administrador','admin','169fbcab2bba2cdcea26821c9e02de185e7cdc25','A');
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-11 20:01:00
