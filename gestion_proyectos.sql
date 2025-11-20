CREATE OR REPLACE DATABASE gestion_proyectos;
USE gestion_proyectos;

CREATE TABLE tipo (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(20) DEFAULT NULL
);

CREATE TABLE estado (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(20) DEFAULT NULL
);

CREATE TABLE proyectos (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(50) DEFAULT NULL,
  descripcion TEXT DEFAULT NULL,
  id_tipo int(11) NOT NULL,
  CONSTRAINT fk_tipo FOREIGN KEY (id_tipo) REFERENCES tipo(id),
  id_estado int(11) NOT NULL,
  CONSTRAINT fk_estado FOREIGN KEY (id_estado) REFERENCES estado(id)
);

CREATE TABLE tecnologias (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(20) DEFAULT NULL
);

CREATE TABLE proyecto_tecnologias (
  id_proyectos int NOT NULL,
  id_tecnologias int NOT NULL,
  PRIMARY KEY(id_proyectos, id_tecnologias),
  CONSTRAINT fk_proyectos FOREIGN KEY (id_proyectos) REFERENCES proyectos(id),
  CONSTRAINT fk_tecnologias FOREIGN KEY (id_tecnologias) REFERENCES tecnologias(id)
);

/*
SELECT p.nombre, t.nombre AS tecnologia FROM proyectos p
INNER JOIN proyecto_tecnologias pt on p.id = pt.id_proyectos
INNER JOIN tecnologias t on pt.id_tecnologias = t.id;

Mostrar nombre proyecto, descripcion, tipo y estado
SELECT p.nombre, p.descripcion, t.nombre AS tipo, e.nombre AS estado FROM proyectos p
INNER JOIN tipo t on p.id_tipo = t.id
INNER JOIN estado e on p.id_estado = e.id;
*/

INSERT INTO tipo (id, nombre) VALUES (1, 'Proyecto interno');
INSERT INTO tipo (id, nombre) VALUES (2, 'Consultoría');
INSERT INTO tipo (id, nombre) VALUES (3, 'Iniciativa RRHH');

INSERT INTO estado (id, nombre) VALUES (1, 'En progreso');
INSERT INTO estado (id, nombre) VALUES (2, 'Bloqueado');
INSERT INTO estado (id, nombre) VALUES (3, 'Finalizado');
INSERT INTO estado (id, nombre) VALUES (4, 'Pendiente');


INSERT INTO  proyectos (id, nombre, descripcion, id_tipo, id_estado) VALUES (
  1,
  'Intranet Corporativa',
  'Desarrollo de una intranet para centralizar documentos internos, comunicados y herramientas de gestión del personal',
  1, 1
);

INSERT INTO  proyectos (id, nombre, descripcion, id_tipo, id_estado) VALUES (
  2,
  'Portal del Cliente - Consultoría Alfa',
  'Plataforma web personalizada para la gestión de incidencias y seguimiento de proyectos para un cliente externo',
  2, 1
);

INSERT INTO  proyectos (id, nombre, descripcion, id_tipo, id_estado) VALUES (
  3,
  'Gestor de Formación Continua',
  'Aplicación para el departamento de RRHH que permite planificar, inscribir y evaluar cursos de formación interna',
  1, 2
);

INSERT INTO  proyectos (id, nombre, descripcion, id_tipo, id_estado) VALUES (
  4,
  'Evaluación del Desempeño',
  'Aplicación web para gestionar las evaluaciones anuales del personal, con informes automáticos y exportación de resultados',
  3, 3
);

INSERT INTO  proyectos (id, nombre, descripcion, id_tipo, id_estado) VALUES (
  5,
  'Sistema de Control de Accesos',
  'Herramienta web para registrar y monitorizar accesos físicos y digitales de empleados, integrada con la base de datos corporativa',
  1, 4
);

INSERT INTO tecnologias (id, nombre) VALUES (1, 'PHP');
INSERT INTO tecnologias (id, nombre) VALUES (2, 'Laravel');
INSERT INTO tecnologias (id, nombre) VALUES (3, 'MySQL');
INSERT INTO tecnologias (id, nombre) VALUES (4, 'Bootstrap');
INSERT INTO tecnologias (id, nombre) VALUES (5, 'Symfony');
INSERT INTO tecnologias (id, nombre) VALUES (6, 'MariaDB');
INSERT INTO tecnologias (id, nombre) VALUES (7, 'Tailwind CSS');
INSERT INTO tecnologias (id, nombre) VALUES (8, 'PostgreSQL');
INSERT INTO tecnologias (id, nombre) VALUES (9, 'Vue.js');
INSERT INTO tecnologias (id, nombre) VALUES (10, 'Chart.js');
INSERT INTO tecnologias (id, nombre) VALUES (11, 'CodeIgniter');
INSERT INTO tecnologias (id, nombre) VALUES (12, 'jQuery');

INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (1, 1);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (1, 2);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (1, 3);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (1, 4);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (2, 1);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (2, 5);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (2, 6);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (2, 7);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (3, 1);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (3, 2);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (3, 8);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (3, 9);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (4, 1);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (4, 2);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (4, 3);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (4, 10);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (5, 1);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (5, 11);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (5, 3);
INSERT INTO proyecto_tecnologias (id_proyectos, id_tecnologias) VALUES (5, 12);
