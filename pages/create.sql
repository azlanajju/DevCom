CREATE TABLE Users (
  UserID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PhoneNumber VARCHAR(20),
  RegistrationDate DATE DEFAULT CURRENT_DATE
);



CREATE TABLE qna (
  id INT PRIMARY KEY AUTO_INCREMENT,
  UserID INT(11),
  questionTitle VARCHAR(255),
  problemDetails TEXT,
  answerExpectations TEXT,
  tags VARCHAR(255),
  askedTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updatedTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  upvote INT DEFAULT 0,
  downvote INT DEFAULT 0,
  FOREIGN KEY (UserID) REFERENCES User(UserID)
);



CREATE TABLE answers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  questionID INT,
  answerDetails TEXT,
  answeredBy INT,
  answeredTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (questionID) REFERENCES qna(id),
  FOREIGN KEY (answeredBy) REFERENCES User(UserID)
);
ALTER TABLE answers
ADD COLUMN upvote INT DEFAULT 0,
ADD COLUMN downvote INT DEFAULT 0;

-- may be required

SELECT answers.id, answers.answerDetails, User.Name AS answeredBy
FROM answers
JOIN User ON answers.answeredBy = User.UserID;
