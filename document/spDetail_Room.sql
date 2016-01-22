CREATE  PROCEDURE `spdetail_room` (IN hotelId VARCHAR(100),
                                IN checkInDate Date, 
                                IN checkOutDate Date,
                                IN adult INTEGER (5),
                                IN children INTEGER(5),
                                IN roomNum INTEGER(5))
BEGIN
  
    SELECT * from mst020; 
END//