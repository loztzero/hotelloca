# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-01-08 06:22                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST005` DROP FOREIGN KEY `MST004_MST005`;

ALTER TABLE `MST005` DROP FOREIGN KEY `MST004_MST0052`;

# ---------------------------------------------------------------------- #
# Drop table "MST005"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST005` DROP PRIMARY KEY;

DROP INDEX `TUC_MST005_1` ON `MST005`;

# Drop table #

DROP TABLE `MST005`;
