create database if not exists jdr;
use jdr;

create table if not exists utilisateur(
   id_utilisateur int primary key not null auto_increment,
   pseudo_utilisateur varchar(50) not null,
   password_utilisateur varchar(100) not null,
   mail_utilisateur varchar(50) not null,
   id_type_utilisateur int
);

create table if not exists type_utilisateur(
   id_type_utilisateur int primary key not null auto_increment,
   nom_type_utilisateur varchar(50)
);

create table if not exists scenario(
   id_scenario int primary key not null auto_increment,
   intrigue text not null,
   situation_initiale text,
   element_perturbateur text,
   element_de_resolution text,
   conclusion text,
   recompense varchar(50),
   auteur_scenario int
  ); 
   
create table if not exists participer(
   id_fiche_personnage int,
   id_scenario int,
   primary key(id_fiche_personnage, id_scenario)
);


create table if not exists fiche_personnage(
   id_fiche_personnage int primary key not null auto_increment,
   nom_personnage varchar(50) not null,
   histoire_personnage text not null,
   photo_personnage varchar(50),
   equipement_personnage text,
   statut_personnage boolean,
   id_stats_personnage int unique,
   id_type_personnage int,
   auteur_personnage int
);

create table if not exists type_personnage(
   id_type_personnage int primary key not null auto_increment,
   nom_type_personnage varchar(50)
);

create table if not exists stats_personnage(
   id_stats_personnage int primary key not null auto_increment,
   constitution int,
   reflexes int,
   intelligence int
);

alter table utilisateur add constraint fk_id_type_utilisateur foreign key (id_type_utilisateur) references type_utilisateur(id_type_utilisateur);
alter table scenario add constraint fk_id_utilisateur_scenario foreign key (auteur_scenario) references utilisateur(id_utilisateur);
alter table participer add constraint fk_id_fiche_personnage foreign key (id_fiche_personnage) references fiche_personnage(id_fiche_personnage);
alter table participer add constraint fk_id_scenario foreign key (id_scenario) references scenario(id_scenario);
alter table fiche_personnage add constraint fk_id_utilisateur_fiche_personnage foreign key (auteur_personnage) references utilisateur(id_utilisateur);
alter table fiche_personnage add constraint fk_id_stats_personnage foreign key (id_stats_personnage) references stats_personnage(id_stats_personnage);
alter table fiche_personnage add constraint fk_id_type_personnage foreign key (id_type_personnage) references type_personnage(id_type_personnage);


insert into utilisateur(pseudo_utilisateur,mail_utilisateur,password_utilisateur) values 
('Korto','korto@gmail.com','test'),
('Tsen','tsen@gmail.com','test'),
('Voute','voute@gmail.com','test');
insert into fiche_personnage(nom_personnage,histoire_personnage,equipement_personnage,photo_personnage,statut_personnage,auteur_personnage) values
('Korto','Corpo','Lames mantis','test.png','1','1'),
('Tsen','Nomade','Fusil longue portée','test.png','1','2'),
('Voute','Gosse des rues','Sandevistan','test.png','1','3');

select * from utilisateur;
select * from fiche_personnage where statut_personnage = true ;
drop database jdr;
use jdr;