-- 형변환 convert
SELECT '10';
SELECT CONVERT('10', INT);

SELECT '10' + '10';
SELECT CONVERT('10', INT) + CONVERT('10', INT);

SELECT CONVERT('10.1', FLOAT);

SELECT 10;
SELECT CONVERT(10, CHAR);

-- 형변환 cast
SELECT CAST('10' AS INT);

-- concat
SELECT 'A1' + '2B2';
SELECT CONCAT('A1', '2B2', '가나다');

-- if
SELECT if(100>200, '100은 200보다 크다', '100은 200보다 작다');

SELECT if(employees.gender = 'M', '남자', '여자') FROM employees;

-- 응용
SELECT if(employees.gender = 'M', '남자', if(employees.gender = 'F', '여자', '외계인')) FROM employees;

-- 응용 2
SELECT nm, if(t_hobby.nm = '농구', 'basketball', if(t_hobby.nm = '배구', 'valleyball', 'football')) AS 'eng'
FROM t_hobby;

-- ifnull
SELECT *, IFNULL(memberaddress, '주소없음') FROM membertbl;

-- nullif
SELECT NULLIF('안녕1', '안녕2');

-- case 값 when 비교값 then ...
SELECT
	nm,
	case nm when '농구' then 'basketball'
			  when '배구' then 'volleyball'
			  when '축구' then 'football'
			  ELSE '없음'
	end
FROM t_hobby;

-- case when 조건식 then ...
SELECT
	nm,
	case when nm = '농구' then 'basketball'
		  when nm = '배구' then 'volleyball'
		  when nm = '축구' then 'football'
		  ELSE '없음'
	END
FROM t_hobby;

-- 아스키코드
SELECT ASCII('A'), CHAR(65);

-- 문자열 합치기 concat, concat_ws
SELECT CONCAT('A', '_', 'B', '_', 'C');
SELECT CONCAT_WS('_', 'A', 'B', 'C');

-- format 천단위 콤마, 실수 몇자리까지 나타낼지 선택
SELECT FORMAT(11112222.623456, 0);
SELECT ROUND(11112222.623456, 3);


-- insert
SELECT INSERT('abcdefghi', 3, 4, '@@@@')
	  , INSERT('abcdefghi', 3, 0, '@@@@');
	  
-- upper, lower
SELECT 'aBc', 'AbC', 'aBc' = 'AbC', UPPER('aBc'), UPPER('AbC'), UPPER('aBc') = UPPER('AbC');

-- trim
SELECT '     a bc     ', TRIM('     a bc     '), LTRIM('     a bc     ');
SELECT TRIM(BOTH 'ㅋ' FROM 'ㅋㅋㅋ재밌어요.ㅋㅋㅋ');

-- dateformat
SELECT DATE_FORMAT(created_at, '%y/%m/%d %r / %H:%i:%s %p') FROM t_hobby2;