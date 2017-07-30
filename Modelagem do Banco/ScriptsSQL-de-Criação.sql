CREATE TABLE Usuario(
	email VARCHAR(100),
	nome VARCHAR(100) NOT NULL,
	senha VARCHAR(32) NOT NULL,
	sexo VARCHAR(10) NOT NULL,
	telefone VARCHAR(20) NOT NULL,
	nascimento VARCHAR(15) NOT NULL,
	PRIMARY KEY(email)
);

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
	PRIMARY KEY(email_usuario, data_viajem, hora_saida),
	FOREIGN KEY(email_usuario) REFERENCES Usuario(email)
);

CREATE TABLE waypoints(
	id SERIAL,
	email_usuario VARCHAR(100) NOT NULL,
	data_carona VARCHAR(100) NOT NULL,
	hora_carona VARCHAR(100) NOT NULL,
	descricao VARCHAR(500) NOT NULL,
	geom GEOMETRY,
	PRIMARY KEY(id),
	CONSTRAINT FOREIGN KEY FK1(email_usuario) REFERENCES Usuario(email),
	CONSTRAINT FOREIGN KEY FK2(data_carona) REFERENCES Carona(data_viajem),
	CONSTRAINT FOREIGN KEY FK3(hora_carona) REFERENCES Carona(hora_saida)
);
