/**************************
** Routes table
**************************/
drop table if exists routes;
create table routes (
	id int not null auto_increment primary key,
	method varchar(4),
	route varchar(200),
	controller varchar(50),
	action varchar(50)
) engine = InnoDB;

insert into routes (method, route, controller, action) values 

	-- Statics pages
	('GET', '', 'MainController', 'index'),

;