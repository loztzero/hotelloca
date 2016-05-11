# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-05-11 20:24                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop table "LOG040"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `LOG040` DROP PRIMARY KEY;

DROP INDEX `TUC_LOG040_1` ON `LOG040`;

# Drop table #

DROP TABLE `LOG040`;
