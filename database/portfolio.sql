CREATE TABLE admins (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,email VARCHAR(190) NOT NULL UNIQUE,password_hash VARCHAR(255) NOT NULL,created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
CREATE TABLE login_attempts (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,ip_address VARCHAR(45) NOT NULL,attempted_at DATETIME NOT NULL,INDEX idx_login_ip_time(ip_address,attempted_at)) ENGINE=InnoDB;
CREATE TABLE settings (setting_key VARCHAR(100) PRIMARY KEY,setting_value TEXT NOT NULL) ENGINE=InnoDB;
CREATE TABLE skills (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(150) NOT NULL,category VARCHAR(100) NOT NULL DEFAULT '',proficiency TINYINT UNSIGNED NULL,sort_order INT NOT NULL DEFAULT 0) ENGINE=InnoDB;
CREATE TABLE projects (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(200) NOT NULL,description TEXT NOT NULL,image_path VARCHAR(255) NOT NULL DEFAULT '',technologies VARCHAR(500) NOT NULL DEFAULT '',project_url VARCHAR(500) NOT NULL DEFAULT '',sort_order INT NOT NULL DEFAULT 0) ENGINE=InnoDB;
CREATE TABLE education (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,institution VARCHAR(200) NOT NULL,qualification VARCHAR(200) NOT NULL,period VARCHAR(100) NOT NULL DEFAULT '',details TEXT NOT NULL,sort_order INT NOT NULL DEFAULT 0) ENGINE=InnoDB;
CREATE TABLE experience (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,organization VARCHAR(200) NOT NULL,role VARCHAR(200) NOT NULL,period VARCHAR(100) NOT NULL DEFAULT '',details TEXT NOT NULL,sort_order INT NOT NULL DEFAULT 0) ENGINE=InnoDB;
CREATE TABLE achievements (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(200) NOT NULL,organization VARCHAR(200) NOT NULL DEFAULT '',achieved_on VARCHAR(100) NOT NULL DEFAULT '',details TEXT NOT NULL,sort_order INT NOT NULL DEFAULT 0) ENGINE=InnoDB;
CREATE TABLE messages (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,email VARCHAR(190) NOT NULL,subject VARCHAR(180) NOT NULL,message TEXT NOT NULL,is_read TINYINT(1) NOT NULL DEFAULT 0,created_at DATETIME NOT NULL,INDEX idx_messages_created(created_at)) ENGINE=InnoDB;
INSERT INTO settings(setting_key,setting_value) VALUES
('name','Francis I. Salcedo'),('introduction','Information Technology student at Negros Oriental State University'),('biography','I enjoy building practical web and desktop systems, from records management to internship tracking tools. Outside coding, I enjoy gaming, playing guitar, and singing.'),('email','salcedofrancis88@gmail.com'),('profile_image','images/profilepic.jpg');
INSERT INTO skills(name,category,sort_order) VALUES ('PHP','Web Development',1),('MySQL','Database',2),('HTML & CSS','Web Development',3),('JavaScript','Programming',4);
INSERT INTO projects(title,description,image_path,technologies,project_url,sort_order) VALUES
('Barangay Records Management System (BRMS)','A system for managing barangay records, document requests, blotter entries, announcements, and reports.','images/project1.jpg','Java · NetBeans · MySQL','',1),
('Internship Monitoring and Evaluation System (IMES)','A web system for intern records, progress monitoring, and evaluation.','images/project2.jpg','PHP · MySQL','',2),
('Electronic Vehicular Incident Report System','A web platform for online vehicular incident reporting.','images/project3.jpg','PHP · MySQL','',3),
('Adobe Animate Project','An advertisement project for Baiphone.','images/project4.jpg','Adobe Animate','https://www.facebook.com/share/v/19STJrRPkR/',4);
INSERT INTO education(institution,qualification,period,details,sort_order) VALUES ('Bayawan City East Central School (BCECS)','Elementary','2017','',1),('Bayawan National High School / Macario Delfin Bermejo National High School','High School','2024','',2),('Negros Oriental State University (NORSU)','BS Information Technology','Currently enrolled','',3);
INSERT INTO admins (email, password_hash)
VALUES (
    'salcedofrancis88@gmail.com',
    '$2y$10$L51NyRagm/gGLRXXmqhdtOsxMdegS6nUzpaKaWchcL0sNYLDc3BsS'
);
