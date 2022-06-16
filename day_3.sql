SELECT DISTINCT dept_no FROM dept_emp;

SELECT DISTINCT title FROM titles;

SELECT * FROM employees
LIMIT 0, 5;

SELECT * FROM salaries
ORDER BY salary DESC
LIMIT 4, 6;

CREATE TABLE departments_temp
(SELECT * FROM departments);

SELECT * FROM departments_temp INTO departments_temp2;


-- group by
SELECT MIN(salary), MAX(salary), SUM(salary), AVG(salary), COUNT(emp_no), SUM(salary) / COUNT(*)
FROM salaries;

SELECT emp_no, min(salary), MAX(salary), SUM(salary), AVG(salary), COUNT(*)
FROM salaries
GROUP BY emp_no;

SELECT dept_no, COUNT(*)
FROM dept_emp
GROUP BY dept_no
HAVING COUNT(*) > 20000
ORDER BY COUNT(*) DESC;

SELECT * from employees
WHERE emp_no =
(SELECT emp_no
FROM salaries
ORDER BY salary
LIMIT 1);

-- auto_increment
USE test;
CREATE TABLE t_hobby(
i_hobby INT UNSIGNED AUTO_INCREMENT,
nm VARCHAR(10) UNIQUE NOT NULL,
PRIMARY KEY(i_hobby)
);

INSERT INTO t_hobby (nm)
VALUES ('농구');

INSERT INTO t_hobby (nm)
VALUES ('축구');

INSERT INTO t_hobby (nm)
VALUES ('배구');

SELECT * FROM t_hobby ORDER BY i_hobby;

CREATE TABLE t_hobby2(
hobby_id INT UNSIGNED PRIMARY KEY,
NAME VARCHAR(20) NOT NULL,
created_at DATETIME DEFAULT NOW()
);

INSERT INTO t_hobby2
(hobby_id, NAME)
VALUES
(1, '핸드볼');

INSERT INTO t_hobby2
(hobby_id, NAME, created_at)
VALUES
(2, '핸드볼', '2022-02-10');

INSERT INTO t_hobby2
(hobby_id, NAME, created_at)
VALUES
(3, '독서', '2022-02-10 12:12:13');

SELECT * FROM t_hobby;
SELECT * FROM t_hobby2;

INSERT INTO t_hobby2
(hobby_id, NAME)
SELECT i_hobby + 3, nm FROM t_hobby;

UPDATE salaries
SET salary = salary + 1000
WHERE emp_no = 10001;

SELECT * FROM salaries WHERE emp_no = 10001;

-- insert ignore
SELECT * FROM t_hobby2;

INSERT IGNORE INTO t_hobby2 (hobby_id, NAME) VALUES (6, '탁구');
INSERT INTO t_hobby2 (hobby_id, NAME) VALUES (7, '스키');

INSERT INTO t_hobby2 (hobby_id, NAME) VALUES (7, '탁구')
ON DUPLICATE KEY UPDATE NAME = '수영';

DROP TABLE t_board;
CREATE table t_board(
	i_board INT UNSIGNED PRIMARY KEY,
	title VARCHAR(10) UNIQUE NOT NULL,
	hits INT UNSIGNED DEFAULT 0
);

SELECT * FROM t_board;

INSERT INTO t_board (i_board, title, hits) VALUES (2, '안녕', 0)
ON DUPLICATE KEY UPDATE hits = hits + 1;

WITH dept_emp_d001(aaa, bbb, ccc)
AS (
SELECT emp_no, from_date, to_date FROM dept_emp
WHERE dept_no = 'd001'
)
SELECT * FROM dept_emp_d001;

SELECT Abb.* FROM
(
SELECT emp_no, from_date, to_date FROM dept_emp
WHERE dept_no = 'd001'
) Abb;

SELECT emp_no, AVG(salary) FROM salaries
GROUP BY emp_no;

CREATE TABLE T_ORDER(
	o_no INT PRIMARY KEY,
	cus_no INT,
	o_date DATE DEFAULT NOW(),
	o_price INT DEFAULT 0
);

CREATE TABLE T_CUSTOMER(
	cus_no INT PRIMARY KEY,
	nm VARCHAR(10) NOT NULL
);

INSERT INTO t_order
(o_no, cus_no, o_price)
VALUES
(1, 3, 55000), (2, 5, 70000), (3, 3, 60000);

INSERT INTO t_customer
(cus_no, nm)
VALUES
(3, '홍길동'), (5, '이순신');

UPDATE t_customer
SET nm = '장보고'
WHERE cus_no = 5;

DELETE FROM t_order
WHERE o_no = 2;

SELECT o_no, o_price
  FROM t_order
 WHERE cus_no = 3;