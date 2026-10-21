CREATE TABLE users ( /*user au singulier est un mot réservé*/
    username VARCHAR(25) PRIMARY KEY,
    picture VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    userpassword VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE NOT NULL, /*ouvrir l'accès à la page d'ajout de mots à l'admin*/
    point INT DEFAULT 0 NOT NULL
);

CREATE TABLE password_resets (
    token_hash VARCHAR(64) PRIMARY KEY,
    email      VARCHAR(255) NOT NULL REFERENCES users(email) ON DELETE CASCADE,
    expires_at TIMESTAMP NOT NULL
);

CREATE TABLE words (
    id SERIAL PRIMARY KEY, /*SERIAL = numéro automatique à chaque nouveau mot ajouté*/
    word VARCHAR(25) UNIQUE NOT NULL,
    length INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    daily_date DATE UNIQUE
);

CREATE TABLE rooms (
    id SERIAL PRIMARY KEY,
    code VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(25) NOT NULL REFERENCES users(username) ON DELETE CASCADE, /*créateur de la room*/
    word_id INT NOT NULL REFERENCES words(id) ON DELETE CASCADE
);

CREATE TABLE games (
    id SERIAL PRIMARY KEY,
    username VARCHAR(25) NOT NULL REFERENCES users(username) ON DELETE CASCADE, /*Si le joueur supprime son compte son historique s'efface*/
    word_id INT NOT NULL REFERENCES words(id) ON DELETE CASCADE, /*Relie la partie au mot qui devait être deviné*/
    room_id INT REFERENCES rooms(id) ON DELETE CASCADE, /*NULL si partie Daily solo, ou numéro du salon si multijoueur*/
    attempts INT NOT NULL,
    time_seconds INT,
    is_won BOOLEAN NOT NULL,
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE friends (
    user_1 VARCHAR(25) NOT NULL REFERENCES users(username) ON DELETE CASCADE, /*celui qui envoie la demande*/
    user_2 VARCHAR(25) NOT NULL REFERENCES users(username) ON DELETE CASCADE, /*celui qui reçoit la demande*/
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_1, user_2),
    CHECK (user_1 != user_2)
);

CREATE TABLE guesses (
    id SERIAL PRIMARY KEY,
    attempt_number INT NOT NULL,
    guess_word VARCHAR(25) NOT NULL,
    game_id INT NOT NULL REFERENCES games(id) ON DELETE CASCADE
);

CREATE TABLE is_in (
    username VARCHAR(25) NOT NULL REFERENCES users(username) ON DELETE CASCADE,
    room_id INT NOT NULL REFERENCES rooms(id) ON DELETE CASCADE,
    PRIMARY KEY (username, room_id)
);

INSERT INTO words (word, length, category, daily_date) VALUES
('LINUX', 5, 'Système', CURRENT_DATE),
('PIXEL', 5, 'Graphisme', CURRENT_DATE + INTERVAL '1 day'),
('CLOUD', 5, 'Réseau', CURRENT_DATE + INTERVAL '2 days'),
('DEBUG', 5, 'Dév', CURRENT_DATE + INTERVAL '3 days'),
('BYTES', 5, 'Mémoire', CURRENT_DATE + INTERVAL '4 days'),
('MODEM', 5, 'Réseau', CURRENT_DATE + INTERVAL '5 days'),
('STACK', 5, 'Dév', CURRENT_DATE + INTERVAL '6 days'),
('QUERY', 5, 'Base de données', CURRENT_DATE + INTERVAL '7 days'),
('PROXY', 5, 'Réseau', CURRENT_DATE + INTERVAL '8 days'),
('LOGIC', 5, 'Dév', CURRENT_DATE + INTERVAL '9 days');