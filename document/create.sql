# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-10-22 22:16                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "TRX011"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX011` (
    `id` VARCHAR(100) NOT NULL,
    `trx010_id` VARCHAR(100) NOT NULL,
    `line_number` INTEGER(5) NOT NULL COMMENT 'tgl order',
    `hotel_id` VARCHAR(100) NOT NULL,
    `hotel_name` VARCHAR(100) NOT NULL COMMENT 'nama hotel',
    `star` INTEGER(5) NOT NULL COMMENT 'bintang',
    `type` VARCHAR(100) NOT NULL,
    `type_room` VARCHAR(100) NOT NULL COMMENT 'tipe kamar',
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `check_out_date` DATE NOT NULL COMMENT 'tanggal check out',
    `day` INTEGER(5) NOT NULL COMMENT 'jumlah hari',
    `base_value` DOUBLE(30,10) NOT NULL COMMENT 'modal/hari',
    `gross_value_day` DOUBLE(30,10) NOT NULL,
    `gross_value` DOUBLE(30,10) NOT NULL COMMENT 'nilai kamar sebelum PPN dan diskon promo',
    `disc_value` DOUBLE(30,10) NOT NULL COMMENT 'diskon promo',
    `dpp_value` DOUBLE(30,10) NOT NULL,
    `ppn_value` DOUBLE(30,10) NOT NULL COMMENT 'nilai PPN',
    `tot_value` DOUBLE(30,10) NOT NULL COMMENT 'total nilai : gross value - disc+PPN',
    `title` VARCHAR(40) NOT NULL COMMENT 'mr/mrs',
    `guest_first_name` VARCHAR(100) NOT NULL COMMENT 'nama depan tamu',
    `guest_last_name` VARCHAR(100) NOT NULL COMMENT 'nama akhir tamu',
    `non_smoking_flag` VARCHAR(40) NOT NULL,
    `interconnetion_flag` VARCHAR(40) NOT NULL,
    `early_check_in_flag` VARCHAR(40) NOT NULL,
    `late_check_in_flag` VARCHAR(40) NOT NULL,
    `high_floor_flag` VARCHAR(40) NOT NULL,
    `low_floor_flag` VARCHAR(40) NOT NULL,
    `twin_flag` VARCHAR(40) NOT NULL,
    `note` VARCHAR(1024) NOT NULL,
    `cancel_policy` VARCHAR(1024),
    `photo` VARCHAR(100),
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX011` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX011_1` UNIQUE (`trx010_id`, `line_number`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `TRX011` ADD CONSTRAINT `TRX010_TRX011` 
    FOREIGN KEY (`trx010_id`) REFERENCES `TRX010` (`id`);
