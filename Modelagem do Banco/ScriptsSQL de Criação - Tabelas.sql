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
	id SERIAL,
	usuario VARCHAR(100) NOT NULL,
	oferecimento BOOLEAN NOT NULL,
	origem VARCHAR(100) NOT NULL,
	data_viajem VARCHAR(15) NOT NULL,
	hora_saida VARCHAR(10) NOT NULL,
	hora_chegada VARCHAR(10) NOT NULL,
	ajuda_custo REAL NOT NULL,
	destino VARCHAR(100) NOT NULL,
	distancia VARCHAR(100) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(usuario) REFERENCES Usuario(email)
);