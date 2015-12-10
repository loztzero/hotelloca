# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-12-10 20:49                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST020` DROP FOREIGN KEY `MST001_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST002_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST003_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST004_MST020`;

ALTER TABLE `MST021` DROP FOREIGN KEY `MST020_MST021`;

ALTER TABLE `MST022` DROP FOREIGN KEY `MST020_MST022`;

ALTER TABLE `MST022` DROP FOREIGN KEY `MST004_MST022`;

# ---------------------------------------------------------------------- #
# Drop table "MST022"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST022` DROP PRIMARY KEY;

DROP INDEX `TUC_MST022_1` ON `MST022`;

# Drop table #

DROP TABLE `MST022`;

# ---------------------------------------------------------------------- #
# Drop table "MST021"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST021` DROP PRIMARY KEY;

DROP INDEX `TUC_MST021_1` ON `MST021`;

# Drop table #

DROP TABLE `MST021`;

# ---------------------------------------------------------------------- #
# Drop table "MST020"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST020` DROP PRIMARY KEY;

DROP INDEX `TUC_MST020_1` ON `MST020`;

# Drop table #

DROP TABLE `MST020`;
