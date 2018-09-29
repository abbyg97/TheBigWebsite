-- populates tables
sp_configure 'show advanced options', 1;
RECONFIGURE;
GO  --Added
sp_configure 'Ad Hoc Distributed Queries', 1;
RECONFIGURE;
GO

INSERT INTO Host VALUES (1,  "Kate", "Brown", "6628010399", NULL, "katebrown@gmail.com", "Julia", "Brown", "6623548172", "jbrown@gmail.com");

INSERT INTO Transportation VALUES ("Van", 1), ("Bus", 2);

INSERT INTO proj_restriction VALUES (1, "Paint"), (2, "Powertools"), (3, "Medium Lifting"), (4, "Heavy Lifting"), (5, "Exposure to outdoor allergens (grass, pollen, etc.)"), (6, "Chemicals"), (7, "Climbing"), (8, "Animals");

INSERT INTO proj_category VALUES (1, "Nonprofit"), (2, "Chruch"), (3, "Government or Government Agency"), (4, "Residential, yard work"), (5, "Residential, basic renovations"), (6, "Residential, cleaning"), (7, "Small Business"), (8, "K-12 School"), (9, "University");

INSERT INTO Projects VALUES (1, 1, "692 Olive Branch Road, Oxford, MS, 38655", 4, 8, NULL, 2, "Landscaping", NULL, "Go down 7", "no", NULL, 5);

INSERT INTO Committee_Members VALUES (1, "Abby", "Garrett"), (2, "Sarah", "Smith"), (3, "Marguerite", "Marquez");

INSERT INTO Approvals VALUES (1, 1, "no", "none", 1), (1, 1, "no", "none", 2), (1, 2, "no", "none", 3);

--https://stackoverflow.com/questions/3635166/how-to-import-csv-file-to-mysql-table
LOAD DATA LOCAL INFILE "/home/agarrett/organizationsCSV.csv" INTO TABLE Organization FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n' (number, name, total_members);

INSERT INTO Team_Leaders VALUES (1, "Hunter", "Johnson", "6016240922", "hjohnson@go.com", 1), (2, "Haleigh", "Hunter", "7314137347", "hurt@gmail.com", 1), (3, "Abby", "Garrett", "2053545133", "agarrett@gmail.com", 1);

INSERT INTO volunteers VALUES (1, "Libby", "Weir", "libbyw@gmail.com", "yes", NULL, "8325159977", 1, 1), (2,"Alexander", "Roy", "avgroy@gmail.com", "no", NULL, "6155122899", NULL, 1), (3, "Neely", "Francis", "fran.nel@gmail.com", "yes", NULL, "2059945888", 1, 1);
