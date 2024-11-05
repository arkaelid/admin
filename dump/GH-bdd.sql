CREATE TABLE utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   pseudo_utilisateur VARCHAR(150) ,
   mail VARCHAR(180) ,
   password VARCHAR(250) ,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE editeur(
   id_editeur INT AUTO_INCREMENT,
   nom_societe VARCHAR(180) ,
   login_editeur VARCHAR(80) ,
   password_editeur VARCHAR(255) ,
   siret VARCHAR(50) ,
   mail_editeur VARCHAR(180) ,
   adresse_editeur VARCHAR(200) ,
   PRIMARY KEY(id_editeur)
);

CREATE TABLE admin(
   login VARCHAR(50) ,
   password VARCHAR(250) ,
   PRIMARY KEY(login)
);

CREATE TABLE categorie(
   id_categorie INT AUTO_INCREMENT,
   libelle_categorie VARCHAR(80) ,
   PRIMARY KEY(id_categorie)
);

CREATE TABLE genre(
   id_genre INT AUTO_INCREMENT,
   libelle_genre VARCHAR(80) ,
   PRIMARY KEY(id_genre)
);

CREATE TABLE notif(
   id_notif INT AUTO_INCREMENT,
   date_heure_notif DATETIME,
   objet VARCHAR(120) ,
   contenu TEXT,
   PRIMARY KEY(id_notif)
);

CREATE TABLE commande(
   id_transaction INT AUTO_INCREMENT,
   date_heure_transaction DATETIME,
   total_transaction VARCHAR(50) ,
   etat_transaction VARCHAR(50) ,
   id_editeur INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_transaction),
   FOREIGN KEY(id_editeur) REFERENCES editeur(id_editeur),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE type(
   id_type INT AUTO_INCREMENT,
   libelle_type VARCHAR(80) ,
   PRIMARY KEY(id_type)
);

CREATE TABLE controlleur(
   id_controlleurs INT AUTO_INCREMENT,
   libelle_controlleur VARCHAR(90) ,
   PRIMARY KEY(id_controlleurs)
);

CREATE TABLE jeu(
   id_jeu INT AUTO_INCREMENT,
   nom_jeu VARCHAR(255) ,
   prix DECIMAL(8,2)  ,
   resume TEXT,
   date_sortie DATE,
   validation BOOLEAN,
   gif VARCHAR(100) ,
   image_banniere VARCHAR(100) ,
   id_editeur INT NOT NULL,
   id_genre INT NOT NULL,
   PRIMARY KEY(id_jeu),
   FOREIGN KEY(id_editeur) REFERENCES editeur(id_editeur),
   FOREIGN KEY(id_genre) REFERENCES genre(id_genre)
);

CREATE TABLE dlc(
   id_dlc INT AUTO_INCREMENT,
   nom_dlc VARCHAR(255) ,
   prix_dlc DECIMAL(8,2)  ,
   resume_dlc TEXT,
   date_sortie_dlc DATE,
   validation BOOLEAN,
   id_jeu INT NOT NULL,
   PRIMARY KEY(id_dlc),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu)
);

CREATE TABLE media(
   id_media INT AUTO_INCREMENT,
   chemin_media TEXT,
   id_dlc INT,
   id_jeu INT,
   PRIMARY KEY(id_media),
   FOREIGN KEY(id_dlc) REFERENCES dlc(id_dlc),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu)
);

CREATE TABLE posseder_2(
   id_jeu INT,
   id_categorie INT,
   PRIMARY KEY(id_jeu, id_categorie),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);

CREATE TABLE recevoir_2(
   id_utilisateur INT,
   id_notif INT,
   date_heure_lecture_ DATETIME,
   PRIMARY KEY(id_utilisateur, id_notif),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_notif) REFERENCES notif(id_notif)
);

CREATE TABLE recevoir(
   id_editeur INT,
   id_notif INT,
   date_heure_lecture_ DATETIME,
   PRIMARY KEY(id_editeur, id_notif),
   FOREIGN KEY(id_editeur) REFERENCES editeur(id_editeur),
   FOREIGN KEY(id_notif) REFERENCES notif(id_notif)
);

CREATE TABLE recevoir_3(
   login VARCHAR(50) ,
   id_notif INT,
   date_heure_lecture_ DATETIME,
   PRIMARY KEY(login, id_notif),
   FOREIGN KEY(login) REFERENCES admin(login),
   FOREIGN KEY(id_notif) REFERENCES notif(id_notif)
);

CREATE TABLE posseder(
   id_utilisateur INT,
   id_jeu INT,
   statut BOOLEAN,
   favoris BOOLEAN,
   date_acquisition DATE,
   PRIMARY KEY(id_utilisateur, id_jeu),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu)
);

CREATE TABLE categoriser_4(
   id_jeu INT,
   id_type INT,
   PRIMARY KEY(id_jeu, id_type),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu),
   FOREIGN KEY(id_type) REFERENCES type(id_type)
);

CREATE TABLE adapter(
   id_jeu INT,
   id_controlleurs INT,
   PRIMARY KEY(id_jeu, id_controlleurs),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu),
   FOREIGN KEY(id_controlleurs) REFERENCES controlleur(id_controlleurs)
);

CREATE TABLE preferer(
   id_utilisateur INT,
   id_genre INT,
   PRIMARY KEY(id_utilisateur, id_genre),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_genre) REFERENCES genre(id_genre)
);

CREATE TABLE utiliser(
   id_utilisateur INT,
   id_controlleurs INT,
   PRIMARY KEY(id_utilisateur, id_controlleurs),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_controlleurs) REFERENCES controlleur(id_controlleurs)
);

CREATE TABLE preferer_3(
   id_utilisateur INT,
   id_type INT,
   PRIMARY KEY(id_utilisateur, id_type),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_type) REFERENCES type(id_type)
);

CREATE TABLE preferer_2(
   id_utilisateur INT,
   id_categorie INT,
   PRIMARY KEY(id_utilisateur, id_categorie),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);

CREATE TABLE contenir_dlc(
   id_dlc INT,
   id_transaction INT,
   PRIMARY KEY(id_dlc, id_transaction),
   FOREIGN KEY(id_dlc) REFERENCES dlc(id_dlc),
   FOREIGN KEY(id_transaction) REFERENCES commande(id_transaction)
);

CREATE TABLE contenir(
   id_jeu INT,
   id_transaction INT,
   PRIMARY KEY(id_jeu, id_transaction),
   FOREIGN KEY(id_jeu) REFERENCES jeu(id_jeu),
   FOREIGN KEY(id_transaction) REFERENCES commande(id_transaction)
);
CREATE TABLE bannis(
   id_bannis INT,
   date_debutBan DATETIME,
   date_finBan DATETIME,
   ban_perma BOOLEAN,
   raison_ban TEXT,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_bannis),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);