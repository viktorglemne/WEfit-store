<div align="center">

# **WEfit Store** :muscle:

<img src="./content_images/svg_icon/logo_WEfit.svg" width="20%">

![Apache](https://img.shields.io/badge/apache-%23D42029.svg?style=for-the-badge&logo=apache&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
![Markdown](https://img.shields.io/badge/markdown-%23000000.svg?style=for-the-badge&logo=markdown&logoColor=white)
![Git](https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white)

# My first e commerce project :shopping:

</div>

This is one of the first PHP project i have done. 

It contains relative basic concept of PHP but have a strict structure between html, php and css. All syntaxes are separated in different files for a more clarity in the code and to be more readable.

I have used XAMPP for the development of the system through that containing a Apache distribution with MariaDB and PHP.

The main focus have been on enhancing your understanding on web development and how to use php.

## **Download and contribution** :tada: 

If you like to try the website out or contribut to the project, 
Before you execute this project make sure you insert values in the database. 

Copy and execute in maridb in a new database named website.

```-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Värd: localhost
-- Tid vid skapande: 11 jan 2022 kl 11:14
-- Serverversion: 10.4.21-MariaDB
-- PHP-version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `website`
--

--
-- Tabellstruktur `customer`
--

CREATE TABLE `customer` (
  `idcustomer` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellstruktur `orders`
--

CREATE TABLE `orders` (
  `idorder` int(11) NOT NULL,
  `customer_idcustomer` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellstruktur `order_item`
--

CREATE TABLE `order_item` (
  `products_idproducts` int(11) NOT NULL,
  `order_idorder` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellstruktur `products`
--

CREATE TABLE `products` (
  `idproducts` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `image` tinytext NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `category` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`idproducts`, `name`, `image`, `price`, `category`) VALUES
(1, 'WEfit-Prework', 'products_images/WEfit-Prework.png', '299.00', 'supplement'),
(2, 'WEfit-Sport', 'products_images/WEfit-Sport.png', '299.00', 'supplement'),
(3, 'WEfit-After', 'products_images/WEfit-After.png', '299.00', 'supplement'),
(4, 'WEfit-Drink', 'products_images/WEfit-drink.png', '19.00', 'supplement'),
(5, 'WEfit-Bars', 'products_images/WEfit-bars.png', '39.00', 'supplement'),
(6, 'WEfit-Milkshake', 'products_images/WEfit-milkshake.png', '22.00', 'supplement'),
(7, 'WEfit-Gel', 'products_images/WEfit-gel.png', '19.00', 'supplement'),
(8, 'WEfit-Bars 12-pack', 'products_images/WEfit-bars-12-pack.png', '399.00', 'supplement'),
(9, 'WEfit Belt', 'products_images/WEfit-balte.png', '500.00', 'equipment'),
(10, 'WEfit Shaker', 'products_images/WEfit-shaker.png', '19.00', 'equipment'),
(11, 'WEfit Väska', 'products_images/WEfit-bag.jpg', '400.00', 'equipment'),
(12, 'WEfit Gummmiband', 'products_images/WEfit_elastic-band.png', '100.00', 'equipment'),
(13, 'WEfit T-shirt', 'products_images/WEfit-T-shirt.png', '299.00', 'clothes'),
(14, 'WEfit Byxor', 'products_images/WEfit-pants.png', '499.00', 'clothes'),
(15, 'WEfit Shorts', 'products_images/WEfit-shorts.png', '499.00', 'clothes'),
(16, 'WEfit Hoodie', 'products_images/WEfit-Hoodie.png', '599.00', 'clothes');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idcustomer`);

--
-- Index för tabell `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idorder`,`customer_idcustomer`),
  ADD KEY `fk_order_customer1_idx` (`customer_idcustomer`);

--
-- Index för tabell `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`products_idproducts`,`order_idorder`),
  ADD KEY `fk_products_has_order_order1_idx` (`order_idorder`),
  ADD KEY `fk_products_has_order_products_idx` (`products_idproducts`);

--
-- Index för tabell `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idproducts`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `customer`
--
ALTER TABLE `customer`
  MODIFY `idcustomer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `orders`
--
ALTER TABLE `orders`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT för tabell `products`
--
ALTER TABLE `products`
  MODIFY `idproducts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_customer1` FOREIGN KEY (`customer_idcustomer`) REFERENCES `customer` (`idcustomer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_products_has_order_order1` FOREIGN KEY (`order_idorder`) REFERENCES `orders` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_has_order_products` FOREIGN KEY (`products_idproducts`) REFERENCES `products` (`idproducts`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```



More about how to contribute below. :fire:

## **The website** :computer:

The website is a e commerce that sells traning gear like, supplements, equipment and clothes. The initial ide was to develop a webshop that "had it all", therefore it also is a page for articles where the company can present information about training and use of supplements.

For the development i have focused on design as a big topic but also the functionality. It have to be an seamless journey for the customer where it should feel satisfying to order products. 

More technical, all pages are presented through php files that take and / or replace information from html files depending on the users interaction and display the content to the user.

The css almost specific for every pages but some general styles exist as well. I have used flex-box for the most part but also some grid, depending if the fetches data differs or not, eg. like in the shoppingcart.

Data is stored in a database using MariaDB and PDO (PHP Data Objects) syntax, no specific security measures been taken of storeing the data.

## **Learning and further work** :thinking::bulb:

This project was for an examination in a university course which has enhanced my knowledge, but it could be of interest to see closer on more industry standard technologies. With that said i will try to make some similar project but with "newer" approaches eg. first of all javascript and node.js, but also libraries like react and vue.

## **Contributing**
If you want to contribute to a the project and make it better, your help is very welcome. Contributing is also a great way to learn more about social coding on Github, new technologies and and their ecosystems and how to make constructive, helpful bug reports, feature requests and the noblest of all contributions: a good, clean pull request.

#### **How to make a clean pull request**

- Create a personal fork of the project on Github.
- Clone the fork on your local machine. Your remote repo on Github is called `origin`.
- Add the original repository as a remote called `upstream`.
- If you created your fork a while ago be sure to pull upstream changes into your local repository.
- Create a new branch to work on! Branch from `develop` if it exists, else from `master`.
- Implement/fix your feature, comment your code.
- Follow the code style of the project, including indentation.
- If the project has tests run them!
- Write or adapt tests as needed.
- Add or change the documentation as needed.
- Squash your commits into a single commit with git's `interactive rebase`. Create a new branch if necessary.
- Push your branch to your fork on Github, the remote `origin`.
- From your fork open a pull request in the correct branch. Target the project's `develop` branch if there is one, else go for `master`!
- If the maintainer requests further changes just push them to your branch. The PR will be updated automatically.
- Once the pull request is approved and merged you can pull the changes from `upstream` to your local repo and delete
your extra branch(es).

And last but not least: Always write your commit messages in the present tense. Your commit message should describe what the commit, when applied, does to the code – not what you did to the code.

Contributing info, credit to [MarcDiethelm](https://github.com/MarcDiethelm)
