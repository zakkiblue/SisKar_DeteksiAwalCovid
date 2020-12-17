

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
('G3','Kelelahan'),
('G4','Rasa tidak nyaman dan Nyeri'),
('G5','Nyeri tenggorokan'),
('G6','Diare'),
('G7','Mata Merah'),
('G8','Sakit kepala'),
('G9','Hilangnya indra perasa atau pencium'),
('G10','Ruam pada kulit dan perubahan warna pada jari tangan atau kaki'),
('G11','Sesak nafas'),
('G12','Nyeri atau rasa tertekan pada dada'),
('G13','HIlangnya kemampuan bicara atau bergerak'),
('G14','Kontak dengan pasien Covid-19'),
('G15','Bepergian ke luar kota dengan zona merah'); 

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
('P2','Masuk Angin','Gejala yang anda alami adalah masuka anain.'),
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
('2','1','0.3'),
('3','1','0.3'),
('1','2','0.3'),
('2','2','0.3'),
('3','2','0.3'),
('1','3','0.3'),
('2','3','0.3'),
('3','3','0.3'),
('1','4','0.6'),
('2','4','0.6'),
('1','5','0.6'),
('2','5','0.6'),
('3','5','0.6'),
('1','6','0.6'),
('2','6','0.6'),
('1','7','0.6'),
('2','7','0.6'),
('1','8','0.6'),
('2','8','0.6'),
('3','8','0.6'),
('1','9','0.6'),
('3','9','0.6'),
('1','10','0.7'),
('1','11','0.6'),
('3','11','0.6'),
('1','12','0.6'),
('1','13','0.7'),
('1','14','0.85'),
('1','15','0.8'); 
