# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-11-16 21:41                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "TEMP002"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `TEMP002` (
    `id` VARCHAR(100) NOT NULL,
    `temp001_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tanggal check in',
    `room_id` INTEGER(5) NOT NULL,
    `curency_code` VARCHAR(40) NOT NULL,
    `price` DOUBLE(30,10) NOT NULL,
    `sell_price` DOUBLE(30,10) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TEMP002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TEMP002_1` UNIQUE (`temp001_id`, `check_in_date`, `room_id`, `price`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `TEMP002` ADD CONSTRAINT `TEMP001_TEMP002` 
    FOREIGN KEY (`temp001_id`) REFERENCES `TEMP001` (`id`);
