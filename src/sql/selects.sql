--Get unique age
SELECT DISTINCT age FROM children ORDER BY 1;

--Get number of children for camps and periods
SELECT hc.camp_name, vp.vacation_start, vp.vacation_end, COUNT(v.vacation_id) AS number_of_children
FROM vacation AS v 
INNER JOIN vacation_period AS vp
ON v.period_id = vp.period_id
INNER JOIN holiday_camps AS hc
ON v.camp_id = hc.camp_id
GROUP BY 1,2,3
ORDER BY 4;

--Get children older than 14 years or in which the first letter of the name "B"
SELECT c.first_name, c.last_name, s.school_name, c.age, c.parents_phone
FROM children AS c
NATURAL JOIN schools AS S
WHERE (c.first_name LIKE 'В%' OR c.age > 14);

--Get minimum, maximum, and average children age
SELECT MIN(age) AS "Min Age", MAX(age) AS "Max Age", ROUND(AVG(age)) AS "Avg Age"
FROM children;

--JOINS
INSERT INTO schools (school_id,school_name) VALUES 
(4,'Польська гімназія м.Тернопіль');

SELECT c.first_name, c.last_name, s.school_name 
FROM children AS c
RIGHT JOIN schools AS s
ON c.school_id = s.school_id;

SELECT s.school_name, COUNT(*) as children
FROM schools AS s
LEFT JOIN children AS c
ON c.school_id = s.school_id
GROUP BY 1
HAVING count(*) > 2;

SELECT c.first_name, c.last_name, s.school_name, c.age, c.parents_phone
FROM children AS c
CROSS JOIN schools AS S
ORDER BY 1,2,4
LIMIT 5;

--UNIONS
SELECT first_name, last_name, age FROM children WHERE age < 11
UNION
SELECT first_name, last_name, age FROM children WHERE age > 14
ORDER BY age;

SELECT first_name, last_name, age FROM children
UNION ALL 
SELECT first_name, last_name, age FROM children
ORDER BY first_name, first_name;

--VIEW
CREATE OR REPLACE VIEW get_vacation AS
SELECT c.first_name,
       c.last_name,
       s.school_name,
       c.age,
       hc.camp_name,
       vp.vacation_start,
	   vp.vacation_end
FROM vacation AS v
INNER JOIN holiday_camps AS hc ON hc.camp_id = v.camp_id
INNER JOIN vacation_period AS vp ON v.period_id = vp.period_id
INNER JOIN children AS c ON v.child_id = c.child_id
INNER JOIN schools AS s ON c.school_id = s.school_id
ORDER BY 6,7,1,2;
 
SELECT * FROM get_vacation;
