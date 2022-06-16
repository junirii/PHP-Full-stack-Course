USE `employees`;

SELECT * FROM departments;

INSERT INTO departments
(dept_no, dept_name)
VALUES
('d010', 'Business');

INSERT INTO employees
(emp_no, birth_date, first_name, last_name, gender, hire_date)
VALUES
(500000, '1999-10-10', 'Gildong', 'Hong', 'M', '2022-03-29');

SELECT * FROM employees WHERE emp_no = 500000;

SELECT * FROM employees WHERE gender = 'F' AND last_name LIKE '%ch%';

SELECT * FROM employees WHERE LEFT(birth_date, 4) = '1952';

SELECT * FROM employees WHERE birth_date LIKE "____-__-24";

SELECT * FROM employees WHERE LEFT(birth_date, 4) >= '1960';

UPDATE employees
SET gender = 'F'
, hire_date = '2021-03-29'
, first_name = 'Jindong'
WHERE emp_no = 500000;

DELETE FROM employees
WHERE LEFT(hire_date, 4) >= 2020;

SELECT * FROM employees;

SELECT emp_no AS my_no FROM employees;

SELECT * FROM employees WHERE birth_date = '1953-06-09';

SELECT * FROM employees WHERE birth_date = (SELECT birth_date FROM employees WHERE emp_no = 499613);

SELECT * from employees
where gender = (SELECT gender FROM employees WHERE emp_no = 499619)
AND emp_no != 499619;

SELECT * FROM salaries
WHERE emp_no IN (499988, 499987, 499986)
ORDER BY emp_no DESC, from_date;

SELECT * FROM employees
ORDER BY birth_date DESC, gender desc;