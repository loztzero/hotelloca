  
-- note endt date nya tu hrsnya check out date - 1 hari, soalnya klo lu tulis check out tgl 3 ya dia cm byr sampe tgl 2
-- misalkan 1-5 jan , tgl 5 januari check out berarti sampe tgl 4 check outnya
          select a.*, j.pict,h.nett_value
			from MST020 a	
			inner join 
			(
			  select c.mst020_id, c.nett_value , c.rate_type, c.comm_type, 
			    c.comm_pct,c.comm_value,c.num_adults,c.allotment,
			    c.from_date, c.end_date
			  from MST022 c 
			  where c.id = ( select min(f.id) 
                             from MST022 f 
                             where f.mst020_id = c.mst020_id
                             and f.nett_value = (select min(g.nett_value) 
                                                 from MST022 g 
                                                 where g.mst020_id =f.mst020_id))

			  and c.num_adults >= 0 
			  and c.allotment-c.used_allotment >= 0 
			  and (c.from_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y') or c.end_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y'))
               And (c.end_date <= STR_TO_DATE('01/13/2016', '%m/%d/%Y') or c.from_date <= STR_TO_DATE('01/13/2016', '%m/%d/%Y'))
              And STR_TO_DATE('01/12/2016', '%m/%d/%Y') >= (select min(ab.from_date) from mst022 ab where ab.mst020_id = c.mst020_id)
               And STR_TO_DATE('01/13/2016', '%m/%d/%Y') <= (select max(ac.end_date) from mst022 ac where ac.mst020_id = c.mst020_id)) as h on h.mst020_id = a.id 
            left join 
			(select e.pict,e.mst020_id as mst020_id
			 from MST021 e 
			 where e.line_number =(select max(f.line_number) 
                                   from MST021 f 
                                   where f.mst020_id = e.mst020_id)) as j on j.mst020_id = a.id
			where a.mst002_id = 


-- query baru yang bener
select a.hotel_id,a.hotel_name,a.star, j.pict, min(h.nett_value)
			from MST020 a	
			inner join 
			(
				select c.mst020_id, c.nett_value, c.rate_type, c.comm_type, 
				c.comm_pct,c.comm_value,c.num_adults,c.allotment,
				c.from_date, c.end_date
				from MST022 c 
				where 
				 c.num_adults >= 0 
				and c.allotment-c.used_allotment >= 0 
				and (
						c.from_date >= STR_TO_DATE('2016-02-11', '%Y-%m-%d') 
						or 
						c.end_date >= STR_TO_DATE('2016-02-11', '%Y-%m-%d') 
					)
				and (
						c.end_date <= STR_TO_DATE('2016-02-12', '%Y-%m-%d') 
						or 
						c.from_date <= STR_TO_DATE('2016-02-12', '%Y-%m-%d') 
					)
				and STR_TO_DATE('2016-02-11', '%Y-%m-%d') >= 
				(
					select min(ab.from_date) 
					from MST022 ab 
					where ab.mst020_id = c.mst020_id
				)
				and STR_TO_DATE('2016-02-12', '%Y-%m-%d')  <= 
				(
					select max(ac.end_date) 
					from MST022 ac 
					where ac.mst020_id = c.mst020_id
				)
			) as h on h.mst020_id = a.id 

			left join 
			(
				select e.pict,e.mst020_id as mst020_id
				from MST021 e 
				where e.line_number =
				(
					select max(f.line_number) 
					from MST021 f 
					where f.mst020_id = e.mst020_id
				)
			) as j on j.mst020_id = a.id
			where a.mst002_id = '1493ba24-e4d7-4925-bba6-4f181651f575'
            group by a.hotel_id,a.hotel_name,a.star, j.pict; 
note , group by sesuain ma selectnya

	