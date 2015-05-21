CREATE TABLE MEMBRE (
	ID_USER INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	EMAIL VARCHAR(50) UNIQUE,
	SEXE VARCHAR(10),
	NOM VARCHAR(50),
	PRENOM VARCHAR(50),
	MDP VARCHAR(50),
	DROIT INT(1) unsigned, /* 1 pour administrateur, 2 pour restaurateur */
	ACTIF INT(1) unsigned  /* 1 pour actif, 0 inactif*/
);

CREATE TABLE RESTAURANT (
	ID_RESTO INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ID_USER INT(10) unsigned NOT NULL,
	NOM_RESTO VARCHAR(100),
	ADRESSE VARCHAR(100),
	TELEPHONE VARCHAR(20),
	DESCRIPTIF VARCHAR(1000),
	IMAGE VARCHAR(200), /*répertoire images*/
	DATE_DERNIERE_MODIF DATETIME,
	ACTIF INT(1) unsigned, /* 1 pour actif, 0 inactif*/
	FOREIGN KEY (ID_USER) REFERENCES MEMBRE(ID_USER) ON DELETE RESTRICT
);

/*Définition du calendrier hebdomadaire du restaurant*/
CREATE TABLE CALENDRIER_HEBDO (
	ID_REGLE_HEBDO INT(10) unsigned NOT NULL AUTO_INCREMENT,
	ID_RESTO INT(10) unsigned NOT NULL,
	JOUR enum('1','2','3','4','5','6','7') NOT NULL,/*  1 pour lundi, 2 pour mardi...7 pour dimanche*/
	HORAIRE TIME,
	NB_TABLES INT(3),
	ACTIF INT(1) unsigned,
	KEY(ID_REGLE_HEBDO),
	PRIMARY KEY (ID_RESTO, JOUR, HORAIRE),
	FOREIGN KEY (ID_RESTO) REFERENCES RESTAURANT(ID_RESTO) ON DELETE RESTRICT
);

/*Définition des dates exceptionnelles du restaurant*/
CREATE TABLE CALENDRIER_EXCEPTION (
	ID_REGLE_EXCEP INT(10) unsigned NOT NULL AUTO_INCREMENT,
	ID_RESTO INT(10) unsigned NOT NULL,
	DATE_EXCEPTION DATE,
	HORAIRE TIME,
	NB_TABLES INT,
	ACTIF INT(1) unsigned,
	KEY(ID_REGLE_EXCEP),
    PRIMARY KEY (ID_RESTO, DATE_EXCEPTION, HORAIRE),
	FOREIGN KEY (ID_RESTO) REFERENCES RESTAURANT(ID_RESTO) ON DELETE RESTRICT
);

CREATE TABLE OFFRE (
	ID_OFFRE INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY, /*Doit être cohérente avec celle de la BDD de la plateforme*/
	ID_RESTO INT(10) unsigned NOT NULL,
	DESCRIPTIF VARCHAR(1000),
	ACTIF INT(1) unsigned,
	FOREIGN KEY (ID_RESTO) REFERENCES RESTAURANT(ID_RESTO) ON DELETE RESTRICT
);

CREATE TABLE CONNEXION_CLIENT (
	ID_OFFRE INT(10) unsigned NOT NULL,
	IP VARCHAR(15),
	URL VARCHAR(100),
	VISITE DATETIME,
	PRIMARY KEY (ID_OFFRE, IP, URL, VISITE),
	FOREIGN KEY (ID_OFFRE) REFERENCES OFFRE(ID_OFFRE) ON DELETE RESTRICT
);

CREATE TABLE CONNEXION_ERRONEE (
	IP VARCHAR(15),
	URL VARCHAR(100),
	VISITE DATETIME,
	PRIMARY KEY (IP, URL, VISITE)
);

CREATE TABLE RESERVATION (
	ID_RESA INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ID_OFFRE INT(10)unsigned NOT NULL,
	EMAIL_CLIENT VARCHAR(50),
	NOM VARCHAR(50),
	PRENOM VARCHAR(50),
	DATE_RESA DATETIME,
	NB_TABLES INT(3),
	NB_PRS INT(3),
	DATE_CREER DATETIME,
	ACTIF INT(1) unsigned,
	FOREIGN KEY (ID_OFFRE) REFERENCES OFFRE(ID_OFFRE) ON DELETE RESTRICT
);

/*Enregistrement des annulations des réservations*/
CREATE TABLE ANNULATION_RESA (
	ID_RESA INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	MOTIF VARCHAR(500),
	DATE_ANNULATION DATETIME,
	FOREIGN KEY (ID_RESA) REFERENCES RESERVATION(ID_RESA) ON DELETE RESTRICT
);

/*Notifications modifications restaurants**/
CREATE TABLE NOTIFICATIONS_RESTO (
	ID_NOTIF_RESTO INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ID_RESTO INT(10) unsigned NOT NULL,
	DATE_MODIF DATETIME,
	FOREIGN KEY (ID_RESTO) REFERENCES RESTAURANT(ID_RESTO) ON DELETE RESTRICT
);




INSERT INTO `MEMBRE`(`ID_USER`,`EMAIL`,`PRENOM`,`NOM`,`SEXE`, `MDP`, `DROIT`, `ACTIF`) VALUES
 ('','david@yahoo.fr','David','Smith','Homme','8a511f205dcfb340abe41c37d4f08ad1', 1,1),/*MDP: simply */ 
 ('','lea@yahoo.fr','Lea','Comose','Femme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','melanie@yahoo.fr','Mélanie','Macret','Femme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','joseph@yahoo.fr','Joseph','Ninja','Homme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','helene@yahoo.fr','Helene','Fleur','Femme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','emma@yahoo.fr','Emma','Miret','Femme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','patrick@yahoo.fr','Patrick','Master','Homme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','pedro@yahoo.fr','Pedro','Maestro','Homme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','mylene@yahoo.fr','Mylène','Teratu','Femme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','edouard@yahoo.fr','Edouard','Berthe','Homme','8a511f205dcfb340abe41c37d4f08ad1', 2,1),/*MDP: simply */
 ('','etienne@yahoo.fr','Etienne','Piris','Homme','8a511f205dcfb340abe41c37d4f08ad1', 2,1);/*MDP: simply */

 
INSERT INTO `RESTAURANT`(`ID_RESTO`, `ID_USER`,`NOM_RESTO`, `ADRESSE`, `TELEPHONE`, `DESCRIPTIF`, `IMAGE`, `DATE_DERNIERE_MODIF`,`ACTIF`) VALUES
 ('',1,'Les petits parapluies','7 route de rome 44300 Nantes','02 51 92 37 22','Ambiance familiale. Des plats pour tous.','restaurant1.jpg', '2015-4-11 12:00:00',1),
 ('',2,'La bonne franquette','4 rue des monuments 44300 Nantes','02 51 92 37 22','Tapas à volonté.','restaurant2.jpg', '2015-4-11 12:00:00',1),
 ('',3,'Au temps des cerises','13 rue du Luxembourg 44300 Nantes','02 51 92 37 22','Cuisine typiquement française.','restaurant3.jpg', '2015-4-11 12:00:00',1),
 ('',4,'Créperie Bretonne','6 Allée Jean Baptiste Fourier 44300 Nantes','02 51 92 37 22','Crèpes sucrées et salées.','restaurant4.jpg', '2015-4-11 12:00:00',1),
 ('',5,'Le Goéland','10 avenue des peupliers Fourier 44300 Nantes','02 51 92 37 22','Cuisine rapide et simple.','restaurant5.jpg', '2015-4-11 12:00:00',1),
 ('',6,'Le bouquet Garni','1 route de paris 44300 Nantes','02 51 92 37 22','Tables rafinées, ambience soignée.','restaurant6.jpg', '2015-4-11 12:00:00',1),
 ('',7,'Cocotte','24 avenue du louvres 44300 Nantes','02 51 92 37 22','Restaurant chinois.','restaurant7.jpg', '2015-4-11 12:00:00',1),
 ('',8,'Anatolia','9 rue des béliers 44300 Nantes','02 51 92 37 22','Restaurant japonais.','restaurant8.jpg', '2015-4-11 12:00:00',1),
 ('',9,'L\'instinct Gourmand','35 boulevard de république 44300 Nantes','02 51 92 37 22','Buffet à volonté, bon rapport qualité/prix.','restaurant9.jpg', '2015-4-11 12:00:00',1),
 ('',10,'Pizzeria dell\'etna','157 route des coquelicots 44300 Nantes','02 51 92 37 22','Ambiance italienne. Pizza cuites au feu de bois.','restaurant10.jpg', '2015-4-11 12:00:00',1);

INSERT INTO `CALENDRIER_HEBDO`(`ID_REGLE_HEBDO`, `ID_RESTO`, `JOUR`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES
 ('',1,1,'11:00:00',2,1), 
 ('',1,1,'13:00:00',2,1), 
 ('',1,1,'15:00:00',3,1), 
 ('',1,2,'12:00:00',2,1),
 ('',1,2,'14:00:00',2,1),
 ('',1,2,'16:00:00',3,1),
 ('',1,3,'13:00:00',2,1),
 ('',1,3,'15:00:00',2,1),
 ('',1,4,'14:00:00',3,1),
 ('',1,4,'16:00:00',2,1),
 ('',1,4,'18:00:00',2,1),
 ('',1,5,'15:00:00',3,1),
 ('',1,5,'17:00:00',1,1),
 ('',1,6,'16:00:00',2,1),
 ('',1,6,'18:30:00',2,1);

INSERT INTO `CALENDRIER_EXCEPTION`(`ID_REGLE_EXCEP`, `ID_RESTO`, `DATE_EXCEPTION`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES
 ('',1,'2015-3-18','15:00:00',0,1), 
 ('',1,'2015-3-18','21:00:00',1,1),
 ('',1,'2015-3-22','15:00:00',1,1);

INSERT INTO `OFFRE`(`ID_OFFRE`, `ID_RESTO`, `DESCRIPTIF`, `ACTIF`) VALUES
 ('','1','-50% sur les menus -12ans.',1),
 ('','1','-10% sur le pat du jour',1),
 ('','2','1 bouteille de vin achetée, 1 bouteille offerte',1);

INSERT INTO `CONNEXION_CLIENT`(`ID_OFFRE`, `IP`, `URL`, `VISITE`) VALUES
 (1,'53.164.48.166','','2015-3-16 14:30:16'),
 (1,'53.164.48.166','','2015-3-17 12:05:55'),
 (2,'78.161.244.13','','2015-2-16 19:12:03');

INSERT INTO `CONNEXION_ERRONEE`(`IP`, `URL`, `VISITE`) VALUES
 ('88.188.188.93', '','2015-4-16 22:30:15'),
 ('88.188.188.93', '' ,'2015-4-16 22:30:13'),
 ('88.188.188.93', '' ,'2015-4-16 22:30:19'),
 ('88.188.188.93', '' ,'2015-4-16 22:30:22'),
 ('202.106.196.115', '' ,'2015-4-16 11:15:20'),
 ('202.106.196.115', '' ,'2015-4-16 11:15:25'),
 ('202.106.196.115', '' ,'2015-4-16 11:15:29'),
 ('202.106.196.115', '' ,'2015-4-16 11:15:44');

INSERT INTO `RESERVATION`(`ID_RESA`, `ID_OFFRE`, `EMAIL_CLIENT`, `NOM`, `PRENOM`, `DATE_RESA`, `NB_TABLES`, `NB_PRS` , `DATE_CREER`,`ACTIF`) VALUES
 ('',1,'john@yahoo.fr','John','Ford','2015-5-23 12:30:00', 1,2, '2015-6-11 12:00:00',1),
 ('',2,'julia@yahoo.fr','Julia','Dubois','2015-5-25 19:00:00', 1,4, '2015-4-4 19:00:00',1),
 ('',2,'paul@yahoo.fr','Paul','Dutronc','2015-6-01 19:30:00', 1,3,'2015-5-12 09:00:00',1),
 ('',3,'marine@yahoo.fr','Marine','Fosset','2015-5-03 13:00:00', 1,1,'2015-6-13 17:00:00',1);