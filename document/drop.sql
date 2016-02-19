# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          hotelLoca.dez                                   #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2016-02-20 00:01                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop table "TEMP004"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `TEMP004` MODIFY `id` BIGINT NOT NULL;

# Drop constraints #

ALTER TABLE `TEMP004` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `TEMP004`;

# ---------------------------------------------------------------------- #
# Drop table "TEMP003"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `TEMP003` MODIFY `id` BIGINT NOT NULL;

# Drop constraints #

ALTER TABLE `TEMP003` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `TEMP003`;
