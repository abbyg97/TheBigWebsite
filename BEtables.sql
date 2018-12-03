-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2018-11-05 19:21:55.775

-- tables
-- Table: Approvals
CREATE TABLE Approvals (
    project int  NOT NULL,
    approver int  NOT NULL,
    status varchar(3)  NOT NULL,
    additional_comments varchar(200)  NULL,
    num int  NOT NULL,
    CONSTRAINT Approvals_pk PRIMARY KEY (num)
);

-- Table: Committee_Members
CREATE TABLE Committee_Members (
    number int  NOT NULL,
    first_name varchar(15)  NOT NULL,
    last_name varchar(15)  NOT NULL,
    CONSTRAINT Committee_Members_pk PRIMARY KEY (number)
);

-- Table: Host
CREATE TABLE Host (
    host_number int  NOT NULL,
    first_name varchar(15)  NOT NULL,
    last_name varchar(20)  NOT NULL,
    phone int  NOT NULL,
    second_phone int  NOT NULL,
    email varchar(50)  NOT NULL,
    alt_first_name varchar(20)  NOT NULL,
    alt_last_name varchar(20)  NOT NULL,
    alt_phone int  NOT NULL,
    alt_email varchar(50)  NOT NULL,
    CONSTRAINT Host_pk PRIMARY KEY (host_number)
);

-- Table: Organization
CREATE TABLE Organization (
    number int  NOT NULL,
    name varchar(40)  NOT NULL,
    total_members int  NOT NULL,
    CONSTRAINT Organization_pk PRIMARY KEY (number)
);

-- Table: Projects
CREATE TABLE Projects (
    Project_Number int  NOT NULL,
    Host int  NOT NULL,
    address varchar(150)  NOT NULL,
    min_volunteers int  NOT NULL,
    max_volunteers int  NOT NULL,
    transportation int  NULL,
    category int  NOT NULL,
    description varchar(250)  NOT NULL,
    tools varchar(50)  NOT NULL,
    additional_comments varchar(250)  NULL,
    rain varchar(3)  NOT NULL,
    rain_proj varchar(100)  NOT NULL,
    restriction_violation varchar(45)  NULL,
    CONSTRAINT Projects_pk PRIMARY KEY (Project_Number)
);

-- Table: Team_Leaders
CREATE TABLE Team_Leaders (
    tl_number int  NOT NULL,
    tl_first_name varchar(20)  NOT NULL,
    tl_last_name varchar(20)  NOT NULL,
    phone int  NOT NULL,
    email varchar(20)  NOT NULL,
    tl_project int  NOT NULL,
    CONSTRAINT Team_Leaders_pk PRIMARY KEY (tl_number)
);

-- Table: Transportation
CREATE TABLE Transportation (
    type varchar(4)  NOT NULL,
    number int  NOT NULL,
    CONSTRAINT Transportation_pk PRIMARY KEY (number)
);

-- Table: execLogin
CREATE TABLE execLogin (
    username varchar(25)  NOT NULL,
    password varchar(75)  NOT NULL,
    perissions int  NOT NULL,
    CONSTRAINT execLogin_pk PRIMARY KEY (username)
);

-- Table: hostLogin
CREATE TABLE hostLogin (
    username varchar(25)  NOT NULL,
    password varchar(75)  NOT NULL,
    permissions int  NOT NULL,
    host_num int  NOT NULL,
    CONSTRAINT hostLogin_pk PRIMARY KEY (username)
);

-- Table: orgLogin
CREATE TABLE orgLogin (
    username varchar(25)  NOT NULL,
    password varchar(75)  NOT NULL,
    permissions int  NOT NULL,
    org int  NOT NULL,
    CONSTRAINT orgLogin_pk PRIMARY KEY (username)
);

-- Table: proj_category
CREATE TABLE proj_category (
    number int  NOT NULL,
    cat varchar(50)  NOT NULL,
    CONSTRAINT proj_category_pk PRIMARY KEY (number)
);

-- Table: proj_restriction
CREATE TABLE proj_restriction (
    number int  NOT NULL,
    resstriction varchar(50)  NOT NULL,
    CONSTRAINT proj_restriction_pk PRIMARY KEY (number)
);

-- Table: volLogin
CREATE TABLE volLogin (
    username varchar(25)  NOT NULL,
    password varchar(75)  NOT NULL,
    permissions int  NOT NULL,
    vol_number int  NOT NULL,
    CONSTRAINT volLogin_pk PRIMARY KEY (username)
);

-- Table: volunteers
CREATE TABLE volunteers (
    vol_number int  NOT NULL,
    umID int  NOT NULL,
    wedID varchar(30)  NOT NULL,
    first_name varchar(20)  NOT NULL,
    last_name varchar(20)  NOT NULL,
    email varchar(50)  NOT NULL,
    provide_transport varchar(3)  NOT NULL,
    restrictions varchar(100)  NOT NULL,
    phone_numbers int  NOT NULL,
    organization int  NULL,
    project int  NULL,
    CONSTRAINT volunteers_pk PRIMARY KEY (vol_number)
);

-- foreign keys
-- Reference: Approvals_Committee_Members (table: Approvals)
ALTER TABLE Approvals ADD CONSTRAINT Approvals_Committee_Members
    FOREIGN KEY (approver)
    REFERENCES Committee_Members (number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: Approvals_Projects (table: Approvals)
ALTER TABLE Approvals ADD CONSTRAINT Approvals_Projects
    FOREIGN KEY (project)
    REFERENCES Projects (Project_Number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: Projects_Host (table: Projects)
ALTER TABLE Projects ADD CONSTRAINT Projects_Host
    FOREIGN KEY (Host)
    REFERENCES Host (host_number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: Projects_Transportation (table: Projects)
ALTER TABLE Projects ADD CONSTRAINT Projects_Transportation
    FOREIGN KEY (transportation)
    REFERENCES Transportation (number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: Projects_proj_category (table: Projects)
ALTER TABLE Projects ADD CONSTRAINT Projects_proj_category
    FOREIGN KEY (category)
    REFERENCES proj_category (number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: Team_Leaders_Projects (table: Team_Leaders)
ALTER TABLE Team_Leaders ADD CONSTRAINT Team_Leaders_Projects
    FOREIGN KEY (tl_project)
    REFERENCES Projects (Project_Number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: hostLogin_Host (table: hostLogin)
ALTER TABLE hostLogin ADD CONSTRAINT hostLogin_Host
    FOREIGN KEY (host_num)
    REFERENCES Host (host_number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: orgLogin_Organization (table: orgLogin)
ALTER TABLE orgLogin ADD CONSTRAINT orgLogin_Organization
    FOREIGN KEY (org)
    REFERENCES Organization (number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: volLogin_volunteers (table: volLogin)
ALTER TABLE volLogin ADD CONSTRAINT volLogin_volunteers
    FOREIGN KEY (vol_number)
    REFERENCES volunteers (vol_number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: volunteers_Organization (table: volunteers)
ALTER TABLE volunteers ADD CONSTRAINT volunteers_Organization
    FOREIGN KEY (organization)
    REFERENCES Organization (number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: volunteers_Projects (table: volunteers)
ALTER TABLE volunteers ADD CONSTRAINT volunteers_Projects
    FOREIGN KEY (project)
    REFERENCES Projects (Project_Number)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- End of file.

