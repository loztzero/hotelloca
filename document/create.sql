# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-02-20 00:01                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "TEMP003"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `TEMP003` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `session_id` VARCHAR(100),
    `mst022_id` VARCHAR(100),
    `mst023_id` VARCHAR(100),
    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "TEMP004"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `TEMP004` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `session_id` VARCHAR(100),
    `mst023_id` VARCHAR(100),
    `record` INTEGER(5),
    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;
