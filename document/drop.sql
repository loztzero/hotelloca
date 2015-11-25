# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-11-25 23:21                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST020` DROP FOREIGN KEY `MST001_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST002_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST003_MST020`;

ALTER TABLE `MST020` DROP FOREIGN KEY `MST004_MST020`;

# ---------------------------------------------------------------------- #
# Drop table "MST020"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST020` DROP PRIMARY KEY;

DROP INDEX `TUC_MST020_1` ON `MST020`;

# Drop table #

DROP TABLE `MST020`;
