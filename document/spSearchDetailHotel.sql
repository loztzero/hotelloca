create procedure search_detail_room(pSessionId VARCHAR(100),
                                    pHotelId varchar(100),
                                    pFromDate VARCHAR(100),
                                    pEndDate VARCHAR(100),
                                    pMarket VARCHAR(100),
                                    pAllotment INTEGER,
                                    pNumsAdult INTEGER,
                                    pNumsChild INTEGER )
BEGIN 

    -- ambil semua room yang possible
     INSERT INTO TEMP003
        (session_id, mst022_id, mst023_id)
     SELECT pSessionId,C.id,D.id
     FROM MST022 C
     INNER JOIN MST023 D ON D.id = C.mst023_id
     WHERE  C.num_adults >= pNumsAdult
     AND C.num_child >= pNumsChild
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


       -- query sesuai kebutuhan
     SELECT B.mst020_id, D.room_name, B.room_desc, D.num_adults, B.num_child, B.num_breakfast,
             B.from_date, B.end_date, B.net_fee, B.net, B.cancel_fee_flag, B.cancel_fee_val,
             B.allotment-B.used_allotment AS allotment, B.comm_value, B.cut_off, B.bed_type,
             CASE WHEN UPPER(pMarket) = 'INDONESIA' 
             THEN B.nett_value 
                ELSE B.nett_value_wna 
             END as nett_value
     FROM TEMP003 C
     inner join mst022 b on b.id = c.mst022_id
     inner join mst023 d on d.id = c.mst023_id
     WHERE 
      (
        b.from_date >= STR_TO_DATE(pFromDate, '%d-%m-%Y')
        OR
        b.end_date >= STR_TO_DATE(pFromDate, '%d-%m-%Y')
      )

     AND
      (
        b.end_date <= STR_TO_DATE(pEndDate, '%d-%m-%Y')
        OR
        b.from_date <= STR_TO_DATE(pEndDate, '%d-%m-%Y')
      )

     AND STR_TO_DATE(pFromDate, '%d-%m-%Y') >=
      (
        SELECT MIN(AB.from_date) FROM MST022 AB WHERE AB.mst023_id = C.mst023_id
        AND AB.id IN(SELECT CD.mst022_id FROM TEMP003 CD WHERE CD.session_id = pSessionId)
      )

     AND STR_TO_DATE(pEndDate, '%d-%m-%Y') <=
      (
        SELECT MAX(AC.end_date) FROM MST022 AC WHERE AC.mst023_id = C.mst023_id
        AND AC.id IN(SELECT CD.mst022_id FROM TEMP003 CD WHERE CD.session_id = pSessionId)
      ) 
      AND C.session_id = pSessionId
      ORDER BY D.room_name, B.from_date;

       DELETE FROM TEMP003 WHERE session_id = pSessionId;
END;