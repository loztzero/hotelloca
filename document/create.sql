# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-01-14 20:32                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST025"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST025` (
    `id` VARCHAR(100) NOT NULL,
    `mst023_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `line_number` INTEGER(5) NOT NULL COMMENT 'line number',
    `facility` TEXT NOT NULL COMMENT 'fasilitas',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST025` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST025_1` UNIQUE (`mst023_id`, `line_number`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "MST024"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST024` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `line_number` INTEGER(5) NOT NULL COMMENT 'line number',
    `facility` TEXT NOT NULL COMMENT 'fasilitas',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST024` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST024_1` UNIQUE (`mst020_id`, `line_number`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST025` ADD CONSTRAINT `MST023_MST025` 
    FOREIGN KEY (`mst023_id`) REFERENCES `MST023` (`id`);

ALTER TABLE `MST024` ADD CONSTRAINT `MST020_MST024` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);
