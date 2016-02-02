# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2016-02-02 20:35                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "TRX010"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX010` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL COMMENT 'nomor order',
    `oder_yrmo` VARCHAR(6) NOT NULL,
    `order_date` DATETIME NOT NULL COMMENT 'tgl order',
    `mst001_id` VARCHAR(100) NOT NULL,
    `mst004_id` VARCHAR(100) NOT NULL COMMENT 'valuta',
    `tot_commision_val` DOUBLE(30,2) NOT NULL COMMENT 'total komisi ',
    `tot_gross_price` DOUBLE(30,2) COMMENT 'total gross price detail',
    `tot_disc` DOUBLE(30,2) NOT NULL COMMENT 'nilai diskon',
    `tot_tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'total dppvalue : gross- diskon',
    `tot_tax_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai PPN',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'tot_tax_base_price+tax_value',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX010` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX010_1` UNIQUE (`order_no`, `oder_yrmo`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "TRX012"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX012` (
    `id` VARCHAR(100) NOT NULL,
    `trx010_id` VARCHAR(100) NOT NULL,
    `payment_method` VARCHAR(100) NOT NULL COMMENT 'tipe pembayaran :deposit/transfer/card',
    `card_type` VARCHAR(100) COMMENT 'tipe cc: master/visa',
    `card_number` VARCHAR(40) COMMENT 'nomor cc',
    `card_name` VARCHAR(100) COMMENT 'nama cc',
    `ccv` INTEGER(5) COMMENT 'nomor ccv',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX012` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX012_1` UNIQUE (`trx010_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "BLNC001"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `BLNC001` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL COMMENT 'nomor order',
    `oder_yrmo` VARCHAR(6) NOT NULL,
    `order_date` DATETIME NOT NULL COMMENT 'tgl order',
    `mst001_id` VARCHAR(100) NOT NULL,
    `mst004_id` VARCHAR(100) NOT NULL COMMENT 'valuta',
    `tot_base_price` DOUBLE(30,2) NOT NULL COMMENT 'total modal ',
    `tot_gross_price` DOUBLE(30,2) NOT NULL COMMENT 'total gross price detail',
    `disc_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai diskon',
    `tot_tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'total dppvalue : gross- diskon',
    `tax_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai PPN',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'tot_tax_base_price+tax_value',
    `status_flg` VARCHAR(40) NOT NULL COMMENT 'done/cancel/pending',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_BLNC001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_BLNC001_1` UNIQUE (`order_no`, `oder_yrmo`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "BLNC003"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `BLNC003` (
    `id` VARCHAR(100) NOT NULL,
    `blnc001_id` VARCHAR(100) NOT NULL,
    `payment_method` VARCHAR(100) NOT NULL COMMENT 'tipe pembayaran :deposit/transfer/card',
    `card_type` VARCHAR(100) COMMENT 'tipe cc: master/visa',
    `card_number` VARCHAR(40) COMMENT 'nomor cc',
    `card_name` VARCHAR(100) COMMENT 'nama cc',
    `ccv` INTEGER(5) COMMENT 'nomor ccv',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_BLNC003` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_BLNC003_1` UNIQUE (`blnc001_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "TRX011"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX011` (
    `id` VARCHAR(100) NOT NULL,
    `trx010_id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL,
    `mst023_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `check_out_date` DATE NOT NULL,
    `supply_id` VARCHAR(100) NOT NULL,
    `type` VARCHAR(100) NOT NULL COMMENT 'room/IncBreakfast',
    `room_name` VARCHAR(100) NOT NULL COMMENT 'tipe kamar',
    `room_id` VARCHAR(100) COMMENT 'terisi jika dari api',
    `room_num` INTEGER(5) NOT NULL COMMENT 'jumlah kamar',
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
    `tot_commision_price` DOUBLE(30,2) NOT NULL COMMENT 'total komisi',
    `tot_gross_price` DOUBLE(30,2) NOT NULL COMMENT 'total nilai setelah komisi',
    `tot_disc` DOUBLE(30,2) NOT NULL COMMENT 'total diskon',
    `tot_tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'total dpp',
    `tot_tax_value` DOUBLE(30,2) NOT NULL COMMENT 'total nilai pajak',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'total nilai pembayaran',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX011` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX011_1` UNIQUE (`trx010_id`, `mst020_id`, `mst023_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "BLNC002"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `BLNC002` (
    `id` VARCHAR(100) NOT NULL,
    `blnc001_id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL,
    `mst023_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `check_out_date` DATE NOT NULL,
    `supply_id` VARCHAR(100) NOT NULL,
    `type` VARCHAR(100) NOT NULL COMMENT 'room/IncBreakfast',
    `room_name` VARCHAR(100) NOT NULL COMMENT 'tipe kamar',
    `room_id` VARCHAR(100) COMMENT 'terisi jika dari api',
    `room_num` INTEGER(5) NOT NULL COMMENT 'jumlah kamar',
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
    `tot_commision_price` DOUBLE(30,2) NOT NULL COMMENT 'total komisi',
    `tot_gross_price` DOUBLE(30,2) NOT NULL COMMENT 'total nilai setelah komisi',
    `tot_disc` DOUBLE(30,2) NOT NULL COMMENT 'total diskon',
    `tot_tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'total dpp',
    `tot_tax_value` DOUBLE(30,2) NOT NULL COMMENT 'total nilai pajak',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'total nilai pembayaran',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_BLNC002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_BLNC002_1` UNIQUE (`blnc001_id`, `mst020_id`, `mst023_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "BLNC004"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `BLNC004` (
    `id` VARCHAR(100) NOT NULL,
    `blnc002_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `daily_price` DOUBLE(30,2) NOT NULL COMMENT 'nilai bersih /hari ',
    `nett_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai nett untuk ditampilkan ke customer',
    `tot_base_price` DOUBLE(30,2) NOT NULL COMMENT 'nett_value * room_num',
    `commision_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai komisi = nett_value - daily_price  nilai perhari',
    `tot_comm_val` DOUBLE(30,2) NOT NULL COMMENT 'commision_value * day',
    `gross_price` DOUBLE(30,2) NOT NULL COMMENT 'nett_value x room_num',
    `disc` DOUBLE(30,2) NOT NULL COMMENT 'diskon promo',
    `tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'gross_price - disc',
    `tax_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai PPN',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'total nilai : tax_base_price+PPN',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_BLNC004` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_BLNC004_1` UNIQUE (`blnc002_id`, `check_in_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "TRX013"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX013` (
    `id` VARCHAR(100) NOT NULL,
    `trx011_id` VARCHAR(100) NOT NULL,
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `daily_price` DOUBLE(30,2) NOT NULL COMMENT 'nilai bersih /hari ',
    `nett_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai nett untuk ditampilkan ke customer',
    `tot_base_price` DOUBLE(30,2) NOT NULL COMMENT 'nett_value * room_num',
    `commision_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai komisi = nett_value - daily_price  nilai perhari',
    `tot_comm_val` DOUBLE(30,2) NOT NULL COMMENT 'commision_value * day',
    `gross_price` DOUBLE(30,2) NOT NULL COMMENT 'nett_value x room_num',
    `disc` DOUBLE(30,2) NOT NULL COMMENT 'diskon promo',
    `tax_base_price` DOUBLE(30,2) NOT NULL COMMENT 'gross_price - disc',
    `tax_value` DOUBLE(30,2) NOT NULL COMMENT 'nilai PPN',
    `tot_payment` DOUBLE(30,2) NOT NULL COMMENT 'total nilai : tax_base_price+PPN',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX013` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX013_1` UNIQUE (`trx011_id`, `check_in_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `TRX010` ADD CONSTRAINT `MST001_TRX010` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);

ALTER TABLE `TRX010` ADD CONSTRAINT `MST004_TRX010` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `TRX013` ADD CONSTRAINT `TRX011_TRX013` 
    FOREIGN KEY (`trx011_id`) REFERENCES `TRX011` (`id`);

ALTER TABLE `TRX012` ADD CONSTRAINT `TRX010_TRX012` 
    FOREIGN KEY (`trx010_id`) REFERENCES `TRX010` (`id`);

ALTER TABLE `BLNC001` ADD CONSTRAINT `MST001_BLNC001` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);

ALTER TABLE `BLNC001` ADD CONSTRAINT `MST004_BLNC001` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `BLNC003` ADD CONSTRAINT `BLNC001_BLNC003` 
    FOREIGN KEY (`blnc001_id`) REFERENCES `BLNC001` (`id`);

ALTER TABLE `TRX011` ADD CONSTRAINT `TRX010_TRX011` 
    FOREIGN KEY (`trx010_id`) REFERENCES `TRX010` (`id`);

ALTER TABLE `TRX011` ADD CONSTRAINT `MST020_TRX011` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `TRX011` ADD CONSTRAINT `MST023_TRX011` 
    FOREIGN KEY (`mst023_id`) REFERENCES `MST023` (`id`);

ALTER TABLE `BLNC002` ADD CONSTRAINT `BLNC001_BLNC002` 
    FOREIGN KEY (`blnc001_id`) REFERENCES `BLNC001` (`id`);

ALTER TABLE `BLNC002` ADD CONSTRAINT `MST020_BLNC002` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `BLNC002` ADD CONSTRAINT `MST023_BLNC002` 
    FOREIGN KEY (`mst023_id`) REFERENCES `MST023` (`id`);

ALTER TABLE `BLNC004` ADD CONSTRAINT `BLNC002_BLNC004` 
    FOREIGN KEY (`blnc002_id`) REFERENCES `BLNC002` (`id`);
