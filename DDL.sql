-- Users Table
CREATE TABLE Users (
    ssn CHAR(5) PRIMARY KEY,
    name CHAR(10),
    email VARCHAR(50),
    password VARCHAR(12),
    birthdate DATE,
    diabetesType VARCHAR(20),
    sex CHAR(1)
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
    name VARCHAR(255),
    description VARCHAR(255)
);
--for testing purpose:
INSERT INTO Medicine (name, description)
VALUES  ("Med A", "A medicine for diabetes"),
		("Med B", "Whatever"),
        ("Med C", "Okay");

-- MedicationReminder Table
CREATE TABLE MedicationReminder (
    medRemID INT PRIMARY KEY AUTO_INCREMENT,
    medID INT REFERENCES Medicine(medID),
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    dosage INT(5),
    sDate DATETIME,
    eDate DATETIME,
    remType VARCHAR(10)
);

-- BSTestingAlert Table
CREATE TABLE BSTestingAlert (
    testingID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    sDate DATETIME,
    eDate DATETIME,
    alertType VARCHAR(10)
);

-- Appointment Table
CREATE TABLE Appointment (
    apptID INT PRIMARY KEY AUTO_INCREMENT,
    ssn CHAR(5) REFERENCES Users(ssn),
    title VARCHAR(50),
    sDate DATETIME,
    eDate DATETIME,
    location VARCHAR(100),
    remType VARCHAR(10)
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
    dosage INT(4)
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
    weightValue DECIMAL(3,2)
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
