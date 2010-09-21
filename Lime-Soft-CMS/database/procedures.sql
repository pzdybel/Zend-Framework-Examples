delimiter //

drop procedure if exists getRoleTree//
create procedure getRoleTree (in role varchar(16))
begin
	declare nid int default -1;
	declare done boolean default false;
	drop temporary table if exists __result;
	create temporary table __result (id int);
	select id from AclRoles where name = role limit 1 into nid;
	insert into __result values (nid);
	outer_loop: loop
		if done then
			leave outer_loop;
		end if;
		inner_block: begin
			declare current_val int;
			declare no_more_rows boolean default false;
			declare my_cursor cursor for select idParent from AclRoles where id = nid;
			declare continue handler for not found set no_more_rows = true;
			set done = true;
			open my_cursor;
			inner_loop: loop
				fetch my_cursor into current_val;
				if no_more_rows then
					leave inner_loop;
				end if;
				insert into __result values (current_val);
				set done = false;
				set nid = current_val;
			end loop inner_loop;
			close my_cursor;
		end inner_block;
	end loop outer_loop;
	/* produce the resultset */
	select t1.*, t2.name as nameParent from AclRoles t1
	join __result using(id)
	left join AclRoles t2 on t1.idParent = t2.id order by t1.id;
end//

drop procedure if exists getResourceTree//
create procedure getResourceTree (in role varchar(16))
begin
	declare i int default 0;
	declare done boolean default false;
	drop temporary table if exists __result;
	create temporary table __result (id int, iteration int);
	insert into __result (id, iteration)
	select distinct resourceId as id, i from AclPermissionView v where roleName = role;
	outer_loop: loop
		if done then
			leave outer_loop;
		end if;
		inner_block: begin
			declare current_val int;
			declare no_more_rows boolean default false;
			declare my_cursor cursor for select distinct id from __result where iteration = i;
			declare continue handler for not found set no_more_rows = true;
			set done = true;
			open my_cursor;
			inner_loop: loop
				fetch my_cursor into current_val;
				if no_more_rows then
					leave inner_loop;
				end if;
				insert into __result (id, iteration)
				select idParent as id, i+1 from AclResources where id = current_val;
				set done = false;
			end loop inner_loop;
			set i = i + 1;
			close my_cursor;
		end inner_block;
	end loop outer_loop;
	/* produce the resultset */
	select distinct t1.*, t2.name as nameParent from AclResources t1
	join __result using(id)
	left join AclResources t2 on t1.idParent = t2.id order by t1.id, t1.idParent;
end//

delimiter ;