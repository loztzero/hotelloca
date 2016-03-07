 SELECT B.mst020_id, D.room_name, B.room_desc, D.num_adults, B.num_child, B.num_breakfast,
                             B.from_date, B.end_date, B.net_fee, B.net, B.cancel_fee_flag, B.cancel_fee_val,
                            COALESCE(E.allotment,B.allotment) AS allotment, B.comm_value, B.cut_off, B.bed_type,
                             CASE WHEN UPPER(?) = 'INDONESIA'
                                THEN B.nett_value
                                ELSE B.nett_value_wna
                             END as nett_value
                     FROM MST022 B
                     inner join MST023 D on D.id = B.mst023_id
                     left join (select A.mst023_id,Min(A.allotment-A.used_allotment) as allotment
                                from LOG020 A 
                                inner join MST023 F on F.id = A.mst023_id
                                where F.mst020_id = pHotelId) E
                                 on E.mst023_id = D.id
                     WHERE
                      (
                        B.from_date >= STR_TO_DATE(?, '%d-%m-%Y')
                        OR
                        B.end_date >= STR_TO_DATE(?, '%d-%m-%Y')
                      )
                 
                     AND
                      (
                        B.end_date <= STR_TO_DATE(?, '%d-%m-%Y')
                        OR
                        B.from_date <= STR_TO_DATE(?, '%d-%m-%Y')
                      )
                 
                     AND STR_TO_DATE(?, '%d-%m-%Y') >=
                      (
                        SELECT MIN(AB.from_date) FROM MST022 AB WHERE AB.mst023_id = B.mst023_id
                      )
                 
                     AND STR_TO_DATE(?, '%d-%m-%Y') <=
                      (
                        SELECT MAX(AC.end_date) FROM MST022 AC WHERE AC.mst023_id = B.mst023_id
                      )
 
                      AND B.mst023_id = ?
                      ORDER BY D.room_name, B.from_date;