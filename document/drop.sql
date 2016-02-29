# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-02-29 23:13                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `TRX010` DROP FOREIGN KEY `MST001_TRX010`;

ALTER TABLE `TRX010` DROP FOREIGN KEY `MST004_TRX010`;

ALTER TABLE `TRX013` DROP FOREIGN KEY `TRX011_TRX013`;

ALTER TABLE `TRX012` DROP FOREIGN KEY `TRX010_TRX012`;

ALTER TABLE `BLNC001` DROP FOREIGN KEY `MST001_BLNC001`;

ALTER TABLE `BLNC001` DROP FOREIGN KEY `MST004_BLNC001`;

ALTER TABLE `BLNC003` DROP FOREIGN KEY `BLNC001_BLNC003`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `TRX010_TRX011`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `MST020_TRX011`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `MST023_TRX011`;

ALTER TABLE `BLNC002` DROP FOREIGN KEY `BLNC001_BLNC002`;

ALTER TABLE `BLNC002` DROP FOREIGN KEY `MST020_BLNC002`;

ALTER TABLE `BLNC002` DROP FOREIGN KEY `MST023_BLNC002`;

ALTER TABLE `BLNC004` DROP FOREIGN KEY `BLNC002_BLNC004`;

ALTER TABLE `BLNC020` DROP FOREIGN KEY `MST001_BLNC020`;

ALTER TABLE `BLNC020` DROP FOREIGN KEY `MST004_BLNC020`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC004"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC004` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC004_1` ON `BLNC004`;

# Drop table #

DROP TABLE `BLNC004`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC002"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC002` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC002_1` ON `BLNC002`;

# Drop table #

DROP TABLE `BLNC002`;

# ---------------------------------------------------------------------- #
# Drop table "TRX011"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX011` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX011_1` ON `TRX011`;

# Drop table #

DROP TABLE `TRX011`;

# ---------------------------------------------------------------------- #
# Drop table "TRX013"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX013` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX013_1` ON `TRX013`;

# Drop table #

DROP TABLE `TRX013`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC020"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC020` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC020_1` ON `BLNC020`;

# Drop table #

DROP TABLE `BLNC020`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC003"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC003` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC003_1` ON `BLNC003`;

# Drop table #

DROP TABLE `BLNC003`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC001"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC001` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC001_1` ON `BLNC001`;

# Drop table #

DROP TABLE `BLNC001`;

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

# ---------------------------------------------------------------------- #
# Drop table "TRX001"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX001` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX001_1` ON `TRX001`;

# Drop table #

DROP TABLE `TRX001`;
