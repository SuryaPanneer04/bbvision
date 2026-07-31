CREATE TABLE IF NOT EXISTS `asses_question` (
  `question_no` int(11) NOT NULL AUTO_INCREMENT,
  `question_type` varchar(255) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
