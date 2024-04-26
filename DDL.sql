set global net_buffer_length=1000000; 
set global max_allowed_packet=1000000000;

-- Users Table
CREATE TABLE Users (
    ssn CHAR(5) PRIMARY KEY,
    name CHAR(10),
    email VARCHAR(50),
    password VARCHAR(255),
    birthdate DATE,
    diabetesType VARCHAR(20),
    sex CHAR(1),
    profilePic MEDIUMBLOB
);

-- Feedback Table
CREATE TABLE Feedback (
    feedbackID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    date DATE,
    time TIME,
    comment VARCHAR(255),
    email VARCHAR(50)
);

-- ReportConfiguration Table
CREATE TABLE ReportConfiguration (
    configID INT PRIMARY KEY AUTO_INCREMENT,
    reportType VARCHAR(10)
);

-- Report Table
CREATE TABLE Report (
    reportID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    configID INT REFERENCES ReportConfiguration(configID),
    startDate DATE,
    endDate DATE,
    time TIME,
    lowestBloodSugar DECIMAL(5,2),
    highestBloodSugar DECIMAL(5,2),
    avgBloodSugar DECIMAL(5,2),
    stdDev DECIMAL(5,2),
    countLow INT(4),
    countHigh INT(4),
    countNormal INT(4)
);

-- Medicine Table
CREATE TABLE Medicine (
    medID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    name VARCHAR(255),
    description VARCHAR(255),
    image MEDIUMBLOB
);


-- MedicationReminder Table
CREATE TABLE MedicationReminder (
    medRemID INT PRIMARY KEY AUTO_INCREMENT,
    medID INT REFERENCES Medicine(medID),
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    dosage DECIMAL(5,2),
    unit VARCHAR(255),
    sDate DATETIME,
    eDate DATETIME,
    remType VARCHAR(10),
    status INT(1)
);

-- BSTestingAlert Table
CREATE TABLE BSTestingAlert (
    testingID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    sDate DATETIME,
    eDate DATETIME,
    alertType VARCHAR(10),
    status INT(1)
);

-- Appointment Table
CREATE TABLE Appointment (
    apptID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    sDate DATETIME,
    eDate DATETIME,
    location VARCHAR(100),
    remType VARCHAR(10),
    status INT(1)
);

-- Records Table
CREATE TABLE Records (
    recordID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    time TIME,
    date DATE,
    recordType VARCHAR(20)
);
-- INSERT statements for Records table
INSERT INTO Records (ssn, time, date, recordType) VALUES
('U2072', '08:30:00', '2024-03-01', 'Blood Sugar'),
('U2072', '09:45:00', '2024-03-02', 'Blood Sugar'),
('U2072', '10:15:00', '2024-03-03', 'Blood Sugar'),
('U2072', '11:30:00', '2024-03-04', 'Blood Sugar'),
('U2072', '12:45:00', '2024-03-05', 'Blood Sugar'),
('U2072', '13:15:00', '2024-03-06', 'Blood Sugar'),
('U2072', '14:30:00', '2024-03-07', 'Blood Sugar'),
('U2072', '15:45:00', '2024-03-08', 'Blood Sugar'),
('U2072', '16:15:00', '2024-03-09', 'Blood Sugar'),
('U2072', '17:30:00', '2024-03-10', 'Blood Sugar');

INSERT INTO Records (ssn, time, date, recordType) VALUES
('U2147', '08:30:00', '2024-04-01', 'Blood Sugar'),
('U2147', '09:45:00', '2024-04-02', 'Blood Sugar'),
('U2147', '10:15:00', '2024-04-03', 'Blood Sugar'),
('U2147', '11:30:00', '2024-04-04', 'Blood Sugar'),
('U2147', '12:45:00', '2024-04-05', 'Blood Sugar'),
('U2147', '13:15:00', '2024-04-06', 'Blood Sugar'),
('U2147', '14:30:00', '2024-04-07', 'Blood Sugar'),
('U2147', '15:45:00', '2024-04-08', 'Blood Sugar'),
('U2147', '16:15:00', '2024-04-09', 'Blood Sugar'),
('U2147', '17:30:00', '2024-04-10', 'Blood Sugar');

-- MedicationIntake Table
CREATE TABLE MedicationIntake (
    medIntakeID INT PRIMARY KEY AUTO_INCREMENT,
    medID INT REFERENCES Medicine(medID),
    recordID INT REFERENCES Records(recordID),
    dosage DECIMAL(5,2),
    unit VARCHAR(255)
);

-- BloodPressure Table
CREATE TABLE BloodPressure (
    bpID INT PRIMARY KEY AUTO_INCREMENT,
    recordID INT REFERENCES Records(recordID),
    systolic INT(5),
    diastolic INT(5)
);

-- Meal Table
CREATE TABLE Meal (
    mealID INT PRIMARY KEY AUTO_INCREMENT,
    recordID INT REFERENCES Records(recordID),
    mealType VARCHAR(50),
    foodItem VARCHAR(255)
);

-- BodyWeight Table
CREATE TABLE BodyWeight (
    weightID INT PRIMARY KEY AUTO_INCREMENT,
    recordID INT REFERENCES Records(recordID),
    weightValue DECIMAL(5,2)
);

-- InsulinDose Table
CREATE TABLE InsulinDose (
    insulinID INT PRIMARY KEY AUTO_INCREMENT,
    recordID INT REFERENCES Records(recordID),
    dosage DECIMAL(4,2)
);

-- BloodSugar Table
CREATE TABLE BloodSugar (
    bsID INT PRIMARY KEY AUTO_INCREMENT,
    recordID INT REFERENCES Records(recordID),
    value DECIMAL(5,2),
    timing VARCHAR(20)
);

-- INSERT statements for BloodSugar table
INSERT INTO BloodSugar (recordID, value, timing) VALUES
(1, 120.5, 'Fasting'),
(2, 110.8, 'Before Meal'),
(3, 130.3, 'After Meal'),
(4, 140.6, 'Bedtime'),
(5, 125.2, 'Fasting'),
(6, 115.7, 'Before Meal'),
(7, 128.9, 'After Meal'),
(8, 135.4, 'Bedtime'),
(9, 145.1, 'Fasting'),
(10, 118.6, 'Before Meal');

INSERT INTO BloodSugar (recordID, value, timing) VALUES
(12, 120.5, 'Fasting'),
(13, 110.8, 'Before Meal'),
(14, 140.6, 'Bedtime'),
(15, 125.2, 'Fasting'),
(16, 115.7, 'Before Meal'),
(17, 128.9, 'After Meal'),
(18, 135.4, 'Bedtime'),
(19, 145.1, 'Fasting'),
(20, 145.1, 'Fasting'),
(21, 118.6, 'Before Meal');
