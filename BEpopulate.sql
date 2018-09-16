-- populates tables
INSERT INTO Host VALUES (1,  "Kate", "Brown", "6628010399", NULL, "katebrown@gmail.com", "Julia", "Brown", "6623548172", "jbrown@gmail.com");

INSERT INTO Transportation VALUES ("Van", 1), ("Bus", 2);

INSERT INTO Projects VALUES (1, 1, "692 Olive Branch Road, Oxford, MS, 38655", 4, 8, NULL, 2, "Landscaping", NULL, "Go down 7", "no", NULL, "Exposure to outdoor allergens (grass, pollen, etc.)");

INSERT INTO Committee_Members VALUES (1, "Abby", "Garrett"), (2, "Sarah", "Smith"), (3, "Marguerite", "Marquez");

INSERT INTO Approvals VALUES (1, 1, "no", "none", 1), (1, 1, "no", "none", 2), (1, 2, "no", "none", 3);

--https://stackoverflow.com/questions/3635166/how-to-import-csv-file-to-mysql-table
LOAD DATA LOCAL INFILE "/home/agarrett/organizationsCSV.csv" INTO TABLE Organization FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n' (number, name, total_members);

INSERT INTO Team_Leaders VALUES (1, "Hunter", "Johnson", "6016240922", "hjohnson@go.com", 1), (2, "Haleigh", "Hunter", "7314137347", "hurt@gmail.com", 1), (3, "Abby", "Garrett", "2053545133", "agarrett@gmail.com", 1);

INSERT INTO volunteers VALUES (1, "Libby", "Weir", "yes", NULL, "8325159977", 1, 1), (2,"Alexander", "Roy", "no", NULL, "6155122899", NULL, 1), (3, "Neely", "Francis", "yes", NULL, "2059945888", 1, 1);
