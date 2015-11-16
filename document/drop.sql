# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-11-16 21:41                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `TEMP002` DROP FOREIGN KEY `TEMP001_TEMP002`;

# ---------------------------------------------------------------------- #
# Drop table "TEMP002"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TEMP002` DROP PRIMARY KEY;

DROP INDEX `TUC_TEMP002_1` ON `TEMP002`;

# Drop table #

DROP TABLE `TEMP002`;
