-- Create the BookVerse database (only for localdevelopment)
CREATE DATABASE IF NOT EXISTS bookverse
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;

USE bookverse;
-- Comment out the above lines for deployment (Jacob 5)

DROP TABLE IF EXISTS books;
-- Users table
DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)   NOT NULL UNIQUE,
    email       VARCHAR(100)  NOT NULL UNIQUE,
    password    CHAR(60)      NOT NULL,
    phone       VARCHAR(20),
    location    VARCHAR(100),
    bio         TEXT,
    joined_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Books table with user relationship
CREATE TABLE IF NOT EXISTS books
(
    book_id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT           NULL,
    title            VARCHAR(255)  NOT NULL,
    author           VARCHAR(255)  NOT NULL,
    genre            VARCHAR(100)  NOT NULL,
    publication_year INT,
    isbn             VARCHAR(20),
    description      TEXT          NOT NULL,
    book_condition   ENUM('New','Gently Used','Fair') NOT NULL DEFAULT 'New',
    price            DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
    image_path       VARCHAR(255),
    status           ENUM('Available','Reserved','Sold') NOT NULL DEFAULT 'Available',
    created_at       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Sample Users (password is 'password123' for all - use password_hash in production)
INSERT INTO users
    (username, email, password, phone, location, bio)
VALUES
    ('john_reader', 'john@example.com', '$2y$10$4LbMPwxi7dSwW8h8soKhLugoLAVBUV32UN1lF6IfoWRX06NJYFOnK', '555-0001', 'New York, NY', 'Passionate book collector and seller'),
    ('sarah_books', 'sarah@example.com', '$2y$10$4LbMPwxi7dSwW8h8soKhLugoLAVBUV32UN1lF6IfoWRX06NJYFOnK', '555-0002', 'Los Angeles, CA', 'Love finding hidden literary gems'),
    ('mike_classics', 'mike@example.com', '$2y$10$4LbMPwxi7dSwW8h8soKhLugoLAVBUV32UN1lF6IfoWRX06NJYFOnK', '555-0003', 'Chicago, IL', 'Specializing in classic literature');

-- Sample Books from different users
INSERT INTO books
    (user_id, title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status)
VALUES
    (1, 'The Midnight Library', 'Matt Haig', 'Fiction', 2020, '9781020000000', 'A dazzling novel about all the choices that go into a life well lived. Nora Seed finds herself in the Midnight Library, a library that exists between life and death.', 'New', 24.99, '1.png', 'Available'),
    (1, 'Project Hail Mary', 'Andy Weir', 'Science Fiction', 2021, '9781020000001', 'Ryland Grace is the sole survivor on a crippled spaceship. His only hope for rescue is an impossible task no one has ever accomplished.', 'New', 28.99, '2.png', 'Available'),
    (2, 'Dune', 'Frank Herbert', 'Science Fiction', 1965, '9781020000002', 'In the far future, humanity has spread across the galaxy and lives under the control of the vast galactic empire and the various noble houses.', 'Gently Used', 22.99, '3.png', 'Available'),
    (2, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 1937, '9781020000003', 'Bilbo Baggins is a respectable hobbit. Now he is drawn into an unexpected adventure with a wizard and thirteen dwarves.', 'Fair', 18.99, '4.png', 'Available'),
    (3, '1984', 'George Orwell', 'Dystopian', 1949, '9781020000004', 'In the totalitarian state of Oceania, the Thought Police monitor the actions and thoughts of citizens. Winston Smith begins to rebel against oppression.', 'Gently Used', 16.99, '5.png', 'Available'),
    (3, 'Pride and Prejudice', 'Jane Austen', 'Romance', 1813, '9781020000005', 'Elizabeth Bennet is a spirited woman navigating society with wit and intelligence, challenging social norms in pursuit of true love.', 'New', 14.99, '6.png', 'Reserved'),
    (1, 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1960, '9781020000006', 'Scout Finch grows up in the Depression-era South and witnesses her father stand up for justice when accused of defending a Black man.', 'Gently Used', 19.99, '7.png', 'Available'),
    (2, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 1925, '9781020000007', 'Nick Carraway comes to Long Island in 1922 and becomes entangled in the mysterious world of his wealthy neighbor, Jay Gatsby.', 'Fair', 15.99, '8.png', 'Sold'),
    (3, 'Educated', 'Tara Westover', 'Memoir', 2018, '9781020000008', 'Born to survivalists in the mountains of Idaho, Tara keeps no records of her schooling, no medical records, and no birth certificate.', 'New', 20.99, '9.png', 'Available'),
    (1, 'The Seven Husbands of Evelyn Hugo', 'Taylor Jenkins Reid', 'Fiction', 2017, '9781020000009', 'Aging Hollywood icon Evelyn Hugo finally tells the truth about her glamorous and scandalous life, and her greatest love.', 'New', 18.99, '10.png', 'Reserved'),
    (2, 'Atomic Habits', 'James Clear', 'Self-Help', 2018, '9781020000010', 'Discover the power of tiny changes. An atomic habit is a regular practice that is a fundamental unit of the larger systems.', 'New', 26.99, '11.png', 'Available'),
    (3, 'Sapiens', 'Yuval Noah Harari', 'Non-Fiction', 2014, '9781020000011', 'How Homo sapiens came to dominate the world. From the Stone Age to Modern Times, an epic narrative of humankind.', 'Gently Used', 27.99, '12.png', 'Available');
