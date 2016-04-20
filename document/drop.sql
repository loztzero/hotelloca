# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-04-20 22:21                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST030` DROP FOREIGN KEY `MST003_MST030`;

# ---------------------------------------------------------------------- #
# Drop table "MST030"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST030` DROP PRIMARY KEY;

DROP INDEX `TUC_MST030_1` ON `MST030`;

# Drop table #

DROP TABLE `MST030`;
