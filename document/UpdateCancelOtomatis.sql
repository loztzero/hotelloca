update LOG020 set used_allotment = used_allotment - (SELECT SUM(B.room_num)
												FROM BLNC004 A 
												INNER JOIN BLNC002 B ON B.id = A.blnc002_id
												INNER JOIN BLNC001 C ON C.id = B.blnc001_id
												INNER JOIN BLNC003 E ON E.blnc001_id = C.id	
												INNER JOIN MST022 D ON D.mst023_id = B.mst023_id
						  												  AND A.check_in_date 
																		  BETWEEN D.from_date AND D.end_date
												WHERE  DATE_ADD(E.created_at,INTERVAL 1 HOUR) < NOW()
												AND E.conf_payment_date is null
												AND E.payment_method = 'Transfer'
												AND LOG020.mst023_id = B.mst023_id
												AND LOG020.check_in_date = A.check_in_date )
WHERE EXISTS (SELECT 1
				  FROM BLNC004 A 
				  INNER JOIN BLNC002 B ON B.id = A.blnc002_id
				  INNER JOIN BLNC001 C ON C.id = B.blnc001_id
				  INNER JOIN BLNC003 E ON E.blnc001_id = C.id	
				  INNER JOIN MST022 D ON D.mst023_id = B.mst023_id
				   						  AND A.check_in_date 
											  BETWEEN D.from_date AND D.end_date
				  WHERE  DATE_ADD(E.created_at,INTERVAL 1 HOUR) < NOW()
				  AND E.conf_payment_date is null
				  AND E.payment_method = 'Transfer'
				  AND LOG020.mst023_id = B.mst023_id
				  AND LOG020.check_in_date = A.check_in_date);






UPDATE BLNC001 SET status_flag = 'Cancel',status_pymnt = 'Failed'
WHERE 
EXISTS (SELECT 1 FROM BLNC003 A WHERE A.blnc001_id = BLNC001.id
										AND A.payment_method = 'Transfer'	
										AND A.conf_payment_date is null
										AND DATE_ADD(A.created_at,INTERVAL 1 HOUR) < NOW());
