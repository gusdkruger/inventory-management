CREATE DATABASE inventory_management;
USE inventory_management;

CREATE TABLE user (
	id INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL UNIQUE,
	password varchar(255) NOT NULL
);