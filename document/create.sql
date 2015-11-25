# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-11-25 23:04                                #
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
    `postcode` VARCHAR(15) NOT NULL COMMENT 'kode pos',
    `mst002_id` VARCHAR(100) NOT NULL COMMENT 'negara',
    `mst003_id` VARCHAR(100) NOT NULL COMMENT 'kota',
    `phone_number` VARCHAR(40) NOT NULL COMMENT 'no telepon',
    `fax_number` VARCHAR(40) COMMENT 'nomor fax',
    `email` VARCHAR(40) NOT NULL COMMENT 'email',
    `website` VARCHAR(40) COMMENT 'website',
    `mst004_id` VARCHAR(100),
    `meal_price` DOUBLE(30,10),
    `bed_price` DOUBLE(30,10),
    `active_flg` VARCHAR(100) NOT NULL COMMENT 'aktif = dah kirim email ke agent untuk passwordnya',
    `mst001_id` VARCHAR(100) COMMENT 'user',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST020` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST020_1` UNIQUE (`hotel_id`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;;

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
