INSERT INTO Kayttaja (username, password, name, email) VALUES ('hcmalkki', 'spedesrules', 'henri malkki', 'hcmalkki@helsinki.fi');
INSERT INTO Ajoneuvo (rekisterinumero, merkki, malli, kilometrit, lisatiedot) VALUES ('EBI-739', 'BMW', '116i', '101588', 'tänne jotain lisätietoja');
INSERT INTO Ajotapahtuma (pvm, reitti, kilometrit, tarkoitus, lisatiedot, fk_reknro) VALUES ('24.05.2015', 'Helsinki-Lahti-Helsinki', '101900', 'Auton huolto', 'ei lisättävää', 'EBI-739');
