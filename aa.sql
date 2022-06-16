  CREATE database board1;

  use board1;

  create table t_board ( 
    i_board int unsigned primary key auto_increment, 
    title varchar(200) not null, 
    ctnt varchar(3000) not null, 
    create_at datetime default now()
  );
  
  SELECT * FROM t_board;
  
  SELECT i_board, title, create_at FROM t_board ORDER BY i_board DESC;
  
 
  ALTER TABLE t_board ADD mod_at DATETIME DEFAULT NOW();

  ALTER TABLE t_board ADD image longblob;
  
    create table t_board2 ( 
    i_board int unsigned primary key auto_increment, 
    title varchar(200) not null, 
    ctnt varchar(3000) not null, 
    create_at datetime default NOW(),
    mod_at DATETIME DEFAULT NOW()
  );
  
  ALTER TABLE t_board ADD views INT DEFAULT 0;
  ALTER TABLE t_board2 ADD views INT DEFAULT 0;
  ALTER TABLE t_board ADD img VARCHAR(1000);
  ALTER TABLE t_board2 ADD img VARCHAR(1000);
  
  SELECT DATE_FORMAT('2019-03-19 20:23:12', '%Y/%m/%d %H:%i');
  SELECT * FROM (SELECT i_board, title, create_at, views, img FROM t_board WHERE views >= 5 UNION SELECT i_board, title, create_at, views, img FROM t_board2 WHERE views >= 5) AS a ORDER BY create_at;
  
  ALTER TABLE t_board ADD board_num INT DEFAULT 1;
  ALTER TABLE t_board2 ADD board_num INT DEFAULT 2;
  
  DELETE FROM t_board;
  DELETE FROM t_board2;
  
  ALTER TABLE t_board ADD NAME VARCHAR(20) NOT null;
  ALTER TABLE t_board2 ADD NAME VARCHAR(20) NOT null;
  ALTER TABLE t_board ADD passwd VARCHAR(10) NOT NULL;
  ALTER TABLE t_board2 ADD passwd VARCHAR(10) NOT NULL;  
  
 create table reply ( 
 idx int unsigned primary key auto_increment, 
 id varchar(200) not null, 
 passwd VARCHAR(10) NOT NULL,
 ctnt varchar(3000) not null, 
 create_at datetime default now()
  );
  
  DELETE FROM reply;
  ALTER TABLE reply ADD i_board INT NOT null;
  ALTER TABLE reply ADD board_num INT NOT null;
  
  DROP TABLE t_board;
  DROP TABLE t_user;
  
  ALTER TABLE t_user MODIFY nm VARCHAR(30);
  
  CREATE TABLE t_user(
  i_user INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uid VARCHAR(20) UNIQUE NOT NULL, 
  upw varCHAR(30) NOT NULL, 
  nm VARCHAR(5) NOT NULL,
  gender INT UNSIGNED NOT null CHECK(gender IN (0, 1)),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT current_timestamp
);

SELECT * FROM t_user;

CREATE TABLE t_board(
	i_board INT UNSIGNED AUTO_INCREMENT,
	PRIMARY KEY(i_board),
	title VARCHAR(100) NOT NULL,
	ctnt VARCHAR(2000) NOT NULL,
	i_user INT UNSIGNED NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(i_user) REFERENCES t_user(i_user)
);

SELECT i_board, title, nm, A.created_at FROM t_board A INNER JOIN t_user B ON A.i_user = B.i_user;

SELECT * FROM
    (SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board WHERE views >= 5 UNION
    SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board2 WHERE views >= 5) AS a
    WHERE title LIKE '%a%' ORDER BY VIEWs desc;
    
    DELETE FROM t_board;
    
    SELECT ceil(COUNT(i_board)/20) FROM t_board;
    
    DELETE FROM t_board WHERE i_board = 109;
    
    SELECT * FROM t_board WHERE i_board = (SELECT MIN(i_board) FROM t_board WHERE i_board > 110);
    SELECT * FROM t_board WHERE i_board = (SELECT MAX(i_board) FROM t_board WHERE i_board < 110);    
    SELECT * FROM t_board WHERE i_board > 110 ORDER BY i_board LIMIT 1;
    SELECT * FROM t_board WHERE i_board < 110 ORDER BY i_board DESC LIMIT 1;
    
      ALTER TABLE t_board ADD views INT DEFAULT 0;
      SELECT COUNT(i_board) AS total FROM t_board;
      
      SELECT COUNT(idx) AS reply FROM reply WHERE i_board = 74;
      
      SELECT A.i_board, A.title, A.create_at, A.views, A.board_num, A.writer, A.img, B.board_num
      FROM t_board A
      INNER JOIN reply B
      ON A.i_board = B.i_board;
      
      SELECT COUNT(idx) AS reply FROM reply WHERE i_board = 74;
      
      SELECT * FROM count_db;
      DELETE FROM count_db;
      INSERT INTO count_db VALUES (10, '2022-05-03');
      
      SELECT * FROM t_board WHERE title LIKE "%닌텐도%" OR title LIKE "%동숲%";

      SELECT A.title, B.nm, A.created_at, A.ctnt, A.i_user
      FROM t_board A
      INNER JOIN t_user B
      ON A.i_user = B.i_user
      WHERE A.title LIKE "%닌텐%" OR A.ctnt LIKE "%닌텐%";
      
      SELECT A.i_board, A.title, B.nm, A.created_at, A.views, A.i_user, A.ctnt
      FROM t_board A
      INNER JOIN t_user B
      ON A.i_user = B.i_user
      WHERE A.title LIKE "%닌텐%" OR A.ctnt LIKE "%닌텐%";
      
      SELECT A.i_board, A.title, B.nm, A.created_at, A.views
        FROM t_board A
        INNER JOIN t_user B
        ON A.i_user = B.i_user;
        
        ALTER TABLE t_user ADD profile_img VARCHAR(100) DEFAULT NULL;
        
        SELECT A.i_board, A.title, B.nm, A.created_at, A.views, B.profile_img
      FROM t_board A
      INNER JOIN t_user B
      ON A.i_user = B.i_user
      ORDER BY A.i_board DESC;
      
      INSERT INTO class_timetable
      (class_no, start_time, end_time)
		VALUES
      (1, 09:00:00, 09:05:00),
      (1, 10:00:00, 10:05:00),
      (1, 11:00:00, 11:05:00),
      (1, 12:00:00, 12:05:00),
      (1, 13:00:00, 13:05:00),
      (1, 14:00:00, 14:05:00),
      (1, 15:00:00, 15:05:00),
      (1, 16:00:00, 16:05:00);
      
      SELECT ceil(COUNT(i_board)/10) AS total_page FROM t_board;
      
      SELECT count(i_board)
      FROM t_board 
      WHERE title LIKE '%교수%';