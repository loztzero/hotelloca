# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-01-07 22:55                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `TRX010` DROP FOREIGN KEY `MST001_TRX010`;

ALTER TABLE `TRX010` DROP FOREIGN KEY `MST004_TRX010`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `TRX010_TRX011`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `MST020_TRX011`;

ALTER TABLE `TRX012` DROP FOREIGN KEY `TRX010_TRX012`;

# ---------------------------------------------------------------------- #
# Drop table "TRX011"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX011` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX011_1` ON `TRX011`;

# Drop table #

DROP TABLE `TRX011`;

# ---------------------------------------------------------------------- #
# Drop table "TRX012"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX012` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX012_1` ON `TRX012`;

# Drop table #

DROP TABLE `TRX012`;

# ---------------------------------------------------------------------- #
# Drop table "TRX010"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX010` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX010_1` ON `TRX010`;

# Drop table #

DROP TABLE `TRX010`;
