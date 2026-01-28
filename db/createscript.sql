DROP DATABASE IF EXISTS achtbaan_2509;
CREATE DATABASE achtbaan_2509;
USE achtbaan_2509;

CREATE TABLE HoogsteAchtbaanVanEuropa (
    ID SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RollerCoaster VARCHAR(50) NOT NULL,
    AmusementPark VARCHAR(50) NOT NULL,
    Country VARCHAR(50) NOT NULL,
    TopSpeed SMALLINT UNSIGNED NOT NULL,
    Height TINYINT UNSIGNED NOT NULL,
    YearOfConstruction DATE NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Remark VARCHAR(225) DEFAULT NULL,
    DateCreate DATETIME(6) NOT NULL DEFAULT NOW(6),
    DateChange DATETIME(6) NOT NULL DEFAULT NOW(6)
);

INSERT INTO HoogsteAchtbaanVanEuropa
(RollerCoaster, AmusementPark, Country, TopSpeed, Height, YearOfConstruction)
VALUES
('Kingda Ka', 'Six Flags Great Adventure', 'Verenigd Koninkrijk', 206, 127, '2005-10-21'),
('Red Force', 'Ferrari Land', 'Spanje', 180, 112, '2017-04-07'),
('Hyperion', 'Energielandia', 'Polen', 142, 77, '2018-08-14'),
('Sjalamba', 'PortAventura', 'Spanje', 134, 76, '2012-04-07'),
('Schwur des Karnen', 'Hansa Park', 'Duitsland', 127, 73, '2017-02-25');

