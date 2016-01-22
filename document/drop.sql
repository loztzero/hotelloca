# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-01-19 20:59                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `BLNC002` DROP FOREIGN KEY `BLNC001_BLNC002`;

# ---------------------------------------------------------------------- #
# Drop table "BLNC002"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `BLNC002` DROP PRIMARY KEY;

DROP INDEX `TUC_BLNC002_1` ON `BLNC002`;

# Drop table #

DROP TABLE `BLNC002`;
