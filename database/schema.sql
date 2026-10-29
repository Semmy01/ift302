-- =====================================================================
-- UIISP Database Schema & Mock Seed Data
-- University of Ibadan Internet Service Provider
-- database/schema.sql (Import this file in phpMyAdmin or via MySQL CLI)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS ift302 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ift302;

-- Table: user
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matric VARCHAR(50) NOT NULL UNIQUE,
    fullname VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: subscription_history
CREATE TABLE IF NOT EXISTS subscription_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    plan VARCHAR(100) NOT NULL,
    amount INT NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Realistic Mock Seed Data
-- All accounts use password: Password123
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE subscription_history;
TRUNCATE TABLE user;
SET FOREIGN_KEY_CHECKS = 1;

-- Users (All passwords are 'Password123')
INSERT INTO user (matric, fullname, phone, email, password, created_at) VALUES
('219084', 'Babatunde Adeleke', '08031234567', 'b.adeleke@ui.edu.ng', '$2y$10$DIipygCECDD8fW0YhWmxweWsBaCEOBWHesoY7wtlvae5U9NuNxASm', DATE_SUB(NOW(), INTERVAL 40 DAY)),
('UI/STF/4821', 'Dr. Folashade Alabi', '08059876543', 'f.alabi@ui.edu.ng', '$2y$10$DIipygCECDD8fW0YhWmxweWsBaCEOBWHesoY7wtlvae5U9NuNxASm', DATE_SUB(NOW(), INTERVAL 75 DAY)),
('224105', 'Chioma Okonkwo', '08123456789', 'c.okonkwo@ui.edu.ng', '$2y$10$DIipygCECDD8fW0YhWmxweWsBaCEOBWHesoY7wtlvae5U9NuNxASm', DATE_SUB(NOW(), INTERVAL 50 DAY)),
('238912', 'Ibrahim Danjuma', '07011223344', 'i.danjuma@ui.edu.ng', '$2y$10$DIipygCECDD8fW0YhWmxweWsBaCEOBWHesoY7wtlvae5U9NuNxASm', DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Subscriptions History
INSERT INTO subscription_history (user_id, plan, amount, `date`) VALUES
-- Babatunde Adeleke (Standard Plan - Active: 22 days remaining)
('219084', 'Standard Package', 10000, DATE_SUB(NOW(), INTERVAL 8 DAY)),
('219084', 'Standard Package', 10000, DATE_SUB(NOW(), INTERVAL 38 DAY)),

-- Dr. Folashade Alabi (Premium Plan - Active: 14 days remaining)
('UI/STF/4821', 'Premium Package', 20000, DATE_SUB(NOW(), INTERVAL 16 DAY)),
('UI/STF/4821', 'Premium Package', 20000, DATE_SUB(NOW(), INTERVAL 46 DAY)),
('UI/STF/4821', 'Standard Package', 10000, DATE_SUB(NOW(), INTERVAL 76 DAY)),

-- Chioma Okonkwo (Basic Plan - Expired: 35 days ago)
('224105', 'Basic Package', 5000, DATE_SUB(NOW(), INTERVAL 35 DAY));
