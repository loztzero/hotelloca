# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-01-19 20:59                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "BLNC002"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `BLNC002` (
    `id` VARCHAR(100) NOT NULL,
    `blnc001_id` VARCHAR(100) NOT NULL,
    `line_number` INTEGER(5) NOT NULL COMMENT 'tgl order',
    `mst020_id` VARCHAR(100) NOT NULL,
    `supply_id` VARCHAR(100) NOT NULL,
    `type` VARCHAR(100) NOT NULL COMMENT 'room/IncBreakfast',
    `room_name` VARCHAR(100) NOT NULL COMMENT 'tipe kamar',
    `room_id` VARCHAR(100) COMMENT 'terisi jika dari api',
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `check_out_date` DATE NOT NULL COMMENT 'tanggal check out',
    `day` INTEGER(5) NOT NULL COMMENT 'jumlah hari',
    `room_num` INTEGER(5) NOT NULL COMMENT 'jumlah kamar',
    `daily_price` DOUBLE(30,2) NOT NULL COMMENT 'nilai bersih /hari',
    `tot_base_price` DOUBLE(30,2) NOT NULL COMMENT 'daily_price x day x room_num',
    `commision_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai komisi',
    `gross_price_day` DOUBLE(30,2) NOT NULL COMMENT 'harga gross /hari',
    `gross_price` DOUBLE(30,2) NOT NULL COMMENT 'harga gross perhari * jumlah hari * jumlah kamar',
    `disc` DOUBLE(30,2) NOT NULL COMMENT 'diskon promo',
    `tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'gross_price - disc',
    `tax_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai PPN',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'total nilai : tax_base_price+PPN',
    `title` VARCHAR(40) NOT NULL COMMENT 'mr/mrs',
    `guest_first_name` VARCHAR(100) NOT NULL COMMENT 'nama depan tamu',
    `guest_last_name` VARCHAR(100) NOT NULL COMMENT 'nama akhir tamu',
    `num_breakfast` INTEGER(5) NOT NULL COMMENT 'jumlah breakfast',
    `non_smoking_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `interconnetion_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `early_check_in_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `late_check_in_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `high_floor_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `low_floor_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `twin_flag` VARCHAR(40) NOT NULL COMMENT 'yes/no',
    `note` VARCHAR(1024) NOT NULL,
    `cut_off` INTEGER(5) NOT NULL COMMENT 'syarat cancel',
    `cancel_flag` VARCHAR(100) NOT NULL COMMENT 'Yes/No',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_BLNC002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_BLNC002_1` UNIQUE (`blnc001_id`, `line_number`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `BLNC002` ADD CONSTRAINT `BLNC001_BLNC002` 
    FOREIGN KEY (`blnc001_id`) REFERENCES `BLNC001` (`id`);
