CREATE database test;
DROP DATABASE test;

CREATE TABLE memberTBL (
	memberID CHAR(8) NOT NULL PRIMARY KEY, 
	memberName CHAR(5) NOT NULL,
	memberAddress CHAR(20) NULL
);
DROP TABLE membertbl;

CREATE TABLE producttbl(
	productName CHAR(4) PRIMARY KEY,
	cost INT NOT NULL,
	makeDate DATE,
	company CHAR(5),
	amount INT NOT null
);
DROP TABLE producttbl;

INSERT INTO membertbl
(memberId, membername, memberaddress)
VALUES
(1, '홍길동', '서울시');

INSERT INTO membertbl
(memberId, membername, memberaddress)
VALUES
(2, '홍길동', '서울시');

INSERT INTO membertbl
(memberId, membername)
VALUES
(3, '홍길동');

INSERT INTO membertbl
(memberId, membername)
VALUES
(4, '신사임당'),
(5, '유관순'),
(6, "나이팅게일");

SELECT memberid, membername, memberaddress
FROM membertbl;

SELECT * FROM membertbl;

SELECT membername FROM membertbl;

SELECT * FROM membertbl
WHERE memberaddress IS NULL;

SELECT * FROM membertbl
WHERE memberaddress != '서울시' or memberaddress IS null;

SELECT *
  FROM membertbl
 WHERE memberaddress = '부산시'
   AND membername = '유관순';

SELECT * FROM membertbl
WHERE membername LIKE '%동';

UPDATE membertbl SET membername = '게일' WHERE memberid = '6';

UPDATE membertbl
SET membername = 'Yoo'
, memberaddress = '강원도'
WHERE memberid = '5';

DELETE FROM membertbl WHERE memberaddress IS NULL;

SELECT * FROM employees
WHERE emp_no <= 10010;

SELECT * FROM departments
WHERE dept_no = 'd001' OR dept_no = 'd003' OR dept_no = 'd005';

SELECT * FROM departments
WHERE dept_no IN('d001', 'd003', 'd005');

SELECT * FROM employees
WHERE emp_no % 2 = 0;