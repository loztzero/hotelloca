# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-10-15 10:28                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST001"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST001` (
    `id` VARCHAR(100) NOT NULL,
    `email` VARCHAR(40) NOT NULL COMMENT 'Email user, sebagai user code',
    `password` VARCHAR(100) NOT NULL,
    `role` VARCHAR(40) NOT NULL COMMENT 'Role : user/admin',
    `remembered_token` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST001_1` UNIQUE (`email`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST002"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST002` (
    `id` VARCHAR(100) NOT NULL,
    `country_code` VARCHAR(40) NOT NULL COMMENT 'Email user, sebagai user code',
    `country_name` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST002_1` UNIQUE (`country_code`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST003"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST003` (
    `id` VARCHAR(100) NOT NULL,
    `city_kode` VARCHAR(40) NOT NULL,
    `city_name` VARCHAR(100) NOT NULL,
    `mst002_id` VARCHAR(100) NOT NULL COMMENT 'Email user, sebagai user code',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST003` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST003_1` UNIQUE (`city_kode`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST004"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST004` (
    `id` VARCHAR(100) NOT NULL,
    `curr_code` VARCHAR(40) NOT NULL,
    `curr_name` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST004` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST004_1` UNIQUE (`curr_code`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST005"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST005` (
    `id` VARCHAR(100) NOT NULL,
    `begin_date` DATE NOT NULL COMMENT 'Email user, sebagai user code',
    `end_date` DATE NOT NULL,
    `mst004_id` VARCHAR(100) NOT NULL,
    `kurs_val` DOUBLE(30,10) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST005` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST005_1` UNIQUE (`begin_date`, `mst004_id`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "TRX001"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX001` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL COMMENT 'Email user, sebagai user code',
    `order_date` DATE NOT NULL,
    `email` VARCHAR(40) NOT NULL COMMENT 'Role : user/admin',
    `transfer_to` VARCHAR(100) NOT NULL,
    `payment_val` DOUBLE(30,10) NOT NULL,
    `transfer_date` DATE NOT NULL,
    `bank_transfer` VARCHAR(100) NOT NULL,
    `account_transfer` VARCHAR(40) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `note` VARCHAR(1024),
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX001_1` UNIQUE (`order_no`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST003` ADD CONSTRAINT `MST002_MST003` 
    FOREIGN KEY (`mst002_id`) REFERENCES `MST002` (`id`);

ALTER TABLE `MST005` ADD CONSTRAINT `MST004_MST005` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);
