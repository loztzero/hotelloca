# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-12-28 22:23                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST022"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST022` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `room_id` VARCHAR(100) NOT NULL COMMENT 'alamat',
    `from_date` DATE NOT NULL COMMENT 'tgl awal',
    `end_date` DATE COMMENT 'tgl akhir',
    `room_name` VARCHAR(100) NOT NULL COMMENT 'kodnama kamar',
    `num_adults` INTEGER(5) NOT NULL COMMENT 'jumlah orang /kamar',
    `num_child` INTEGER(5) NOT NULL COMMENT 'jumlah anak',
    `bed_type` VARCHAR(100) NOT NULL COMMENT 'Tipe Ranjang queen/king',
    `net` VARCHAR(100) NOT NULL COMMENT 'ada internet Yes/No',
    `net_fee` DOUBLE(30,5) NOT NULL COMMENT 'biaya interner',
    `num_breakfast` INTEGER(5) NOT NULL COMMENT 'ada berapa org breakfast',
    `allotment` INTEGER COMMENT 'kapasitas',
    `cut_off` INTEGER(5) COMMENT 'cutt off dalam hari',
    `room_desc` VARCHAR(1024) NOT NULL COMMENT 'keterangan kamar',
    `mst004_id` VARCHAR(100) NOT NULL COMMENT 'valuta',
    `rate_type` VARCHAR(100) NOT NULL COMMENT 'tipe rate commision/nett',
    `daily_price` DOUBLE(30,5) NOT NULL COMMENT 'rate/hari',
    `comm_type` VARCHAR(100) COMMENT 'tipe komisi %/value',
    `comm_pct` DOUBLE(5,2) NOT NULL COMMENT '% komisi',
    `comm_value` DOUBLE(30,5) NOT NULL COMMENT 'nilai komisi',
    `image` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST022` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST022_1` UNIQUE (`mst020_id`, `room_id`, `end_date`, `room_name`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST022` ADD CONSTRAINT `MST020_MST022` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `MST022` ADD CONSTRAINT `MST004_MST022` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);
