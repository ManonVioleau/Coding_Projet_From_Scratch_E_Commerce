-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.6.25-0ubuntu0.15.04.1 - (Ubuntu)
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

DROP DATABASE IF EXISTS `my_shop`;
CREATE DATABASE `my_shop`;
USE `my_shop`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Export de la structure de la base pour my_shop


-- Export de la structure de table my_shop.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `name` varchar(255) NOT NULL UNIQUE,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table my_shop.categories : ~0 rows (environ)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Export de la structure de table my_shop.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `name` varchar(255) NOT NULL UNIQUE,
  `price` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table my_shop.products : ~0 rows (environ)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Export de la structure de table my_shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table my_shop.users : ~0 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- mdp : admin
INSERT INTO users (username, password, email, admin)
values 
("admin", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "admin@admin", 1),
("user1", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user1@connexion.fr", 0),
("user2", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user2@connexion.fr", 0),
("user3", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user3@connexion.fr", 0),
("user4", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user4@connexion.fr", 0),
("user5", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user5@connexion.fr", 0),
("user6", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user6@connexion.fr", 0),
("user7", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user7@connexion.fr", 0),
("user8", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user8@connexion.fr", 0),
("user9", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user9@connexion.fr", 0),
("user10", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user10@connexion.fr", 0),
("user11", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user11@connexion.fr", 0),
("user12", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user12@connexion.fr", 0),
("user13", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user13@connexion.fr", 0),
("user14", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user14@connexion.fr", 0),
("user15", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user15@connexion.fr", 0),
("user16", "$2y$10$VehLeIIMjtkbLzDtT/TGY.npfN42BticP3r4SPpjhP5s7HOUplYRy", "user16@connexion.fr", 0)
;

INSERT INTO categories (name, parent_id)
values ("chair", null), 
("chair 70’s", 1),
("chair 70’s orange", 2),
("chair 70’s blue", 2),
("chair 70’s green", 2),
("chair 80’s", 1),
("chair 80’s red", 6),
("chair 80’s purple", 6),
("table", null),
("table 70’s", 9),
("table 80’s", 9),
("lounge", null),
("lounge 70’s", 12),
("lounge 70’s orange", 13),
("lounge 70’s blue", 13)
;

INSERT INTO products (name, price, picture, description, category_id)
VALUES ("Plastic Orange", 65, "https://i.pinimg.com/originals/74/b0/e1/74b0e1624cb6b589e2b22f739e65edce.jpg", "A beautifull plastic chair designed by the great designer Fred Obvlosky.", 3),
("Space Age", 95, "https://img.vntg.com/large/15884945826717/70s-space-age-lounge-chair.jpg", "What an amazing armchair so comfortable with a pretty nice 70's design.", 3),
("Blue Velvet", 100, "https://www.arteslonga.com/13659-large_default/bleu-velvet-armchair-chiara.jpg", "A new armchair with a special shell design.", 4),
("Comfort Green", 90, "https://i.pinimg.com/originals/cb/f7/46/cbf746ead65236ca18f143dbd27f926e.jpg", "Simply but so comfortable, this couch is a must-have to watch TV.", 5),
("Swivel Armchair", 75, "https://www.design-mkt.com/371910-thickbox_default/vintage-swivel-armchair-in-green-fabric-1970s.jpg", "This rotating armchair is perfect to watch around you without effort.", 5),
("Deep Blue See", 955, "https://medias.maisonsdumonde.com/image/upload/q_auto,f_auto/w_500/img/canape-2-3-places-en-velours-bleu-1000-9-30-188097_8.jpg", "This blue velvet lounge is perfect to sleep after diner.", 15),
("Blue Egg", 145, "https://www.inside75.com/contents/refim/-f/fauteuil-boule-ball-chair-vintage-retro-bleu-blanc.jpg", "This beautifull blue bird nest brings you a amazing comfort during moments of rest.", 4),
("Dallas" , 1550, "https://www.decoinparis.com/img/produit/21250-canape-cuir-blanc-2-places-romeo.jpg", "A wonderful excellent quality leather lounge for living room or library.", 13),
("Novoretro", 45, "http://www.novoretro.net/files/f883248ef91e612047619bcc58fdb837.jpg", "A plastic and steel chair with a great refined style.", 7),
("Circle Look", 40, "https://images.squarespace-cdn.com/content/v1/5c8fddf67046803ca5b37ff6/1570018603067-UUSGJG5NKYCZ0P6XVKGM/ke17ZwdGBToddI8pDm48kNiEM88mrzHRsd1mQ3bxVct7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z4YTzHvnKhyp6Da-NYroOW3ZGjoBKy3azqku80C789l0s0XaMNjCqAzRibjnE_wBlkZ2axuMlPfqFLWy-3Tjp4nKScCHg1XF4aLsQJlo6oYbA/IMG_4941.jpg?format=1500w", "Between the chair and the stool, useful in every room of the house.", 7),
("Mushroom", 65, "https://www.design-mkt.com/55839-thickbox_default/mushroom-armchair-in-violet-fabric-pierre-paulin-1960s.jpg", "This psychedelic purple armchair will be the best place to have a break.", 8),
("Seccose", 105, "https://www.arteslonga.com/20995-tm_thickbox_default/table-basse-circle-set-de-2-design-retro-70s.jpg", "This wonderfull chair is able to welcome two persons at the same time.", 8),
("Lipstick", 1050, "https://cdn.laredoute.com/products/1200by1200/0/5/3/053f4488b62c2af46b19e56e7b08de17.jpg","Unique design for unique sofa, a 70's best seller in Hollywood.",14),
("Simple table", 75, "http://decidecadesign.fr/wp-content/uploads/2019/03/table-basse-vintage-plexi-70s.jpg", "An unbreakable plastic table with nice 70's look.", 10),
("Bernard Vuarnesson", 250, "https://images.selency.com/ad90018b-c5e0-4745-9047-3c37c9aa7f8d/80s-bernard-vuarnesson-hexa-table-basse-pour-bellato_original.png?bg_color=0FFF&bg=0FFF&fit=fill&func=fit&auto=format%2Ccompress&w=600&h=600&meta_format=product_og", "This french gigogne table is designed by the very famous Bernard Vuarnesson.", 11),
("Vuarnesson is back", 210, "https://images.selency.com/d58c6321-2008-4314-a10e-2e92243c5a59/80s-bernard-vuarnesson-hexa-table-basse-pour-bellato_original.png?bg_color=0FFF&bg=0FFF&fit=fill&func=fit&auto=format%2Ccompress&w=600&h=600&meta_format=product_og", "Another table by Bernard Vuarnesson with high quality oak wood.", 11),
("Unique Sofa", 655, "https://images.selency.com/b1bea992-00a2-4af9-97d7-0e22f3a8769b/canape-vintage-original-canape-convertible-entierement-renove-annees-1960-velours-orange-russet_original.png?bg_color=F5F5F5&bg=F5F5F5&fit=fill&func=fit&auto=format%2Ccompress&w=350&h=350&fm=jpg&meta_format=catalog_product_grey_thumb", "An amazing sofa made with orange velvet, suitable for at least four persons.", 14)
;
