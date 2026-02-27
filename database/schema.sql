CREATE DATABASE IF NOT EXISTS bnc_social_network CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bnc_social_network;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','recruiter','admin') NOT NULL DEFAULT 'user',
  status ENUM('active','banned','pending') NOT NULL DEFAULT 'active',
  email_verification_token VARCHAR(64) DEFAULT NULL,
  email_verified_at DATETIME NULL,
  premium_until DATETIME NULL,
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  INDEX idx_users_role_status(role,status)
);

CREATE TABLE profiles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  slug VARCHAR(120) NOT NULL UNIQUE,
  first_name VARCHAR(80) DEFAULT NULL,
  last_name VARCHAR(80) DEFAULT NULL,
  headline VARCHAR(180) DEFAULT NULL,
  bio TEXT,
  avatar_path VARCHAR(255) DEFAULT NULL,
  banner_path VARCHAR(255) DEFAULT NULL,
  location VARCHAR(120) DEFAULT NULL,
  website VARCHAR(255) DEFAULT NULL,
  privacy_level ENUM('public','connections','private') NOT NULL DEFAULT 'public',
  profile_views INT UNSIGNED NOT NULL DEFAULT 0,
  locale VARCHAR(10) NOT NULL DEFAULT 'fr',
  dark_mode TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE experiences (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  company_name VARCHAR(180) NOT NULL,
  title VARCHAR(180) NOT NULL,
  location VARCHAR(120) DEFAULT NULL,
  description TEXT,
  start_date DATE NOT NULL,
  end_date DATE DEFAULT NULL,
  is_current TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_exp_user_dates(user_id,start_date,end_date)
);

CREATE TABLE education (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  school VARCHAR(180) NOT NULL,
  degree VARCHAR(120) DEFAULT NULL,
  field_of_study VARCHAR(120) DEFAULT NULL,
  start_year YEAR DEFAULT NULL,
  end_year YEAR DEFAULT NULL,
  description TEXT,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE skills (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

CREATE TABLE user_skills (
  user_id BIGINT UNSIGNED NOT NULL,
  skill_id BIGINT UNSIGNED NOT NULL,
  endorsements_count INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (user_id,skill_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE
);

CREATE TABLE connection_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sender_id BIGINT UNSIGNED NOT NULL,
  receiver_id BIGINT UNSIGNED NOT NULL,
  status ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  UNIQUE KEY uq_request(sender_id,receiver_id),
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE connections (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  connected_user_id BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  UNIQUE KEY uq_connection(user_id,connected_user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (connected_user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE posts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  image_path VARCHAR(255) DEFAULT NULL,
  visibility ENUM('public','connections','private') NOT NULL DEFAULT 'public',
  tags VARCHAR(255) DEFAULT NULL,
  shared_post_id BIGINT UNSIGNED DEFAULT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (shared_post_id) REFERENCES posts(id) ON DELETE SET NULL,
  INDEX idx_posts_feed(created_at,visibility)
);

CREATE TABLE comments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_comments_post(post_id,created_at)
);

CREATE TABLE likes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  UNIQUE KEY uq_like(post_id,user_id),
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE conversations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_by BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE conversation_participants (
  conversation_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  joined_at DATETIME NOT NULL,
  PRIMARY KEY (conversation_id,user_id),
  FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  conversation_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  body TEXT NOT NULL,
  seen_at DATETIME DEFAULT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_messages_conversation(conversation_id,created_at)
);

CREATE TABLE companies (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(180) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  description TEXT,
  website VARCHAR(255) DEFAULT NULL,
  logo_path VARCHAR(255) DEFAULT NULL,
  banner_path VARCHAR(255) DEFAULT NULL,
  industry VARCHAR(120) DEFAULT NULL,
  size_range VARCHAR(60) DEFAULT NULL,
  location VARCHAR(120) DEFAULT NULL,
  created_by BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE company_admins (
  company_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  role ENUM('owner','admin') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (company_id,user_id),
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE jobs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  company_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(120) DEFAULT NULL,
  employment_type ENUM('full_time','part_time','contract','internship') NOT NULL DEFAULT 'full_time',
  salary_min INT DEFAULT NULL,
  salary_max INT DEFAULT NULL,
  is_remote TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('draft','published','closed') NOT NULL DEFAULT 'published',
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
  INDEX idx_jobs_search(status,location,created_at)
);

CREATE TABLE job_applications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  job_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  cv_path VARCHAR(255) NOT NULL,
  cover_letter TEXT,
  status ENUM('submitted','reviewed','interview','rejected','hired') NOT NULL DEFAULT 'submitted',
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  UNIQUE KEY uq_application(job_id,user_id),
  FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  type ENUM('like','comment','connection','message','application') NOT NULL,
  title VARCHAR(190) NOT NULL,
  payload JSON DEFAULT NULL,
  read_at DATETIME DEFAULT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_notifications_user(user_id,read_at,created_at)
);

INSERT INTO users (email,password_hash,role,status,email_verified_at,created_at,updated_at) VALUES
('admin@bnc.local','$2y$10$67VUj8wJHJsBscqY2Kzygeqrw4WodfgJ8f6bfQ0fD2BcI26OgwBFS','admin','active',NOW(),NOW(),NOW()),
('alice@bnc.local','$2y$10$67VUj8wJHJsBscqY2Kzygeqrw4WodfgJ8f6bfQ0fD2BcI26OgwBFS','user','active',NOW(),NOW(),NOW()),
('recruiter@bnc.local','$2y$10$67VUj8wJHJsBscqY2Kzygeqrw4WodfgJ8f6bfQ0fD2BcI26OgwBFS','recruiter','active',NOW(),NOW(),NOW());

INSERT INTO profiles (user_id,slug,first_name,last_name,headline,bio,privacy_level,created_at,updated_at) VALUES
(1,'admin','Super','Admin','Platform Admin','Compte administration','public',NOW(),NOW()),
(2,'alice','Alice','Martin','Développeuse PHP Senior','Passionnée de backend scalable','public',NOW(),NOW()),
(3,'recruiter','Nina','RH','Talent Acquisition Specialist','Recrutement tech','public',NOW(),NOW());

INSERT INTO skills (name,created_at,updated_at) VALUES ('PHP',NOW(),NOW()),('MySQL',NOW(),NOW()),('Architecture Logicielle',NOW(),NOW());
INSERT INTO user_skills (user_id,skill_id,endorsements_count) VALUES (2,1,12),(2,2,9),(2,3,7);

INSERT INTO companies (name,slug,description,created_by,created_at,updated_at) VALUES
('BNC Tech','bnc-tech','Entreprise tech orientée produits SaaS',3,NOW(),NOW());
INSERT INTO company_admins (company_id,user_id,role) VALUES (1,3,'owner');
INSERT INTO jobs (company_id,title,description,location,employment_type,status,created_at,updated_at) VALUES
(1,'Senior PHP Engineer','Concevoir des architectures robustes','Paris','full_time','published',NOW(),NOW());
