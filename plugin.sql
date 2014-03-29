DROP DATABASE IF EXISTS packages;
CREATE DATABASE IF NOT EXISTS packages;
GRANT ALL PRIVILEGES ON insult_generator.* to 'dtlt'@'localhost' identified by 'package';
USE packages;

CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `professor` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
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
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
);

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `excerpt` varchar(50) DEFAULT NULL,
  `content` blob DEFAULT NULL,
  `format` varchar(50) DEFAULT NULL,
  `allow_comments` varchar(3) DEFAULT 'yes',
  `sticky` varchar(3) DEFAULT 'no',
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `allow_comments` varchar(3) DEFAULT 'yes',
  `slug` blob DEFAULT NULL,
  `publish` varchar(3) DEFAULT 'yes',
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` blob DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
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
  `count` int(11) DEFAULT NULL,
  `html_url` varchar(100) DEFAULT NULL,
  `rss_url` varchar(100) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages_tags` (
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
);
