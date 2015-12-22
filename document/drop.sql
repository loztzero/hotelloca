# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-12-22 22:43                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

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
