-- Query untuk halaman my booking
SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
       D.transfer_date, A.status_flg,A.tot_payment,coalesce(E.payment_menthod,'pending') as payment_mehtod,
       CASE WHEN now() < ADDDATE(b.check_in_date, - (b.cut_off +1)) THEN true ELSE false END as show_cancel
FROM BLNC001 A
INNER JOIN BLNC002 B ON B.blnc001_id = A.id
INNER JOIN MST020 C ON C.id = B.mst020_id
LEFT JOIN TRX001 D ON D.order_no = A.order_no
LEFT JOIN BLNC003 E ON E.blnc001_id = a.id
WHERE A.order_no LIKE '%123%'
AND B.check_in_date =  STR_TO_DATE('2016-02-11', '%Y-%m-%d')
AND B.check_out_date = STR_TO_DATE('2016-02-11', '%Y-%m-%d')
AND C.mst002_id = '12345'
AND C.mst003_id = '12345'
AND A.mst001_id = :userid;


-- Layout Order Detail
SELECT A.order_no,A.order_date,B.market,B.title || ',' ||B.first_name||' '||B.last_name AS guest,
       D.country_name,E.city_name,B.check_in_date,B.check_out_date,A.status_flg,
       C.hotel_name,C.address,C.postcode,C.phone_number,B.num_adults,B.num_child,B.num_breakfast,
       F.image,B.type,B.room_num
FROM BLNC001 A
INNER JOIN BLNC002 B ON B.blnc001_id = A.id
INNER JOIN MST020 C ON C.id = B.mst020_id
INNER JOIN MST002 D ON D.id = C.mst002_id
INNER JOIN MST003 E ON E.id = C.mst003_id
INNER JOIN MST023 F ON F.id = B.mst023_id
WHERE A.order_no = pOrderNo
AND A.mst001_id = :userid;


--Print Voucher for agent
SELECT A.order_no,A.order_date,B.market,B.title || ',' ||B.first_name||' '||B.last_name AS guest,
       D.country_name,B.check_in_date,B.check_out_date,A.status_flg,
       C.hotel_name,B.room_name,B.num_adults,B.num_child,B.num_breakfast,
       B.room_num,C.address,C.postcode,C.phone_number,B.note,B.cut_off,B.cancel_fee_flg,B.cancel_fee_value
FROM BLNC001 A
INNER JOIN BLNC002 B ON B.blnc001_id = A.id
INNER JOIN MST020 C ON C.id = B.mst020_id
INNER JOIN MST002 D ON D.id = C.mst002_id
INNER JOIN MST003 E ON E.id = C.mst003_id
INNER JOIN MST023 F ON F.id = B.mst023_id
WHERE A.order_no = pOrderNo
AND A.mst001_id = :userid;

--Invoice
SELECT A.order_no,A.order_date,B.market,B.title || ',' ||B.first_name||' '||B.last_name AS guest,
       D.country_name,G.transfer_date As payment_date,
       C.hotel_name,B.room_name,B.num_adults,B.num_child,B.num_breakfast,
       B.room_num,B.cut_off, B.tot_payment,
FROM BLNC001 A
INNER JOIN BLNC002 B ON B.blnc001_id = A.id
INNER JOIN MST020 C ON C.id = B.mst020_id
INNER JOIN MST023 F ON F.id = B.mst023_id
INNER JOIN TRX001 G ON G.order_no = A.order_no
WHERE A.order_no = pOrderNo
AND A.mst001_id = :userid;

-- detail Invoice
SELECT A.check_in_date,A.nett_value as daily_price,A.nett_value*B.room_num as total
FROM BLNC004 A
INNER JOIN BLNC002 B ON B.id = A.blnc002_id
INNER JOIN BLNC001 C ON C.id = B.blnc001_id
WHERE C.order_no = pOrderNo
AND C.mst001_id = :userid;
