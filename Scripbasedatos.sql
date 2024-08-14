-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`chefgroup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`chefgroup` (
  `ChefGroupID` INT NOT NULL AUTO_INCREMENT,
  `Groupnumber` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ChefGroupID`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`role` (
  `RoleID` INT NOT NULL AUTO_INCREMENT,
  `RoleName` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE INDEX `Rolecol_UNIQUE` (`RoleName` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `UserID` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(45) NOT NULL,
  `PasswordHash` VARCHAR(255) NOT NULL,
  `RoleID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC) VISIBLE,
  INDEX `RoleIDForeing_idx` (`RoleID` ASC) VISIBLE,
  CONSTRAINT `RoleIDForeing`
    FOREIGN KEY (`RoleID`)
    REFERENCES `mydb`.`role` (`RoleID`))
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`owner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`owner` (
  `OwnerID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Contactinfo` VARCHAR(255) NULL DEFAULT NULL,
  `Address` VARCHAR(255) NOT NULL,
  `UserID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`OwnerID`),
  INDEX `UserIDForeing_idx` (`UserID` ASC) VISIBLE,
  CONSTRAINT `UserIDForeing`
    FOREIGN KEY (`UserID`)
    REFERENCES `mydb`.`user` (`UserID`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`chef`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`chef` (
  `ChefID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Contactinfo` VARCHAR(255) NULL DEFAULT NULL,
  `Specialization` VARCHAR(255) NULL DEFAULT NULL,
  `UserID` INT NULL DEFAULT NULL,
  `ChefgroupID` INT NULL DEFAULT NULL,
  `Social_Security_Number` INT NULL DEFAULT NULL,
  `EPS` VARCHAR(100) NULL DEFAULT NULL,
  `Health Ensurance` VARCHAR(100) NULL DEFAULT NULL,
  `Owner` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ChefID`),
  INDEX `UserIDForeing_idx` (`UserID` ASC) VISIBLE,
  INDEX `ChefGroupID_idx` (`ChefgroupID` ASC) VISIBLE,
  INDEX `OwnerIDForeing_idx` (`Owner` ASC) VISIBLE,
  CONSTRAINT `ChefGroupID`
    FOREIGN KEY (`ChefgroupID`)
    REFERENCES `mydb`.`chefgroup` (`ChefGroupID`),
  CONSTRAINT `OwnerIDForeing1`
    FOREIGN KEY (`Owner`)
    REFERENCES `mydb`.`owner` (`OwnerID`),
  CONSTRAINT `UserIDForeing1`
    FOREIGN KEY (`UserID`)
    REFERENCES `mydb`.`user` (`UserID`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`cost`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`cost` (
  `CostID` INT NOT NULL AUTO_INCREMENT,
  `Amount` DECIMAL(10,2) NOT NULL,
  `CostDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `OwnerID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`CostID`),
  INDEX `OwnerIDForeing_idx` (`OwnerID` ASC) VISIBLE,
  CONSTRAINT `OwnerIDForeing4`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `mydb`.`owner` (`OwnerID`))
ENGINE = InnoDB
AUTO_INCREMENT = 60
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`dish`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`dish` (
  `DishID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  `Description` TEXT NULL DEFAULT NULL,
  `Price` DECIMAL(10,2) NULL DEFAULT NULL,
  `PreparationTime` TIME NULL DEFAULT NULL,
  `Available` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`DishID`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`ingredient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`ingredient` (
  `IngredientID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  `Unit` VARCHAR(50) NULL DEFAULT NULL,
  `ExpirationDate` DATE NULL DEFAULT NULL,
  `ChefgroupID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`IngredientID`),
  INDEX `chefgroupIDForeing_idx` (`ChefgroupID` ASC) VISIBLE,
  CONSTRAINT `chefgroupIDForeing12`
    FOREIGN KEY (`ChefgroupID`)
    REFERENCES `mydb`.`chefgroup` (`ChefGroupID`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`dishingredient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`dishingredient` (
  `DishIngredientID` INT NOT NULL AUTO_INCREMENT,
  `DishID` INT NULL DEFAULT NULL,
  `IngredientID` INT NULL DEFAULT NULL,
  `Quantity` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`DishIngredientID`),
  UNIQUE INDEX `unique_dish_ingredient` (`DishID` ASC, `IngredientID` ASC) VISIBLE,
  INDEX `IngredientIDForeing_idx` (`IngredientID` ASC) VISIBLE,
  CONSTRAINT `DishIDForeing`
    FOREIGN KEY (`DishID`)
    REFERENCES `mydb`.`dish` (`DishID`),
  CONSTRAINT `IngredientIDForeing60`
    FOREIGN KEY (`IngredientID`)
    REFERENCES `mydb`.`ingredient` (`IngredientID`))
ENGINE = InnoDB
AUTO_INCREMENT = 37
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`inactiveorders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`inactiveorders` (
  `InactiveOrderID` INT NOT NULL AUTO_INCREMENT,
  `OrderDetailID` INT NULL DEFAULT NULL,
  `Date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`InactiveOrderID`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`inventory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`inventory` (
  `InventoryID` INT NOT NULL AUTO_INCREMENT,
  `IngredientID` INT NULL DEFAULT NULL,
  `Quantity` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`InventoryID`),
  INDEX `IngredientsIDForeing_idx` (`IngredientID` ASC) VISIBLE,
  CONSTRAINT `IngredientsIDForeing90`
    FOREIGN KEY (`IngredientID`)
    REFERENCES `mydb`.`ingredient` (`IngredientID`))
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`inventoryrefillrequest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`inventoryrefillrequest` (
  `RefillRequestID` INT NOT NULL AUTO_INCREMENT,
  `IngredientID` INT NULL DEFAULT NULL,
  `Quantity` DECIMAL(10,2) NULL DEFAULT NULL,
  `RequestDate` DATE NULL DEFAULT NULL,
  `ExpectedDeliveryTime` TIME NULL DEFAULT NULL,
  `Cost` DECIMAL(10,2) NULL DEFAULT NULL,
  `OwnerID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`RefillRequestID`),
  INDEX `IngredientIDForeing3_idx` (`IngredientID` ASC) VISIBLE,
  INDEX `OwnerIDForeing_idx` (`OwnerID` ASC) VISIBLE,
  CONSTRAINT `IngredientIDForeing50`
    FOREIGN KEY (`IngredientID`)
    REFERENCES `mydb`.`ingredient` (`IngredientID`),
  CONSTRAINT `OwnerIDForeing5`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `mydb`.`owner` (`OwnerID`))
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`waiter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`waiter` (
  `WaiterID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  `Contactinfo` VARCHAR(255) NULL DEFAULT NULL,
  `UserID` INT NULL DEFAULT NULL,
  `Social_Security_Number` INT NULL DEFAULT NULL,
  `EPS` VARCHAR(100) NULL DEFAULT NULL,
  `Health Ensurance` VARCHAR(100) NULL DEFAULT NULL,
  `OwnerID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`WaiterID`),
  INDEX `UserIDForeing_idx` (`UserID` ASC) VISIBLE,
  INDEX `OwnerIDForeing_idx` (`OwnerID` ASC) VISIBLE,
  CONSTRAINT `OwnerIDForeing`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `mydb`.`owner` (`OwnerID`),
  CONSTRAINT `UserIDForeing2`
    FOREIGN KEY (`UserID`)
    REFERENCES `mydb`.`user` (`UserID`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`table`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`table` (
  `TableID` INT NOT NULL AUTO_INCREMENT,
  `Number` INT NULL DEFAULT NULL,
  `Seats` INT NULL DEFAULT NULL,
  `Location` VARCHAR(255) NULL DEFAULT NULL,
  `WaiterID` INT NULL DEFAULT NULL,
  `Served` TINYINT NULL DEFAULT '0',
  `ChefgroupID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`TableID`),
  INDEX `WaiterIDForeing_idx` (`WaiterID` ASC) VISIBLE,
  INDEX `ChefGroupID_idx` (`ChefgroupID` ASC) VISIBLE,
  CONSTRAINT `ChefGroupID20`
    FOREIGN KEY (`ChefgroupID`)
    REFERENCES `mydb`.`chefgroup` (`ChefGroupID`),
  CONSTRAINT `WaiterIDForeing`
    FOREIGN KEY (`WaiterID`)
    REFERENCES `mydb`.`waiter` (`WaiterID`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`order` (
  `OrderID` INT NOT NULL AUTO_INCREMENT,
  `TableID` INT NULL DEFAULT NULL,
  `OrderTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `ChefGroupID` INT NULL DEFAULT NULL,
  `Totalcost` DECIMAL(10,2) NULL DEFAULT NULL,
  `PaidOrder` TINYINT NULL DEFAULT '0',
  PRIMARY KEY (`OrderID`),
  INDEX `TableIDForeing_idx` (`TableID` ASC) VISIBLE,
  INDEX `ChefGroupIDForeing1` (`ChefGroupID` ASC) VISIBLE,
  CONSTRAINT `ChefGroupIDForeing1`
    FOREIGN KEY (`ChefGroupID`)
    REFERENCES `mydb`.`chefgroup` (`ChefGroupID`),
  CONSTRAINT `TableIDForeing`
    FOREIGN KEY (`TableID`)
    REFERENCES `mydb`.`table` (`TableID`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`orderindividual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`orderindividual` (
  `OrderDetailID` INT NOT NULL,
  `OrderID` INT NULL DEFAULT NULL,
  `Quantity` INT NULL DEFAULT NULL,
  `Subtotal` DECIMAL(10,2) NULL DEFAULT NULL,
  `DishID` INT NULL DEFAULT NULL,
  `Activeorder` TINYINT NULL DEFAULT '1',
  `WaiterID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`OrderDetailID`),
  INDEX `OrderIDForeing_idx` (`OrderID` ASC) VISIBLE,
  INDEX `DishIDForeing_idx` (`DishID` ASC) VISIBLE,
  INDEX `WaiterIDForeing_idx` (`WaiterID` ASC) VISIBLE,
  CONSTRAINT `DishIDForeing1`
    FOREIGN KEY (`DishID`)
    REFERENCES `mydb`.`dish` (`DishID`),
  CONSTRAINT `OrderIDForeing`
    FOREIGN KEY (`OrderID`)
    REFERENCES `mydb`.`order` (`OrderID`),
  CONSTRAINT `WaiterIDForeing4`
    FOREIGN KEY (`WaiterID`)
    REFERENCES `mydb`.`waiter` (`WaiterID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`payment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`payment` (
  `PaymentID` INT NOT NULL AUTO_INCREMENT,
  `EmployeeID` INT NULL DEFAULT NULL,
  `PaymentDate` DATE NULL DEFAULT NULL,
  `Amount` DECIMAL(10,2) NULL DEFAULT NULL,
  `PaymentMethod` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`PaymentID`),
  INDEX `EmployeeIDForeing_idx` (`EmployeeID` ASC) VISIBLE,
  CONSTRAINT `EmployeeIDForeing`
    FOREIGN KEY (`EmployeeID`)
    REFERENCES `mydb`.`user` (`UserID`))
ENGINE = InnoDB
AUTO_INCREMENT = 48
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`profit`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`profit` (
  `ProfitID` INT NOT NULL AUTO_INCREMENT,
  `TotalRevenue` DECIMAL(10,2) NULL DEFAULT NULL,
  `TotalCost` DECIMAL(10,2) NULL DEFAULT NULL,
  `CalculationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `OwnerID` INT NULL DEFAULT NULL,
  `TotalProfit` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`ProfitID`),
  INDEX `OwnerIDForeing_idx` (`OwnerID` ASC) VISIBLE,
  CONSTRAINT `OwnerIDForeing40`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `mydb`.`owner` (`OwnerID`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`revenue`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`revenue` (
  `RevenueID` INT NOT NULL AUTO_INCREMENT,
  `Amount` DECIMAL(10,2) NULL DEFAULT NULL,
  `Revenuedate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `OwnerID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`RevenueID`),
  INDEX `OwnerIDForeing_idx` (`OwnerID` ASC) VISIBLE,
  CONSTRAINT `OwnerIDForeing10`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `mydb`.`owner` (`OwnerID`))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`tip`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tip` (
  `TIPID` INT NOT NULL AUTO_INCREMENT,
  `WaiterID` INT NULL DEFAULT NULL,
  `Amount` DECIMAL(10,2) NOT NULL,
  `TIPDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TIPID`),
  INDEX `WaiterIDForeing_idx` (`WaiterID` ASC) VISIBLE,
  CONSTRAINT `WaiterIDForeing2`
    FOREIGN KEY (`WaiterID`)
    REFERENCES `mydb`.`waiter` (`WaiterID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`unavailabledish`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`unavailabledish` (
  `UnavailableDishID` INT NOT NULL AUTO_INCREMENT,
  `DishID` INT NULL DEFAULT NULL,
  `Date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `ChefGroupID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`UnavailableDishID`),
  INDEX `ChefIDForeing_idx` (`ChefGroupID` ASC) VISIBLE,
  CONSTRAINT `ChefIDForeing2`
    FOREIGN KEY (`ChefGroupID`)
    REFERENCES `mydb`.`chefgroup` (`ChefGroupID`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb3;

USE `mydb` ;

-- -----------------------------------------------------
-- procedure AssignPrivileges
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AssignPrivileges`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE username VARCHAR(45);
    DECLARE role_name VARCHAR(50);
    
    -- Cursor para iterar sobre la tabla user y role
    DECLARE user_cursor CURSOR FOR 
    SELECT u.Username, r.RoleName
    FROM user u
    JOIN role r ON u.RoleID = r.RoleID;
    
    -- Handler para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Abrir el cursor
    OPEN user_cursor;
    
    read_loop: LOOP
        FETCH user_cursor INTO username, role_name;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Asegurarse de que no hay valores NULL en username o role_name
        IF username IS NOT NULL AND role_name IS NOT NULL THEN
            CASE role_name
                WHEN 'owner' THEN
                    SET @grant_priv = CONCAT('GRANT ALL PRIVILEGES ON mydb.* TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                WHEN 'chef' THEN
                    SET @grant_priv = CONCAT('GRANT SELECT, INSERT, UPDATE ON mydb.dish TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.order TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.payment TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.inventory TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.unavailabledish TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.dishingredient TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                WHEN 'waiter' THEN
                    SET @grant_priv = CONCAT('GRANT SELECT, INSERT ON mydb.orderindividual TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.tip TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.unavailabledish TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.dish TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
                    
                    SET @grant_priv = CONCAT('GRANT SELECT ON mydb.order TO \'', username, '\'@\'localhost\';');
                    PREPARE stmt FROM @grant_priv;
                    EXECUTE stmt;
                    DEALLOCATE PREPARE stmt;
            END CASE;
            
            -- Debug: Mostrar la instrucción SQL
            SELECT @grant_priv AS debug_sql;
        END IF;
    END LOOP;
    
    -- Cerrar el cursor
    CLOSE user_cursor;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure CreateUsers
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateUsers`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE user_id INT;
    DECLARE username VARCHAR(45);
    DECLARE password VARCHAR(255);
    DECLARE role_id INT;
    
    -- Cursor para iterar sobre la tabla user
    DECLARE user_cursor CURSOR FOR 
    SELECT UserID, Username, PasswordHash, RoleID FROM user;
    
    -- Handler para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Abrir el cursor
    OPEN user_cursor;
    
    read_loop: LOOP
        FETCH user_cursor INTO user_id, username, password, role_id;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Asegurarse de que no hay valores NULL en username o password
        IF username IS NOT NULL AND password IS NOT NULL THEN
            -- Crear el usuario en MySQL
            SET @create_user = CONCAT('CREATE USER \'', username, '\'@\'localhost\' IDENTIFIED BY \'', password, '\';');
            PREPARE stmt FROM @create_user;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
            
            -- Debug: Mostrar la instrucción SQL
            SELECT @create_user AS debug_sql;
        END IF;
    END LOOP;
    
    -- Cerrar el cursor
    CLOSE user_cursor;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure UpdateProfitAndCalculateTotalProfit
-- -----------------------------------------------------

DELIMITER $$
USE `mydb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProfitAndCalculateTotalProfit`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE profit_id INT;
    DECLARE total_revenue DECIMAL(10, 2);
    DECLARE total_cost DECIMAL(10, 2);
    
    -- Cursor para recorrer los registros en Profit
    DECLARE cur CURSOR FOR 
    SELECT ProfitID, TotalRevenue, TotalCost FROM Profit;

    -- Handler para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO profit_id, total_revenue, total_cost;

        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Actualizar TotalProfit
        UPDATE Profit
        SET TotalProfit = total_revenue - total_cost
        WHERE ProfitID = profit_id;
    END LOOP;

    -- Cerrar el cursor
    CLOSE cur;
END$$

DELIMITER ;
USE `mydb`;

DELIMITER $$
USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`DishIngredient_AFTER_INSERT`
AFTER INSERT ON `mydb`.`dishingredient`
FOR EACH ROW
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE available_quantity DECIMAL(10, 2);
    DECLARE required_quantity DECIMAL(10, 2);
    DECLARE ingredient_id INT;
    DECLARE dish_id INT;
    DECLARE unavailable_dish_count INT;

    -- Cursor para obtener los ingredientes y cantidades necesarias para el plato
    DECLARE ingredient_cursor CURSOR FOR 
    SELECT di.IngredientID, di.Quantity
    FROM DishIngredient di
    WHERE di.DishID = NEW.DishID;

    -- Handlers para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Obtener el DishID del ingrediente insertado
    SET dish_id = NEW.DishID;

    -- Abrir el cursor
    OPEN ingredient_cursor;

    ingredient_loop: LOOP
        -- Obtener cada ingrediente y su cantidad necesaria
        FETCH ingredient_cursor INTO ingredient_id, required_quantity;

        -- Salir del loop cuando no haya más datos
        IF done THEN
            LEAVE ingredient_loop;
        END IF;

        -- Obtener la cantidad disponible del ingrediente
        SELECT Quantity INTO available_quantity
        FROM Inventory
        WHERE IngredientID = ingredient_id;

        -- Verificar si hay suficiente cantidad del ingrediente
        IF available_quantity < required_quantity THEN
            -- Si no hay suficiente cantidad, agregar el plato a UnavailableDish si no está ya presente
            SELECT COUNT(*) INTO unavailable_dish_count
            FROM UnavailableDish
            WHERE DishID = dish_id;

            IF unavailable_dish_count = 0 THEN
                INSERT INTO UnavailableDish (DishID, Date)
                VALUES (dish_id, NOW());
            END IF;

            LEAVE ingredient_loop;
        END IF;
    END LOOP ingredient_loop;

    -- Cerrar el cursor
    CLOSE ingredient_cursor;
END$$

USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`InventoryrefillRequest_AFTER_INSERT`
AFTER INSERT ON `mydb`.`inventoryrefillrequest`
FOR EACH ROW
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE dish_id INT;
    DECLARE ingredient_id INT;
    DECLARE required_quantity DECIMAL(10, 2);
    DECLARE available_quantity DECIMAL(10, 2);
    DECLARE all_ingredients_available BOOLEAN DEFAULT TRUE;
    DECLARE inventory_count INT;

    -- Cursor para recorrer los platos no disponibles
    DECLARE dish_cursor CURSOR FOR 
    SELECT DishID FROM UnavailableDish;

    -- Cursor para obtener los ingredientes necesarios para un plato
    DECLARE ingredient_cursor CURSOR FOR 
    SELECT di.IngredientID, di.Quantity
    FROM DishIngredient di
    WHERE di.DishID = dish_id;

    -- Handlers para los cursores
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Insertar el nuevo costo en Cost con el OwnerID
    INSERT INTO Cost (Amount, CostDate, OwnerID)
    VALUES (NEW.Cost, CURRENT_TIMESTAMP, NEW.OwnerID);

    -- Verificar si ya existe un registro en Profit para el OwnerID
    IF (SELECT COUNT(*) FROM Profit WHERE ProfitID = NEW.OwnerID) = 0 THEN
        -- Si no existe, crear un nuevo registro
        INSERT INTO Profit (ProfitID, TotalRevenue, TotalCost, TotalProfit, CalculationDate, OwnerID)
        VALUES (NEW.OwnerID, 0, 0, 0, CURRENT_TIMESTAMP, NEW.OwnerID);
    END IF;

    -- Actualizar la tabla Profit
    UPDATE Profit
    SET TotalCost = TotalCost + NEW.Cost,
        CalculationDate = CURRENT_TIMESTAMP
    WHERE ProfitID = NEW.OwnerID;

    -- Verificar si el IngredientID ya existe en Inventory
    SELECT COUNT(*) INTO inventory_count
    FROM Inventory
    WHERE IngredientID = NEW.IngredientID;

    -- Si existe, actualizar la cantidad
    IF inventory_count > 0 THEN
        UPDATE Inventory
        SET Quantity = Quantity + NEW.Quantity
        WHERE IngredientID = NEW.IngredientID;
    ELSE
        -- Si no existe, insertar una nueva fila
        INSERT INTO Inventory (IngredientID, Quantity)
        VALUES (NEW.IngredientID, NEW.Quantity);
    END IF;

    -- Abrir el cursor de platos no disponibles
    OPEN dish_cursor;

    dish_loop: LOOP
        -- Obtener cada plato no disponible
        FETCH dish_cursor INTO dish_id;

        -- Salir del loop cuando no haya más datos
        IF done THEN
            LEAVE dish_loop;
        END IF;

        -- Resetear la variable de verificación
        SET all_ingredients_available = TRUE;

        -- Abrir el cursor de ingredientes para el plato actual
        OPEN ingredient_cursor;

        ingredient_inner_loop: LOOP
            -- Obtener cada ingrediente y su cantidad necesaria
            FETCH ingredient_cursor INTO ingredient_id, required_quantity;

            -- Salir del loop cuando no haya más datos
            IF done THEN
                LEAVE ingredient_inner_loop;
            END IF;

            -- Obtener la cantidad disponible del ingrediente
            SELECT Quantity INTO available_quantity
            FROM Inventory
            WHERE IngredientID = ingredient_id;

            -- Verificar si hay suficiente cantidad del ingrediente
            IF available_quantity < required_quantity THEN
                SET all_ingredients_available = FALSE;
                LEAVE ingredient_inner_loop;
            END IF;
        END LOOP ingredient_inner_loop;

        -- Cerrar el cursor de ingredientes
        CLOSE ingredient_cursor;

        -- Si todos los ingredientes están disponibles, eliminar el plato de la tabla de no disponibles
        IF all_ingredients_available THEN
            DELETE FROM UnavailableDish WHERE DishID = dish_id;
        END IF;
    END LOOP dish_loop;

    -- Cerrar el cursor de platos
    CLOSE dish_cursor;
END$$

USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`Order_AFTER_UPDATE`
AFTER UPDATE ON `mydb`.`order`
FOR EACH ROW
BEGIN
    DECLARE owner_id INT;

    IF NEW.PaidOrder = 1 AND OLD.PaidOrder = 0 THEN
        -- Obtener el OwnerID relacionado con el ChefGroupID de la orden
        SELECT c.Owner
        INTO owner_id
        FROM Chef c
        JOIN ChefGroup cg ON c.ChefgroupID = cg.ChefGroupID
        WHERE cg.ChefGroupID = NEW.ChefGroupID
        LIMIT 1;

        -- Insertar el nuevo ingreso en Revenue con el OwnerID
        INSERT INTO Revenue (Amount, Revenuedate, OwnerID)
        VALUES (NEW.Totalcost, CURRENT_TIMESTAMP, owner_id);

        -- Verificar si ya existe un registro en Profit para el OwnerID
        IF (SELECT COUNT(*) FROM Profit WHERE OwnerID = owner_id) = 0 THEN
            -- Si no existe, crear un nuevo registro
            INSERT INTO Profit (OwnerID, TotalRevenue, TotalCost, TotalProfit, CalculationDate)
            VALUES (owner_id, 0, 0, 0, CURRENT_TIMESTAMP);
        END IF;

        -- Actualizar la tabla Profit
        UPDATE Profit
        SET TotalRevenue = TotalRevenue + Totalcost,
            CalculationDate = CURRENT_TIMESTAMP
        WHERE OwnerID = owner_id;
    END IF;
END$$

USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`Orderindividual_AFTER_INSERT`
AFTER INSERT ON `mydb`.`orderindividual`
FOR EACH ROW
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE available_quantity DECIMAL(10, 2);
    DECLARE required_quantity DECIMAL(10, 2);
    DECLARE ingredient_id INT;
    DECLARE enough_stock BOOLEAN DEFAULT TRUE;
    DECLARE enough_stock_for_one BOOLEAN DEFAULT TRUE;

    -- Cursor para obtener los ingredientes y cantidades necesarias para el plato
    DECLARE ingredient_cursor CURSOR FOR 
    SELECT di.IngredientID, di.Quantity
    FROM DishIngredient di
    WHERE di.DishID = NEW.DishID;

    -- Handlers para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN ingredient_cursor;

    ingredient_loop: LOOP
        FETCH ingredient_cursor INTO ingredient_id, required_quantity;

        IF done THEN
            LEAVE ingredient_loop;
        END IF;

        -- Obtener la cantidad disponible del ingrediente
        SELECT Quantity INTO available_quantity
        FROM Inventory
        WHERE IngredientID = ingredient_id;

        -- Verificar si hay suficiente cantidad del ingrediente para cumplir la orden completa
        IF available_quantity < required_quantity * NEW.Quantity THEN
            SET enough_stock = FALSE;
        END IF;

        -- Verificar si hay suficiente cantidad del ingrediente para hacer al menos una unidad
        IF available_quantity < required_quantity THEN
            SET enough_stock_for_one = FALSE;
        END IF;
    END LOOP ingredient_loop;

    -- Cerrar el cursor
    CLOSE ingredient_cursor;

    -- Si no hay suficientes ingredientes para cumplir la orden completa, agregar a InactiveOrders
    IF NOT enough_stock THEN
        INSERT INTO InactiveOrders (OrderDetailID, Date)
        VALUES (NEW.OrderDetailID, NOW());
    END IF;

    -- Si no hay suficientes ingredientes para hacer al menos una unidad, agregar a UnavailableDish
    IF NOT enough_stock_for_one THEN
        IF NOT EXISTS (SELECT 1 FROM UnavailableDish WHERE DishID = NEW.DishID) THEN
            INSERT INTO UnavailableDish (DishID, Date)
            VALUES (NEW.DishID, NOW());
        END IF;
    END IF;

    -- Si hay suficientes ingredientes para cumplir la orden completa, actualizar el inventario
    IF enough_stock THEN
        OPEN ingredient_cursor;
        ingredient_loop: LOOP
            FETCH ingredient_cursor INTO ingredient_id, required_quantity;
            IF done THEN
                LEAVE ingredient_loop;
            END IF;

            -- Actualizar la cantidad del ingrediente en el inventario
            UPDATE Inventory
            SET Quantity = Quantity - required_quantity * NEW.Quantity
            WHERE IngredientID = ingredient_id;
        END LOOP ingredient_loop;
        CLOSE ingredient_cursor;
    END IF;
END$$

USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`Payment_AFTER_INSERT`
AFTER INSERT ON `mydb`.`payment`
FOR EACH ROW
BEGIN
    DECLARE owner_id INT;
    DECLARE role_name VARCHAR(50);

    -- Obtener el rol del empleado que recibió el pago
    SELECT r.RoleName 
    INTO role_name
    FROM User u
    JOIN Role r ON u.RoleID = r.RoleID
    WHERE u.UserID = NEW.EmployeeID
    LIMIT 1;

    -- Obtener el OwnerID basado en el rol del empleado
    IF role_name = 'Waiter' THEN
        SELECT w.OwnerID 
        INTO owner_id
        FROM Waiter w
        WHERE w.UserID = NEW.EmployeeID
        LIMIT 1;
    ELSEIF role_name = 'Chef' THEN
        SELECT c.Owner 
        INTO owner_id
        FROM Chef c
        WHERE c.UserID = NEW.EmployeeID
        LIMIT 1;
    END IF;

    -- Insertar el nuevo costo en Cost con el OwnerID
    INSERT INTO Cost (Amount, CostDate, OwnerID)
    VALUES (NEW.Amount, CURRENT_TIMESTAMP, owner_id);

    -- Verificar si ya existe un registro en Profit para el OwnerID
    IF (SELECT COUNT(*) FROM Profit WHERE OwnerID = owner_id) = 0 THEN
        -- Si no existe, crear un nuevo registro
        INSERT INTO Profit (TotalRevenue, TotalCost, CalculationDate, OwnerID)
        VALUES (0, 0, CURRENT_TIMESTAMP, owner_id);
    END IF;

    -- Actualizar la tabla Profit
    UPDATE Profit
    SET TotalCost = TotalCost + NEW.Amount,
        CalculationDate = CURRENT_TIMESTAMP
    WHERE OwnerID = owner_id;
END$$

USE `mydb`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mydb`.`UnavailableDish_AFTER_INSERT`
AFTER INSERT ON `mydb`.`unavailabledish`
FOR EACH ROW
BEGIN
    -- Actualizar la disponibilidad del plato en la tabla Dish
    UPDATE Dish
    SET Available = 0
    WHERE DishID = NEW.DishID;
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
