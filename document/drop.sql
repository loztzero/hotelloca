# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-01-14 20:32                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST025` DROP FOREIGN KEY `MST023_MST025`;

ALTER TABLE `MST024` DROP FOREIGN KEY `MST020_MST024`;

# ---------------------------------------------------------------------- #
# Drop table "MST024"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST024` DROP PRIMARY KEY;

DROP INDEX `TUC_MST024_1` ON `MST024`;

# Drop table #

DROP TABLE `MST024`;

# ---------------------------------------------------------------------- #
# Drop table "MST025"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST025` DROP PRIMARY KEY;

DROP INDEX `TUC_MST025_1` ON `MST025`;

# Drop table #

DROP TABLE `MST025`;
