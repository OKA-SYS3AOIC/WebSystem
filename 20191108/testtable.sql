-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019 年 11 朁E12 日 09:30
-- サーバのバージョン： 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testtable`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `m_class`
--

CREATE TABLE `m_class` (
  `m_class_year` date NOT NULL COMMENT 'クラス年度',
  `m_class_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'クラス番号',
  `m_class_studentid` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT '生徒クラス番号',
  `m_student_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '学籍番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='クラスマスタ';

-- --------------------------------------------------------

--
-- テーブルの構造 `m_classroom`
--

CREATE TABLE `m_classroom` (
  `m_classroom_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室番号',
  `m_classroom_qrdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室QRデータ',
  `m_classroomform_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室形態番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `m_classroom`
--

INSERT INTO `m_classroom` (`m_classroom_id`, `m_classroom_qrdate`, `m_classroomform_id`) VALUES
('1A', 'qrtest', 'RF01'),
('1B', 'qrtest', 'RF02'),
('1C', 'qrtest', 'RF03'),
('1D', 'qrtest', 'RF04'),
('2A', 'qrtest', 'RF01'),
('3A', 'qrtest', 'RF02'),
('4A', 'qrtest', 'RF03'),
('8C', 'qrtest', 'RF03'),
('9D1', 'QR', 'RF03'),
('9D2', 'QR', 'RF03');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_classroomform`
--

CREATE TABLE `m_classroomform` (
  `m_classroomform_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室形態番号',
  `m_classroomform_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室形態名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='教室形態マスタ';

--
-- テーブルのデータのダンプ `m_classroomform`
--

INSERT INTO `m_classroomform` (`m_classroomform_id`, `m_classroomform_name`) VALUES
('RF01', '通常'),
('RF02', 'PC常設'),
('RF03', 'PC可'),
('RF04', 'その他');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_course`
--

CREATE TABLE `m_course` (
  `m_course_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'コース番号',
  `m_course_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'コース名称',
  `m_course_takingmodelname` varchar(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '履修モデル名称',
  `m_course_studyyears` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '修学年限',
  `m_subject_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '学科番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='コースマスタ';

--
-- テーブルのデータのダンプ `m_course`
--

INSERT INTO `m_course` (`m_course_id`, `m_course_name`, `m_course_takingmodelname`, `m_course_studyyears`, `m_subject_id`) VALUES
('C001', 'ITスペシャリスト専攻', 'SI', '4', 'S01'),
('C002', 'test', 'KS', '3', 'S02');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_dayofweek`
--

CREATE TABLE `m_dayofweek` (
  `m_dayofweek_id` int(1) NOT NULL COMMENT '曜日番号',
  `m_dayofweek_name` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '曜日名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='曜日マスタ';

--
-- テーブルのデータのダンプ `m_dayofweek`
--

INSERT INTO `m_dayofweek` (`m_dayofweek_id`, `m_dayofweek_name`) VALUES
(1, '日曜日'),
(2, '月曜日'),
(3, '火曜日'),
(4, '水曜日'),
(5, '木曜日'),
(6, '金曜日'),
(7, '土曜日');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_employee`
--

CREATE TABLE `m_employee` (
  `m_employee_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT '従業員番号',
  `m_employee_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '従業員氏名',
  `m_employee_password` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'パスワード',
  `m_employee_mailaddress` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
  `m_employee_gotoworkstatus` int(1) NOT NULL COMMENT '出勤状態',
  `m_employeeclassification_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '従業員分類番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='従業員マスタ';

--
-- テーブルのデータのダンプ `m_employee`
--

INSERT INTO `m_employee` (`m_employee_id`, `m_employee_name`, `m_employee_password`, `m_employee_mailaddress`, `m_employee_gotoworkstatus`, `m_employeeclassification_id`) VALUES
('E00001', '金本知憲', 'pass', 'mail', 1, 'EC01T'),
('E00002', '矢野燿大', 'pass', 'mail', 0, 'EC02O');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_employeeclassification`
--

CREATE TABLE `m_employeeclassification` (
  `m_employeeclassification_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '従業員分類番号',
  `m_employeeclassification_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '従業員分類名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='従業員分類マスタ';

--
-- テーブルのデータのダンプ `m_employeeclassification`
--

INSERT INTO `m_employeeclassification` (`m_employeeclassification_id`, `m_employeeclassification_name`) VALUES
('EC01T', '講師'),
('EC02O', '事務員');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_lesson`
--

CREATE TABLE `m_lesson` (
  `m_lesson_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業番号',
  `m_lesson_name` varchar(90) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業名称',
  `m_lessonclassifcation_id` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業分類番号',
  `m_lesson_implementationday` int(2) NOT NULL COMMENT '実施日数',
  `m_lesson_attendancepercentage` int(3) NOT NULL COMMENT '必要出席割合',
  `m_lesson_getunits` int(2) NOT NULL COMMENT '取得単位数',
  `m_lessondivision_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業区分番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='授業マスタ';

--
-- テーブルのデータのダンプ `m_lesson`
--

INSERT INTO `m_lesson` (`m_lesson_id`, `m_lesson_name`, `m_lessonclassifcation_id`, `m_lesson_implementationday`, `m_lesson_attendancepercentage`, `m_lesson_getunits`, `m_lessondivision_id`) VALUES
('T0001', 'ゼミナール1', 'TC01', 30, 80, 2, 'TD01'),
('T0002', 'ゼミナール2', 'TC01', 30, 80, 2, 'TD01'),
('T0003', 'ゼミナール3', 'TC01', 30, 80, 2, 'TD01'),
('T0004', 'ゼミナール4', 'TC01', 30, 80, 2, 'TD01'),
('T0005', 'COBOL1', 'TC01', 30, 80, 4, 'TD01'),
('T0006', 'COBOL応用', 'TC03', 30, 80, 2, 'TD02');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_lessonclassification`
--

CREATE TABLE `m_lessonclassification` (
  `m_lessonclassification_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業分類番号',
  `m_lessonclassification_name` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業分類名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='授業分類マスタ';

--
-- テーブルのデータのダンプ `m_lessonclassification`
--

INSERT INTO `m_lessonclassification` (`m_lessonclassification_id`, `m_lessonclassification_name`) VALUES
('TC01', '選択'),
('TC02', '選択必修'),
('TC03', '自由');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_lessondivision`
--

CREATE TABLE `m_lessondivision` (
  `m_lessondivision_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業区分番号',
  `m_lessondivision_name` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業区分名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='授業区分マスタ';

--
-- テーブルのデータのダンプ `m_lessondivision`
--

INSERT INTO `m_lessondivision` (`m_lessondivision_id`, `m_lessondivision_name`) VALUES
('TD01', '専門知識'),
('TD02', '専門応用'),
('TD03', '関連知識');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_lessonperiod`
--

CREATE TABLE `m_lessonperiod` (
  `m_lessonperiod_id` int(1) NOT NULL COMMENT '授業時限番号',
  `m_lessonperiod_starttime` time NOT NULL COMMENT '授業開始時間',
  `m_lessonperiod_endtime` time NOT NULL COMMENT '授業終了時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='授業時限マスタ';

--
-- テーブルのデータのダンプ `m_lessonperiod`
--

INSERT INTO `m_lessonperiod` (`m_lessonperiod_id`, `m_lessonperiod_starttime`, `m_lessonperiod_endtime`) VALUES
(1, '09:10:00', '10:40:00'),
(2, '10:50:00', '12:20:00'),
(3, '13:10:00', '14:40:00'),
(4, '14:50:00', '16:20:00'),
(5, '16:30:00', '18:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_student`
--

CREATE TABLE `m_student` (
  `m_student_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '学籍番号',
  `m_student_birthday` date NOT NULL COMMENT '生年月日',
  `m_student_graduationyear` year(4) DEFAULT NULL COMMENT '卒業年度',
  `m_student_qrdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '生徒QRデータ',
  `m_student_nowclassid` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '現在生徒クラス番号',
  `m_course_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'コース番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='生徒マスタ';

--
-- テーブルのデータのダンプ `m_student`
--

INSERT INTO `m_student` (`m_student_id`, `m_student_birthday`, `m_student_graduationyear`, `m_student_qrdate`, `m_student_nowclassid`, `m_course_id`) VALUES
('A0001', '1990-04-01', 0000, 'qr', '', 'C001'),
('A0002', '1990-04-01', 0000, 'qr', '', 'C001'),
('A003', '1990-04-01', 0000, 'qr', '', 'C002'),
('A5678', '1995-04-01', 0000, 'qr', '', 'C002');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_subject`
--

CREATE TABLE `m_subject` (
  `m_subject_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '学科番号',
  `m_subject_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '学科名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='学科マスタ';

--
-- テーブルのデータのダンプ `m_subject`
--

INSERT INTO `m_subject` (`m_subject_id`, `m_subject_name`) VALUES
('S01', '総合情報メディア学科'),
('S02', 'てす');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_yearlessondetails`
--

CREATE TABLE `t_yearlessondetails` (
  `t_yearlesson_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '年度授業番号',
  `t_yearlessondetails_dayofweek` int(1) NOT NULL COMMENT '曜日番号',
  `m_lessonperiod_id` int(1) NOT NULL COMMENT '授業時限番号',
  `t_yearlessondetails_implementationunittime` int(1) NOT NULL COMMENT '実施コマ数',
  `t_classroom_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='年度授業明細テーブル';

--
-- テーブルのデータのダンプ `t_yearlessondetails`
--

INSERT INTO `t_yearlessondetails` (`t_yearlesson_id`, `t_yearlessondetails_dayofweek`, `m_lessonperiod_id`, `t_yearlessondetails_implementationunittime`, `t_classroom_id`) VALUES
('T000520191A', 2, 2, 1, '8C');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_yearlesson_id`
--

CREATE TABLE `t_yearlesson_id` (
  `t_yearlesson_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '年度授業番号',
  `t_yearlesson_year` year(4) NOT NULL COMMENT '授業年度',
  `t_lesson_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '授業番号',
  `t_class_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '受講クラス番号',
  `t_teacher_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT '担当教員番号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='年度授業テーブル';

--
-- テーブルのデータのダンプ `t_yearlesson_id`
--

INSERT INTO `t_yearlesson_id` (`t_yearlesson_id`, `t_yearlesson_year`, `t_lesson_id`, `t_class_id`, `t_teacher_id`) VALUES
('T000520191A', 2019, 'T0005', '1A', 'E00001'),
('T000520191B', 2019, 'T0005', '1B', 'E00002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_class`
--
ALTER TABLE `m_class`
  ADD PRIMARY KEY (`m_class_year`,`m_class_id`,`m_class_studentid`),
  ADD KEY `m_student_id` (`m_student_id`);

--
-- Indexes for table `m_classroom`
--
ALTER TABLE `m_classroom`
  ADD PRIMARY KEY (`m_classroom_id`),
  ADD KEY `m_classroomform_id` (`m_classroomform_id`);

--
-- Indexes for table `m_classroomform`
--
ALTER TABLE `m_classroomform`
  ADD PRIMARY KEY (`m_classroomform_id`);

--
-- Indexes for table `m_course`
--
ALTER TABLE `m_course`
  ADD PRIMARY KEY (`m_course_id`),
  ADD KEY `m_subject_id` (`m_subject_id`);

--
-- Indexes for table `m_dayofweek`
--
ALTER TABLE `m_dayofweek`
  ADD PRIMARY KEY (`m_dayofweek_id`);

--
-- Indexes for table `m_employee`
--
ALTER TABLE `m_employee`
  ADD PRIMARY KEY (`m_employee_id`),
  ADD KEY `m_employeeclassification_id` (`m_employeeclassification_id`);

--
-- Indexes for table `m_employeeclassification`
--
ALTER TABLE `m_employeeclassification`
  ADD PRIMARY KEY (`m_employeeclassification_id`);

--
-- Indexes for table `m_lesson`
--
ALTER TABLE `m_lesson`
  ADD PRIMARY KEY (`m_lesson_id`),
  ADD KEY `m_lessonclassifcation_id` (`m_lessonclassifcation_id`),
  ADD KEY `m_lessondivision_id` (`m_lessondivision_id`);

--
-- Indexes for table `m_lessonclassification`
--
ALTER TABLE `m_lessonclassification`
  ADD PRIMARY KEY (`m_lessonclassification_id`);

--
-- Indexes for table `m_lessondivision`
--
ALTER TABLE `m_lessondivision`
  ADD PRIMARY KEY (`m_lessondivision_id`);

--
-- Indexes for table `m_lessonperiod`
--
ALTER TABLE `m_lessonperiod`
  ADD PRIMARY KEY (`m_lessonperiod_id`);

--
-- Indexes for table `m_student`
--
ALTER TABLE `m_student`
  ADD PRIMARY KEY (`m_student_id`),
  ADD KEY `m_course_id` (`m_course_id`);

--
-- Indexes for table `m_subject`
--
ALTER TABLE `m_subject`
  ADD PRIMARY KEY (`m_subject_id`);

--
-- Indexes for table `t_yearlessondetails`
--
ALTER TABLE `t_yearlessondetails`
  ADD KEY `m_lessonperiod_id` (`m_lessonperiod_id`),
  ADD KEY `t_yearlessondetails_dayofweek` (`t_yearlessondetails_dayofweek`),
  ADD KEY `t_classroom_id` (`t_classroom_id`);

--
-- Indexes for table `t_yearlesson_id`
--
ALTER TABLE `t_yearlesson_id`
  ADD PRIMARY KEY (`t_yearlesson_id`),
  ADD KEY `t_lesson_id` (`t_lesson_id`),
  ADD KEY `t_teacher_id` (`t_teacher_id`);

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `m_class`
--
ALTER TABLE `m_class`
  ADD CONSTRAINT `m_class_ibfk_1` FOREIGN KEY (`m_student_id`) REFERENCES `m_student` (`m_student_id`);

--
-- テーブルの制約 `m_classroom`
--
ALTER TABLE `m_classroom`
  ADD CONSTRAINT `m_classroom_ibfk_1` FOREIGN KEY (`m_classroomform_id`) REFERENCES `m_classroomform` (`m_classroomform_id`);

--
-- テーブルの制約 `m_course`
--
ALTER TABLE `m_course`
  ADD CONSTRAINT `m_course_ibfk_1` FOREIGN KEY (`m_subject_id`) REFERENCES `m_subject` (`m_subject_id`);

--
-- テーブルの制約 `m_employee`
--
ALTER TABLE `m_employee`
  ADD CONSTRAINT `m_employee_ibfk_1` FOREIGN KEY (`m_employeeclassification_id`) REFERENCES `m_employeeclassification` (`m_employeeclassification_id`);

--
-- テーブルの制約 `m_lesson`
--
ALTER TABLE `m_lesson`
  ADD CONSTRAINT `m_lesson_ibfk_1` FOREIGN KEY (`m_lessonclassifcation_id`) REFERENCES `m_lessonclassification` (`m_lessonclassification_id`),
  ADD CONSTRAINT `m_lesson_ibfk_2` FOREIGN KEY (`m_lessondivision_id`) REFERENCES `m_lessondivision` (`m_lessondivision_id`);

--
-- テーブルの制約 `m_student`
--
ALTER TABLE `m_student`
  ADD CONSTRAINT `m_student_ibfk_1` FOREIGN KEY (`m_course_id`) REFERENCES `m_course` (`m_course_id`);

--
-- テーブルの制約 `t_yearlessondetails`
--
ALTER TABLE `t_yearlessondetails`
  ADD CONSTRAINT `t_yearlessondetails_ibfk_1` FOREIGN KEY (`m_lessonperiod_id`) REFERENCES `m_lessonperiod` (`m_lessonperiod_id`),
  ADD CONSTRAINT `t_yearlessondetails_ibfk_2` FOREIGN KEY (`t_yearlessondetails_dayofweek`) REFERENCES `m_dayofweek` (`m_dayofweek_id`),
  ADD CONSTRAINT `t_yearlessondetails_ibfk_3` FOREIGN KEY (`t_classroom_id`) REFERENCES `m_classroom` (`m_classroom_id`);

--
-- テーブルの制約 `t_yearlesson_id`
--
ALTER TABLE `t_yearlesson_id`
  ADD CONSTRAINT `t_yearlesson_id_ibfk_1` FOREIGN KEY (`t_lesson_id`) REFERENCES `m_lesson` (`m_lesson_id`),
  ADD CONSTRAINT `t_yearlesson_id_ibfk_2` FOREIGN KEY (`t_teacher_id`) REFERENCES `m_employee` (`m_employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
