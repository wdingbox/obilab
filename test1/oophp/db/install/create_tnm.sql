
###### Test 


DROP TABLE IF EXISTS `tabnm`;

CREATE TABLE `tabnm` (
  `id`         INT  NOT NULL AUTO_INCREMENT,
  `desc`       VARCHAR(200),
  `isOK`       BOOLEAN,
  PRIMARY KEY(id)
);

INSERT INTO tabnm (`desc`, `isOk`) VALUE 
( 'aaaa  b'  ,0), 
( 'aaaa',0), 
( 'aaaa',0), 
( 'aaaa',0), 
( 'aaaa',0), 
( 'aaaa',0), 
( 'aaaa',0);

INSERT INTO tabnm (`desc`, `isOk`) VALUE (
  'aaaa',0
);
INSERT INTO tabnm (`desc`, `isOk`) VALUE (
  'aaaa',0
);
INSERT INTO tabnm (`desc`, `isOk`) VALUE (
  'aaaa',0
);

