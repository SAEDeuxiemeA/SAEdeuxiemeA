CREATE Table users ( /*user au singulier est un mot réservé*/
    username VARCHAR(25) PRIMARY KEY,
    picture VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    userpassword VARCHAR(255) NOT NULL
);
CREATE Table password_resets (
    token_hash VARCHAR(64) PRIMARY KEY,
    email      VARCHAR(255) NOT NULL REFERENCES users(email) ON DELETE CASCADE,
    expires_at TIMESTAMP NOT NULL
);