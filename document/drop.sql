# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-10-19 22:19                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST003` DROP FOREIGN KEY `MST002_MST003`;

ALTER TABLE `MST005` DROP FOREIGN KEY `MST004_MST005`;

ALTER TABLE `MST010` DROP FOREIGN KEY `MST001_MST010`;

ALTER TABLE `MST010` DROP FOREIGN KEY `MST002_MST010`;

ALTER TABLE `MST010` DROP FOREIGN KEY `MST003_MST010`;

ALTER TABLE `TRX011` DROP FOREIGN KEY `TRX010_TRX011`;

ALTER TABLE `TRX012` DROP FOREIGN KEY `TRX010_TRX012`;

ALTER TABLE `BLNC001` DROP FOREIGN KEY `MST001_BLNC001`;

ALTER TABLE `BLNC001` DROP FOREIGN KEY `MST004_BLNC001`;

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
# Drop table "TRX011"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX011` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX011_1` ON `TRX011`;

# Drop table #

DROP TABLE `TRX011`;

# ---------------------------------------------------------------------- #
# Drop table "TRX010"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX010` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX010_1` ON `TRX010`;

# Drop table #

DROP TABLE `TRX010`;

# ---------------------------------------------------------------------- #
# Drop table "MST010"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST010` DROP PRIMARY KEY;

DROP INDEX `TUC_MST010_1` ON `MST010`;

# Drop table #

DROP TABLE `MST010`;

# ---------------------------------------------------------------------- #
# Drop table "TRX001"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX001` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX001_1` ON `TRX001`;

# Drop table #

DROP TABLE `TRX001`;

# ---------------------------------------------------------------------- #
# Drop table "MST005"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST005` DROP PRIMARY KEY;

DROP INDEX `TUC_MST005_1` ON `MST005`;

# Drop table #

DROP TABLE `MST005`;

# ---------------------------------------------------------------------- #
# Drop table "MST004"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST004` DROP PRIMARY KEY;

DROP INDEX `TUC_MST004_1` ON `MST004`;

# Drop table #

DROP TABLE `MST004`;

# ---------------------------------------------------------------------- #
# Drop table "MST003"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST003` DROP PRIMARY KEY;

DROP INDEX `TUC_MST003_1` ON `MST003`;

# Drop table #

DROP TABLE `MST003`;

# ---------------------------------------------------------------------- #
# Drop table "MST002"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST002` DROP PRIMARY KEY;

DROP INDEX `TUC_MST002_1` ON `MST002`;

# Drop table #

DROP TABLE `MST002`;

# ---------------------------------------------------------------------- #
# Drop table "MST001"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST001` DROP PRIMARY KEY;

DROP INDEX `TUC_MST001_1` ON `MST001`;

# Drop table #

DROP TABLE `MST001`;
