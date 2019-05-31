
###### Test 


DROP TABLE IF EXISTS `tabnm`;

CREATE TABLE `tabnm` (
  `id`              INTEGER PRIMARY KEY AUTOINCREMENT,
  `description`     VARCHAR(200),
  `isDeleted`       BOOLEAN
);

INSERT INTO tabnm VALUE (
  0,
  'aaaa',
  0
);

INSERT INTO tabnm VALUE (
  1,
  'bbbb',
  0
);


