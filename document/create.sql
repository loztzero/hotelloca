# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-11-04 19:43                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "TEMP001"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `TEMP001` (
    `id` VARCHAR(100) NOT NULL,
    `hotel_id` VARCHAR(100) NOT NULL,
    `hotel_name` VARCHAR(100) NOT NULL COMMENT 'nama hotel',
    `star` DOUBLE(10,5) NOT NULL COMMENT 'bintang hotel',
    `address` VARCHAR(1024) NOT NULL COMMENT 'alamat hotel',
    `country` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `landmark_name` VARCHAR(1024),
    `telp` VARCHAR(40) NOT NULL,
    `fax` VARCHAR(40) NOT NULL,
    `curr_code` VARCHAR(40) NOT NULL,
    `hotel_desc` VARCHAR(1024) NOT NULL,
    `meal_price` DOUBLE(30,10) NOT NULL,
    `bed_price` DOUBLE(30,10) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TEMP001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TEMP001_1` UNIQUE (`hotel_id`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "TEMP002"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `TEMP002` (
    `id` VARCHAR(100) NOT NULL,
    `temp001_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tanggal check in',
    `curency_code` VARCHAR(40) NOT NULL,
    `price` DOUBLE(30,10) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TEMP002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TEMP002_1` UNIQUE (`temp001_id`, `check_in_date`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `TEMP002` ADD CONSTRAINT `TEMP001_TEMP002` 
    FOREIGN KEY (`temp001_id`) REFERENCES `TEMP001` (`id`);
