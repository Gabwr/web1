/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     1/3/2025 20:13:14                            */
/*==============================================================*/


/*==============================================================*/
/* Table: qr                                                    */
/*==============================================================*/
create table qr
(
   qr_id                int auto_increment,
   qr_url               varchar(250) not null,
   primary key (qr_id)
);



/*==============================================================*/
/* Table: Perfiles                                              */
/*==============================================================*/
create table perfiles
(
   idPermiso            int auto_increment,
   idUsuario            int not null,
   nombreperfil         varchar(64) not null,
   estado               varchar(64) not null,
   primary key (idPermiso, idUsuario)
);

/*==============================================================*/
/* Table: gasto                                                 */
/*==============================================================*/
create table gasto
(
   idGasto              int auto_increment,
   idUsuario            int not null,
   idconcepto           int not null,
   fecha                date not null,
   valor                decimal(4,2) not null,
   medio_de_pago        national varchar(45) not null,
   acreedor_cobrador    national varchar(45) not null,
   descripcion          national varchar(128) not null,
   primary key (idGasto)
);

/*==============================================================*/
/* Table: ingreso                                               */
/*==============================================================*/
create table ingreso
(
   idIngreso            int auto_increment,
   idconcepto           int not null,
   idUsuario            int not null,
   fecha                date not null,
   valor                decimal(4,2) not null,
   medio_de_pago        national varchar(45) not null,
   fuente_beneficiario  national varchar(45) not null,
   descripcion          national varchar(128) not null,
   primary key (idIngreso)
);

/*==============================================================*/
/* Table: permisos                                              */
/*==============================================================*/
create table permisos
(
   idPermiso            int auto_increment,
   nombre               national varchar(45) not null,
   descripcion          national varchar(45) not null,
   primary key (idPermiso)
);

/*==============================================================*/
/* Table: usuario                                               */
/*==============================================================*/
create table usuario
(
   idUsuario            int auto_increment,
   nombre               national varchar(45) not null,
   apellido             national varchar(45) not null,
   usuario              national varchar(45) not null,
   contrasenia          national varchar(60) not null,
   estado               national varchar(32) not null,
   Conexion             date not null,
   primary key (idUsuario)
);

/*==============================================================*/
/* Table: Concepto                                              */
/*==============================================================*/
create table concepto
(
   idconcepto           int auto_increment,
   qr_id                int not null,
   nombre               varchar(128) not null,
   tipo                 varchar(128) not null,
   primary key (idconcepto)
);

alter table Concepto add constraint FK_se_representa foreign key (qr_id)
      references qr (qr_id) on delete restrict on update restrict;

alter table Perfiles add constraint FK_Permisos foreign key (idPermiso)
      references permisos (idPermiso) on delete restrict on update restrict;

alter table Perfiles add constraint FK_Perfiles foreign key (idUsuario)
      references usuario (idUsuario) on delete restrict on update restrict;

alter table gasto add constraint FK_fk_GASTO_USUARIO foreign key (idUsuario)
      references usuario (idUsuario) on delete restrict on update restrict;

alter table gasto add constraint FK_tiene_un2 foreign key (idconcepto)
      references Concepto (idconcepto) on delete restrict on update restrict;

alter table ingreso add constraint FK_fk_INGRESO_USUARIO1 foreign key (idUsuario)
      references usuario (idUsuario) on delete restrict on update restrict;

alter table ingreso add constraint FK_tiene_un foreign key (idconcepto)
      references Concepto (idconcepto) on delete restrict on update restrict;

INSERT INTO permisos (idPermiso, nombre, descripcion) VALUES 
(1, 'lectura ingresos', 'Permiso de solo lectura'),
(2, 'insercion ingresos', 'Permiso de inserción'),
(3, 'edicion ingresos', 'Permiso de edición'),
(4, 'lectura gastos', 'Permiso de solo lectura'),
(5, 'insercion gastos', 'Permiso de inserción'),
(6, 'edicion gastos', 'Permiso de edición'),
(7, 'lectura usuarios', 'Permiso de solo lectura'),
(8, 'insercion usuarios', 'Permiso de inserción'),
(9, 'edicion usuarios', 'Permiso de edición'),
(10, 'lectura perfiles', 'Permiso de solo lectura'),
(11, 'insercion perfiles', 'Permiso de inserción'),
(12, 'edicion perfiles', 'Permiso de edición'),
(13, 'lectura conceptos', 'Permiso de solo lectura'),
(14, 'insercion conceptos', 'Permiso de inserción'),
(15, 'edicion conceptos', 'Permiso de edición'),
(16, 'lectura qr', 'Permiso de solo lectura');

-- Insertar usuarios con perfiles
INSERT INTO usuario (idUsuario, nombre, apellido, usuario, contrasenia, estado, Conexion) VALUES 
(1, 'Admin', 'Admin', 'admin', 'admin123', 'Activo', '2025-03-01'),
(2, 'Carlos', 'Perez', 'cperez', 'clave123', 'Activo', '2025-03-01'),
(3, 'Ana', 'Lopez', 'alopez', 'pass456', 'Activo', '2025-03-01');


INSERT INTO Perfiles (idPermiso, idUsuario, nombreperfil, estado) VALUES 
(1, 1, 'Administrador', 'activo'),
(2, 1, 'Administrador', 'activo'),
(3, 1, 'Administrador', 'activo'),
(4, 1, 'Administrador', 'activo'),
(5, 1, 'Administrador', 'activo'),
(6, 1, 'Administrador', 'activo'),
(7, 1, 'Administrador', 'activo'),
(8, 1, 'Administrador', 'activo'),
(9, 1, 'Administrador', 'activo'),
(10, 1, 'Administrador', 'activo'),
(11, 1, 'Administrador', 'activo'),
(12, 1, 'Administrador', 'activo'),
(13, 1, 'Administrador', 'activo'),
(14, 1, 'Administrador', 'activo'),
(15, 1, 'Administrador', 'activo'),
(16, 1, 'Administrador', 'activo'),
(1, 2, 'Generador de Ingresos', 'activo'),
(2, 2, 'Generador de Ingresos', 'activo'),
(4, 3, 'Generador de Egresos', 'activo'),
(5, 3, 'Generador de Egresos', 'activo');
-- Insertar qr prueba
INSERT INTO qr (qr_url) VALUES 
('https://example.com/qr1'),
('https://example.com/qr2');

-- Insertar conceptos
INSERT INTO Concepto (idconcepto, qr_id, nombre, tipo) VALUES 
('1', 1, 'Salario', 'Ingreso'),
('2', 2, 'Compra de materiales', 'Gasto');

-- Insertar ingresos del usuario con perfil de ingresos
INSERT INTO ingreso (idIngreso, idconcepto, idUsuario, fecha, valor, medio_de_pago, fuente_beneficiario, descripcion) VALUES 
(1, '1', 2, '2025-03-01', 5000.00, 'Transferencia', 'Empresa ABC', 'Pago mensual de salario');

-- Insertar gastos del usuario con perfil de egresos
INSERT INTO gasto (idGasto, idUsuario, idconcepto, fecha, valor, medio_de_pago, acreedor_cobrador, descripcion) VALUES 
(1, 3, '2', '2025-03-01', 300.00, 'Efectivo', 'Proveedor XYZ', 'Compra de materiales de oficina');