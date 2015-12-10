# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-12-10 20:49                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST020"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST020` (
    `id` VARCHAR(100) NOT NULL,
    `hotel_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `hotel_name` VARCHAR(100) NOT NULL COMMENT 'alamat',
    `star` INTEGER(5) NOT NULL,
    `address` VARCHAR(1024) NOT NULL,
    `mst002_id` VARCHAR(100) NOT NULL COMMENT 'negara',
    `mst003_id` VARCHAR(100) NOT NULL COMMENT 'kota',
    `postcode` VARCHAR(15) COMMENT 'kode pos',
    `phone_number` VARCHAR(40) NOT NULL COMMENT 'no telepon',
    `fax_number` VARCHAR(40) COMMENT 'nomor fax',
    `landmark_name` VARCHAR(1024),
    `email` VARCHAR(40) COMMENT 'email',
    `website` VARCHAR(40) COMMENT 'website',
    `mst004_id` VARCHAR(100),
    `meal_price` DOUBLE(30,10),
    `bed_price` DOUBLE(30,10),
    `market` VARCHAR(100) NOT NULL COMMENT 'china/all/nonchina',
    `active_flg` VARCHAR(100) NOT NULL COMMENT 'aktif = dah kirim email ke agent untuk passwordnya',
    `api_flg` VARCHAR(40) COMMENT 'Yes/No',
    `mst001_id` VARCHAR(100) COMMENT 'user',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST020` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST020_1` UNIQUE (`hotel_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "MST021"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST021` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `line_number` VARCHAR(100) NOT NULL COMMENT 'alamat',
    `pict` VARCHAR(100) NOT NULL COMMENT 'kode pos',
    `description` VARCHAR(1024),
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST021` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST021_1` UNIQUE (`mst020_id`, `line_number`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "MST022"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST022` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `room_id` VARCHAR(100) NOT NULL COMMENT 'alamat',
    `from_date` DATE NOT NULL,
    `end_date` DATE,
    `room_name` VARCHAR(100) NOT NULL COMMENT 'kode pos',
    `bed_type` VARCHAR(100) NOT NULL COMMENT 'negara',
    `breakfast_no` INTEGER(5) NOT NULL COMMENT 'ada berapa org breakfast',
    `allotment` INTEGER COMMENT 'kapasitas',
    `cut_off` INTEGER(5) COMMENT 'cutt off dalam hari',
    `room_desc` VARCHAR(1024) NOT NULL COMMENT 'kota',
    `mst004_id` VARCHAR(100) NOT NULL,
    `price` DOUBLE(30,10) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST022` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST022_1` UNIQUE (`mst020_id`, `room_id`, `end_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST020` ADD CONSTRAINT `MST001_MST020` 
    FOREIGN KEY (`mst001_id`) REFERENCES `MST001` (`id`);

ALTER TABLE `MST020` ADD CONSTRAINT `MST002_MST020` 
    FOREIGN KEY (`mst002_id`) REFERENCES `MST002` (`id`);

ALTER TABLE `MST020` ADD CONSTRAINT `MST003_MST020` 
    FOREIGN KEY (`mst003_id`) REFERENCES `MST003` (`id`);

ALTER TABLE `MST020` ADD CONSTRAINT `MST004_MST020` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `MST021` ADD CONSTRAINT `MST020_MST021` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `MST022` ADD CONSTRAINT `MST020_MST022` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `MST022` ADD CONSTRAINT `MST004_MST022` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);
