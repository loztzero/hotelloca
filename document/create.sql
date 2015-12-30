# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2015-12-30 19:12                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "MST023"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST023` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `room_name` VARCHAR(100) NOT NULL COMMENT 'nama kamar',
    `num_adults` INTEGER(5) NOT NULL COMMENT 'jumlah orang /kamar',
    `num_child` INTEGER(5) NOT NULL COMMENT 'jumlah anak',
    `bed_type` VARCHAR(100) NOT NULL COMMENT 'Tipe Ranjang queen/king',
    `net` VARCHAR(100) NOT NULL COMMENT 'ada internet Yes/No',
    `net_fee` DOUBLE(30,5) NOT NULL COMMENT 'biaya interner',
    `num_breakfast` INTEGER(5) NOT NULL COMMENT 'ada berapa org breakfast',
    `room_desc` VARCHAR(1024) NOT NULL COMMENT 'keterangan kamar',
    `image` VARCHAR(100) COMMENT 'gambar',
    `floor` VARCHAR(100) NOT NULL COMMENT 'lantai kamar : higher/lower',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST023` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST023_1` UNIQUE (`mst020_id`, `room_name`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Add table "MST022"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `MST022` (
    `id` VARCHAR(100) NOT NULL,
    `mst020_id` VARCHAR(100) NOT NULL COMMENT 'nama company',
    `mst023_id` VARCHAR(100) NOT NULL COMMENT 'detail room id',
    `from_date` DATE NOT NULL COMMENT 'tgl awal',
    `end_date` DATE COMMENT 'tgl akhir',
    `num_adults` INTEGER(5) NOT NULL COMMENT 'jumlah orang /kamar',
    `num_child` INTEGER(5) NOT NULL COMMENT 'jumlah anak',
    `bed_type` VARCHAR(100) NOT NULL COMMENT 'Tipe Ranjang queen/king',
    `net` VARCHAR(100) NOT NULL COMMENT 'ada internet Yes/No',
    `net_fee` DOUBLE(30,5) NOT NULL COMMENT 'biaya interner',
    `num_breakfast` INTEGER(5) NOT NULL COMMENT 'ada berapa org breakfast',
    `floor` VARCHAR(100) NOT NULL COMMENT 'lantai : higher/lower',
    `allotment` INTEGER COMMENT 'kapasitas',
    `cut_off` INTEGER(5) COMMENT 'cutt off dalam hari',
    `room_desc` VARCHAR(1024) NOT NULL COMMENT 'keterangan kamar',
    `mst004_id` VARCHAR(100) NOT NULL COMMENT 'valuta',
    `rate_type` VARCHAR(100) NOT NULL COMMENT 'tipe rate commision/nett',
    `daily_price` DOUBLE(30,5) NOT NULL COMMENT 'rate/hari',
    `comm_type` VARCHAR(100) COMMENT 'tipe komisi %/value',
    `comm_pct` DOUBLE(5,2) NOT NULL COMMENT '% komisi',
    `comm_value` DOUBLE(30,5) NOT NULL COMMENT 'nilai komisi',
    `cancel_fee_flag` VARCHAR(100) NOT NULL COMMENT 'ada cancel fee? Yes/No',
    `cancel_fee_val` DOUBLE(30,10) NOT NULL COMMENT 'nilai cancel fee',
    `updated_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    CONSTRAINT `PK_MST022` PRIMARY KEY (`id`),
    CONSTRAINT `TUC_MST022_1` UNIQUE (`mst020_id`, `mst023_id`, `end_date`)
)
ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST022` ADD CONSTRAINT `MST020_MST022` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);

ALTER TABLE `MST022` ADD CONSTRAINT `MST004_MST022` 
    FOREIGN KEY (`mst004_id`) REFERENCES `MST004` (`id`);

ALTER TABLE `MST022` ADD CONSTRAINT `MST023_MST022` 
    FOREIGN KEY (`mst023_id`) REFERENCES `MST023` (`id`);

ALTER TABLE `MST023` ADD CONSTRAINT `MST020_MST023` 
    FOREIGN KEY (`mst020_id`) REFERENCES `MST020` (`id`);
