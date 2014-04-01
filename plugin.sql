DROP DATABASE IF EXISTS packages;
CREATE DATABASE IF NOT EXISTS packages;

GRANT ALL PRIVILEGES ON packages.* to 'dtlt'@'host.umwdomains.com' identified by 'package';

USE packages;

CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `professor` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`theme_id`) REFERENCES `themes`(`id`)
);

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `packages_plugins` (
  `package_id` int(11) NOT NULL,
  `plugin_id` int(11) NOT NULL,
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`),
  FOREIGN KEY (`plugin_id`) REFERENCES `plugins`(`id`)
);

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `content` blob DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `slug` blob DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `slug` blob DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages_categories` (
  `page_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
);

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `slug` blob DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages_tags` (
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
);
