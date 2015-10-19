# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-10-19 22:13                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST001"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST001` (
    `id` VARCHAR(100) NOT NULL,
    `email` VARCHAR(40) NOT NULL COMMENT 'Email user, sebagai user code',
    `password` VARCHAR(100) NOT NULL,
    `role` VARCHAR(40) NOT NULL COMMENT 'Role : user/admin',
    `remembered_token` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST001_1` UNIQUE (`email`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST002"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST002` (
    `id` VARCHAR(100) NOT NULL,
    `country_code` VARCHAR(40) NOT NULL COMMENT 'kode negara',
    `country_name` VARCHAR(100) NOT NULL COMMENT 'nama negara',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST002` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST002_1` UNIQUE (`country_code`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST003"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST003` (
    `id` VARCHAR(100) NOT NULL,
    `city_kode` VARCHAR(40) NOT NULL COMMENT 'kode Kota',
    `city_name` VARCHAR(100) NOT NULL COMMENT 'nama Kota',
    `mst002_id` VARCHAR(100) NOT NULL COMMENT 'negara',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST003` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST003_1` UNIQUE (`city_kode`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST004"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST004` (
    `id` VARCHAR(100) NOT NULL,
    `curr_code` VARCHAR(40) NOT NULL COMMENT 'kode valuta',
    `curr_name` VARCHAR(100) NOT NULL COMMENT 'nama valuta',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST004` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST004_1` UNIQUE (`curr_code`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST005"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST005` (
    `id` VARCHAR(100) NOT NULL,
    `begin_date` DATE NOT NULL COMMENT 'tgl awal',
    `end_date` DATE NOT NULL COMMENT 'tgl akhir',
    `mst004_id` VARCHAR(100) NOT NULL COMMENT 'valuta',
    `kurs_val` DOUBLE(30,10) NOT NULL COMMENT 'nilai kurs',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST005` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST005_1` UNIQUE (`begin_date`, `mst004_id`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "TRX001"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX001` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL COMMENT 'Nomor Order',
    `order_date` DATE NOT NULL COMMENT 'Tangga Order',
    `email` VARCHAR(40) NOT NULL COMMENT 'Email',
    `transfer_to` VARCHAR(100) NOT NULL COMMENT 'Transfer ke bank',
    `payment_val` DOUBLE(30,10) NOT NULL COMMENT 'nilai transfer',
    `transfer_date` DATE NOT NULL COMMENT 'tgl transfer',
    `bank_transfer` VARCHAR(100) NOT NULL COMMENT 'bank transfer',
    `account_transfer` VARCHAR(40) NOT NULL COMMENT 'nomor rekening transfer',
    `name` VARCHAR(100) NOT NULL COMMENT 'atas nama transferan',
    `note` VARCHAR(1024) COMMENT 'keterangan',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX001` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX001_1` UNIQUE (`order_no`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "MST010"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST010` (
    `id` VARCHAR(100) NOT NULL,
    `mst001_id` VARCHAR(100) NOT NULL COMMENT 'user',
    `comp_name` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `address` VARCHAR(1024) NOT NULL COMMENT 'alamat',
    `postcode` VARCHAR(15) NOT NULL COMMENT 'kode pos',
    `mst002_id` VARCHAR(100) NOT NULL COMMENT 'negara',
    `mst003_id` VARCHAR(100) NOT NULL COMMENT 'kota',
    `phone_number` VARCHAR(40) NOT NULL COMMENT 'no telepon',
    `fax_number` VARCHAR(40) COMMENT 'nomor fax',
    `email` VARCHAR(40) NOT NULL COMMENT 'email',
    `website` VARCHAR(40) COMMENT 'website',
    `active_flg` VARCHAR(100) NOT NULL COMMENT 'aktif = dah kirim email ke agent untuk passwordnya',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST010` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST010_1` UNIQUE (`mst001_id`)
)
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Add table "TRX010"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `TRX010` (
    `id` VARCHAR(100) NOT NULL,
    `order_no` VARCHAR(40) NOT NULL COMMENT 'nomor order',
    `oder_yrmo` VARCHAR(6) NOT NULL,
    `order_date` DATE NOT NULL COMMENT 'tgl order',
    `tot_gross_value` DOUBLE(30,10) NOT NULL COMMENT 'total gross value',
    `disc_value` DOUBLE(30,10) NOT NULL COMMENT 'nilai diskon',
    `tot_dpp_value` DOUBLE(30,10) NOT NULL COMMENT 'total dppvalue : gross- diskon',
    `ppn_value` DOUBLE(30,10) NOT NULL COMMENT 'nilai PPN',
    `tot_nett_value` DOUBLE(30,10) NOT NULL COMMENT 'total nett value = tot_dpp + PPN ',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX010` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX010_1` UNIQUE (`order_no`, `oder_yrmo`)
)
ENGINE=InnoDB;;

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
    `type_room` VARCHAR(100) NOT NULL COMMENT 'tipe kamar',
    `check_in_date` DATE NOT NULL COMMENT 'tgl check in',
    `check_out_date` DATE NOT NULL COMMENT 'tanggal check out',
    `day` INTEGER(5) NOT NULL COMMENT 'jumlah hari',
    `gross_value` DOUBLE(30,10) NOT NULL COMMENT 'nilai kamar sebelum PPN dan diskon promo',
    `disc_value` DOUBLE(30,10) NOT NULL COMMENT 'diskon promo',
    `ppn_value` DOUBLE NOT NULL COMMENT 'nilai PPN',
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
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_TRX011` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_TRX011_1` UNIQUE (`trx010_id`, `line_number`)
)
ENGINE=InnoDB;;

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
ENGINE=InnoDB;;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST003` ADD CONSTRAINT `MST002_MST003` 
    FOREIGN KEY (`mst002_id`) REFERENCES `MST002` (`id`);

ALTER TABLE `MST005` ADD CONSTRAINT `MST004_MST005` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `MST010` ADD CONSTRAINT `MST001_MST010` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);

ALTER TABLE `MST010` ADD CONSTRAINT `MST002_MST010` 
    FOREIGN KEY (`mst002_id`) REFERENCES `MST002` (`id`);

ALTER TABLE `MST010` ADD CONSTRAINT `MST003_MST010` 
    FOREIGN KEY (`mst003_id`) REFERENCES `MST003` (`id`);

ALTER TABLE `TRX011` ADD CONSTRAINT `TRX010_TRX011` 
    FOREIGN KEY (`trx010_id`) REFERENCES `TRX010` (`id`);

ALTER TABLE `TRX012` ADD CONSTRAINT `TRX010_TRX012` 
    FOREIGN KEY (`trx010_id`) REFERENCES `TRX010` (`id`);
