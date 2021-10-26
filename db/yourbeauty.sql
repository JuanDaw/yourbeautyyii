------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id       bigserial PRIMARY KEY
  , nombre   varchar(255) NOT NULL UNIQUE
  , password varchar(60) NOT NULL
);

DROP TABLE IF EXISTS categorias CASCADE;

CREATE TABLE categorias (
    id       bigserial PRIMARY KEY
  , nombre   varchar(30) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS productos CASCADE;

CREATE TABLE productos (
    id       bigserial PRIMARY KEY
  , nombre   varchar(255) NOT NULL
  , descripcion varchar(255) NOT NULL
  , categoria_id bigint NOT NULL REFERENCES categorias (id)
  , marca varchar(255) NOT NULL
  , link varchar(255) NOT NULL
);

DROP TABLE IF EXISTS patrocinados CASCADE;

CREATE TABLE patrocinados (
    usuario_id  bigint REFERENCES usuarios(id)
  , producto_id bigint REFERENCES productos(id)
  , PRIMARY KEY (usuario_id, producto_id)
);

CREATE EXTENSION pgcrypto;

INSERT INTO usuarios (nombre, password)
VALUES ('juan', crypt('juan', gen_salt('bf')))