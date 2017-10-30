CREATE TABLE "users" (
    "id" SERIAL NOT NULL,
    "ip_address" varchar(45),
    "username" varchar(100) NULL,
    "password" varchar(255) NOT NULL,
    "salt" varchar(255),
    "email" varchar(100) NOT NULL,
    "activation_code" varchar(40),
    "forgotten_password_code" varchar(40),
    "forgotten_password_time" int,
    "remember_code" varchar(40),
    "created_on" int NOT NULL,
    "last_login" int,
    "active" int4,
    "first_name" varchar(50),
    "last_name" varchar(50),
    "company" varchar(100),
    "phone" varchar(20),
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0),
  CONSTRAINT "check_active" CHECK(active >= 0)
);


CREATE TABLE "groups" (
    "id" SERIAL NOT NULL,
    "name" varchar(20) NOT NULL,
    "description" varchar(100) NOT NULL,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);


CREATE TABLE "users_groups" (
    "id" SERIAL NOT NULL,
    "user_id" integer NOT NULL,
    "group_id" integer NOT NULL,
  PRIMARY KEY("id"),
  CONSTRAINT "uc_users_groups" UNIQUE (user_id, group_id),
  CONSTRAINT "users_groups_check_id" CHECK(id >= 0),
  CONSTRAINT "users_groups_check_user_id" CHECK(user_id >= 0),
  CONSTRAINT "users_groups_check_group_id" CHECK(group_id >= 0)
);



CREATE TABLE "login_attempts" (
    "id" SERIAL NOT NULL,
    "ip_address" varchar(15),
    "login" varchar(100) NOT NULL,
    "time" int,
  PRIMARY KEY("id"),
  CONSTRAINT "check_id" CHECK(id >= 0)
);

CREATE TABLE menus
(
  id SERIAL NOT NULL,
  menuorder smallint,
  name character varying(50),
  description character varying(100),
  link character varying(50),
  icon character varying(100),
  statmenu integer,
  mainmenuid integer,
  CONSTRAINT pk_idmenu PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE menus
  OWNER TO postgres;

CREATE TABLE groups_access
(
  id SERIAL NOT NULL,
  group_id integer,
  menu_id integer,
  privilege character varying,
  CONSTRAINT pk_groups_access PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE groups_access
  OWNER TO postgres;

CREATE TABLE users_picture
(
  id SERIAL NOT NULL,
  user_id integer,
  picture text,
  picture_type integer,
  description character varying(500),
  stat integer,
  CONSTRAINT pk_users_picture PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE users_picture
  OWNER TO postgres;

CREATE TABLE "ci_sessions" (
        "id" varchar(128) NOT NULL,
        "ip_address" varchar(45) NOT NULL,
        "timestamp" bigint DEFAULT 0 NOT NULL,
        "data" text DEFAULT '' NOT NULL
);

CREATE INDEX "ci_sessions_timestamp" ON "ci_sessions" ("timestamp");

INSERT INTO groups (id, name, description) VALUES
    (1,'admin','Administrator');

INSERT INTO users (ip_address, username, password, salt, email, activation_code, forgotten_password_code, created_on, last_login, active, first_name, last_name, company, phone) VALUES
    ('127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,'1268889823','1268889823','1','Admin','istrator','ADMIN','0');

INSERT INTO users_groups (user_id, group_id) VALUES
    (1,1);

INSERT INTO menus (id, menuorder, name, description, link, icon, statmenu, mainmenuid) VALUES (3, NULL, 'User Groups', 'User groups management', 'groups', 'fa fa-users', 1, 1);
INSERT INTO menus (id, menuorder, name, description, link, icon, statmenu, mainmenuid) VALUES (2, NULL, 'Menus', 'All menus in application', 'menus', 'fa fa-bars', 1, 1);
INSERT INTO menus (id, menuorder, name, description, link, icon, statmenu, mainmenuid) VALUES (1, NULL, 'Users and Menus', 'Navigate all users and menus application', '#', 'fa fa-th', 1, NULL);
INSERT INTO menus (id, menuorder, name, description, link, icon, statmenu, mainmenuid) VALUES (4, NULL, 'Users', 'User Application Management', 'users', 'fa fa-user-plus', 1, 1);    
