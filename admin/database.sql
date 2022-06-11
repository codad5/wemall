CREATE TABLE admins (
	admin_id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    admin_name varchar(255) NOT NULL,
    email varchar(300) NOT NULL,
    passwords varchar(300) NOT NULL,
    addedby varchar(300) NOT NULL,
    verified boolean NOT NULL,
    company_id varchar(300) NOT NULL,
    datejoined datetime NOT NULL

);

CREATE TABLE company {
    company_id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    company_unique varchar(300) NOT NULL, 
    company_name varchar(300) NOT NULL,
    

}
CREATE TABLE products (
	product_id_private int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	product_id varchar(255) NOT NULL,
    product_name varchar(255) NOT NULL,
    product_size varchar(300) NOT NULL,
    product_gender varchar(300) NOT NULL,
    product_category varchar(300) NOT NULL,
    product_price int(11) NOT NULL,
    discount_method varchar(300) NOT NULL,
    product_discount int(11) NOT NULL,
    product_quantity int(11) NOT NULL,
    product_image1 varchar(300) NOT NULL,
    product_image2 varchar(300) NOT NULL,
    product_image3 varchar(300) NOT NULL,
    product_image4 varchar(300) NOT NULL,
    product_image5 varchar(300) NOT NULL,
    product_perm_link varchar(300) NOT NULL,
    addedby varchar(300) NOT NULL,
    active_status varchar(300) NOT NULL,
    dateadded datetime NOT NULL

);
CREATE TABLE product_changes (
	product_id_private int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	product_id varchar(255) NOT NULL,
    product_name varchar(255) NOT NULL,
    product_category varchar(300) NOT NULL,
    product_price int(11) NOT NULL,
    discount_method varchar(300) NOT NULL,
    product_discount int(11) NOT NULL,
    product_quantity int(11) NOT NULL,
    total_delivery int(11) NOT NULL,
    changedBy varchar(300) NOT NULL,
    changed_made varchar(300) NOT NULL,
    dateChanged datetime NOT NULL

);

INSERT INTO `admins` (`admin_id`, `admin_name`, `email`, `passwords`, `verified`, `datejoined`) VALUES (NULL, 'Admin', 'aniezeoformic@gmail.com', '$2y$10$52GLgHMpjnADmbVs8imRzOnfDsWX93lJPUyJqHkeG3jg6mV8d8.C6', '1', '2022-02-14 16:48:53.000000');