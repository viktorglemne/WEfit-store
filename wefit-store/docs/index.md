<style> 
.logo {

  -webkit-filter: drop-shadow( 3px 3px 4px rgba(0, 0, 0, .7));
  filter: drop-shadow( 3px 3px 4px rgba(0, 0, 0, .7));
  
}
</style>

<div align="center">

<img class="logo" src="./logo_WEfit.svg" width="30%">
<br><br>
<p><img alt="Apache" src="https://img.shields.io/badge/apache-%23D42029.svg?style=for-the-badge&amp;logo=apache&amp;logoColor=white" />
<img alt="PHP" src="https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&amp;logo=php&amp;logoColor=white" />
<img alt="CSS3" src="https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&amp;logo=css3&amp;logoColor=white" />
<img alt="HTML5" src="https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&amp;logo=html5&amp;logoColor=white" />
<img alt="JavaScript" src="https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&amp;logo=javascript&amp;logoColor=%23F7DF1E" />
<img alt="Markdown" src="https://img.shields.io/badge/markdown-%23000000.svg?style=for-the-badge&amp;logo=markdown&amp;logoColor=white" />
<img alt="Git" src="https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&amp;logo=git&amp;logoColor=white" /></p>
</div>

This is one of the first PHP project i have done. 

It contains relative basic concept of PHP but have a strict structure between html, php and css. All syntaxes are separated in different files for a more clarity in the code and to be more readable.

I have used XAMPP for the development of the system through that containing a Apache distribution with MariaDB and PHP.

The main focus have been on enhancing your understanding on web development and how to use php.

## **Download and contribution** 

If you like to try the website out or contribut to the project, 
Before you execute this project make sure you insert values in the database. 

Copy and execute in maridb.

```
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema website
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema website
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `website` DEFAULT CHARACTER SET utf8 ;
USE `website` ;

-- -----------------------------------------------------
-- Table `website`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `website`.`customer` (
  `idcustomer` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `address` VARCHAR(45) NULL,
  `zipcode` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `phonenumber` VARCHAR(45) NULL,
  PRIMARY KEY (`idcustomer`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `website`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `website`.`products` (
  `idproducts` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image` TEXT(80) NOT NULL,
  `price` DECIMAL(5,2) NOT NULL,
  `category` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idproducts`))
ENGINE = InnoDB;

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

-- -----------------------------------------------------
-- Table `website`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `website`.`orders` (
  `idorder` INT NOT NULL AUTO_INCREMENT,
  `customer_idcustomer` INT NOT NULL,
  `date` TIMESTAMP NOT NULL,
  `totalprice` INT NULL,
  PRIMARY KEY (`idorder`, `customer_idcustomer`),
  INDEX `fk_order_customer1_idx` (`customer_idcustomer` ASC),
  CONSTRAINT `fk_order_customer1`
    FOREIGN KEY (`customer_idcustomer`)
    REFERENCES `website`.`customer` (`idcustomer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `website`.`order_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `website`.`order_item` (
  `products_idproducts` INT NOT NULL,
  `order_idorder` INT NOT NULL,
  `quantity` INT NULL,
  PRIMARY KEY (`products_idproducts`, `order_idorder`),
  INDEX `fk_products_has_order_order1_idx` (`order_idorder` ASC),
  INDEX `fk_products_has_order_products_idx` (`products_idproducts` ASC),
  CONSTRAINT `fk_products_has_order_products`
    FOREIGN KEY (`products_idproducts`)
    REFERENCES `website`.`products` (`idproducts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_has_order_order1`
    FOREIGN KEY (`order_idorder`)
    REFERENCES `website`.`orders` (`idorder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
```

More about how to contribute below.

## **The website** 

The website is a e commerce that sells traning gear like, supplements, equipment and clothes. The initial ide was to develop a webshop that "had it all", therefore it also is a page for articles where the company can present information about training and use of supplements.

For the development i have focused on design as a big topic but also the functionality. It have to be an seamless journey for the customer where it should feel satisfying to order products. 

More technical, all pages are presented through php files that take and / or replace information from html files depending on the users interaction and display the content to the user.

The css almost specific for every pages but some general styles exist as well. I have used flex-box for the most part but also some grid, depending if the fetches data differs or not, eg. like in the shoppingcart.

Data is stored in a database using MariaDB and PDO (PHP Data Objects) syntax, no specific security measures been taken of storeing the data.

## **Learning and further work** 

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