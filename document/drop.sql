# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-12-30 19:12                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST022` DROP FOREIGN KEY `MST020_MST022`;

ALTER TABLE `MST022` DROP FOREIGN KEY `MST004_MST022`;

ALTER TABLE `MST022` DROP FOREIGN KEY `MST023_MST022`;

ALTER TABLE `MST023` DROP FOREIGN KEY `MST020_MST023`;

# ---------------------------------------------------------------------- #
# Drop table "MST022"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST022` DROP PRIMARY KEY;

DROP INDEX `TUC_MST022_1` ON `MST022`;

# Drop table #

DROP TABLE `MST022`;

# ---------------------------------------------------------------------- #
# Drop table "MST023"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST023` DROP PRIMARY KEY;

DROP INDEX `TUC_MST023_1` ON `MST023`;

# Drop table #

DROP TABLE `MST023`;
