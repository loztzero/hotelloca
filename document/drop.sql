# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-03-28 21:12                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `LOG030` DROP FOREIGN KEY `MST001_LOG030`;

# ---------------------------------------------------------------------- #
# Drop table "LOG030"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `LOG030` DROP PRIMARY KEY;

DROP INDEX `TUC_LOG030_1` ON `LOG030`;

# Drop table #

DROP TABLE `LOG030`;
