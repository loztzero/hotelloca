-- seracj list detail room
 select d.room_name,c.num_adults,c.num_child,c.num_breakfast,min(c.allotment - c.used_allotment),
        sum(c.nett_value)
			  from MST022 c 
              inner join MST023 d on d.id = c.mst023_id
			  where  c.num_adults >= 0 
			  and c.allotment-c.used_allotment >= 0 
			  and (c.from_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y') or c.end_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y'))
               And (c.end_date <= STR_TO_DATE('02/13/2016', '%m/%d/%Y') or c.from_date <= STR_TO_DATE('02/13/2016', '%m/%d/%Y'))
              And STR_TO_DATE('01/12/2016', '%m/%d/%Y') >= (select min(ab.from_date) from mst022 ab where ab.mst020_id = c.mst020_id)
               And STR_TO_DATE('02/13/2016', '%m/%d/%Y') <= (select max(ac.end_date) from mst022 ac where ac.mst020_id = c.mst020_id)
            group by d.room_name;

-- pas expandable detail price, ini dilooping jd misalkan 
-- check in tgl 1 jan , check out tgl 4 januari, berarti kan 3 malem
-- jd tgllnya hrsnya adanya 1jan,2 jan,3 januari, pas looping sambil query ini
 select c.nett_value
			  from MST022 c 
where pdate between c.from_date and c.end_date
and c.mst020_id = 






-- query untuk mendapatkan informasi lengkap 
-- namun tidak terjadi summary lagi ... 

select d.room_name, c.num_adults, c.num_child, c.num_breakfast,
  c.allotment - c.used_allotment,
  c.nett_value,c.from_date , c.end_date 
from MST022 c
inner join MST023 d on d.id = c.mst023_id
where  c.num_adults >= 0
  and c.allotment - c.used_allotment >= 0
  and
  (
    c.from_date >= STR_TO_DATE('01/20/2016', '%m/%d/%Y')
    or
    c.end_date >= STR_TO_DATE('01/20/2016', '%m/%d/%Y')
  )
 
  and
  (
    c.end_date <= STR_TO_DATE('01/22/2016', '%m/%d/%Y')
    or
    c.from_date <= STR_TO_DATE('01/22/2016', '%m/%d/%Y')
  )
 
  and STR_TO_DATE('01/20/2016', '%m/%d/%Y') >=
  (
    select min(ab.from_date) from MST022 ab where ab.mst020_id = c.mst020_id
  )
 
  and STR_TO_DATE('01/22/2016', '%m/%d/%Y') <=
  (
    select max(ac.end_date) from MST022 ac where ac.mst020_id = c.mst020_id
  ) and c.mst020_id = '0597bfb1-8f57-459d-af6e-d653775a0a73'



--- cara pakai spnya
1. generate temp table TEMP003
2. generate sp di db di file spSearchDetailHotel
3. cara panggil contohnya
   call search_detail_room('nita','216686a2-393d-4fa6-b2e8-fc0b9f9ad26b','03/31/2016','04/03/2016','indonesia',1,2,3)
    nita = session id
    03/31/2016 = start date
04/03/2016 = end date
	indonesia= market
1 = jumlah kamar  
2 = num adults
3 = num children
  
