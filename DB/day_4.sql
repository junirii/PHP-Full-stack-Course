DROP TABLE t_member_hobbit;

CREATE TABLE t_member_hobbit(
	user_num CHAR(8),
	hobbit_num INT(10) unsigned,
	PRIMARY KEY(user_num, hobbit_num),
	FOREIGN KEY(USER_num) REFERENCES membertbl(memberID),
	FOREIGN KEY(hobbit_num) REFERENCES t_hobby2(hobby_id)
);

INSERT INTO t_member_hobbit (user_num, hobbit_num) VALUES ('1', 1);
INSERT INTO t_member_hobbit (user_num, hobbit_num) VALUES ('1', 2);
INSERT INTO t_member_hobbit (user_num, hobbit_num) VALUES ('5', 3), ('5', 6), ('5', 7);
INSERT INTO t_member_hobbit (user_num, hobbit_num) VALUES ('6', 4);

SELECT B.*, A.*, C.* FROM t_member_hobbit A
INNER JOIN membertbl B
ON A.user_num = B.memberID
INNER JOIN t_hobby2 C
ON A.hobbit_num = C.hobby_id;

SELECT A.emp_no, A.first_name, A.last_name, D.dept_name, B.title FROM employees A
INNER JOIN titles B
ON A.emp_no = B.emp_no
INNER JOIN dept_emp C
ON A.emp_no = C.emp_no
INNER JOIN departments D
ON C.dept_no = D.dept_no;

SELECT A.gender, AVG(B.salary) FROM employees A
INNER JOIN salaries B
ON A.emp_no = B.emp_no
GROUP BY A.gender;

SELECT X.dept_no, MAX(X.avg_salary)
FROM (
	SELECT A.emp_no, A.dept_no, avg(salary) AS avg_salary FROM dept_emp A	
	INNER JOIN salaries B
	ON A.emp_no = B.emp_no
	GROUP BY A.emp_no
	) X
GROUP BY X.dept_no;

SELECT B.dept_no, C.dept_name, AVG(A.salary), MAX(A.salary), MIN(A.salary) FROM salaries A
INNER JOIN dept_emp B
ON A.emp_no = B.emp_no
INNER JOIN departments C
ON B.dept_no = C.dept_no
GROUP BY B.dept_no;

SELECT A.title, avg(B.salary) FROM titles A
INNER JOIN salaries B
ON A.emp_no = B.emp_no
GROUP BY A.title;