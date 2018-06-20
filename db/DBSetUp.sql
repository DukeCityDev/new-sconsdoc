DROP TABLE IF EXISTS shift;
DROP TABLE IF EXISTS shiftPlan;
DROP TABLE IF EXISTS pod;
DROP TABLE IF EXISTS scon;

CREATE TABLE scon(
  sconId INT UNSIGNED AUTO_INCREMENT,
  netId VARCHAR(21) NOT NULL,
  firstName VARCHAR(45) NOT NULL ,
  middleInitial VARCHAR(1),
  lastName VARCHAR(45) NOT NULL,
  phoneNumber VARCHAR(17),
  email VARCHAR(75),
  startDate DATETIME,
  adminStatus BOOLEAN,

  PRIMARY KEY(sconId)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE pod(
  podId INT UNSIGNED AUTO_INCREMENT,
  podName VARCHAR(20) UNIQUE,
  PRIMARY KEY(podId)
)CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE shiftPlan(
  shiftPlanId INT UNSIGNED AUTO_INCREMENT,
  podId INT UNSIGNED NOT NULL,
  dayOfWeek SMALLINT,
  startTimeOfDay TIME,
  endTimeOfDay TIME,
  semester SMALLINT,
  PRIMARY KEY(shiftPlanId),
  FOREIGN KEY(podId) REFERENCES pod(podId)
)CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE shift(
  shiftId INT UNSIGNED AUTO_INCREMENT,
  sconId INT UNSIGNED,
  podId INT UNSIGNED NOT NULL,
  shiftPlanId INT UNSIGNED,
  startDateTime DATETIME NOT NULL,
  endDateTime DATETIME NOT NULL,
  available BOOLEAN,

  INDEX(sconId),
  INDEX(podId),
  INDEX(shiftPlanId),

  PRIMARY KEY(shiftId),
  FOREIGN KEY (sconId) REFERENCES scon(sconId),
  FOREIGN KEY (podId) REFERENCES pod(podId),
  FOREIGN KEY (shiftPlanId) REFERENCES shiftPlan(shiftPlanId)

)CHARACTER SET utf8 COLLATE utf8_unicode_ci;