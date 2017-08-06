CREATE TABLE Usuario(
	email VARCHAR(100),
	nome VARCHAR(100) NOT NULL,
	senha VARCHAR(32) NOT NULL,
	sexo VARCHAR(10) NOT NULL,
	telefone VARCHAR(20) NOT NULL,
	nascimento VARCHAR(15) NOT NULL,
	CONSTRAINT PKU PRIMARY KEY(email)
)ENGINE = InnoDB;

CREATE TABLE Carona(
	email_usuario VARCHAR(100),
	geom_origem GEOMETRY,
	geom_destino GEOMETRY,
	descricao_origem VARCHAR(500) NOT NULL,
	data_viajem VARCHAR(100),
	hora_saida VARCHAR(100),
	hora_chegada VARCHAR(100) NOT NULL,
	ajuda_custo REAL NOT NULL,
	descricao_destino VARCHAR(500) NOT NULL,
	distancia VARCHAR(100) NOT NULL,
	CONSTRAINT PK1 PRIMARY KEY(email_usuario, data_viajem, hora_saida),
	CONSTRAINT FKC FOREIGN KEY(email_usuario) 
		REFERENCES Usuario(email) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE waypoints(
	id SERIAL,
	email_usuario VARCHAR(100) NOT NULL,
	data_carona VARCHAR(100) NOT NULL,
	hora_carona VARCHAR(100) NOT NULL,
	descricao VARCHAR(500) NOT NULL,
	geom GEOMETRY,
	CONSTRAINT PKW PRIMARY KEY(id),
	CONSTRAINT FKW FOREIGN KEY(email_usuario, data_carona, hora_carona) 
		REFERENCES Carona(email_usuario, data_viajem, hora_saida) 
			ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE = InnoDB;
