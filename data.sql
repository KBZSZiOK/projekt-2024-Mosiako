-- Insert Data into film_type Table
INSERT INTO film_type (Id, Name) VALUES
(1, 'Akcja'),
(2, 'Dramat'),
(3, 'Komedia'),
(4, 'Horror');

-- Insert Data into films Table
INSERT INTO films (Id, Title, Director, Length) VALUES
(1, 'Die Hard', 'John McTiernan', 132),
(2, 'The Godfather', 'Francis Ford Coppola', 175),
(3, 'Superbad', 'Greg Mottola', 113),
(4, 'The Conjuring', 'James Wan', 112);

-- Insert Data into type_film Table
INSERT INTO type_film (Id, Film_Id, Type_Id) VALUES
(1, 1, 1), -- Die Hard is Action
(2, 2, 2), -- The Godfather is Drama
(3, 3, 3), -- Superbad is Comedy
(4, 4, 4); -- The Conjuring is Horror

-- Insert Data into rooms Table
INSERT INTO rooms (Id, Seat_count) VALUES
(1, 100),
(2, 150),
(3, 120),
(4, 80);

-- Insert Data into sessions Table
INSERT INTO sessions (Id, Term, Room_Id, Film_Id, Empty_seat_count) VALUES
(1, '2024-10-25 18:00:00', 1, 1, 50), -- Die Hard in Room 1
(2, '2024-10-25 20:30:00', 2, 2, 70), -- The Godfather in Room 2
(3, '2024-10-26 19:00:00', 3, 3, 60), -- Superbad in Room 3
(4, '2024-10-26 21:00:00', 4, 4, 40); -- The Conjuring in Room 4

-- Insert Data into clients Table (Polish Names)
INSERT INTO clients (Id, Name, Surname, Email) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@example.com'),
(2, 'Anna', 'Nowak', 'anna.nowak@example.com'),
(3, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com'),
(4, 'Maria', 'Wójcik', 'maria.wojcik@example.com');

-- Insert Data into sellers Table (Polish Names)
INSERT INTO sellers (Id, Name, Surname) VALUES
(1, 'Katarzyna', 'Zielińska'),
(2, 'Michał', 'Lewandowski'),
(3, 'Magdalena', 'Szymańska'),
(4, 'Tomasz', 'Kowalczyk');

-- Insert Data into tickets Table
INSERT INTO tickets (Id, Session_Id, Seller_Id, Client_Id, Price) VALUES
(1, 1, 1, 1, 10), -- Jan buys a ticket for Die Hard
(2, 2, 2, 2, 15), -- Anna buys a ticket for The Godfather
(3, 3, 3, 3, 12), -- Piotr buys a ticket for Superbad
(4, 4, 4, 4, 8);  -- Maria buys a ticket for The Conjuring
