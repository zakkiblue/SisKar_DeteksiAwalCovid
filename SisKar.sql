

CREATE DATABASE IF NOT EXISTS db_expert_covid;
USE db_expert_covid;

DROP TABLE IF EXISTS ds_evidences;
CREATE TABLE IF NOT EXISTS ds_evidences(
    id INT AUTO_INCREMENT,
    code VARCHAR(3),
    name VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=MyISAM CHARSET=utf8;

INSERT INTO ds_evidences(code,name)
VALUES
('G1','Demam lebih dari 37 dearajat celcius'),
('G2','Batuk Kering'),
('G3','Hidung meler'),
('G4','Pernapasan Cepat tidak normal'),
('G5','Nersin bersin'),
('G6','Munath muntah'),
('G7','Diare'),
('G8','Dahak kental kuning kehijauan'),
('G9','Otot -otot  nyeri'),
('G10','Sinar X pada paru'),
('G11','Sakit kepala'),
('G12','Hidung tersumbat'),
('G13','Tenggorokan sakit'),
('G14','Tenggorokan tidak nyaman'); 

DROP TABLE IF EXISTS ds_problems;
CREATE TABLE IF NOT EXISTS ds_problems(
    id INT AUTO_INCREMENT,
    code VARCHAR(3),
    name VARCHAR(30),
    notes TEXT,
    PRIMARY KEY (id)
) ENGINE=MyISAM CHARSET=utf8;

INSERT INTO ds_problems(code,name,notes)
VALUES
('P1','Covid-19','anda teridentifikasi mengalami gejala Covid-19 perlu pengetesan secara mendalam di rumah sakit terdekat.'),
('P2','Influenza','Gejala yang anda alami adalah Influenza.'),
('P3','Flu','Anda mengalami gejala Flu biasa.');

DROP TABLE IF EXISTS ds_rules;
CREATE TABLE IF NOT EXISTS ds_rules(
    id_problem INT,
    id_evidence INT,
    cf float
) ENGINE=MyISAM CHARSET=utf8;

INSERT INTO ds_rules(id_problem,id_evidence,cf)
VALUES
('1','1','0.3'),
('2','1','0.2'),
('1','2','0.4'),
('2','2','0.3'),
('3','2','0.3'),
('3','3','0.4'),
('1','4','0.5'),
('2','5','0.5'),
('3','5','0.4'),
('2','6','0.2'),
('1','7','0.5'),
('1','8','0.2'),
('2','9','0.2'),
('1','10','0.5'),
('2','11','0.3'),
('3','12','0.4'),
('3','13','0.2'),
('3','14','0.2'); 
