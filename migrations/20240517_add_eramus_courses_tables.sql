-- TETRA Educational Program Database Migration
-- Based on the TETRA Session Overview document

-- Create main subjects/programs table
CREATE TABLE subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create introductions table (each subject can have multiple introduction sessions)
CREATE TABLE introductions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Create practicals table (each subject can have multiple practical sessions)
CREATE TABLE practicals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Insert subjects based on TETRA Session Overview document
INSERT INTO subjects (name, description) VALUES
('Orientation Session', 'Students are provided with an overview of the course and its objectives. Team building session focusing on collaboration, communication, critical thinking and creativity.'),
('IT Hardware / Best Practices in IT', 'Covers basics of computer hardware including internal components, external peripherals, and management within modern business context. Focus on IT careers and pathways.'),
('Audio Hardware and Software', 'Introduction to audio production, equipment and tools both hardware and software, fundamentals of sound, the process of recording and releasing recordings.'),
('Video Hardware and Software', 'Introduction to video production, equipment and tools both hardware and software, fundamentals of video, technical process of producing video content.'),
('Audio / Visual Project', 'Students design and create their own Audio/Visual Production from storyboard to final product, recommended context of advertising a branded product.'),
('Streaming Hardware and Software', 'Introduction to video production equipment and tools for streaming, fundamentals of video streaming technology.'),
('Cyber Security', 'Developing and increasing awareness of cyber-security from a practical standpoint, learning to protect data and understand online risks.'),
('Introduction to Networking', 'Basic introduction to networking concepts covering OSI Layers, Basic Cabling Standards, Network Packets, and Basic Network Protocols.'),
('Introduction to Windows Active Directory', 'Introduction to Active Directory concepts including DNS, Domain Management, management of windows devices, user and groups, and basic GPO settings.'),
('3D Printing Hardware and Software', 'Introduction to different types of 3D printers and 3D printing technology across various industries, demonstration of 3D printer operation.'),
('Introduction to AI for Students', 'Foundational understanding of AI concepts, technologies, and applications with hands-on experience of basic AI algorithms and tools.'),
('Programming Training', 'Introduction to programming concepts through hands-on experience building and programming robots with LEGO Mindstorms.'),
('Introduction to Blockchain Technologies', 'Basic concepts of Blockchain Technology, data sharing in transparent manner, securing digital records in decentralized systems.'),
('Introduction to Esports', 'Introduction to esports training in healthy environment, focusing on physical, mental, emotional and social well-being with soft skills development.'),
('Founding Your Own Business', '10-day intensive course guiding students through developing and pitching business ideas, including market research and business planning.');

-- Insert introduction sessions based on document content
INSERT INTO introductions (subject_id, title, content) VALUES
-- Audio Hardware and Software introductions
(3, 'Introduction to Audio Production', 'Brief history to understand the concept of recording audio.'),
(3, 'Frequencies and Human Hearing', 'Understanding sound frequencies and how human hearing works.'),
(3, 'Audio Equipment Overview', 'What equipment is involved to start recording and producing audio at home.'),
(3, 'Recording Equipment and Techniques', 'Discussing different types of recording equipment and techniques.'),
(3, 'Recording Process Overview', 'Discussing the whole process of making a recording from start to finish.'),

-- Video Hardware and Software introductions
(4, 'Introduction to Video Production', 'Brief history to understand the concept of video production.'),
(4, 'Video Equipment and Techniques', 'Different types of video equipment and techniques and their installation.'),
(4, 'Video Editing Software', 'Different types of video editing and development software, the installation and management thereof.'),

-- 3D Printing introductions
(10, '3D Printing Industry Applications', 'Different types of 3D printing technology in architecture, model making, prop design, medical and space engineering.'),
(10, 'Industrial 3D Printing', 'Explanation of the pros and cons of using a 3d printer in a large scale industry.'),
(10, '3D Printing as Hobby', 'Using 3D printing as a hobby and demonstration of how a 3D printer works.'),
(10, '3D Printer Components', 'Different components of the printers and introduction to 3D software for beginners.'),
(10, '3D Model Workflow', 'How to download a 3d model from online resources, exportation to slicer software, importation to 3D printer.'),

-- AI introductions
(11, 'Understanding AI', 'Definition, historical context, and categories of AI (Narrow AI, General AI, Superintelligent AI).'),
(11, 'Applications of AI', 'Exploration of AI in healthcare, transportation, finance, and other sectors.'),
(11, 'Ethical Considerations', 'Discussion on data privacy, machine bias, and other ethical concerns related to AI.');

-- Insert practical sessions based on document content
INSERT INTO practicals (subject_id, title, description) VALUES
-- Audio practical
(3, 'Audio Practical', 'Students get practical experience merging knowledge and skills from previous sessions to create step by step production. Work with various audio samples to create final original product. Focus on creativity as part of final product.'),

-- Video practical
(4, 'Video Practical', 'Students get practical experience merging knowledge and skills from previous sessions to create step by step video production. Work with various video samples to create final original product. Focus on creativity as part of final product.'),

-- 3D Printing practical
(10, '3D Printing Practical', 'Students get practical experience merging knowledge and skills from previous sessions to create 3d printed object from design to product. Work with 3d model samples or design own 3d creation. Focus on creativity as part of final product.'),

-- AI practical
(11, 'Hands-on AI Workshop', 'Introduction to simple machine learning algorithms, data sets, and problem-solving using AI tools. Hands-on experience with rudimentary AI tools and algorithms.');

-- Create indexes for better performance
CREATE INDEX idx_subjects_name ON subjects(name);