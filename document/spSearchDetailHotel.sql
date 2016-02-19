create procedure search_detail_room(pSessionId VARCHAR(100),
                                    pHotelId varchar(100),
                                    pFromDate VARCHAR(100),
                                    pEndDate VARCHAR(100),
                                    pMarket VARCHAR(100),
                                    pAllotment INTEGER)
BEGIN 

    -- ambil semua room yang possible
     INSERT INTO TEMP003
        (SESSION_ID,MST022_ID,MST023_ID)
     SELECT pSessionId,C.ID,D.ID
     FROM MST022 C
     INNER JOIN MST023 D ON D.ID = C.MST023_ID
     WHERE  C.NUM_ADULTS >= 0
     AND C.ALLOTMENT - C.USED_ALLOTMENT >= pAllotment
     AND
      (
        C.FROM_DATE >= STR_TO_DATE(pFromDate, '%m/%d/%Y')
        OR
        C.END_DATE >= STR_TO_DATE(pFromDate, '%m/%d/%Y')
      )

     AND
      (
        C.END_DATE <= STR_TO_DATE(pEndDate, '%m/%d/%Y')
        OR
        C.FROM_DATE <= STR_TO_DATE(pEndDate, '%m/%d/%Y')
      )

     AND STR_TO_DATE(pFromDate, '%m/%d/%Y') >=
      (
        SELECT MIN(AB.FROM_DATE) FROM MST022 AB WHERE AB.MST020_ID = C.MST020_ID
      )

     AND STR_TO_DATE(pEndDate, '%m/%d/%Y') <=
      (
        SELECT MAX(AC.END_DATE) FROM MST022 AC WHERE AC.MST020_ID = C.MST020_ID
      ) AND C.MST020_ID = pHotelId;

      -- beri nomor count per kamar
      INSERT INTO TEMP004
        (SESSION_ID,mst023_id,record)
      SELECT 
        pSessionId,MST023_ID,COUNT(*)
       FROM TEMP003
       GROUP BY MST023_ID;

       -- query sesuai kebutuhan
       SELECT B.mst020_id,C.room_name,B.num_adults,B.num_child,B.num_breakfast,
             B.from_date,B.end_date,B.net_fee,B.net,B.cancel_fee_flag,B.cancel_fee_val,
             B.allotment-B.used_allotment,B.comm_value,B.cut_off,B.bed_type,
             CASe WHEN UPPER(pMarket)='INDONESIA' THEN B.nett_value ELSE B.nett_value_wna END FROM TEMP003 A
       INNER JOIN MST022 B ON A.mst022_id = B.ID
       INNER JOIN MST023 C ON C.ID = A.mst023_id
       WHERE A.mst023_id IN (SELECT B.mst023_id FROM TEMP004 B
                              WHERE B.RECORD = (SELECT MAX(C.RECORD) FROM TEMP004 C
                                                WHERE C.SESSION_ID = B.SESSION_ID)
                              AND B.SESSION_ID = pSessionId)
       AND A.SESSION_ID = pSessionId;

       DELETE FROM TEMP003 WHERE SESSION_ID = pSessionId;
       DELETE FROM TEMP004 WHERE SESSION_ID = pSessionId;
END;