
CREATE TABLE Kayttaja(
	username varchar(25) UNIQUE NOT NULL,
	password varchar(50) NOT NULL,
	name varchar(50),
	email varchar(100),
	PRIMARY KEY(username)
);

CREATE TABLE Ajoneuvo(
	rekisterinumero varchar(10) UNIQUE NOT NULL,
	merkki varchar(20) NOT NULL,
	malli varchar(30) NOT NULL,
	kilometrit INTEGER NOT NULL,
	lisatiedot varchar(400),
	PRIMARY KEY(rekisterinumero)
);

CREATE TABLE Ajotapahtuma(
	id SERIAL PRIMARY KEY,
	pvm DATE NOT NULL,
	reitti varchar(100) NOT NULL,
	tarkoitus varchar(400) NOT NULL,
	lisatiedot varchar(400),
	fk_reknro varchar(10) REFERENCES Ajoneuvo(rekisterinumero)
);