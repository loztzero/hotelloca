# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-03-28 21:12                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "LOG030"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `LOG030` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL,
    `order_date` DATE NOT NULL COMMENT 'added/used',
    `cancel_date` TIMESTAMP NOT NULL,
    `mst001_id` VARCHAR(40) NOT NULL COMMENT 'nomor yang menggunakan log',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_LOG030` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_LOG030_1` UNIQUE (`order_no`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG030` ADD CONSTRAINT `MST001_LOG030` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);
