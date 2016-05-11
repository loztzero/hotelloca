# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-05-11 20:24                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "LOG040"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `LOG040` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(100) NOT NULL,
    `order_date` DATE NOT NULL COMMENT 'added/used',
    `transfer_date` DATE NOT NULL COMMENT 'nomor yang menggunakan log',
    `payment_val` DOUBLE(30,2) NOT NULL,
    `read_flag` VARCHAR(100) NOT NULL COMMENT 'tahun bulan yang menggunakan log',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_LOG040` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_LOG040_1` UNIQUE (`order_no`, `order_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;
