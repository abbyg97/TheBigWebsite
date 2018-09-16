-- drops in order as to not be bothered by constraints
DROP TABLE IF EXISTS Approvals;

DROP TABLE IF EXISTS Committee_Members;

DROP TABLE IF EXISTS Team_Leaders;

DROP TABLE IF EXISTS volunteers;

DROP TABLE IF EXISTS Organization;

DROP TABLE IF EXISTS Projects;

DROP TABLE IF EXISTS Transportation;

DROP TABLE IF EXISTS Host;

-- creates tables
CREATE TABLE Approvals (
    project int  NOT NULL,
    approver int  NOT NULL,
    status varchar(3)  NOT NULL,
    additional_comments varchar(250)  NULL,
    number int  NOT NULL,
    CONSTRAINT Approvals_pk PRIMARY KEY (number)
);

CREATE TABLE Committee_Members (
    number int  NOT NULL,
    first_name varchar(15)  NOT NULL,
    last_name varchar(15)  NOT NULL,
    CONSTRAINT Committee_Members_pk PRIMARY KEY (number)
);

CREATE TABLE Host (
    host_number int  NOT NULL,
    first_name varchar(15)  NOT NULL,
    last_name varchar(20)  NOT NULL,
    phone varchar(12)  NOT NULL,
    second_phone varchar(12) NULL,
    email varchar(30) NULL,
    alt_first_name varchar(15)  NULL,
    alt_last_name varchar(20)  NULL,
    alt_phone varchar(12)  NULL,
    alt_email varchar(30) NULL,
    CONSTRAINT Host_pk PRIMARY KEY (host_number)
);

CREATE TABLE Organization (
    number int  NOT NULL,
    name varchar(40)  NOT NULL,
    total_members int  NOT NULL,
    CONSTRAINT Organization_pk PRIMARY KEY (number)
);

CREATE TABLE Projects (
    Project_Number int  NOT NULL,
    Host int  NOT NULL,
    address varchar(40)  NOT NULL,
    min_volunteers int  NOT NULL,
    max_volunteers int  NOT NULL,
    transportation int  NULL,
    category int NOT NULL,
    description varchar(250)  NOT NULL,
    tools varchar(50) NULL,
    additional_comments varchar(250)  NULL,
    rain varchar(3)  NOT NULL,
    rain_proj varchar(100) NULL,
    restriction_violation varchar(45)  NULL,
    CONSTRAINT Projects_pk PRIMARY KEY (Project_Number)
);

CREATE TABLE Team_Leaders (
    tl_number int  NOT NULL,
    tl_first_name varchar(20)  NOT NULL,
    tl_last_name varchar(20)  NOT NULL,
    phone int  NOT NULL,
    email varchar(20)  NOT NULL,
    tl_project int  NOT NULL,
    CONSTRAINT Team_Leaders_pk PRIMARY KEY (tl_number)
);

CREATE TABLE Transportation (
    type varchar(4)  NOT NULL,
    number int  NOT NULL,
    CONSTRAINT Transportation_pk PRIMARY KEY (number)
);

CREATE TABLE volunteers (
    vol_number int  NOT NULL,
    first_name varchar(20)  NOT NULL,
    last_name varchar(20)  NOT NULL,
    email varchar(50) NOT NULL,
    provide_transport varchar(3)  NOT NULL,
    restrictions varchar(100) NULL,
    phone_numbers varchar(12)  NOT NULL,
    organization int  NULL,
    project int  NULL,
    CONSTRAINT volunteers_pk PRIMARY KEY (vol_number)
);

-- adds foreign key
ALTER TABLE Approvals ADD CONSTRAINT Approvals_Committee_Members
    FOREIGN KEY (approver)
    REFERENCES Committee_Members (number)
;

ALTER TABLE Approvals ADD CONSTRAINT Approvals_Projects
    FOREIGN KEY (project)
    REFERENCES Projects (Project_Number)
;

ALTER TABLE Projects ADD CONSTRAINT Projects_Host
    FOREIGN KEY (Host)
    REFERENCES Host (host_number)
;

ALTER TABLE Projects ADD CONSTRAINT Projects_Transportation
    FOREIGN KEY (transportation)
    REFERENCES Transportation (number)
;

-- Reference: Team_Leaders_Projects (table: Team_Leaders)
ALTER TABLE Team_Leaders ADD CONSTRAINT Team_Leaders_Projects
    FOREIGN KEY (tl_project)
    REFERENCES Projects (Project_Number)
;

ALTER TABLE volunteers ADD CONSTRAINT volunteers_Organization
    FOREIGN KEY (organization)
    REFERENCES Organization (number)
;

ALTER TABLE volunteers ADD CONSTRAINT volunteers_Projects
    FOREIGN KEY (project)
    REFERENCES Projects (Project_Number)
;
