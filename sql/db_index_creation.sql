--add index
ALTER TABLE `libbook` ADD INDEX `bookTitle` (`Title`);
ALTER TABLE `libavtorname` ADD INDEX `avtorname` (`MiddleName`);
ALTER TABLE `libavtorname` ADD INDEX `avtorlastname` (`LastName`);

--add full text indexing
CREATE FULLTEXT INDEX libbook_title_full_text_idx ON libbook(Title);
CREATE FULLTEXT INDEX libavtorname_lastname_full_text_idx ON libavtorname(LastName);
CREATE FULLTEXT INDEX libavtorname_middlename_full_text_idx ON libavtorname(MiddleName);
CREATE FULLTEXT INDEX libavtorname_firstname_full_text_idx ON libavtorname(FirstName);