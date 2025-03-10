-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               11.6.2-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Zrzut struktury bazy danych sklep_internetowy
CREATE DATABASE IF NOT EXISTS `sklep_internetowy` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `sklep_internetowy`;

-- Zrzut struktury tabela sklep_internetowy.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli sklep_internetowy.carts: ~0 rows (około)
INSERT INTO `carts` (`id`, `cart_id`, `data`, `created_at`) VALUES
	(1, '2c4dd7398fcf0784a6e4b032363efed1', '{"35":2}', '2025-03-09 09:00:06');

-- Zrzut struktury tabela sklep_internetowy.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli sklep_internetowy.categories: ~2 rows (około)
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
	(1, 'Elektronika', 'Produkty elektroniczne, takie jak telewizory, laptopy, smartfony', '2025-03-07 09:34:15'),
	(2, 'Odzież', 'Odzież męska i damska, obuwie, akcesoria', '2025-03-07 09:34:15');

-- Zrzut struktury tabela sklep_internetowy.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `specifications` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli sklep_internetowy.products: ~30 rows (około)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created_at`, `specifications`) VALUES
	(35, 'Laptop HP', 'Laptop HP z 16 GB RAM i 512 GB SSD', 2999.00, 'https://placehold.co/600x400.png?text=Laptop+HP', 1, '2025-03-10 08:23:26', '{"processor": "Intel i7", "ram": "16 GB", "storage": "512 GB SSD", "os": "Windows 10", "graphics_card": "NVIDIA GTX 1650", "ports": "2 x USB 3.0, 1 x HDMI, 1 x USB-C"}'),
	(36, 'Smartphone Samsung', 'Smartphone Samsung Galaxy S21 z 128 GB pamięciSmartphone Samsung Galaxy S21 z 128 GB pamięciSmartphone Samsung Galaxy S21 z 128 GB pamięciSmartphone Samsung Galaxy S21 z 128 GB pamięciSmartphone Samsung Galaxy S21 z 128 GB pamięciSmartphone Samsung Galaxy S21 z 128 GB pamięci', 2499.00, 'https://placehold.co/600x400.png?text=Smartphone+Samsung', 1, '2025-03-10 08:23:26', '{\r\n    "Screen Size": "6.5 inches",\r\n    "RAM": "8GB",\r\n    "Storage": "128GB",\r\n    "Battery": "4500mAh",\r\n    "Camera": "64MP"\r\n}'),
	(37, 'Smartwatch Apple', 'Smartwatch Apple Watch Series 6', 1299.00, 'https://placehold.co/600x400.png?text=Smartwatch+Apple', 1, '2025-03-10 08:23:26', '{\r\n    "Display": "Retina OLED",\r\n    "Battery Life": "18 hours",\r\n    "Waterproof": "Yes",\r\n    "GPS": "Yes",\r\n    "Heart Rate Monitor": "Yes"\r\n}'),
	(38, 'Tablet Huawei', 'Tablet Huawei MatePad Pro 10.8', 1399.00, 'https://placehold.co/600x400.png?text=Tablet+Huawei', 1, '2025-03-10 08:23:26', '{\r\n    "Screen Size": "10.1 inches",\r\n    "RAM": "6GB",\r\n    "Storage": "128GB",\r\n    "Battery": "6000mAh",\r\n    "OS": "Android"\r\n}'),
	(39, 'Bluetooth Speaker JBL', 'Głośnik Bluetooth JBL Charge 4', 499.00, 'https://placehold.co/600x400.png?text=Bluetooth+Speaker+JBL', 1, '2025-03-10 08:23:26', '{\r\n    "Power": "20W",\r\n    "Bluetooth Version": "5.0",\r\n    "Battery Life": "12 hours",\r\n    "Waterproof": "IPX7"\r\n}'),
	(40, 'Monitor Dell', 'Monitor Dell 27" 4K UHD', 1799.00, 'https://placehold.co/600x400.png?text=Monitor+Dell', 1, '2025-03-10 08:23:26', '{\r\n    "Screen Size": "27 inches",\r\n    "Resolution": "2560x1440",\r\n    "Refresh Rate": "144Hz",\r\n    "Panel Type": "IPS",\r\n    "Connectivity": "HDMI, DisplayPort"\r\n}'),
	(41, 'Gaming Mouse Razer', 'Mysz gamingowa Razer DeathAdder Elite', 249.00, 'https://placehold.co/600x400.png?text=Gaming+Mouse+Razer', 1, '2025-03-10 08:23:26', '{\r\n    "DPI": "20000",\r\n    "RGB Lighting": "Yes",\r\n    "Wireless": "Yes",\r\n    "Buttons": "8",\r\n    "Weight": "90g"\r\n}'),
	(42, 'Keyboard Logitech', 'Klawiatura mechaniczna Logitech G Pro X', 599.00, 'https://placehold.co/600x400.png?text=Keyboard+Logitech', 1, '2025-03-10 08:23:26', '{\r\n    "Switch Type": "Mechanical",\r\n    "Backlight": "RGB",\r\n    "Wireless": "No",\r\n    "Key Rollover": "N-Key",\r\n    "Material": "Aluminum"\r\n}'),
	(43, 'Kamera Sony', 'Kamera Sony Alpha 7 III', 6899.00, 'https://placehold.co/600x400.png?text=Kamera+Sony', 1, '2025-03-10 08:23:26', '{\r\n    "Resolution": "20MP",\r\n    "Zoom": "10x Optical",\r\n    "Video": "4K",\r\n    "Connectivity": "Wi-Fi, Bluetooth"\r\n}'),
	(44, 'Laptop Asus', 'Laptop Asus ZenBook 14 z i7 i 16GB RAM', 3199.00, 'https://placehold.co/600x400.png?text=Laptop+Asus', 1, '2025-03-10 08:23:26', '{\r\n    "Screen Size": "15.6 inches",\r\n    "Processor": "Intel i7",\r\n    "RAM": "16GB",\r\n    "Storage": "512GB SSD",\r\n    "GPU": "NVIDIA RTX 3060"\r\n}'),
	(45, 'T-shirt Nike', 'T-shirt Nike z logo', 99.00, 'https://placehold.co/600x400.png?text=T-shirt+Nike', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Cotton",\r\n    "Size": "S, M, L, XL",\r\n    "Brand": "Nike",\r\n    "Color": "Black, White, Blue"\r\n}'),
	(46, 'Jeans Levi\'s', 'Spodnie jeansowe Levi\'s 511', 299.00, 'https://placehold.co/600x400.png?text=Jeans+Levi%27s', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Denim",\r\n    "Fit": "Slim",\r\n    "Brand": "Levi\'s",\r\n    "Color": "Blue, Black"\r\n}'),
	(47, 'Sneakers Adidas', 'Buty sneakers Adidas Superstar', 399.00, 'https://placehold.co/600x400.png?text=Sneakers+Adidas', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Synthetic",\r\n    "Size": "38-46",\r\n    "Brand": "Adidas",\r\n    "Color": "White, Black, Red"\r\n}'),
	(48, 'Jacket Columbia', 'Kurtka Columbia Termalene', 599.00, 'https://placehold.co/600x400.png?text=Jacket+Columbia', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Polyester",\r\n    "Brand": "Columbia",\r\n    "Waterproof": "Yes",\r\n    "Size": "S, M, L, XL"\r\n}'),
	(49, 'Sweater Tommy Hilfiger', 'Sweter Tommy Hilfiger z wełny', 499.00, 'https://placehold.co/600x400.png?text=Sweater+Tommy', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Wool",\r\n    "Brand": "Tommy Hilfiger",\r\n    "Size": "S, M, L, XL",\r\n    "Color": "Gray, Blue"\r\n}'),
	(50, 'Shorts Reebok', 'Szorty Reebok do treningu', 179.00, 'https://placehold.co/600x400.png?text=Shorts+Reebok', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Cotton",\r\n    "Brand": "Reebok",\r\n    "Size": "S, M, L, XL",\r\n    "Color": "Black, Blue"\r\n}'),
	(51, 'Hat Adidas', 'Czapka Adidas Originals', 129.00, 'https://placehold.co/600x400.png?text=Hat+Adidas', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Cotton",\r\n    "Brand": "Adidas",\r\n    "Size": "One Size",\r\n    "Color": "Black, White"\r\n}'),
	(52, 'Scarf Gucci', 'Szalik Gucci z kaszmiru', 399.00, 'https://placehold.co/600x400.png?text=Scarf+Gucci', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Wool",\r\n    "Brand": "Gucci",\r\n    "Color": "Red, Black, White",\r\n    "Pattern": "Checkered"\r\n}'),
	(53, 'Jacket North Face', 'Kurtka North Face Thermoball', 699.00, 'https://placehold.co/600x400.png?text=Jacket+NorthFace', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Waterproof Fabric",\r\n    "Brand": "North Face",\r\n    "Size": "S, M, L, XL",\r\n    "Color": "Black, Blue"\r\n}'),
	(54, 'Boots Timberland', 'Buty Timberland z wodoodporną powłoką', 599.00, 'https://placehold.co/600x400.png?text=Boots+Timberland', 2, '2025-03-10 08:23:26', '{"material": "Skóra, Guma", "color": "Brązowy", "size": "40, 41, 42, 43, 44, 45", "water_resistance": "Tak", "style": "Outdoor"}'),
	(55, 'Socks Puma', 'Skarpety Puma Performance 3 pary', 39.00, 'https://placehold.co/600x400.png?text=Socks+Puma', 2, '2025-03-10 08:23:26', '{\r\n    "Material": "Cotton",\r\n    "Brand": "Puma",\r\n    "Size": "39-46",\r\n    "Color": "White, Black, Blue"\r\n}'),
	(56, 'Camera Canon EOS', 'Aparat Canon EOS 5D Mark IV', 6999.00, 'https://placehold.co/600x400.png?text=Camera+Canon', 1, '2025-03-10 08:23:26', '{\r\n    "Resolution": "24MP",\r\n    "Zoom": "Optical 5x",\r\n    "Video": "4K",\r\n    "Connectivity": "Wi-Fi, Bluetooth"\r\n}'),
	(57, 'Drone DJI', 'Dron DJI Air 2S', 4599.00, 'https://placehold.co/600x400.png?text=Drone+DJI', 1, '2025-03-10 08:23:26', '{\r\n    "Flight Time": "30 mins",\r\n    "Camera": "4K",\r\n    "GPS": "Yes",\r\n    "Range": "10 km"\r\n}'),
	(58, 'Action Camera GoPro', 'Kamera GoPro Hero 9 Black', 1999.00, 'https://placehold.co/600x400.png?text=GoPro+Hero9', 1, '2025-03-10 08:23:26', '{\r\n    "Resolution": "12MP",\r\n    "Waterproof": "Yes",\r\n    "Video": "4K",\r\n    "Connectivity": "Wi-Fi, Bluetooth"\r\n}'),
	(59, 'Speakers Bose', 'Głośniki Bose SoundLink Revolve+', 1299.00, 'https://placehold.co/600x400.png?text=Speakers+Bose', 1, '2025-03-10 08:23:26', '{\r\n    "Power": "50W",\r\n    "Bluetooth Version": "5.0",\r\n    "Battery Life": "15 hours",\r\n    "Waterproof": "IPX6"\r\n}'),
	(60, 'Printer HP', 'Drukarka HP DeskJet 2710', 199.00, 'https://placehold.co/600x400.png?text=Printer+HP', 1, '2025-03-10 08:23:26', '{\r\n    "Type": "Laser",\r\n    "Resolution": "1200 dpi",\r\n    "Connectivity": "USB, Wi-Fi",\r\n    "Speed": "20 ppm"\r\n}'),
	(61, 'Headphones Sony', 'Słuchawki Sony WH-1000XM4', 1199.00, 'https://placehold.co/600x400.png?text=Headphones+Sony', 1, '2025-03-10 08:23:26', '{\r\n    "Type": "Over-ear",\r\n    "Noise Cancelling": "Yes",\r\n    "Wireless": "Yes",\r\n    "Battery Life": "30 hours"\r\n}'),
	(62, 'Electric Razor Philips', 'Maszynka elektryczna Philips OneBlade', 249.00, 'https://placehold.co/600x400.png?text=Razor+Philips', 1, '2025-03-10 08:23:26', '{\r\n    "Blades": "Titanium",\r\n    "Battery Life": "90 minutes",\r\n    "Waterproof": "Yes",\r\n    "Adjustable Lengths": "Yes"\r\n}'),
	(63, 'Fitness Tracker Fitbit', 'Opaska fitness Fitbit Charge 4', 549.00, 'https://placehold.co/600x400.png?text=Fitbit+Charge4', 1, '2025-03-10 08:23:26', '{\r\n    "Heart Rate Monitor": "Yes",\r\n    "Sleep Tracking": "Yes",\r\n    "Waterproof": "Yes",\r\n    "Battery Life": "7 days"\r\n}'),
	(64, 'Washing Machine LG', 'Pralka LG TurboWash 360', 2499.00, 'https://placehold.co/600x400.png?text=Washing+Machine+LG', 1, '2025-03-10 08:23:26', '{\r\n    "Capacity": "7kg",\r\n    "Energy Class": "A+++",\r\n    "Spin Speed": "1400 rpm",\r\n    "Noise Level": "50 dB"\r\n}');

-- Zrzut struktury tabela sklep_internetowy.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli sklep_internetowy.users: ~1 rows (około)
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`) VALUES
	(1, 'janek', 'mp110402@gmail.com', '$2y$10$JCm105enOgcPpKwTMAcwSu6f5yyL0DdOA0MhOgzVWB4MANFBNvQRO', '2025-03-07 10:11:33'),
	(3, 'jan.kowalski', 'mp1104202@gmail.com', '$2y$10$2GsA1BFh4VHTX3hU/Z5bnOWgVHUmfst0IQjpTYE5r7idRIW9Xod.u', '2025-03-09 08:20:13');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
