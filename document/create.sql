# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-04-15 20:30                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "LOG010"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `LOG010` (
    `id` VARCHAR(100) NOT NULL,
    `mst001_id` VARCHAR(100) NOT NULL,
    `type` VARCHAR(15) NOT NULL COMMENT 'added/used',
    `log_no` VARCHAR(40) NOT NULL COMMENT 'nomor yang menggunakan log',
    `log_yrmo` VARCHAR(6) NOT NULL COMMENT 'tahun bulan yang menggunakan log',
    `log_date` DATE COMMENT 'tgl yang menggunakan log',
    `deposit_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai deposit yang dipakai /ditambah',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_LOG010` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_LOG010_1` UNIQUE (`mst001_id`, `type`, `log_no`, `log_yrmo`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG010` ADD CONSTRAINT `MST001_LOG010` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);
