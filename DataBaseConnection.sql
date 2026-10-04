CREATE Table users ( /*user au singulier est un mot réservé*/
    username VARCHAR(25) PRIMARY KEY,
    picture VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    userpassword VARCHAR(255) NOT NULL
)
