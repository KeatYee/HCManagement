set global net_buffer_length=1000000; 
set global max_allowed_packet=1000000000;

-- Users Table
CREATE TABLE Users (
    ssn CHAR(5) PRIMARY KEY,
    name CHAR(10),
    email VARCHAR(50),
    password VARCHAR(255),
    role VARCHAR(255),
    birthdate DATE,
    diabetesType VARCHAR(20),
    sex CHAR(1),
    profilePic MEDIUMBLOB
);
-- INSERT admin & superuser for Users table
 --hash the password b4 insert
INSERT INTO Users(ssn,name,email,password,role) VALUES
('A0001','KeatYee','admin1@gmail.com','Admin123@','admin'),
('A0002','Esther','admin2@gmail.com','Admin123@','admin'),
('S0001','Diacare','diacare@gmail.com','Super123@','superuser');

-- Feedback Table
CREATE TABLE Feedback (
    feedbackID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    date DATE,
    time TIME,
    comment VARCHAR(255),
    email VARCHAR(50)
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
