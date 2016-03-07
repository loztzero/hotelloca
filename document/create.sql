# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-03-07 22:15                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "LOG020"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `LOG020` (
    `id` VARCHAR(100) NOT NULL,
    `mst023_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'added/used',
    `allotment` INTEGER(5) NOT NULL,
    `used_allotment` INTEGER(5) NOT NULL COMMENT 'nomor yang menggunakan log',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_LOG020` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_LOG020_1` UNIQUE (`mst023_id`, `check_in_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG020` ADD CONSTRAINT `MST023_LOG020` 
    FOREIGN KEY (`mst023_id`) REFERENCES `MST023` (`id`);
