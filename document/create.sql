# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-01-08 06:22                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST005"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST005` (
    `id` VARCHAR(100) NOT NULL,
    `daily_period` DATE NOT NULL COMMENT 'tgl akhir',
    `curr1_id` VARCHAR(100) NOT NULL COMMENT 'valuta 1',
    `kurs1_val` DOUBLE(30,10) NOT NULL COMMENT 'nilai kurs valuta 1',
    `curr2_id` VARCHAR(100) NOT NULL COMMENT 'valuta 2',
    `kurs2_val` DOUBLE(30,10) NOT NULL COMMENT 'nilai kurs valuta 2',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST005` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST005_1` UNIQUE (`curr1_id`, `daily_period`, `curr2_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST005` ADD CONSTRAINT `MST004_MST005` 
    FOREIGN KEY (`curr1_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `MST005` ADD CONSTRAINT `MST004_MST0052` 
    FOREIGN KEY (`curr2_id`) REFERENCES `MST004` (`id`);
