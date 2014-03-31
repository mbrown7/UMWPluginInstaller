DROP DATABASE IF EXISTS packages;
CREATE DATABASE IF NOT EXISTS packages;
GRANT ALL PRIVILEGES ON packages.* to 'dtlt'@'localhost' identified by 'dtlt';
USE packages;

CREATE TABLE IF NOT EXISTS `package` (
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
  `allow_comments` BOOL DEFAULT 1,
  `sticky` BOOL DEFAULT 0,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES `package`(`id`)
);

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `allow_comments` BOOL DEFAULT 1,
  `slug` blob DEFAULT NULL,
  `publish` BOOL DEFAULT 1,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
);
