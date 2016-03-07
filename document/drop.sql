# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-03-07 22:15                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG020` DROP FOREIGN KEY `MST023_LOG020`;

# ---------------------------------------------------------------------- #
# Drop table "LOG020"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `LOG020` DROP PRIMARY KEY;

DROP INDEX `TUC_LOG020_1` ON `LOG020`;

# Drop table #

DROP TABLE `LOG020`;
