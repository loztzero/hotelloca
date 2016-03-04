# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-03-04 20:18                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG010` DROP FOREIGN KEY `MST001_LOG010`;

# ---------------------------------------------------------------------- #
# Drop table "LOG010"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `LOG010` DROP PRIMARY KEY;

DROP INDEX `TUC_LOG010_1` ON `LOG010`;

# Drop table #

DROP TABLE `LOG010`;
