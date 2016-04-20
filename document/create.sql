# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-04-20 22:21                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST030"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST030` (
    `id` VARCHAR(100) NOT NULL,
    `mst003_id` VARCHAR(100) NOT NULL COMMENT 'kota',
    `area` VARCHAR(100) NOT NULL COMMENT 'area contoh  jakarta barat, selatan',
    `location` VARCHAR(100) NOT NULL COMMENT 'lokasi:grogol, cengkareng',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST030` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST030_1` UNIQUE (`mst003_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST030` ADD CONSTRAINT `MST003_MST030` 
    FOREIGN KEY (`mst003_id`) REFERENCES `MST003` (`id`);
