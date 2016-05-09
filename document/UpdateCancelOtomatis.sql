INSERT INTO LOG020 (
	id,mst023_id,check_in_date,allotment,used_allotment,updated_at,created_at)
SELECT
	A.ID,B.mst023_id,A.check_in_date,D.allotment,B.room_num*-1,NOW(),NOW()
FROM BLNC004 A 
INNER JOIN BLNC002 B ON B.id = A.blnc002_id
INNER JOIN BLNC001 C ON C.id = B.blnc001_id
INNER JOIN BLNC003 E ON E.blnc001_id = C.id	
INNER JOIN MST022 D ON D.mst023_id = B.mst023_id
						  AND A.check_in_date BETWEEN D.from_date AND D.end_date
WHERE  DATE_ADD(E.created_at,INTERVAL 1 HOUR) < NOW()
AND E.conf_payment_date is null
AND E.payment_method = 'Transfer';


UPDATE BLNC001 SET status_flag = 'Cancel',status_pymnt = 'Failed'
WHERE 
EXISTS (SELECT 1 FROM BLNC003 A WHERE A.blnc001_id = BLNC001.id
										AND A.payment_method = 'Transfer'	
										AND A.conf_payment_date is null
										AND DATE_ADD(A.created_at,INTERVAL 1 HOUR) < NOW());
