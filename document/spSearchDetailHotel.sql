create procedure search_detail_room(pSessionId VARCHAR(100),
                                    pHotelId varchar(100),
                                    pFromDate VARCHAR(100),
                                    pEndDate VARCHAR(100),
                                    pMarket VARCHAR(100),
                                    pAllotment INTEGER)
BEGIN 

    -- ambil semua room yang possible
     INSERT INTO TEMP003
        (session_id, mst022_id, mst023_id)
     SELECT pSessionId,C.id,D.id
     FROM MST022 C
     INNER JOIN MST023 D ON D.id = C.mst023_id
     WHERE  C.num_adults >= 0
     AND C.allotment - C.USED_allotment >= pAllotment
     AND
      (
        C.from_date >= STR_TO_DATE(pFromDate, '%d-%m-%Y')
        OR
        C.end_date >= STR_TO_DATE(pFromDate, '%d-%m-%Y')
      )

     AND
      (
        C.end_date <= STR_TO_DATE(pEndDate, '%d-%m-%Y')
        OR
        C.from_date <= STR_TO_DATE(pEndDate, '%d-%m-%Y')
      )

     AND STR_TO_DATE(pFromDate, '%d-%m-%Y') >=
      (
        SELECT MIN(AB.from_date) FROM MST022 AB WHERE AB.mst020_id = C.mst020_id
      )

     AND STR_TO_DATE(pEndDate, '%d-%m-%Y') <=
      (
        SELECT MAX(AC.end_date) FROM MST022 AC WHERE AC.mst020_id = C.mst020_id
      ) AND C.mst020_id = pHotelId;

      -- beri nomor count per kamar
      INSERT INTO TEMP004
        (session_id, mst023_id, record)
      SELECT 
        pSessionId,mst023_id,COUNT(*)
       FROM TEMP003
       GROUP BY mst023_id;

       -- query sesuai kebutuhan
       SELECT B.mst020_id, C.room_name, B.num_adults, B.num_child, B.num_breakfast,
             B.from_date, B.end_date, B.net_fee, B.net, B.cancel_fee_flag, B.cancel_fee_val,
             B.allotment-B.used_allotment AS allotment, B.comm_value, B.cut_off, B.bed_type,
             CASE WHEN UPPER(pMarket) = 'INDONESIA' 
             THEN B.nett_value 
                ELSE B.nett_value_wna 
             END as nett_value
       FROM TEMP003 A
       INNER JOIN MST022 B ON A.mst022_id = B.id
       INNER JOIN MST023 C ON C.id = A.mst023_id
       WHERE A.mst023_id IN (SELECT B.mst023_id FROM TEMP004 B
                              WHERE B.record = (SELECT MAX(C.record) FROM TEMP004 C
                                                WHERE C.session_id = B.session_id)
                              AND B.session_id = pSessionId)
       AND A.session_id = pSessionId
       ORDER BY C.room_name, B.from_date;

       DELETE FROM TEMP003 WHERE session_id = pSessionId;
       DELETE FROM TEMP004 WHERE session_id = pSessionId;
END;