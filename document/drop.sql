# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2015-10-13 23:13                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `MST003` DROP FOREIGN KEY `MST002_MST003`;

ALTER TABLE `MST005` DROP FOREIGN KEY `MST004_MST005`;

# ---------------------------------------------------------------------- #
# Drop table "MST005"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST005` DROP PRIMARY KEY;

DROP INDEX `TUC_MST005_1` ON `MST005`;

# Drop table #

DROP TABLE `MST005`;

# ---------------------------------------------------------------------- #
# Drop table "MST004"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST004` DROP PRIMARY KEY;

DROP INDEX `TUC_MST004_1` ON `MST004`;

# Drop table #

DROP TABLE `MST004`;

# ---------------------------------------------------------------------- #
# Drop table "MST003"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST003` DROP PRIMARY KEY;

DROP INDEX `TUC_MST003_1` ON `MST003`;

# Drop table #

DROP TABLE `MST003`;

# ---------------------------------------------------------------------- #
# Drop table "MST002"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST002` DROP PRIMARY KEY;

DROP INDEX `TUC_MST002_1` ON `MST002`;

# Drop table #

DROP TABLE `MST002`;

# ---------------------------------------------------------------------- #
# Drop table "MST001"                                                    #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `MST001` DROP PRIMARY KEY;

DROP INDEX `TUC_MST001_1` ON `MST001`;

# Drop table #

DROP TABLE `MST001`;
