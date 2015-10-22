# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-10-22 22:16                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `TRX011` DROP FOREIGN KEY `TRX010_TRX011`;

# ---------------------------------------------------------------------- #
# Drop table "TRX011"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `TRX011` DROP PRIMARY KEY;

DROP INDEX `TUC_TRX011_1` ON `TRX011`;

# Drop table #

DROP TABLE `TRX011`;
