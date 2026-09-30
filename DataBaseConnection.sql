CREATE Table user (
    username VARCHAR(25) PRIMARY KEY,
    picture VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    userpassword VARCHAR(255)
)
