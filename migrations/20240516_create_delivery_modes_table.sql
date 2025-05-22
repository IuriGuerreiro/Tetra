-- Migration: Create delivery_modes table and update cpds table
-- Date: 2024-05-16

-- Create delivery_modes table
CREATE TABLE `delivery_modes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default delivery modes
INSERT INTO `delivery_modes` (`name`) VALUES
('Interactive Talk'),
('Workshop'),
('Interactive Talk + Workshop');

-- Add delivery_mode_id column to cpds table
ALTER TABLE `cpds`
ADD COLUMN `delivery_mode_id` int AFTER `course_procedures`,
ADD CONSTRAINT `fk_cpds_delivery_mode` FOREIGN KEY (`delivery_mode_id`) REFERENCES `delivery_modes` (`id`);

-- Update existing cpds to use the new delivery_mode_id
UPDATE `cpds` c
JOIN `delivery_modes` d ON c.delivery_mode = d.name
SET c.delivery_mode_id = d.id;

-- Remove the old delivery_mode column
ALTER TABLE `cpds`
DROP COLUMN `delivery_mode`; 