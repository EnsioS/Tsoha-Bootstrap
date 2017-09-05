-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Lisätään tuoteluokat 
INSERT INTO Tuoteluokka (nimi) VALUES ('Asunnot');
INSERT INTO Tuoteluokka (nimi) VALUES ('Pokemonit');
INSERT INTO Tuoteluokka (nimi) VALUES ('POISTETTAVA');
INSERT INTO Tuoteluokka (nimi) VALUES ('Lemmikit');
INSERT INTO Tuoteluokka (nimi) VALUES ('Taide');


-- Lisätään tuotteita
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan) 
VALUES ('Kesämökki', 'Hyvien kulkuyhteyksien varrella.','2014-10-19 10:23:54+02', '2018-10-30 10:23:54+02', 30, 'https://upload.wikimedia.org/wikipedia/commons/e/e4/White_House_02.jpg');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Moderni asunto 1', 'Nimi kertoo kaiken.', '2017-07-01 00:00:00', '2017-09-01 00:00:00', '100', 'https://upload.wikimedia.org/wikipedia/commons/a/af/All_Gizah_Pyramids.jpg');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Moderni asunto 2', 'Nimi kertoo kaiken.', '2004-10-19 10:23:54+02', '2004-10-30 10:23:54+02', '100', 'https://upload.wikimedia.org/wikipedia/commons/a/af/All_Gizah_Pyramids.jpg');
INSERT INTO Tuote (nimi, kuvaus, minimihinta, linkki_kuvaan)
VALUES ('Moderni asunto 3', 'Nimi kertoo kaiken.', '100', 'https://upload.wikimedia.org/wikipedia/commons/a/af/All_Gizah_Pyramids.jpg');
INSERT INTO Tuote (nimi, kuvaus, minimihinta, linkki_kuvaan)
VALUES ('Pokemon center', '"Haluutko parantaa sun pokemonit?"', '10000', 'https://c1.staticflickr.com/5/4070/4549247371_3aecce8246_z.jpg');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Machu Picchu', 'Osta, jos uskallat.', '2017-07-17 17:05:47', '2017-10-10 17:00:00', 100, 'http://orig07.deviantart.net/bd39/f/2010/074/e/7/pichu_animacion_by_dark_clefita.gif');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Mursu', 'Lämmin ja halattava lemmikki.', '2017-07-17 00:00:00', '2017-10-10 17:00:00', 65, 'https://c1.staticflickr.com/5/4006/4684089330_4b6b70c413_b.jpg');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Ihana kissa', 'Niin hellyttävä katse.', '2017-07-17 00:00:00', '2017-10-10 17:00:00', 150, 'https://mgl.skyrock.net/art/SHAR.1867.268.2.jpg');
INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu, minimihinta, linkki_kuvaan)
VALUES ('Kissanpentu', 'Niin hellyttävä katse.', '2017-11-17 00:00:00', '2017-12-10 17:00:00', 150, 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Green_eyes_kitten.jpg'); 

-- Lisätään tuotteet luokkiin
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (1, 1);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (2, 1);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (3, 1);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (4, 1);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (5, 1);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (5, 2);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (6, 2);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (7, 4);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (8, 4);
INSERT INTO Luokan_tuote (tuote, tuoteluokka) VALUES (9, 4);

-- Lisätään henkilötiedot
INSERT INTO Henkilotiedot (nimi, sahkoposti, osoite)
VALUES ('Ensio', 'ensio.suonpera@helsinki.fi', 'Höpötie 31');
INSERT INTO Henkilotiedot (nimi, sahkoposti, osoite)
VALUES ('TESTAAJA', 'testi@testiposti.fi', 'Mannerhemintie 5, Helsiki');
INSERT INTO Henkilotiedot (nimi, sahkoposti, osoite)
VALUES ('TESTAAJATAR', 'testitys@testiposti.fi', 'Mannerhemintie 5b, Helsiki');

-- Lisätään asiakastilit
INSERT INTO Asiakastili (henkilotiedot, kayttajatunnus, salasana)
-- VALUES (1, 'ensu', 'Salasana1');
VALUES (1, 'ensu', '$2y$10$stnuVODbAt5bt0qIURIFb.Z9zZL.YgkfIK8QiKQ1xNKe310SzqlJm');
INSERT INTO Asiakastili (henkilotiedot, kayttajatunnus, salasana)
-- VALUES (3, 'NAINEN', 'Salasana3');
VALUES (3, 'NAINEN', '$2y$10$vvXq7gi.fmA3V.kMsOVWAuL2wG0z29ScePgfdb4uPXcm8v8BhxC82');
INSERT INTO Asiakastili (henkilotiedot, kayttajatunnus, salasana, Meklari)
-- VALUES (2, 'MIES', 'Salasana2', TRUE);
VALUES (2, 'MIES', '$2y$10$68YrlgIncw0plXBfwrxViukx0/OaUiPlCR5V7cawi6Yow2VayUX8G', TRUE);

-- Lisätään Tarjouksia
INSERT INTO Tarjous (tuote, henkilotiedot, summa) VALUES (2, 3, 112);
INSERT INTO Tarjous (tuote, henkilotiedot, summa) VALUES (2, 1, 144);
INSERT INTO Tarjous (tuote, henkilotiedot, summa) VALUES (3, 3, 1000);
