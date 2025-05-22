-- Migration: Add new columns and remove old columns from cpds table
-- Date: 2024-05-16

-- Add new columns to cpds table
ALTER TABLE `cpds`
ADD COLUMN `duration_hours` int NOT NULL AFTER `title`,
ADD COLUMN `course_rationale` text COLLATE utf8mb4_general_ci AFTER `title`,
ADD COLUMN `course_objectives` text COLLATE utf8mb4_general_ci AFTER `course_rationale`,
ADD COLUMN `learning_outcomes` text COLLATE utf8mb4_general_ci AFTER `course_objectives`,
ADD COLUMN `course_procedures` text COLLATE utf8mb4_general_ci AFTER `learning_outcomes`,
ADD COLUMN `delivery_mode` varchar(255) COLLATE utf8mb4_general_ci AFTER `course_procedures`,
ADD COLUMN `assessment_procedure` text COLLATE utf8mb4_general_ci AFTER `delivery_mode`;

-- Remove old columns
ALTER TABLE `cpds`
DROP COLUMN `abstract`,
DROP COLUMN `registration_link`,
DROP COLUMN `description`;
