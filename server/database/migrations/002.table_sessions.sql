-- +migrate Up
CREATE TABLE IF NOT EXISTS Sessions (
 token VARCHAR(255) NOT NULL PRIMARY KEY,
 expiry_date TIMESTAMP NOT NULL,
 user_id INTEGER NOT NULL,
 FOREIGN KEY(user_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- +migrate Down
DROP TABLE IF EXISTS Sessions;