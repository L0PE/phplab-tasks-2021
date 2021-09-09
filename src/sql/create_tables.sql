CREATE DATABASE childrens_rest;

--Create tables
CREATE TABLE schools (
	school_id SERIAL PRIMARY KEY,
	school_name varchar(50) NOT NULL
);

CREATE TABLE children (
	child_id SERIAL PRIMARY KEY,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	school_id int,
	age int NOT NULL,
	parents_phone varchar(15)
);

CREATE TABLE holiday_camps (
	camp_id SERIAL PRIMARY KEY,
	camp_name varchar(50) NOT NULL,
	camp_place varchar(255) NOT NULL
);

CREATE TABLE vacation_period (
	period_id SERIAL PRIMARY KEY,
	vacation_start date NOT NULL,
	vacation_end date NOT NULL
);

CREATE TABLE vacation (
	vacation_id serial PRIMARY KEY,
	child_id int,
	camp_id int,
	period_id int
);


--ADD CONSTRAINTS
ALTER TABLE children ADD CONSTRAINT fk_child_school
FOREIGN KEY (school_id) REFERENCES schools(school_id);

ALTER TABLE children ADD CONSTRAINT child_age_check
CHECK (age > 0);

ALTER TABLE vacation ADD CONSTRAINT fk_vacation_child
FOREIGN KEY (child_id) REFERENCES children(child_id);

ALTER TABLE vacation ADD CONSTRAINT fk_vacation_camp
FOREIGN KEY (camp_id) REFERENCES holiday_camps(camp_id);

ALTER TABLE vacation ADD CONSTRAINT fk_vacation_period
FOREIGN KEY (period_id) REFERENCES vacation_period(period_id);


--INSERT DATA
INSERT INTO schools (school_id, school_name) VALUES
	(1,'Тлумацька гімназія'),
	(2,'Івано-Франківська гімназія №1'),
	(3,'Школа №5 м.Івано-Франківськ');

INSERT INTO children (child_id, first_name, last_name, school_id, age, parents_phone) VALUES
	(1, 'Тетяна', 'Бугак', 1, 10, '(03554) 35370'),
	(2, 'Тетяна', 'Грицай',  2, 15, '(067) 3507303'),
	(3, 'Віктор', 'Жвавий', 1, 12, '(0352) 435743'),
	(4, 'Сергій', 'Касурський', 1, 12, '(0352) 220797'),
	(5, 'Артем', 'Коба', 1, 12, '(098) 4274078'),
	(6, 'Владислав', 'Мошко', 3, 14,'(0352) 431146'),
	(7, 'Богдан', 'Найдич', 2, 14, '(0352) 524114'),
	(8, 'Максим', 'Харченко', 2, 13, '(0352) 524114'),
	(9, 'Дмитро', 'Гулевич', 1, 13, '(03554) 41375'),
	(10, 'Марина', 'Кириченко', 2, 15, '(0352) 550040');

INSERT INTO holiday_camps (camp_id, camp_name, camp_place) VALUES
	(1, 'Вербиченька', 'с. Давидівка, Сторожинецький район, Чернівецька область'),
	(2, 'Смерічка', 'с. Микуличин, Яремчанський район, Івано-Франківська область');

INSERT INTO vacation_period (period_id, vacation_start, vacation_end) VALUES
	(1, '2021-06-01', '2021-06-15'),
	(2, '2021-06-17', '2021-07-01');

INSERT INTO vacation (child_id, camp_id, period_id ) VALUES
	(1,1,1),
	(2,1,1),
	(3,1,1),
	(4,2,1),
	(5,2,1),
	(6,2,1),
	(7,1,2),
	(8,1,2),
	(9,2,2),
	(10,2,2);
