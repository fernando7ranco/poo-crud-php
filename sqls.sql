CREATE DATABASE `test`;
use test;
CREATE TABLE `imovels` (
   `id` int NOT NULL AUTO_INCREMENT,
   `tipo` varchar(50) DEFAULT NULL,
   `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
   `endereco` varchar(255) DEFAULT NULL,
   `status` varchar(55) DEFAULT NULL,
   `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
   `updated_at` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
 );
 CREATE TABLE `auth_api` (
   `id` int NOT NULL AUTO_INCREMENT,
   `token` varchar(255) DEFAULT NULL,
   `date_expiration` datetime DEFAULT NULL,
   `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
   `updated_at` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
 );