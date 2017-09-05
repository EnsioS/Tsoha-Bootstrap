CREATE TABLE Tuoteluokka(
    tuoteluokka_id SERIAL PRIMARY KEY,
    nimi varchar(50) UNIQUE
);

CREATE TABLE Tuote(
    tuote_id SERIAL PRIMARY KEY,
    nimi varchar(100) NOT NULL,
    kuvaus varchar(1500) NOT NULL,   
    kauppa_alkaa timestamp,
    kauppa_loppuu timestamp,
    minimihinta INTEGER NOT NULL,
    linkki_kuvaan varchar(200)
);

CREATE TABLE Luokan_tuote(
    tuote INTEGER NOT NULL REFERENCES Tuote(tuote_id) ON DELETE CASCADE,
    tuoteluokka INTEGER REFERENCES Tuoteluokka(tuoteluokka_id)        
    NOT NULL,
    PRIMARY KEY (tuote, tuoteluokka)
);

CREATE TABLE Henkilotiedot(
    henkilo_id SERIAL PRIMARY KEY,
    nimi varchar(100) NOT NULL,
    sahkoposti varchar(50) NOT NULL,
    osoite varchar(150) NOT NULL
);

CREATE TABLE Tarjous(
    tarjous_id SERIAL PRIMARY KEY,
    tuote INTEGER NOT NULL REFERENCES Tuote(tuote_id) ON DELETE CASCADE,
    henkilotiedot INTEGER REFERENCES Henkilotiedot(henkilo_id) NOT NULL,
    summa INTEGER NOT NULL
);

CREATE TABLE Asiakastili(
    asiakastili_id SERIAL PRIMARY KEY,
    henkilotiedot INTEGER REFERENCES Henkilotiedot(henkilo_id) NOT NULL,
    kayttajatunnus varchar(20) NOT NULL,
    salasana varchar(300) NOT NULL,
    meklari boolean DEFAULT FALSE
);
