-- +migrate Up
CREATE TABLE IF NOT EXISTS Users (
 id SERIAL PRIMARY KEY,
 username VARCHAR(255) NOT NULL UNIQUE,
 email VARCHAR(255) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 salt TEXT NOT NULL,
 user_type TEXT NOT NULL,
 created_at TIMESTAMP NOT NULL
);

-- +migrate Down
DROP TABLE IF EXISTS Users;