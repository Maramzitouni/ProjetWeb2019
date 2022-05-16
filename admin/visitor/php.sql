CREATE TABLE visitor (
  id INT(255) AUTO_INCREMENT,
  id_user INT(255),
  browser_name VARCHAR(255),
  browser_version VARCHAR(255),
  type VARCHAR(255),
  os VARCHAR(255),
  url VARCHAR(255),
  ref VARCHAR(255) ,
  added_on timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (id)
) ;


