CREATE DATABASE kino
CREATE TABLE film_type (Id SERIAL PRIMARY KEY, Name VARCHAR(30));
CREATE TABLE type_film (Id SERIAL PRIMARY KEY, Film_Id BIGINT UNSIGNED NOT NULL, Type_Id BIGINT UNSIGNED NOT NULL);
CREATE TABLE films(Id SERIAL PRIMARY KEY,Title VARCHAR(30) NOT NULL,Director VARCHAR(30) NOT NULL,Length BIGINT UNSIGNED NOT NULL);
CREATE TABLE sessions(Id SERIAL PRIMARY KEY,Term DATETIME,Room_Id BIGINT UNSIGNED NOT NULL,Film_Id BIGINT UNSIGNED NOT NULL,Empty_seat_count INT NOT NULL);
CREATE TABLE rooms(Id SERIAL PRIMARY KEY,Seat_count INT NOT NULL);
CREATE TABLE clients(Id SERIAL PRIMARY KEY,Name VARCHAR(30) NOT NULL,Surname VARCHAR(30) NOT NULL,Email VARCHAR(40) NOT NULL);
CREATE TABLE tickets(Id SERIAL PRIMARY KEY,Session_Id BIGINT UNSIGNED NOT NULL,Seller_Id BIGINT UNSIGNED NOT NULL,Client_Id BIGINT UNSIGNED NOT NULL,Price INT NOT NULL);
CREATE TABLE sellers(Id SERIAL PRIMARY KEY,Name VARCHAR(30) NOT NULL,Surname VARCHAR(30) NOT NULL);

ALTER TABLE type_film ADD CONSTRAINT fk_type_film_filmid FOREIGN KEY (Film_Id) REFERENCES films(Id);
ALTER TABLE type_film ADD CONSTRAINT fk_type_film_typeid FOREIGN KEY (Type_Id) REFERENCES film_type(Id);

ALTER TABLE sessions ADD CONSTRAINT fk_session_filmid FOREIGN KEY (Film_Id) REFERENCES films(Id);
ALTER TABLE sessions ADD CONSTRAINT fk_session_roomid FOREIGN KEY (Room_Id) REFERENCES rooms(Id);

ALTER TABLE tickets ADD CONSTRAINT fk_tickets_sessionid FOREIGN KEY (Session_Id) REFERENCES sessions(Id);
ALTER TABLE tickets ADD CONSTRAINT fk_tickets_clientid FOREIGN KEY (Client_Id) REFERENCES clients(Id);
ALTER TABLE tickets ADD CONSTRAINT fk_tickets_sellerid FOREIGN KEY (Seller_Id) REFERENCES sellers(Id);

CREATE USER  admin@localhost IDENTIFIED BY zaq1@WSX;
GRANT ALL  PRIVILEGES on kino.* to admin@localhost;
