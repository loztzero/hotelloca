# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-11-02 22:22                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop table "TEMP001"                                                   #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TEMP001` DROP PRIMARY KEY;

DROP INDEX `TUC_TEMP001_1` ON `TEMP001`;

# Drop table #

DROP TABLE `TEMP001`;
