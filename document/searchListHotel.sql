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
			  and c.from_date >= 2016-05-12 
			  and c.end_date >= 2016-06-13) as h on h.mst020_id = a.id 
            left join 
			(select e.pict,e.mst020_id as mst020_id
			 from MST021 e 
			 where e.line_number =(select max(f.line_number) 
                                   from MST021 f 
                                   where f.mst020_id = e.mst020_id)) as j on j.mst020_id = a.id
			where a.mst002_id = 

	