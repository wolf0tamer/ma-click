drop view if exists other.public.v_dim_user_account;
drop table if exists other.public.dim_user_account;
create table other.public.dim_user_account(
	NAME VARCHAR(100),
	CODE VARCHAR(16),
	OPEN_DT DATE,
	CLICK_COUNT INTEGER
);
create view other.public.v_dim_user_account as select * from other.public.dim_user_account;

drop view if exists other.public.v_fct_user_click_info;
drop table if exists other.public.fct_user_click_info;
create table other.public.fct_user_click_info(
	NAME VARCHAR(100),
	CODE VARCHAR(16),
	CLICK_EVENT VARCHAR(30)
);
create view other.public.v_fct_user_click_info as select * from other.public.fct_user_click_info;