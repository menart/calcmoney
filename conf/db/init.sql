CREATE TABLE public.conversions (
	id serial NOT NULL,
	from_currency bpchar(3) NULL,
	to_currency bpchar(3) NULL,
	amount numeric NULL,
	course numeric NULL,
	converted numeric NULL,
	date_added timestamp NULL DEFAULT 'now'::text::timestamp without time zone,
	date_deleted timestamp NULL
);
