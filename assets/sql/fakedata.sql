-- Insert fake users with bcrypt-hashed passwords
INSERT INTO users (name, email, password, role, status, created_at)
VALUES
    ('Youssef El Amrani', 'youssef.elamrani@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Fatima Zahra Benjelloun', 'fatima.benjelloun@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Mehdi El Fassi', 'mehdi.elfassi@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'teacher', 'active', NOW()), -- password: Password123
    ('Amina Bouzid', 'amina.bouzid@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'teacher', 'active', NOW()), -- password: Password123
    ('ahmed admin', 'admin@youdemy.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'admin', 'active', NOW()), -- password: Password123
    ('Leila Chraibi', 'leila.chraibi@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Omar El Khatib', 'omar.elkhatib@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'archived', NOW()), -- password: Password123
    ('Nadia El Fassi', 'nadia.elfassi@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Hassan El Ouazzani', 'hassan.elouazzani@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Sanaa El Moutawakil', 'sanaa.elmoutawakil@example.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()), -- password: Password123
    ('Student Student', 'student@youdemy.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'student', 'active', NOW()),-- password: Password123
    ('Teacher Teacher', 'teacher@youdemy.com', '$2y$10$tSusQskmlD3zc6VGK.iMw.c83u8R4p5l24tlcnwq1dUAF/9ifZBbe', 'teacher', 'active', NOW()); -- password: Password123

-- Insert fake categories
INSERT INTO categories (name, created_at)
VALUES
    ('Web Development', NOW()),
    ('Data Science', NOW()),
    ('Mobile Development', NOW()),
    ('Artificial Intelligence', NOW()),
    ('Cybersecurity', NOW());

-- Insert fake courses
INSERT INTO courses (name, description, category_id, created_by, created_at)
VALUES
    ('Learn JavaScript', 'Master the basics of JavaScript and build interactive web applications.', 1, 3, NOW()),
    ('Python for Data Science', 'Learn Python for data analysis, visualization, and machine learning.', 2, 4, NOW()),
    ('React for Beginners', 'Build modern web apps with React and master component-based development.', 1, 3, NOW()),
    ('Advanced Python Programming', 'Take your Python skills to the next level with advanced concepts and techniques.', 2, 4, NOW()),
    ('Flutter for Mobile Development', 'Build cross-platform mobile apps with Flutter and Dart.', 3, 3, NOW()),
    ('Introduction to Cybersecurity', 'Learn the fundamentals of cybersecurity and how to protect systems.', 5, 4, NOW()),
    ('Machine Learning Basics', 'Understand the basics of machine learning and build your first models.', 4, 3, NOW());

-- Insert fake tags
INSERT INTO tags (name, created_at)
VALUES
    ('JavaScript', NOW()),
    ('Python', NOW()),
    ('React', NOW()),
    ('Node.js', NOW()),
    ('Machine Learning', NOW()),
    ('Flutter', NOW()),
    ('Cybersecurity', NOW()),
    ('Data Analysis', NOW()),
    ('Web Development', NOW()),
    ('Mobile Development', NOW());

-- Insert fake course_tags relationships
INSERT INTO course_tags (course_id, tag_id)
VALUES
    (1, 1), (1, 9), -- JavaScript, Web Development
    (2, 2), (2, 5), (2, 8), -- Python, Machine Learning, Data Analysis
    (3, 1), (3, 3), (3, 9), -- JavaScript, React, Web Development
    (4, 2), (4, 5), -- Python, Machine Learning
    (5, 6), (5, 10), -- Flutter, Mobile Development
    (6, 7), -- Cybersecurity
    (7, 2), (7, 5); -- Python, Machine Learning

-- Insert fake student_course relationships
INSERT INTO student_course (course_id, student_id, enrolledAt)
VALUES
    (1, 1, NOW()), -- Youssef enrolled in JavaScript
    (1, 2, NOW()), -- Fatima enrolled in JavaScript
    (2, 1, NOW()), -- Youssef enrolled in Python for Data Science
    (3, 2, NOW()), -- Fatima enrolled in React for Beginners
    (4, 6, NOW()), -- Leila enrolled in Advanced Python Programming
    (5, 7, NOW()), -- Omar enrolled in Flutter for Mobile Development
    (6, 8, NOW()), -- Nadia enrolled in Introduction to Cybersecurity
    (7, 9, NOW()); -- Hassan enrolled in Machine Learning Basics


    -- more fake data  

    -- Insert 30 more fake courses
INSERT INTO courses (name, description, category_id, created_by, created_at)
VALUES
    ('Advanced JavaScript Techniques', 'Dive deep into advanced JavaScript concepts like closures, promises, and async/await.', 1, 3, NOW()),
    ('Data Visualization with Python', 'Learn to create stunning visualizations using Matplotlib, Seaborn, and Plotly.', 2, 4, NOW()),
    ('React Native for Mobile Apps', 'Build cross-platform mobile apps using React Native and JavaScript.', 3, 3, NOW()),
    ('Deep Learning with TensorFlow', 'Explore deep learning concepts and build neural networks with TensorFlow.', 4, 4, NOW()),
    ('Ethical Hacking Basics', 'Learn the basics of ethical hacking and penetration testing.', 5, 3, NOW()),
    ('Full-Stack Web Development', 'Master both front-end and back-end development to become a full-stack developer.', 1, 4, NOW()),
    ('Natural Language Processing', 'Understand NLP techniques and build applications like chatbots and sentiment analysis.', 4, 3, NOW()),
    ('iOS Development with Swift', 'Learn to build iOS apps using Swift and Xcode.', 3, 4, NOW()),
    ('Cloud Security Fundamentals', 'Understand the principles of securing cloud-based systems and applications.', 5, 3, NOW()),
    ('Angular for Web Development', 'Build dynamic web applications using Angular and TypeScript.', 1, 4, NOW()),
    ('Big Data with Hadoop', 'Learn to process and analyze big data using Hadoop and Spark.', 2, 3, NOW()),
    ('Game Development with Unity', 'Create 2D and 3D games using Unity and C#.', 3, 4, NOW()),
    ('Blockchain and Cryptocurrency', 'Understand blockchain technology and how cryptocurrencies work.', 5, 3, NOW()),
    ('DevOps Essentials', 'Learn the basics of DevOps, including CI/CD pipelines and containerization.', 5, 4, NOW()),
    ('Advanced React Patterns', 'Explore advanced React patterns like higher-order components and render props.', 1, 3, NOW()),
    ('Data Engineering with Python', 'Learn to build data pipelines and ETL processes using Python.', 2, 4, NOW()),
    ('Android Development with Kotlin', 'Build Android apps using Kotlin and Android Studio.', 3, 3, NOW()),
    ('Computer Vision with OpenCV', 'Learn to process and analyze images and videos using OpenCV.', 4, 4, NOW()),
    ('Network Security Basics', 'Understand the fundamentals of securing computer networks.', 5, 3, NOW()),
    ('Vue.js for Web Development', 'Build modern web applications using Vue.js and JavaScript.', 1, 4, NOW()),
    ('Time Series Analysis', 'Learn to analyze and forecast time series data using Python.', 2, 3, NOW()),
    ('Augmented Reality Development', 'Create AR experiences using ARKit and ARCore.', 3, 4, NOW()),
    ('Reinforcement Learning', 'Explore reinforcement learning algorithms and applications.', 4, 3, NOW()),
    ('Secure Coding Practices', 'Learn to write secure code and avoid common vulnerabilities.', 5, 4, NOW()),
    ('GraphQL for APIs', 'Build and consume GraphQL APIs for modern web applications.', 1, 3, NOW()),
    ('Data Mining Techniques', 'Learn to extract valuable insights from large datasets.', 2, 4, NOW()),
    ('Cross-Platform App Development', 'Build apps that run on multiple platforms using frameworks like Flutter and React Native.', 3, 3, NOW()),
    ('AI for Business', 'Understand how AI can be applied to solve real-world business problems.', 4, 4, NOW()),
    ('Incident Response and Forensics', 'Learn to respond to cybersecurity incidents and conduct digital forensics.', 5, 3, NOW()),
    ('Web Accessibility', 'Learn to build websites that are accessible to all users, including those with disabilities.', 1, 4, NOW());



    -- Insert fake course_tags relationships for the new courses
INSERT INTO course_tags (course_id, tag_id)
VALUES
    (8, 1), (8, 9), -- Advanced JavaScript Techniques: JavaScript, Web Development
    (9, 2), (9, 8), -- Data Visualization with Python: Python, Data Analysis
    (10, 1), (10, 3), (10, 10), -- React Native for Mobile Apps: JavaScript, React, Mobile Development
    (11, 2), (11, 5), -- Deep Learning with TensorFlow: Python, Machine Learning
    (12, 7), -- Ethical Hacking Basics: Cybersecurity
    (13, 1), (13, 9), -- Full-Stack Web Development: JavaScript, Web Development
    (14, 2), (14, 5), -- Natural Language Processing: Python, Machine Learning
    (15, 10), -- iOS Development with Swift: Mobile Development
    (16, 7), -- Cloud Security Fundamentals: Cybersecurity
    (17, 1), (17, 9), -- Angular for Web Development: JavaScript, Web Development
    (18, 2), (18, 8), -- Big Data with Hadoop: Python, Data Analysis
    (19, 10), -- Game Development with Unity: Mobile Development
    (20, 7), -- Blockchain and Cryptocurrency: Cybersecurity
    (21, 7), -- DevOps Essentials: Cybersecurity
    (22, 1), (22, 3), (22, 9), -- Advanced React Patterns: JavaScript, React, Web Development
    (23, 2), (23, 8), -- Data Engineering with Python: Python, Data Analysis
    (24, 10), -- Android Development with Kotlin: Mobile Development
    (25, 2), (25, 5), -- Computer Vision with OpenCV: Python, Machine Learning
    (26, 7), -- Network Security Basics: Cybersecurity
    (27, 1), (27, 9), -- Vue.js for Web Development: JavaScript, Web Development
    (28, 2), (28, 8), -- Time Series Analysis: Python, Data Analysis
    (29, 10), -- Augmented Reality Development: Mobile Development
    (30, 2), (30, 5), -- Reinforcement Learning: Python, Machine Learning
    (31, 7), -- Secure Coding Practices: Cybersecurity
    (32, 1), (32, 9), -- GraphQL for APIs: JavaScript, Web Development
    (33, 2), (33, 8), -- Data Mining Techniques: Python, Data Analysis
    (34, 10), -- Cross-Platform App Development: Mobile Development
    (35, 2), (35, 5), -- AI for Business: Python, Machine Learning
    (36, 7), -- Incident Response and Forensics: Cybersecurity
    (37, 1), (37, 9); -- Web Accessibility: JavaScript, Web Development