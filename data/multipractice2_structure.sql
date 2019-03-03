-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2019 at 08:05 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multipractice2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '-1',
  `info` text COLLATE utf8mb4_unicode_ci,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `uid` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` int(11) NOT NULL DEFAULT '-1',
  `info` text COLLATE utf8mb4_unicode_ci,
  `author` int(11) NOT NULL DEFAULT '-1',
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `uid` text COLLATE utf8mb4_unicode_ci,
  `image` mediumblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE `course_category` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '-1',
  `category_id` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_levels`
--

CREATE TABLE `course_levels` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL DEFAULT '-1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `uid` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemorder` int(11) NOT NULL DEFAULT '0',
  `image` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_levels_completed`
--

CREATE TABLE `course_levels_completed` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `completed` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `englishname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `info` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bdi` int(11) NOT NULL DEFAULT '0',
  `fontfamily` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontsize` int(11) NOT NULL DEFAULT '0',
  `characters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `englishname`, `created`, `info`, `user_id`, `code`, `name_sort`, `bdi`, `fontfamily`, `fontsize`, `characters`) VALUES
(1, 'Qafaraf; ’Afar Af; Afaraf; Qafar af', 'Afar', '2018-01-01 00:00:00', NULL, -1, 'aar', 'afar', 0, '', 0, NULL),
(2, 'Аҧсуа бызшәа; Аҧсшәа', 'Abkhazian', '2018-01-01 00:00:00', NULL, -1, 'abk', 'abkhazian', 0, '', 0, NULL),
(3, 'بهسا اچيه', 'Achinese', '2018-01-01 00:00:00', NULL, -1, 'ace', 'achinese', 0, '', 0, NULL),
(4, 'Lwo', 'Acoli', '2018-01-01 00:00:00', NULL, -1, 'ach', 'acoli', 0, '', 0, NULL),
(5, 'Dangme', 'Adangme', '2018-01-01 00:00:00', NULL, -1, 'ada', 'adangme', 0, '', 0, NULL),
(6, 'Адыгабзэ; Кӏахыбзэ', 'Adyghe; Adygei', '2018-01-01 00:00:00', NULL, -1, 'ady', 'adyghe; adygei', 0, '', 0, NULL),
(7, 'Afro-Asiatic languages', 'Afro-Asiatic languages', '2018-01-01 00:00:00', NULL, -1, 'afa', 'afro-asiatic languages', 0, '', 0, NULL),
(8, 'El-Afrihili', 'Afrihili', '2018-01-01 00:00:00', NULL, -1, 'afh', 'afrihili', 0, '', 0, NULL),
(9, 'Afrikaans', 'Afrikaans', '2018-01-01 00:00:00', NULL, -1, 'afr', 'afrikaans', 0, '', 0, NULL),
(10, 'アイヌ・イタㇰ', 'Ainu', '2018-01-01 00:00:00', NULL, -1, 'ain', 'ainu', 0, '', 0, NULL),
(11, 'Akan', 'Akan', '2018-01-01 00:00:00', NULL, -1, 'aka', 'akan', 0, '', 0, NULL),
(12, '𒀝𒅗𒁺𒌑', 'Akkadian', '2018-01-01 00:00:00', NULL, -1, 'akk', 'akkadu', 0, '', 0, NULL),
(13, 'Shqip', 'Albanian', '2018-01-01 00:00:00', NULL, -1, 'sqi', 'shqip', 0, '', 0, NULL),
(14, 'Унáӈам тунуý; Унаӈан умсуу', 'Aleut', '2018-01-01 00:00:00', NULL, -1, 'ale', 'aleut', 0, '', 0, NULL),
(15, 'Algonquian languages', 'Algonquian languages', '2018-01-01 00:00:00', NULL, -1, 'alg', 'algonquian languages', 0, '', 0, NULL),
(16, 'Алтай тили', 'Southern Altai', '2018-01-01 00:00:00', NULL, -1, 'alt', 'southern altai', 0, '', 0, NULL),
(17, 'አማርኛ', 'Amharic', '2018-01-01 00:00:00', NULL, -1, 'amh', 'amarinna', 0, '', 0, NULL),
(18, 'Ænglisc; Anglisc; Englisc', 'Old English ca. 450–1100', '2018-01-01 00:00:00', NULL, -1, 'ang', 'anglisc', 0, '', 0, NULL),
(19, 'Angika', 'Angika', '2018-01-01 00:00:00', NULL, -1, 'anp', 'angika', 0, '', 0, NULL),
(20, 'Southern Athabaskan languages', 'Apache languages', '2018-01-01 00:00:00', NULL, -1, 'apa', 'apache languages', 0, '', 0, NULL),
(21, 'العَرَبِيَّة', 'Arabic', '2018-01-01 00:00:00', NULL, -1, 'ara', 'arabiya', 1, '', 14, '\r\nؑ\r\nؒ\r\nؓ\r\nؔ\r\nؕ\r\nؖ\r\nؗ\r\nؘ\r\nؙ\r\nؚ\r\n؛\r\n؞\r\n؟\r\nؠ\r\nء\r\nآ\r\nأ\r\nؤ\r\nإ\r\nئ\r\nا\r\nب\r\nة\r\nت\r\nث\r\nج\r\nح\r\nخ\r\nد\r\nذ\r\nر\r\nز\r\nس\r\nش\r\nص\r\nض\r\nط\r\nظ\r\nع\r\nغ\r\nػ\r\nؼ\r\nؽ\r\nؾ\r\nؿ\r\nـ\r\nف\r\nق\r\nك\r\nل\r\nم\r\nن\r\nه\r\nو\r\nى\r\nي\r\nً\r\nٌ\r\nٍ\r\nَ\r\nُ\r\nِ\r\nّ\r\nْ\r\nٓ\r\nٔ\r\nٕ\r\nٖ\r\nٗ\r\n٘\r\nٙ\r\nٚ\r\nٛ\r\nٜ\r\nٝ\r\nٞ\r\nٟ\r\n٠\r\n١\r\n٢\r\n٣\r\n٤\r\n٥\r\n٦\r\n٧\r\n٨\r\n٩\r\n٪\r\n٫\r\n٬\r\n٭\r\nٮ\r\nٯ\r\nٰ\r\nٱ\r\nٲ\r\nٳ\r\nٴ\r\nٵ\r\nٶ\r\nٷ\r\nٸ\r\nٹ\r\nٺ\r\nٻ\r\nټ\r\nٽ\r\nپ\r\nٿ\r\nڀ\r\nځ\r\nڂ\r\nڃ\r\nڄ\r\nڅ\r\nچ\r\nڇ\r\nڈ\r\nډ\r\nڊ\r\nڋ\r\nڌ\r\nڍ\r\nڎ\r\nڏ\r\nڐ\r\nڑ\r\nڒ\r\nړ\r\nڔ\r\nڕ\r\nږ\r\nڗ\r\nژ\r\nڙ\r\nښ\r\nڛ\r\nڜ\r\nڝ\r\nڞ\r\nڟ\r\nڠ\r\nڡ\r\nڢ\r\nڣ\r\nڤ\r\nڥ\r\nڦ\r\nڧ\r\nڨ\r\nک\r\nڪ\r\nګ\r\nڬ\r\nڭ\r\nڮ\r\nگ\r\nڰ\r\nڱ\r\nڲ\r\nڳ\r\nڴ\r\nڵ\r\nڶ\r\nڷ\r\nڸ\r\nڹ\r\nں\r\nڻ\r\nڼ\r\nڽ\r\nھ\r\nڿ\r\nۀ\r\nہ\r\nۂ\r\nۃ\r\nۄ\r\nۅ\r\nۆ\r\nۇ\r\nۈ\r\nۉ\r\nۊ\r\nۋ\r\nی\r\nۍ\r\nێ\r\nۏ\r\nې\r\nۑ\r\nے\r\nۓ\r\n۔\r\nە\r\nۖ\r\nۗ\r\nۘ\r\nۙ\r\nۚ\r\nۛ\r\nۜ\r\n۞\r\n۟\r\n۠\r\nۡ\r\nۢ\r\nۣ\r\nۤ\r\nۥ\r\nۦ\r\nۧ\r\nۨ\r\n۩\r\n۪\r\n۫\r\n۬\r\nۭ\r\nۮ\r\nۯ\r\n۰\r\n۱\r\n۲\r\n۳\r\n۴\r\n۵\r\n۶\r\n۷\r\n۸\r\n۹\r\nۺ\r\nۻ\r\nۼ\r\n۽\r\n۾\r\nۿ\r\n'),
(22, 'Aramaic', 'Official Aramaic 700–300 BCE; Imperial Aramaic 700–300 BCE', '2018-01-01 00:00:00', NULL, -1, 'arc', 'official aramaic (700–300 bce); imperial aramaic (700–300 bce)', 1, '', 0, NULL),
(23, 'aragonés', 'Aragonese', '2018-01-01 00:00:00', NULL, -1, 'arg', 'aragonese', 0, '', 0, NULL),
(24, 'Հայերէն; Հայերեն', 'Armenian', '2018-01-01 00:00:00', NULL, -1, 'hye', 'armenian', 0, '', 0, NULL),
(25, 'Mapudungun; Mapuche', 'Mapudungun; Mapuche', '2018-01-01 00:00:00', NULL, -1, 'arn', 'mapudungun; mapuche', 0, '', 0, NULL),
(26, 'Hinónoʼeitíít', 'Arapaho', '2018-01-01 00:00:00', NULL, -1, 'arp', 'arapaho', 0, '', 0, NULL),
(27, 'Artificial languages', 'Artificial languages', '2018-01-01 00:00:00', NULL, -1, 'art', 'artificial languages', 0, '', 0, NULL),
(28, 'Lokono', 'Arawak', '2018-01-01 00:00:00', NULL, -1, 'arw', 'arawak', 0, '', 0, NULL),
(29, 'অসমীয়া', 'Assamese', '2018-01-01 00:00:00', NULL, -1, 'asm', 'assamese', 0, '', 0, NULL),
(30, 'Asturianu', 'Asturian; Bable; Leonese; Asturleonese', '2018-01-01 00:00:00', NULL, -1, 'ast', 'asturian; bable; leonese; asturleonese', 0, '', 0, NULL),
(31, 'Athabaskan languages', 'Athapascan languages', '2018-01-01 00:00:00', NULL, -1, 'ath', 'athapascan languages', 0, '', 0, NULL),
(32, 'Australian languages', 'Australian languages', '2018-01-01 00:00:00', NULL, -1, 'aus', 'australian languages', 0, '', 0, NULL),
(33, 'Магӏарул мацӏ; Авар мацӏ', 'Avaric', '2018-01-01 00:00:00', NULL, -1, 'ava', 'avaric', 0, '', 0, NULL),
(34, 'Avestan', 'Avestan', '2018-01-01 00:00:00', NULL, -1, 'ave', 'avestan', 0, '', 0, NULL),
(35, 'अवधी', 'Awadhi', '2018-01-01 00:00:00', NULL, -1, 'awa', 'awadhi', 0, '', 0, NULL),
(36, 'Aymar aru', 'Aymara', '2018-01-01 00:00:00', NULL, -1, 'aym', 'aymara', 0, '', 0, NULL),
(37, 'Azərbaycan dili; آذربایجان دیلی; Азәрбајҹан дили', 'Azerbaijani', '2018-01-01 00:00:00', NULL, -1, 'aze', 'azerbaijani', 0, '', 0, NULL),
(38, 'Banda languages', 'Banda languages', '2018-01-01 00:00:00', NULL, -1, 'bad', 'banda languages', 0, '', 0, NULL),
(39, 'Bamiléké', 'Bamileke languages', '2018-01-01 00:00:00', NULL, -1, 'bai', 'bamileke languages', 0, '', 0, NULL),
(40, 'Башҡорт теле; Başqort tele', 'Bashkir', '2018-01-01 00:00:00', NULL, -1, 'bak', 'bashkir', 0, '', 0, NULL),
(41, 'بلوچی‎', 'Baluchi', '2018-01-01 00:00:00', NULL, -1, 'bal', 'baluchi', 0, '', 0, NULL),
(42, 'ߓߊߡߊߣߊߣߞߊߣ‎', 'Bambara', '2018-01-01 00:00:00', NULL, -1, 'bam', 'bambara', 0, '', 0, NULL),
(43, 'ᬪᬵᬱᬩᬮᬶ; ᬩᬲᬩᬮᬶ', 'Balinese', '2018-01-01 00:00:00', NULL, -1, 'ban', 'balinese', 0, '', 0, NULL),
(44, 'Euskara', 'Basque', '2018-01-01 00:00:00', NULL, -1, 'eus', 'euskara', 0, '', 0, NULL),
(45, 'Mbene; Ɓasaá', 'Basa', '2018-01-01 00:00:00', NULL, -1, 'bas', 'basa', 0, '', 0, NULL),
(46, 'Baltic languages', 'Baltic languages', '2018-01-01 00:00:00', NULL, -1, 'bat', 'baltic languages', 0, '', 0, NULL),
(47, 'Bidhaawyeet', 'Beja; Bedawiyet', '2018-01-01 00:00:00', NULL, -1, 'bej', 'beja; bedawiyet', 0, '', 0, NULL),
(48, 'Беларуская мова', 'Belarusian', '2018-01-01 00:00:00', NULL, -1, 'bel', 'belarusian', 0, '', 0, NULL),
(49, 'Chibemba', 'Bemba', '2018-01-01 00:00:00', NULL, -1, 'bem', 'bemba', 0, '', 0, NULL),
(50, 'বাংলা', 'Bengali', '2018-01-01 00:00:00', NULL, -1, 'ben', 'bengali', 0, '', 0, NULL),
(51, 'Tamaziɣt; Tamazight; ⵜⴰⵎⴰⵣⵉⵖⵜ; ⵝⴰⵎⴰⵣⵉⵗⵝ; ⵜⴰⵎⴰⵣⵉⵗⵜ', 'Berber languages', '2018-01-01 00:00:00', NULL, -1, 'ber', 'berber languages', 0, '', 0, NULL),
(52, 'भोजपुरी', 'Bhojpuri', '2018-01-01 00:00:00', NULL, -1, 'bho', 'bhojpuri', 0, '', 0, NULL),
(53, 'Bihari languages', 'Bihari languages', '2018-01-01 00:00:00', NULL, -1, '', 'bihari languages', 0, '', 0, NULL),
(54, 'Bikol', 'Bikol', '2018-01-01 00:00:00', NULL, -1, 'bik', 'bikol', 0, '', 0, NULL),
(55, 'Ẹ̀dó', 'Bini; Edo', '2018-01-01 00:00:00', NULL, -1, 'bin', 'edo', 0, '', 0, NULL),
(56, 'Bislama', 'Bislama', '2018-01-01 00:00:00', NULL, -1, 'bis', 'bislama', 0, '', 0, NULL),
(57, 'ᓱᖽᐧᖿ', 'Siksika', '2018-01-01 00:00:00', NULL, -1, 'bla', 'siksika', 0, '', 0, NULL),
(58, 'Bantu languages', 'Bantu languages', '2018-01-01 00:00:00', NULL, -1, '', 'bantu languages', 0, '', 0, NULL),
(59, 'བོད་སྐད་; ལྷ་སའི་སྐད་', 'Tibetan', '2018-01-01 00:00:00', NULL, -1, 'bod', 'tibetan', 0, '', 0, NULL),
(60, 'bosanski; босански', 'Bosnian', '2018-01-01 00:00:00', NULL, -1, 'bos', 'bosnian', 0, '', 0, NULL),
(61, 'Braj Bhāshā', 'Braj', '2018-01-01 00:00:00', NULL, -1, 'bra', 'braj', 0, '', 0, NULL),
(62, 'Brezhoneg', 'Breton', '2018-01-01 00:00:00', NULL, -1, 'bre', 'breton', 0, '', 0, NULL),
(63, 'Batak languages', 'Batak languages', '2018-01-01 00:00:00', NULL, -1, 'btk', 'batak languages', 0, '', 0, NULL),
(64, 'буряад хэлэн', 'Buriat', '2018-01-01 00:00:00', NULL, -1, 'bua', 'buriat', 0, '', 0, NULL),
(65, 'ᨅᨔ ᨕᨘᨁᨗ', 'Buginese', '2018-01-01 00:00:00', NULL, -1, 'bug', 'buginese', 0, '', 0, NULL),
(66, 'български език', 'Bulgarian', '2018-01-01 00:00:00', NULL, -1, 'bul', 'bulgarian', 0, '', 0, NULL),
(67, 'မြန်မာစာ; မြန်မာစကား', 'Burmese', '2018-01-01 00:00:00', NULL, -1, 'mya', 'burmese', 0, '', 0, NULL),
(68, 'ብሊና, ብሊን', 'Bilin; Blin', '2018-01-01 00:00:00', NULL, -1, 'byn', 'bilin; blin', 0, '', 0, NULL),
(69, 'Hasí:nay', 'Caddo', '2018-01-01 00:00:00', NULL, -1, 'cad', 'caddo', 0, '', 0, NULL),
(70, 'Central American Indian languages', 'Central American Indian languages', '2018-01-01 00:00:00', NULL, -1, 'cai', 'central american indian languages', 0, '', 0, NULL),
(71, 'Kari\'nja', 'Galibi Carib', '2018-01-01 00:00:00', NULL, -1, 'car', 'galibi carib', 0, '', 0, NULL),
(72, 'català', 'Catalan; Valencian', '2018-01-01 00:00:00', NULL, -1, 'cat', 'catalan; valencian', 0, '', 0, NULL),
(73, 'Caucasian languages', 'Caucasian languages', '2018-01-01 00:00:00', NULL, -1, 'cau', 'caucasian languages', 0, '', 0, NULL),
(74, 'Sinugbuanong Binisayâ', 'Cebuano', '2018-01-01 00:00:00', NULL, -1, 'ceb', 'cebuano', 0, '', 0, NULL),
(75, 'Celtic languages', 'Celtic languages', '2018-01-01 00:00:00', NULL, -1, 'cel', 'celtic languages', 0, '', 0, NULL),
(76, 'Čeština; český jazyk', 'Czech', '2018-01-01 00:00:00', NULL, -1, 'ces', 'cestina', 0, '', 0, 'Á\r\ná\r\nÉ\r\né\r\nÍ\r\ní\r\nÓ\r\nó\r\nÚ\r\nú\r\nŮ\r\nů\r\nÝ\r\ný\r\nČ\r\nč\r\nĎ\r\nď\r\nĚ\r\ně\r\nŇ\r\nň\r\nŘ\r\nř\r\nŠ\r\nš\r\nŤ\r\nť\r\nŽ\r\nž\r\n'),
(77, 'Finu\' Chamoru', 'Chamorro', '2018-01-01 00:00:00', NULL, -1, 'cha', 'chamorro', 0, '', 0, NULL),
(78, 'Muysccubun', 'Chibcha', '2018-01-01 00:00:00', NULL, -1, 'chb', 'chibcha', 0, '', 0, NULL),
(79, 'Нохчийн мотт; نَاخچیین موٓتت; ნახჩიე მუოთთ', 'Chechen', '2018-01-01 00:00:00', NULL, -1, 'che', 'chechen', 0, '', 0, NULL),
(80, 'جغتای', 'Chagatai', '2018-01-01 00:00:00', NULL, -1, 'chg', 'chagatai', 0, '', 0, NULL),
(81, '中文; 汉语; 漢語', 'Chinese', '2018-01-01 00:00:00', NULL, -1, 'zho', 'zhongwen', 0, '', 0, NULL),
(82, 'Chuukese', 'Chuukese', '2018-01-01 00:00:00', NULL, -1, 'chk', 'chuukese', 0, '', 0, NULL),
(83, 'марий йылме', 'Mari', '2018-01-01 00:00:00', NULL, -1, 'chm', 'mari', 0, '', 0, NULL),
(84, 'chinuk wawa; wawa; chinook lelang; lelang', 'Chinook jargon', '2018-01-01 00:00:00', NULL, -1, 'chn', 'chinook jargon', 0, '', 0, NULL),
(85, 'Chahta\'', 'Choctaw', '2018-01-01 00:00:00', NULL, -1, 'cho', 'choctaw', 0, '', 0, NULL),
(86, 'ᑌᓀᓱᒼᕄᓀ (Dënesųłiné)', 'Chipewyan; Dene Suline', '2018-01-01 00:00:00', NULL, -1, 'chp', 'chipewyan; dene suline', 0, '', 0, NULL),
(87, 'ᏣᎳᎩ ᎦᏬᏂᎯᏍᏗ', 'Cherokee', '2018-01-01 00:00:00', NULL, -1, 'chr', 'cherokee', 0, '', 0, NULL),
(88, 'Славе́нскїй ѧ҆зы́къ', 'Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic', '2018-01-01 00:00:00', NULL, -1, 'chu', 'church slavic; old slavonic; church slavonic; old bulgarian; old church slavonic', 0, '', 0, NULL),
(89, 'Чӑвашла', 'Chuvash', '2018-01-01 00:00:00', NULL, -1, 'chv', 'chuvash', 0, '', 0, NULL),
(90, 'Tsėhésenėstsestȯtse', 'Cheyenne', '2018-01-01 00:00:00', NULL, -1, 'chy', 'cheyenne', 0, '', 0, NULL),
(91, 'Chamic languages', 'Chamic languages', '2018-01-01 00:00:00', NULL, -1, '', 'chamic languages', 0, '', 0, NULL),
(92, 'crnogorski / црногорски', 'Montenegrin', '2018-01-01 00:00:00', NULL, -1, 'cnr', 'montenegrin', 0, '', 0, NULL),
(93, 'ϯⲙⲉⲑⲣⲉⲙⲛ̀ⲭⲏⲙⲓ; ⲧⲙⲛ̄ⲧⲣⲙ̄ⲛ̄ⲕⲏⲙⲉ', 'Coptic', '2018-01-01 00:00:00', NULL, -1, 'cop', 'tmntrmnkemi', 0, '', 0, NULL),
(94, 'Kernowek', 'Cornish', '2018-01-01 00:00:00', NULL, -1, 'cor', 'cornish', 0, '', 0, NULL),
(95, 'Corsu; Lingua corsa', 'Corsican', '2018-01-01 00:00:00', NULL, -1, 'cos', 'corsican', 0, '', 0, NULL),
(96, 'English based Creoles and pidgins', 'English based Creoles and pidgins', '2018-01-01 00:00:00', NULL, -1, 'cpe', 'english based creoles and pidgins', 0, '', 0, NULL),
(97, 'French-based Creoles and pidgins', 'French-based Creoles and pidgins', '2018-01-01 00:00:00', NULL, -1, 'cpf', 'french-based creoles and pidgins', 0, '', 0, NULL),
(98, 'Portuguese-based Creoles and pidgins', 'Portuguese-based Creoles and pidgins', '2018-01-01 00:00:00', NULL, -1, 'cpp', 'portuguese-based creoles and pidgins', 0, '', 0, NULL),
(99, 'Cree', 'Cree', '2018-01-01 00:00:00', NULL, -1, 'cre', 'cree', 0, '', 0, NULL),
(100, 'Къырымтатарджа; Къырымтатар тили; Ҡырымтатарҗа; Ҡырымтатар тили', 'Crimean Tatar; Crimean Turkish', '2018-01-01 00:00:00', NULL, -1, 'crh', 'crimean tatar; crimean turkish', 0, '', 0, NULL),
(101, 'Creoles and pidgins', 'Creoles and pidgins', '2018-01-01 00:00:00', NULL, -1, 'crp', 'creoles and pidgins', 0, '', 0, NULL),
(102, 'Kaszëbsczi jãzëk', 'Kashubian', '2018-01-01 00:00:00', NULL, -1, 'csb', 'kashubian', 0, '', 0, NULL),
(103, 'Cushitic languages', 'Cushitic languages', '2018-01-01 00:00:00', NULL, -1, 'cus', 'cushitic languages', 0, '', 0, NULL),
(104, 'Cymraeg; y Gymraeg', 'Welsh', '2018-01-01 00:00:00', NULL, -1, 'cym', 'cymraeg', 0, '', 0, NULL),
(106, 'Dakhótiyapi; Dakȟótiyapi', 'Dakota', '2018-01-01 00:00:00', NULL, -1, 'dak', 'dakota', 0, '', 0, NULL),
(107, 'dansk', 'Danish', '2018-01-01 00:00:00', NULL, -1, 'dan', 'danish', 0, '', 0, NULL),
(108, 'дарган мез', 'Dargwa', '2018-01-01 00:00:00', NULL, -1, 'dar', 'dargwa', 0, '', 0, NULL),
(109, 'Land Dayak languages', 'Land Dayak languages', '2018-01-01 00:00:00', NULL, -1, 'day', 'land dayak languages', 0, '', 0, NULL),
(110, 'Delaware', 'Delaware', '2018-01-01 00:00:00', NULL, -1, 'del', 'delaware', 0, '', 0, NULL),
(111, 'Dene K\'e', 'Slave - Athapascan', '2018-01-01 00:00:00', NULL, -1, 'den', 'slave (athapascan)', 0, '', 0, NULL),
(112, 'Deutsch', 'German', '2018-01-01 00:00:00', NULL, -1, 'deu', 'german', 0, '', 0, NULL),
(113, 'डोगरी ڈوگرى‎', 'Dogrib', '2018-01-01 00:00:00', NULL, -1, 'dgr', 'dogrib', 0, '', 0, NULL),
(114, 'Thuɔŋjäŋ', 'Dinka', '2018-01-01 00:00:00', NULL, -1, 'din', 'dinka', 0, '', 0, NULL),
(115, 'ދިވެހި; ދިވެހިބަސް', 'Dhivehi; Dhivehi; Maldivian', '2018-01-01 00:00:00', NULL, -1, 'div', 'dhivehi; dhivehi; maldivian', 0, '', 0, NULL),
(117, 'Dravidian languages', 'Dravidian languages', '2018-01-01 00:00:00', NULL, -1, 'dra', 'dravidian languages', 0, '', 0, NULL),
(118, 'Dolnoserbski; Dolnoserbšćina', 'Lower Sorbian', '2018-01-01 00:00:00', NULL, -1, 'dsb', 'lower sorbian', 0, '', 0, NULL),
(119, 'Duala', 'Duala', '2018-01-01 00:00:00', NULL, -1, 'dua', 'duala', 0, '', 0, NULL),
(120, 'Middle Dutch (ca. 1050–1350)', 'Middle Dutch ca. 1050–1350', '2018-01-01 00:00:00', NULL, -1, 'dum', 'middle dutch (ca. 1050–1350)', 0, '', 0, NULL),
(121, 'Nederlands; Vlaams', 'Dutch; Flemish', '2018-01-01 00:00:00', NULL, -1, 'nld', 'nederlands', 0, '', 0, NULL),
(122, 'Julakan', 'Dyula', '2018-01-01 00:00:00', NULL, -1, 'dyu', 'dyula', 0, '', 0, NULL),
(123, 'རྫོང་ཁ་', 'Dzongkha', '2018-01-01 00:00:00', NULL, -1, 'dzo', 'dzongkha', 0, '', 0, NULL),
(124, 'Efik', 'Efik', '2018-01-01 00:00:00', NULL, -1, 'efi', 'efik', 0, '', 0, NULL),
(125, '𓂋𓏺𓈖𓆎𓅓𓏏𓊖', 'Ancient Egyptian', '2018-01-01 00:00:00', NULL, -1, 'egy', 'rnkmt', 0, '', 0, NULL),
(126, 'Kajuk', 'Ekajuk', '2018-01-01 00:00:00', NULL, -1, 'eka', 'ekajuk', 0, '', 0, NULL),
(127, 'Νέα Ελληνικά', 'Modern Greek', '2018-01-01 00:00:00', NULL, -1, 'ell', 'ellinika', 0, '', 0, NULL),
(128, 'Elamite', 'Elamite', '2018-01-01 00:00:00', NULL, -1, 'elx', 'elamite', 0, '', 0, NULL),
(129, 'English', 'English', '2018-01-01 00:00:00', NULL, -1, 'eng', 'english', 0, '', 0, NULL),
(130, 'Middle English', 'Middle English 1100–1500', '2018-01-01 00:00:00', NULL, -1, 'enm', 'middle english (1100–1500)', 0, '', 0, NULL),
(131, 'Esperanto', 'Esperanto', '2018-01-01 00:00:00', NULL, -1, 'epo', 'esperanto', 0, '', 0, NULL),
(132, 'eesti keel', 'Estonian', '2018-01-01 00:00:00', NULL, -1, 'est', 'estonian', 0, '', 0, NULL),
(133, 'euskara', 'Basque', '2018-01-01 00:00:00', NULL, -1, 'eus', 'basque', 0, '', 0, NULL),
(134, 'Èʋegbe', 'Ewe', '2018-01-01 00:00:00', NULL, -1, 'ewe', 'ewegbe', 0, '', 0, NULL),
(135, 'Kolo', 'Ewondo', '2018-01-01 00:00:00', NULL, -1, 'ewo', 'ewondo', 0, '', 0, NULL),
(136, 'Fang', 'Fang', '2018-01-01 00:00:00', NULL, -1, 'fan', 'fang', 0, '', 0, NULL),
(137, 'føroyskt', 'Faroese', '2018-01-01 00:00:00', NULL, -1, 'fao', 'faroese', 0, '', 0, NULL),
(138, 'فارسی', 'Persian', '2018-01-01 00:00:00', NULL, -1, 'fas', 'farsi', 0, '', 0, NULL),
(139, 'Mfantse; Fante; Fanti', 'Fanti', '2018-01-01 00:00:00', NULL, -1, 'fat', 'fanti', 0, '', 0, NULL),
(140, 'Na Vosa Vakaviti', 'Fijian', '2018-01-01 00:00:00', NULL, -1, 'fij', 'fijian', 0, '', 0, NULL),
(141, 'Wikang Filipino', 'Filipino; Pilipino', '2018-01-01 00:00:00', NULL, -1, 'fil', 'filipino; pilipino', 0, '', 0, NULL),
(142, 'Suomen kieli; Suomi', 'Finnish', '2018-01-01 00:00:00', NULL, -1, 'fin', 'suomi', 0, '', 0, NULL),
(143, 'Finno-Ugrian languages', 'Finno-Ugrian languages', '2018-01-01 00:00:00', NULL, -1, 'fiu', 'finno-ugrian languages', 0, '', 0, NULL),
(144, 'Fon gbè', 'Fon', '2018-01-01 00:00:00', NULL, -1, 'fon', 'fon', 0, '', 0, NULL),
(145, 'Français', 'French', '2018-01-01 00:00:00', NULL, -1, 'fra', 'francais', 0, '', 0, NULL),
(146, 'françois; franceis', 'Middle French ca. 1400–1600', '2018-01-01 00:00:00', NULL, -1, 'frm', 'middle french (ca. 1400–1600)', 0, '', 0, NULL),
(147, 'Franceis; François; Romanz', 'Old French 842–ca. 1400', '2018-01-01 00:00:00', NULL, -1, 'fro', 'old french (842–ca. 1400)', 0, '', 0, NULL),
(148, 'Frasch; Fresk; Freesk; Friisk', 'Northern Frisian', '2018-01-01 00:00:00', NULL, -1, 'frr', 'northern frisian', 0, '', 0, NULL),
(149, 'Seeltersk', 'Eastern Frisian', '2018-01-01 00:00:00', NULL, -1, 'frs', 'eastern frisian', 0, '', 0, NULL),
(150, 'Frysk', 'Western Frisian', '2018-01-01 00:00:00', NULL, -1, 'fry', 'western frisian', 0, '', 0, NULL),
(151, 'Fulfulde; Pulaar; Pular', 'Fulah', '2018-01-01 00:00:00', NULL, -1, 'ful', 'fulah', 0, '', 0, NULL),
(152, 'Furlan', 'Friulian', '2018-01-01 00:00:00', NULL, -1, 'fur', 'friulian', 0, '', 0, NULL),
(153, 'Gã', 'Ga', '2018-01-01 00:00:00', NULL, -1, 'gaa', 'ga', 0, '', 0, NULL),
(154, 'Basa Gayo', 'Gayo', '2018-01-01 00:00:00', NULL, -1, 'gay', 'gayo', 0, '', 0, NULL),
(155, 'Gbaya', 'Gbaya', '2018-01-01 00:00:00', NULL, -1, 'gba', 'gbaya', 0, '', 0, NULL),
(156, 'Germanic languages', 'Germanic languages', '2018-01-01 00:00:00', NULL, -1, 'gem', 'germanic languages', 0, '', 0, NULL),
(157, 'ქართული', 'Georgian', '2018-01-01 00:00:00', NULL, -1, 'kat', 'kartuli', 0, '', 0, NULL),
(159, 'ግዕዝ', 'Geez', '2018-01-01 00:00:00', NULL, -1, 'gez', 'geez', 0, '', 0, NULL),
(160, 'Taetae ni Kiribati', 'Gilbertese', '2018-01-01 00:00:00', NULL, -1, 'gil', 'gilbertese', 0, '', 0, NULL),
(161, 'Gàidhlig', 'Gaelic; Scottish Gaelic', '2018-01-01 00:00:00', NULL, -1, 'gla', 'gaelic; scottish gaelic', 0, '', 0, NULL),
(162, 'Gaeilge', 'Irish', '2018-01-01 00:00:00', NULL, -1, 'gle', 'irish', 0, '', 0, NULL),
(163, 'galego', 'Galician', '2018-01-01 00:00:00', NULL, -1, 'glg', 'galician', 0, '', 0, NULL),
(164, 'Gaelg; Gailck', 'Manx', '2018-01-01 00:00:00', NULL, -1, 'glv', 'manx', 0, '', 0, NULL),
(165, 'Diutsch', 'Middle High German ca. 1050–1500', '2018-01-01 00:00:00', NULL, -1, 'gmh', 'middle high german (ca. 1050–1500)', 0, '', 0, NULL),
(166, 'Diutisk', 'Old High German ca. 750–1050', '2018-01-01 00:00:00', NULL, -1, 'goh', 'old high german (ca. 750–1050)', 0, '', 0, NULL),
(167, 'Gondi', 'Gondi', '2018-01-01 00:00:00', NULL, -1, 'gon', 'gondi', 0, '', 0, NULL),
(168, 'Bahasa Hulontalo', 'Gorontalo', '2018-01-01 00:00:00', NULL, -1, 'gor', 'gorontalo', 0, '', 0, NULL),
(169, 'Gothic', 'Gothic', '2018-01-01 00:00:00', NULL, -1, 'got', 'gothic', 0, '', 0, NULL),
(170, 'Grebo', 'Grebo', '2018-01-01 00:00:00', NULL, -1, 'grb', 'grebo', 0, '', 0, NULL),
(171, 'Ἑλληνική', 'Ancient Greek', '2018-01-01 00:00:00', NULL, -1, 'grc', 'hellenike', 0, '', 0, NULL),
(173, 'Avañe\'ẽ', 'Guarani', '2018-01-01 00:00:00', NULL, -1, 'grn', 'guarani', 0, '', 0, NULL),
(174, 'Schwiizerdütsch', 'Swiss German; Alemannic; Alsatian', '2018-01-01 00:00:00', NULL, -1, 'gsw', 'swiss german; alemannic; alsatian', 0, '', 0, NULL),
(175, 'ગુજરાતી', 'Gujarati', '2018-01-01 00:00:00', NULL, -1, 'guj', 'gujarati', 0, '', 0, NULL),
(176, 'Dinjii Zhu’ Ginjik', 'Gwichʼin', '2018-01-01 00:00:00', NULL, -1, 'gwi', 'gwichʼin', 0, '', 0, NULL),
(177, 'X̱aat Kíl; X̱aadas Kíl; X̱aayda Kil; Xaad kil', 'Haida', '2018-01-01 00:00:00', NULL, -1, 'hai', 'haida', 0, '', 0, NULL),
(178, 'kreyòl ayisyen', 'Haitian; Haitian Creole', '2018-01-01 00:00:00', NULL, -1, 'hat', 'haitian; haitian creole', 0, '', 0, NULL),
(179, 'Harshen Hausa; هَرْشَن', 'Hausa', '2018-01-01 00:00:00', NULL, -1, 'hau', 'hausa', 0, '', 0, NULL),
(180, 'ʻŌlelo Hawaiʻi', 'Hawaiian', '2018-01-01 00:00:00', NULL, -1, 'haw', 'hawaii', 0, '', 0, NULL),
(181, 'עברית‎', 'Hebrew', '2018-01-01 00:00:00', NULL, -1, 'heb', 'ivrit', 1, '', 0, NULL),
(182, 'Otjiherero', 'Herero', '2018-01-01 00:00:00', NULL, -1, 'her', 'herero', 0, '', 0, NULL),
(183, 'Ilonggo', 'Hiligaynon', '2018-01-01 00:00:00', NULL, -1, 'hil', 'hiligaynon', 0, '', 0, NULL),
(184, 'Himachali languages', 'Himachali languages; Western Pahari languages', '2018-01-01 00:00:00', NULL, -1, 'him', 'himachali languages; western pahari languages', 0, '', 0, NULL),
(185, 'हिन्दी', 'Hindi', '2018-01-01 00:00:00', NULL, -1, 'hin', 'hindi', 0, '', 0, NULL),
(186, '𒉈𒅆𒇷 nešili', 'Hittite', '2018-01-01 00:00:00', NULL, -1, 'hit', 'hittite', 0, '', 0, NULL),
(187, 'lus Hmoob; lug Moob; lol Hmongb', 'Hmong; Mong', '2018-01-01 00:00:00', NULL, -1, 'hmn', 'hmong; mong', 0, '', 0, NULL),
(188, 'Hiri Motu', 'Hiri Motu', '2018-01-01 00:00:00', NULL, -1, 'hmo', 'hiri motu', 0, '', 0, NULL),
(189, 'hrvatski', 'Croatian', '2018-01-01 00:00:00', NULL, -1, 'hrv', 'croatian', 0, '', 0, NULL),
(190, 'hornjoserbšćina', 'Upper Sorbian', '2018-01-01 00:00:00', NULL, -1, 'hsb', 'upper sorbian', 0, '', 0, NULL),
(191, 'Magyar nyelv', 'Hungarian', '2018-01-01 00:00:00', NULL, -1, 'hun', 'magyar', 0, '', 0, NULL),
(192, 'Na:tinixwe Mixine:whe\'', 'Hupa', '2018-01-01 00:00:00', NULL, -1, 'hup', 'hupa', 0, '', 0, NULL),
(194, 'Jaku Iban', 'Iban', '2018-01-01 00:00:00', NULL, -1, 'iba', 'iban', 0, '', 0, NULL),
(195, 'Asụsụ Igbo', 'Igbo', '2018-01-01 00:00:00', NULL, -1, 'ibo', 'igbo', 0, '', 0, NULL),
(196, 'íslenska', 'Icelandic', '2018-01-01 00:00:00', NULL, -1, 'isl', 'islenska', 0, '', 0, NULL),
(197, 'Ido', 'Ido', '2018-01-01 00:00:00', NULL, -1, 'ido', 'ido', 0, '', 0, NULL),
(198, 'ꆈꌠꉙ', 'Sichuan Yi; Nuosu', '2018-01-01 00:00:00', NULL, -1, 'iii', 'sichuan yi; nuosu', 0, '', 0, NULL),
(199, 'Ịjọ', 'Ijo languages', '2018-01-01 00:00:00', NULL, -1, 'ijo', 'ijo languages', 0, '', 0, NULL),
(200, 'ᐃᓄᒃᑎᑐᑦ', 'Inuktitut', '2018-01-01 00:00:00', NULL, -1, 'iku', 'inuktitut', 0, '', 0, NULL),
(201, 'Interlingue; Occidental', 'Interlingue; Occidental', '2018-01-01 00:00:00', NULL, -1, 'ile', 'interlingue; occidental', 0, '', 0, NULL),
(202, 'Pagsasao nga Ilokano; Ilokano', 'Iloko', '2018-01-01 00:00:00', NULL, -1, 'ilo', 'iloko', 0, '', 0, NULL),
(203, 'Interlingua', 'Interlingua - International Auxiliary Language Association', '2018-01-01 00:00:00', NULL, -1, 'ina', 'interlingua (international auxiliary language association)', 0, '', 0, NULL),
(204, 'Indo-Aryan languages', 'Indic languages', '2018-01-01 00:00:00', NULL, -1, 'inc', 'indic languages', 0, '', 0, NULL),
(205, 'Bahasa Indonesia', 'Indonesian', '2018-01-01 00:00:00', NULL, -1, 'ind', 'Indonesian', 0, '', 0, NULL),
(206, 'Indo-European languages', 'Indo-European languages', '2018-01-01 00:00:00', NULL, -1, 'iel', 'indo-european languages', 0, '', 0, NULL),
(207, 'ГӀалгӀай мотт', 'Ingush', '2018-01-01 00:00:00', NULL, -1, 'inh', 'ingush', 0, '', 0, NULL),
(208, 'Iñupiaq', 'Inupiaq', '2018-01-01 00:00:00', NULL, -1, 'ipk', 'inupiaq', 0, '', 0, NULL),
(209, 'Iranian languages', 'Iranian languages', '2018-01-01 00:00:00', NULL, -1, 'ira', 'iranian languages', 0, '', 0, NULL),
(210, 'Iroquoian languages', 'Iroquoian languages', '2018-01-01 00:00:00', NULL, -1, 'iro', 'iroquoian languages', 0, '', 0, NULL),
(212, 'Italiano; lingua italiana', 'Italian', '2018-01-01 00:00:00', NULL, -1, 'ita', 'italian', 0, '', 0, NULL),
(213, 'ꦧꦱꦗꦮ', 'Javanese', '2018-01-01 00:00:00', NULL, -1, 'jav', 'jawa', 0, '', 0, NULL),
(214, 'la .lojban.', 'Lojban', '2018-01-01 00:00:00', NULL, -1, 'jbo', 'lojban', 0, '', 0, NULL),
(215, '日本語', 'Japanese', '2018-01-01 00:00:00', NULL, -1, 'jpn', 'nihongo', 0, '', 0, NULL),
(216, 'Dzhidi', 'Judeo-Persian', '2018-01-01 00:00:00', NULL, -1, 'jpr', 'judeo-persian', 0, '', 0, NULL),
(217, 'عربية يهودية‎ / ערבית יהודית‎‎', 'Judeo-Arabic', '2018-01-01 00:00:00', NULL, -1, 'jrb', 'judeo-arabic', 0, '', 0, NULL),
(218, 'Qaraqalpaq tili; Қарақалпақ тили', 'Kara-Kalpak', '2018-01-01 00:00:00', NULL, -1, 'kaa', 'kara-kalpak', 0, '', 0, NULL),
(219, 'Tamaziɣt Taqbaylit; Tazwawt', 'Kabyle', '2018-01-01 00:00:00', NULL, -1, 'kab', 'kabyle', 0, '', 0, NULL),
(220, 'Jingpho', 'Kachin; Jingpho', '2018-01-01 00:00:00', NULL, -1, 'kac', 'kachin; jingpho', 0, '', 0, NULL),
(221, 'Kalaallisut; Greenlandic', 'Kalaallisut; Greenlandic', '2018-01-01 00:00:00', NULL, -1, 'kal', 'kalaallisut; greenlandic', 0, '', 0, NULL),
(222, 'Kamba', 'Kamba', '2018-01-01 00:00:00', NULL, -1, 'kam', 'kamba', 0, '', 0, NULL),
(223, 'ಕನ್ನಡ', 'Kannada', '2018-01-01 00:00:00', NULL, -1, 'kan', 'kannada', 0, '', 0, NULL),
(224, 'Karenic languages', 'Karen languages', '2018-01-01 00:00:00', NULL, -1, 'kar', 'karen languages', 0, '', 0, NULL),
(225, 'कॉशुर / كأشُر', 'Kashmiri', '2018-01-01 00:00:00', NULL, -1, 'kas', 'kashmiri', 0, '', 0, NULL),
(227, 'Kanuri', 'Kanuri', '2018-01-01 00:00:00', NULL, -1, 'kau', 'kanuri', 0, '', 0, NULL),
(228, 'ꦧꦱꦗꦮ', 'Kawi', '2018-01-01 00:00:00', NULL, -1, 'kaw', 'kawi', 0, '', 0, NULL),
(229, 'қазақ тілі / qazaq tili', 'Kazakh', '2018-01-01 00:00:00', NULL, -1, 'kaz', 'kazakh', 0, '', 0, NULL),
(230, 'Адыгэбзэ (Къэбэрдейбзэ)', 'Kabardian', '2018-01-01 00:00:00', NULL, -1, 'kbd', 'kabardian', 0, '', 0, NULL),
(231, 'কা কতিয়েন খাশি', 'Khasi', '2018-01-01 00:00:00', NULL, -1, 'kha', 'khasi', 0, '', 0, NULL),
(232, 'Khoisan languages', 'Khoisan languages', '2018-01-01 00:00:00', NULL, -1, 'khi', 'khoisan languages', 0, '', 0, NULL),
(233, 'ភាសាខ្មែរ', 'Central Khmer', '2018-01-01 00:00:00', NULL, -1, 'khm', 'central khmer', 0, '', 0, NULL),
(234, 'Saka', 'Khotanese; Sakan', '2018-01-01 00:00:00', NULL, -1, 'kho', 'khotanese; sakan', 0, '', 0, NULL),
(235, 'Gĩkũyũ', 'Kikuyu; Gikuyu', '2018-01-01 00:00:00', NULL, -1, 'kik', 'kikuyu; gikuyu', 0, '', 0, NULL),
(236, 'Kinyarwanda', 'Kinyarwanda', '2018-01-01 00:00:00', NULL, -1, 'kin', 'kinyarwanda', 0, '', 0, NULL),
(237, 'кыргызча; кыргыз тили', 'Kirghiz; Kyrgyz', '2018-01-01 00:00:00', NULL, -1, 'kir', 'kirghiz; kyrgyz', 0, '', 0, NULL),
(238, 'Kimbundu', 'Kimbundu', '2018-01-01 00:00:00', NULL, -1, 'kmb', 'kimbundu', 0, '', 0, NULL),
(239, 'कोंकणी', 'Konkani', '2018-01-01 00:00:00', NULL, -1, 'kok', 'konkani', 0, '', 0, NULL),
(240, 'Коми кыв', 'Komi', '2018-01-01 00:00:00', NULL, -1, 'kom', 'komi', 0, '', 0, NULL),
(241, 'Kongo', 'Kongo', '2018-01-01 00:00:00', NULL, -1, 'kon', 'kongo', 0, '', 0, NULL),
(242, '한국어', 'Korean', '2018-01-01 00:00:00', NULL, -1, 'kor', 'hankuko', 0, '', 0, NULL),
(243, 'Kosraean', 'Kosraean', '2018-01-01 00:00:00', NULL, -1, 'kos', 'kosraean', 0, '', 0, NULL),
(244, 'Kpɛlɛwoo', 'Kpelle', '2018-01-01 00:00:00', NULL, -1, 'kpe', 'kpelle', 0, '', 0, NULL),
(245, 'Къарачай-Малкъар тил; Таулу тил', 'Karachay-Balkar', '2018-01-01 00:00:00', NULL, -1, 'krc', 'karachay-balkar', 0, '', 0, NULL),
(246, 'karjal; kariela; karjala', 'Karelian', '2018-01-01 00:00:00', NULL, -1, 'krl', 'karelian', 0, '', 0, NULL),
(247, 'Kru languages', 'Kru languages', '2018-01-01 00:00:00', NULL, -1, 'kro', 'kru languages', 0, '', 0, NULL),
(248, 'कुड़ुख़', 'Kurukh', '2018-01-01 00:00:00', NULL, -1, 'kru', 'kurukh', 0, '', 0, NULL),
(249, 'Kwanyama', 'Kuanyama; Kwanyama', '2018-01-01 00:00:00', NULL, -1, 'kua', 'kuanyama; kwanyama', 0, '', 0, NULL),
(250, 'къумукъ тил/qumuq til', 'Kumyk', '2018-01-01 00:00:00', NULL, -1, 'kum', 'kumyk', 0, '', 0, NULL),
(251, 'Kurdî / کوردی‎', 'Kurdish', '2018-01-01 00:00:00', NULL, -1, 'kur', 'kurdish', 0, '', 0, NULL),
(252, 'Kutenai', 'Kutenai', '2018-01-01 00:00:00', NULL, -1, 'kut', 'kutenai', 0, '', 0, NULL),
(253, 'Judeo-español', 'Ladino', '2018-01-01 00:00:00', NULL, -1, 'lad', 'ladino', 0, '', 0, NULL),
(254, 'بھارت کا‎', 'Lahnda', '2018-01-01 00:00:00', NULL, -1, 'lah', 'lahnda', 0, '', 0, NULL),
(255, 'Lamba', 'Lamba', '2018-01-01 00:00:00', NULL, -1, 'lam', 'lamba', 0, '', 0, NULL),
(256, 'ພາສາລາວ', 'Lao', '2018-01-01 00:00:00', NULL, -1, 'lao', 'lao', 0, '', 0, NULL),
(257, 'Lingua latīna', 'Latin', '2018-01-01 00:00:00', NULL, -1, 'lat', 'latin', 0, '', 0, NULL),
(258, 'Latviešu valoda', 'Latvian', '2018-01-01 00:00:00', NULL, -1, 'lav', 'latvian', 0, '', 0, NULL),
(259, 'Лезги чӏал', 'Lezghian', '2018-01-01 00:00:00', NULL, -1, 'lez', 'lezghian', 0, '', 0, NULL),
(260, 'Lèmburgs', 'Limburgan; Limburger; Limburgish', '2018-01-01 00:00:00', NULL, -1, 'lim', 'limburgan; limburger; limburgish', 0, '', 0, NULL),
(261, 'Lingala', 'Lingala', '2018-01-01 00:00:00', NULL, -1, 'lin', 'lingala', 0, '', 0, NULL),
(262, 'Lietuvių kalba', 'Lithuanian', '2018-01-01 00:00:00', NULL, -1, 'lit', 'lithuanian', 0, '', 0, NULL),
(263, 'Lomongo', 'Mongo', '2018-01-01 00:00:00', NULL, -1, 'lol', 'mongo', 0, '', 0, NULL),
(264, 'Lozi', 'Lozi', '2018-01-01 00:00:00', NULL, -1, 'loz', 'lozi', 0, '', 0, NULL),
(265, 'Lëtzebuergesch', 'Luxembourgish; Letzeburgesch', '2018-01-01 00:00:00', NULL, -1, 'ltz', 'luxembourgish; letzeburgesch', 0, '', 0, NULL),
(266, 'Tshiluba', 'Luba-Lulua', '2018-01-01 00:00:00', NULL, -1, 'lua', 'luba-lulua', 0, '', 0, NULL),
(267, 'Kiluba', 'Luba-Katanga', '2018-01-01 00:00:00', NULL, -1, 'lub', 'luba-katanga', 0, '', 0, NULL),
(268, 'Luganda', 'Ganda', '2018-01-01 00:00:00', NULL, -1, 'lug', 'ganda', 0, '', 0, NULL),
(269, 'Cham\'teela', 'Luiseno', '2018-01-01 00:00:00', NULL, -1, 'lui', 'luiseno', 0, '', 0, NULL),
(270, 'Chilunda', 'Lunda', '2018-01-01 00:00:00', NULL, -1, 'lun', 'lunda', 0, '', 0, NULL),
(271, 'Dholuo', 'Luo - Kenya and Tanzania', '2018-01-01 00:00:00', NULL, -1, 'luo', 'luo (kenya and tanzania)', 0, '', 0, NULL),
(272, 'Mizo ṭawng', 'Lushai', '2018-01-01 00:00:00', NULL, -1, 'lus', 'lushai', 0, '', 0, NULL),
(273, 'македонски јазик', 'Macedonian', '2018-01-01 00:00:00', NULL, -1, 'mkd', 'macedonian', 0, '', 0, NULL),
(274, 'Madhura', 'Madurese', '2018-01-01 00:00:00', NULL, -1, 'mad', 'madurese', 0, '', 0, NULL),
(275, 'मगही', 'Magahi', '2018-01-01 00:00:00', NULL, -1, 'mag', 'magahi', 0, '', 0, NULL),
(276, 'Kajin M̧ajeļ', 'Marshallese', '2018-01-01 00:00:00', NULL, -1, 'mah', 'marshallese', 0, '', 0, NULL),
(277, 'मैथिली; মৈথিলী', 'Maithili', '2018-01-01 00:00:00', NULL, -1, 'mai', 'maithili', 0, '', 0, NULL),
(278, 'Basa Mangkasara / ᨅᨔ ᨆᨀᨔᨑ', 'Makasar', '2018-01-01 00:00:00', NULL, -1, 'mak', 'makasar', 0, '', 0, NULL),
(279, 'മലയാളം', 'Malayalam', '2018-01-01 00:00:00', NULL, -1, 'mal', 'malayala', 0, '', 0, NULL),
(280, 'Mandi\'nka kango', 'Mandingo', '2018-01-01 00:00:00', NULL, -1, 'man', 'mandingo', 0, '', 0, NULL),
(281, 'Te Reo Māori', 'Maori', '2018-01-01 00:00:00', NULL, -1, 'mri', 'maori', 0, '', 0, NULL),
(282, 'Austronesian languages', 'Austronesian languages', '2018-01-01 00:00:00', NULL, -1, 'map', 'austronesian languages', 0, '', 0, NULL),
(283, 'मराठी', 'Marathi', '2018-01-01 00:00:00', NULL, -1, 'mar', 'marathi', 0, '', 0, NULL),
(284, 'ɔl', 'Masai', '2018-01-01 00:00:00', NULL, -1, 'mas', 'masai', 0, '', 0, NULL),
(285, 'Bahasa Melayu', 'Malay', '2018-01-01 00:00:00', NULL, -1, 'msa', 'malay', 0, '', 0, NULL),
(286, 'мокшень кяль', 'Moksha', '2018-01-01 00:00:00', NULL, -1, 'mdf', 'moksha', 0, '', 0, NULL),
(287, 'Mandar', 'Mandar', '2018-01-01 00:00:00', NULL, -1, 'mdr', 'mandar', 0, '', 0, NULL),
(288, 'Mɛnde yia', 'Mende', '2018-01-01 00:00:00', NULL, -1, 'men', 'mende', 0, '', 0, NULL),
(289, 'Gaoidhealg', 'Middle Irish 900–1200', '2018-01-01 00:00:00', NULL, -1, 'mga', 'middle irish (900–1200)', 0, '', 0, NULL),
(290, 'Míkmawísimk', 'Mi\'kmaq; Micmac', '2018-01-01 00:00:00', NULL, -1, 'mic', 'mi\'kmaq; micmac', 0, '', 0, NULL),
(291, 'Baso Minang', 'Minangkabau', '2018-01-01 00:00:00', NULL, -1, 'min', 'minangkabau', 0, '', 0, NULL),
(292, 'Uncoded languages', 'Uncoded languages', '2018-01-01 00:00:00', NULL, -1, 'mis', 'uncoded languages', 0, '', 0, NULL),
(294, 'Austroasiatic languages', 'Mon-Khmer languages', '2018-01-01 00:00:00', NULL, -1, 'mkh', 'mon-khmer languages', 0, '', 0, NULL),
(295, 'Malagasy', 'Malagasy', '2018-01-01 00:00:00', NULL, -1, 'mlg', 'malagasy', 0, '', 0, NULL),
(296, 'Malti', 'Maltese', '2018-01-01 00:00:00', NULL, -1, 'mlt', 'maltese', 0, '', 0, NULL),
(297, 'ᠮᠠᠨᠵᡠ ᡤᡳᠰᡠᠨ', 'Manchu', '2018-01-01 00:00:00', NULL, -1, 'mnc', 'manchu', 0, '', 0, NULL),
(298, 'Meitei', 'Manipuri', '2018-01-01 00:00:00', NULL, -1, 'mni', 'manipuri', 0, '', 0, NULL),
(299, 'Manobo languages', 'Manobo languages', '2018-01-01 00:00:00', NULL, -1, 'mno', 'manobo languages', 0, '', 0, NULL),
(300, 'Kanien’kéha', 'Mohawk', '2018-01-01 00:00:00', NULL, -1, 'moh', 'mohawk', 0, '', 0, NULL),
(301, 'монгол хэл; ᠮᠣᠩᠭᠣᠯ ᠬᠡᠯᠡ', 'Mongolian', '2018-01-01 00:00:00', NULL, -1, 'mon', 'mongolian', 0, '', 0, NULL),
(302, 'Mooré', 'Mossi', '2018-01-01 00:00:00', NULL, -1, 'mos', 'mossi', 0, '', 0, NULL),
(305, 'Multiple languages', 'Multiple languages', '2018-01-01 00:00:00', NULL, -1, 'mul', 'multiple languages', 0, '', 0, NULL),
(306, 'Munda languages', 'Munda languages', '2018-01-01 00:00:00', NULL, -1, 'mun', 'munda languages', 0, '', 0, NULL),
(307, 'Mvskoke', 'Creek', '2018-01-01 00:00:00', NULL, -1, 'mus', 'creek', 0, '', 0, NULL),
(308, 'mirandés; lhéngua mirandesa', 'Mirandese', '2018-01-01 00:00:00', NULL, -1, 'mwl', 'mirandese', 0, '', 0, NULL),
(309, 'मारवाड़ी', 'Marwari', '2018-01-01 00:00:00', NULL, -1, 'mwr', 'marwari', 0, '', 0, NULL),
(311, 'Mayan languages', 'Mayan languages', '2018-01-01 00:00:00', NULL, -1, '', 'mayan languages', 0, '', 0, NULL),
(312, 'эрзянь кель', 'Erzya', '2018-01-01 00:00:00', NULL, -1, 'myv', 'erzya', 0, '', 0, NULL),
(313, 'Nahuan languages', 'Nahuatl languages', '2018-01-01 00:00:00', NULL, -1, 'nah', 'nahuatl languages', 0, '', 0, NULL),
(314, 'North American Indian languages', 'North American Indian languages', '2018-01-01 00:00:00', NULL, -1, 'nai', 'north american indian languages', 0, '', 0, NULL),
(315, 'napulitano', 'Neapolitan', '2018-01-01 00:00:00', NULL, -1, 'nap', 'neapolitan', 0, '', 0, NULL),
(316, 'dorerin Naoero', 'Nauru', '2018-01-01 00:00:00', NULL, -1, 'nau', 'nauru', 0, '', 0, NULL),
(317, 'Diné bizaad; Naabeehó bizaad', 'Navajo; Navaho', '2018-01-01 00:00:00', NULL, -1, 'nav', 'navajo; navaho', 0, '', 0, NULL),
(318, 'isiNdebele seSewula', 'South Ndebele', '2018-01-01 00:00:00', NULL, -1, 'nbl', 'south ndebele', 0, '', 0, NULL),
(319, 'siNdebele saseNyakatho', 'North Ndebele', '2018-01-01 00:00:00', NULL, -1, 'nde', 'north ndebele', 0, '', 0, NULL),
(320, 'ndonga', 'Ndonga', '2018-01-01 00:00:00', NULL, -1, 'ndo', 'ndonga', 0, '', 0, NULL),
(321, 'Plattdütsch; Plattdüütsch', 'Low German; Low Saxon', '2018-01-01 00:00:00', NULL, -1, 'nds', 'low german; low saxon', 0, '', 0, NULL),
(322, 'नेपाली भाषा', 'Nepali', '2018-01-01 00:00:00', NULL, -1, 'nep', 'nepali', 0, '', 0, NULL),
(323, 'नेवाः भाय्', 'Nepal Bhasa; Newari', '2018-01-01 00:00:00', NULL, -1, 'new', 'nepal bhasa; newari', 0, '', 0, NULL),
(324, 'Li Niha', 'Nias', '2018-01-01 00:00:00', NULL, -1, 'nia', 'nias', 0, '', 0, NULL),
(325, 'Niger-Congo languages', 'Niger-Kordofanian languages', '2018-01-01 00:00:00', NULL, -1, 'nic', 'niger-kordofanian languages', 0, '', 0, NULL),
(326, 'ko e vagahau Niuē', 'Niuean', '2018-01-01 00:00:00', NULL, -1, 'niu', 'niuean', 0, '', 0, NULL),
(327, 'Nederlands; Vlaams', 'Dutch; Flemish', '2018-01-01 00:00:00', NULL, -1, 'nld', 'nederlands', 0, '', 0, NULL),
(328, 'nynorsk', 'Norwegian Nynorsk', '2018-01-01 00:00:00', NULL, -1, 'nno', 'norwegian nynorsk', 0, '', 0, NULL),
(329, 'bokmål', 'Norwegian Bokmål', '2018-01-01 00:00:00', NULL, -1, 'nob', 'norwegian bokmål', 0, '', 0, NULL),
(330, 'Ногай тили', 'Nogai', '2018-01-01 00:00:00', NULL, -1, 'nog', 'nogai', 0, '', 0, NULL),
(331, 'Dǫnsk tunga; Norrœnt mál', 'Old Norse', '2018-01-01 00:00:00', NULL, -1, 'non', 'old norse', 0, '', 0, NULL),
(332, 'norsk', 'Norwegian', '2018-01-01 00:00:00', NULL, -1, 'nor', 'norwegian', 0, '', 0, NULL),
(333, 'N\'Ko', 'N\'Ko', '2018-01-01 00:00:00', NULL, -1, 'nqo', 'n\'ko', 0, '', 0, NULL),
(334, 'Sesotho sa Leboa', 'Pedi; Sepedi; Northern Sotho', '2018-01-01 00:00:00', NULL, -1, 'nso', 'pedi; sepedi; northern sotho', 0, '', 0, NULL),
(335, 'لغات نوبية‎', 'Nubian languages', '2018-01-01 00:00:00', NULL, -1, 'nub', 'nubian languages', 0, '', 0, NULL),
(336, 'पुलां भाय्; पुलाङु नेपाल भाय्', 'Classical Newari; Old Newari; Classical Nepal Bhasa', '2018-01-01 00:00:00', NULL, -1, 'nwc', 'classical newari; old newari; classical nepal bhasa', 0, '', 0, NULL),
(337, 'Chichewa; Chinyanja', 'Chichewa; Chewa; Nyanja', '2018-01-01 00:00:00', NULL, -1, 'nya', 'chichewa; chewa; nyanja', 0, '', 0, NULL),
(338, 'Nyamwezi', 'Nyamwezi', '2018-01-01 00:00:00', NULL, -1, 'nym', 'nyamwezi', 0, '', 0, NULL),
(339, 'Nkore', 'Nyankole', '2018-01-01 00:00:00', NULL, -1, 'nyn', 'nyankole', 0, '', 0, NULL),
(340, 'Runyoro', 'Nyoro', '2018-01-01 00:00:00', NULL, -1, 'nyo', 'nyoro', 0, '', 0, NULL),
(341, 'Nzema', 'Nzima', '2018-01-01 00:00:00', NULL, -1, 'nzi', 'nzima', 0, '', 0, NULL),
(342, 'occitan; lenga d\'òc; provençal', 'Occitan - post 1500', '2018-01-01 00:00:00', NULL, -1, 'oci', 'occitan (post 1500)', 0, '', 0, NULL),
(343, 'Ojibwe', 'Ojibwa', '2018-01-01 00:00:00', NULL, -1, 'oji', 'ojibwa', 0, '', 0, NULL),
(344, 'ଓଡ଼ିଆ', 'Oriya', '2018-01-01 00:00:00', NULL, -1, 'ori', 'oriya', 0, '', 0, NULL),
(345, 'Afaan Oromoo', 'Oromo', '2018-01-01 00:00:00', NULL, -1, 'orm', 'oromo', 0, '', 0, NULL),
(346, 'Wazhazhe ie / ???????????? ????', 'Osage', '2018-01-01 00:00:00', NULL, -1, 'osa', 'osage', 0, '', 0, NULL),
(347, 'Ирон æвзаг', 'Ossetian; Ossetic', '2018-01-01 00:00:00', NULL, -1, 'oss', 'ossetian; ossetic', 0, '', 0, NULL),
(348, 'لسان عثمانى‎ / lisân-ı Osmânî', 'Ottoman Turkish 1500–1928', '2018-01-01 00:00:00', NULL, -1, 'ota', 'ottoman turkish (1500–1928)', 0, '', 0, NULL),
(349, 'Oto-Pamean languages', 'Otomian languages', '2018-01-01 00:00:00', NULL, -1, 'oto', 'otomian languages', 0, '', 0, NULL),
(350, 'Papuan languages', 'Papuan languages', '2018-01-01 00:00:00', NULL, -1, 'paa', 'papuan languages', 0, '', 0, NULL),
(351, 'Salitan Pangasinan', 'Pangasinan', '2018-01-01 00:00:00', NULL, -1, 'pag', 'pangasinan', 0, '', 0, NULL),
(352, 'Pārsīk; Pārsīg', 'Pahlavi', '2018-01-01 00:00:00', NULL, -1, 'pal', 'pahlavi', 0, '', 0, NULL),
(353, 'Amánung Kapampangan; Amánung Sísuan', 'Pampanga; Kapampangan', '2018-01-01 00:00:00', NULL, -1, 'pam', 'pampanga; kapampangan', 0, '', 0, NULL),
(354, 'ਪੰਜਾਬੀ / پنجابی‎', 'Panjabi; Punjabi', '2018-01-01 00:00:00', NULL, -1, 'pan', 'panjabi', 0, '', 0, NULL),
(355, 'Papiamentu', 'Papiamento', '2018-01-01 00:00:00', NULL, -1, 'pap', 'papiamento', 0, '', 0, NULL),
(356, 'a tekoi er a Belau', 'Palauan', '2018-01-01 00:00:00', NULL, -1, 'pau', 'palauan', 0, '', 0, NULL),
(357, 'Old Persian', 'Old Persian ca. 600–400 B.C.', '2018-01-01 00:00:00', NULL, -1, 'peo', 'old persian (ca. 600–400 b.c.)', 0, '', 0, NULL),
(359, 'Philippine languages', 'Philippine languages', '2018-01-01 00:00:00', NULL, -1, 'phi', 'philippine languages', 0, '', 0, NULL),
(360, '𐤃𐤁𐤓𐤉𐤌 𐤊𐤍𐤏𐤍𐤉𐤌‬ dabarīm Kanaʿanīm', 'Phoenician', '2018-01-01 00:00:00', NULL, -1, 'phn', 'dabarim kanaanim', 0, '', 0, NULL),
(361, 'Pāli', 'Pali', '2018-01-01 00:00:00', NULL, -1, 'pli', 'pali', 0, '', 0, NULL),
(362, 'Polski (Polish)', 'Polish', '2018-01-01 00:00:00', NULL, -1, 'pol', 'polish', 0, '', 0, NULL),
(363, 'Pohnpeian', 'Pohnpeian', '2018-01-01 00:00:00', NULL, -1, 'pon', 'pohnpeian', 0, '', 0, NULL),
(364, 'Português', 'Portuguese', '2018-01-01 00:00:00', NULL, -1, 'por', 'portuguese', 0, '', 0, NULL),
(365, 'Prakrit languages', 'Prakrit languages', '2018-01-01 00:00:00', NULL, -1, 'pra', 'prakrit languages', 0, '', 0, NULL),
(366, 'Old Provençal', 'Old Provençal - to 1500; Old Occitan - to 1500', '2018-01-01 00:00:00', NULL, -1, 'pro', 'old provençal (to 1500); old occitan (to 1500)', 0, '', 0, NULL),
(367, 'پښتو', 'Pushto; Pashto', '2018-01-01 00:00:00', NULL, -1, 'pus', 'pushto; pashto', 0, '', 0, NULL),
(368, 'Runa simi; kichwa simi; Nuna shimi', 'Quechua', '2018-01-01 00:00:00', NULL, -1, 'que', 'quechua', 0, '', 0, NULL),
(369, 'राजस्थानी', 'Rajasthani', '2018-01-01 00:00:00', NULL, -1, 'raj', 'rajasthani', 0, '', 0, NULL),
(370, 'Vananga rapa nui', 'Rapanui', '2018-01-01 00:00:00', NULL, -1, 'rap', 'rapanui', 0, '', 0, NULL),
(371, 'Māori Kūki \'Āirani', 'Rarotongan; Cook Islands Maori', '2018-01-01 00:00:00', NULL, -1, 'rar', 'rarotongan; cook islands maori', 0, '', 0, NULL),
(372, 'Romance languages', 'Romance languages', '2018-01-01 00:00:00', NULL, -1, 'roa', 'romance languages', 0, '', 0, NULL),
(373, 'Rumantsch; Rumàntsch; Romauntsch; Romontsch', 'Romansh', '2018-01-01 00:00:00', NULL, -1, 'roh', 'romansh', 0, '', 0, NULL),
(374, 'romani čhib', 'Romany', '2018-01-01 00:00:00', NULL, -1, 'rom', 'romany', 0, '', 0, NULL),
(375, 'Limba română', 'Romanian; Moldavian; Moldovan', '2018-01-01 00:00:00', NULL, -1, 'ron', 'romanian; moldavian; moldovan', 0, '', 0, NULL),
(377, 'Ikirundi', 'Rundi', '2018-01-01 00:00:00', NULL, -1, 'run', 'rundi', 0, '', 0, NULL),
(378, 'armãneashce; armãneashti; rrãmãneshti', 'Aromanian; Arumanian; Macedo-Romanian', '2018-01-01 00:00:00', NULL, -1, 'rup', 'aromanian; arumanian; macedo-romanian', 0, '', 0, NULL),
(379, 'Русский язык', 'Russian', '2018-01-01 00:00:00', NULL, -1, 'rus', 'russki', 0, '', 0, NULL),
(380, 'Sandaweeki', 'Sandawe', '2018-01-01 00:00:00', NULL, -1, 'sad', 'sandawe', 0, '', 0, NULL),
(381, 'yângâ tî sängö', 'Sango', '2018-01-01 00:00:00', NULL, -1, 'sag', 'sango', 0, '', 0, NULL),
(382, 'Сахалыы', 'Yakut', '2018-01-01 00:00:00', NULL, -1, 'sah', 'yakut', 0, '', 0, NULL),
(383, 'South American Indian languages', 'South American Indian languages', '2018-01-01 00:00:00', NULL, -1, 'sai', 'south american indian languages', 0, '', 0, NULL),
(384, 'Salishan languages', 'Salishan languages', '2018-01-01 00:00:00', NULL, -1, 'sal', 'salishan languages', 0, '', 0, NULL),
(385, 'ארמית', 'Samaritan Aramaic', '2018-01-01 00:00:00', NULL, -1, 'sam', 'samaritan aramaic', 0, '', 0, NULL),
(386, 'संस्कृतम्', 'Sanskrit', '2018-01-01 00:00:00', NULL, -1, 'san', 'samskrta', 0, '', 0, NULL),
(387, 'Sasak', 'Sasak', '2018-01-01 00:00:00', NULL, -1, 'sas', 'sasak', 0, '', 0, NULL),
(388, 'ᱥᱟᱱᱛᱟᱲᱤ', 'Santali', '2018-01-01 00:00:00', NULL, -1, 'sat', 'santali', 0, '', 0, NULL),
(389, 'Sicilianu', 'Sicilian', '2018-01-01 00:00:00', NULL, -1, 'scn', 'sicilian', 0, '', 0, NULL),
(390, 'Braid Scots; Lallans', 'Scots', '2018-01-01 00:00:00', NULL, -1, 'sco', 'scots', 0, '', 0, NULL),
(391, 'Selkup', 'Selkup', '2018-01-01 00:00:00', NULL, -1, 'sel', 'selkup', 0, '', 0, NULL),
(392, 'Semitic languages', 'Semitic languages', '2018-01-01 00:00:00', NULL, -1, 'sem', 'semitic languages', 0, '', 0, NULL),
(393, 'Goídelc', 'Old Irish - to 900', '2018-01-01 00:00:00', NULL, -1, 'sga', 'old irish (to 900)', 0, '', 0, NULL),
(394, 'Sign languages', 'Sign languages', '2018-01-01 00:00:00', NULL, -1, 'sgn', 'sign languages', 0, '', 0, NULL),
(395, 'ၵႂၢမ်းတႆးယႂ်', 'Shan', '2018-01-01 00:00:00', NULL, -1, 'shn', 'shan', 0, '', 0, NULL),
(396, 'Sidaamu Afoo', 'Sidamo', '2018-01-01 00:00:00', NULL, -1, 'sid', 'sidamo', 0, '', 0, NULL),
(397, 'සිංහල', 'Sinhala; Sinhalese', '2018-01-01 00:00:00', NULL, -1, 'sin', 'sinhala; sinhalese', 0, '', 0, NULL),
(398, 'Siouan languages', 'Siouan languages', '2018-01-01 00:00:00', NULL, -1, 'sio', 'siouan languages', 0, '', 0, NULL),
(399, 'Sino-Tibetan languages', 'Sino-Tibetan languages', '2018-01-01 00:00:00', NULL, -1, 'sit', 'sino-tibetan languages', 0, '', 0, NULL),
(400, 'Slavic languages', 'Slavic languages', '2018-01-01 00:00:00', NULL, -1, 'sla', 'slavic languages', 0, '', 0, NULL),
(401, 'Slovenčina; Slovenský jazyk', 'Slovak', '2018-01-01 00:00:00', NULL, -1, 'slk', 'slovak', 0, '', 0, NULL),
(403, 'slovenski jezik; slovenščina', 'Slovenian', '2018-01-01 00:00:00', NULL, -1, 'slv', 'slovenian', 0, '', 0, NULL),
(404, 'Åarjelsaemien gïele', 'Southern Sami', '2018-01-01 00:00:00', NULL, -1, 'sma', 'southern sami', 0, '', 0, NULL),
(405, 'davvisámegiella', 'Northern Sami', '2018-01-01 00:00:00', NULL, -1, 'sme', 'northern sami', 0, '', 0, NULL),
(406, 'Sami languages', 'Sami languages', '2018-01-01 00:00:00', NULL, -1, 'smi', 'sami languages', 0, '', 0, NULL),
(407, 'julevsámegiella', 'Lule Sami', '2018-01-01 00:00:00', NULL, -1, 'smj', 'lule sami', 0, '', 0, NULL),
(408, 'anarâškielâ', 'Inari Sami', '2018-01-01 00:00:00', NULL, -1, 'smn', 'inari sami', 0, '', 0, NULL),
(409, 'Gagana faʻa Sāmoa', 'Samoan', '2018-01-01 00:00:00', NULL, -1, 'smo', 'samoan', 0, '', 0, NULL),
(410, 'sääʹmǩiõll', 'Skolt Sami', '2018-01-01 00:00:00', NULL, -1, 'sms', 'skolt sami', 0, '', 0, NULL),
(411, 'chiShona', 'Shona', '2018-01-01 00:00:00', NULL, -1, 'sna', 'shona', 0, '', 0, NULL),
(412, 'سنڌي / सिन्धी / ਸਿੰਧੀ', 'Sindhi', '2018-01-01 00:00:00', NULL, -1, 'snd', 'sindhi', 0, '', 0, NULL),
(413, 'Sooninkanxanne', 'Soninke', '2018-01-01 00:00:00', NULL, -1, 'snk', 'soninke', 0, '', 0, NULL),
(414, 'Sogdian', 'Sogdian', '2018-01-01 00:00:00', NULL, -1, 'sog', 'sogdian', 0, '', 0, NULL),
(415, 'af Soomaali', 'Somali', '2018-01-01 00:00:00', NULL, -1, 'som', 'somali', 0, '', 0, NULL),
(416, 'Songhay languages', 'Songhai languages', '2018-01-01 00:00:00', NULL, -1, 'son', 'songhai languages', 0, '', 0, NULL),
(417, 'Sesotho [southern]', 'Southern Sotho', '2018-01-01 00:00:00', NULL, -1, 'sot', 'southern sotho', 0, '', 0, NULL),
(418, 'Español; castellano', 'Spanish; Castilian', '2018-01-01 00:00:00', NULL, -1, 'spa', 'espanol', 0, '', 0, NULL),
(419, 'Shqip', 'Albanian', '2018-01-01 00:00:00', NULL, -1, 'sqi', 'shqip', 0, '', 0, NULL),
(420, 'sardu; limba sarda; lingua sarda', 'Sardinian', '2018-01-01 00:00:00', NULL, -1, 'srd', 'sardinian', 0, '', 0, NULL),
(421, 'Sranan Tongo', 'Sranan Tongo', '2018-01-01 00:00:00', NULL, -1, 'srn', 'sranan tongo', 0, '', 0, NULL),
(422, 'српски / srpski', 'Serbian', '2018-01-01 00:00:00', NULL, -1, 'srp', 'serbian', 0, '', 0, NULL),
(423, 'Seereer', 'Serer', '2018-01-01 00:00:00', NULL, -1, 'srr', 'serer', 0, '', 0, NULL),
(424, 'Nilo-Saharan languages', 'Nilo-Saharan languages', '2018-01-01 00:00:00', NULL, -1, 'ssa', 'nilo-saharan languages', 0, '', 0, NULL),
(425, 'siSwati', 'Swati', '2018-01-01 00:00:00', NULL, -1, 'ssw', 'swati', 0, '', 0, NULL),
(426, 'Kɪsukuma', 'Sukuma', '2018-01-01 00:00:00', NULL, -1, 'suk', 'sukuma', 0, '', 0, NULL),
(427, 'ᮘᮞ ᮞᮥᮔ᮪ᮓ / Basa Sunda', 'Sundanese', '2018-01-01 00:00:00', NULL, -1, 'sun', 'sundanese', 0, '', 0, NULL),
(428, 'Sosoxui', 'Susu', '2018-01-01 00:00:00', NULL, -1, 'sus', 'susu', 0, '', 0, NULL),
(429, '𒅴𒂠 EME.G̃IR15', 'Sumerian', '2018-01-01 00:00:00', NULL, -1, 'sux', 'sumer', 0, '', 0, NULL),
(430, 'Kiswahili', 'Swahili', '2018-01-01 00:00:00', NULL, -1, 'swa', 'kiswahili', 0, '', 0, NULL),
(431, 'Svenska', 'Swedish', '2018-01-01 00:00:00', NULL, -1, 'sve', 'swedish', 0, '', 0, NULL),
(432, 'Classical Syriac', 'Classical Syriac', '2018-01-01 00:00:00', NULL, -1, 'syc', 'classical syriac', 0, '', 0, NULL),
(433, 'ܠܫܢܐ ܣܘܪܝܝܐ', 'Syriac', '2018-01-01 00:00:00', NULL, -1, 'syr', 'syriac', 0, '', 0, NULL),
(434, 'Reo Tahiti; Reo Mā\'ohi', 'Tahitian', '2018-01-01 00:00:00', NULL, -1, 'tah', 'tahitian', 0, '', 0, NULL),
(435, 'ภาษาไท; ภาษาไต', 'Tai languages', '2018-01-01 00:00:00', NULL, -1, 'tai', 'tai languages', 0, '', 0, NULL),
(436, 'தமிழ்', 'Tamil', '2018-01-01 00:00:00', NULL, -1, 'tam', 'tamil', 0, '', 0, NULL),
(437, 'татар теле / tatar tele / تاتار', 'Tatar', '2018-01-01 00:00:00', NULL, -1, 'tat', 'tatar', 0, '', 0, NULL),
(438, 'తెలుగు', 'Telugu', '2018-01-01 00:00:00', NULL, -1, 'tel', 'telugu', 0, '', 0, NULL),
(439, 'KʌThemnɛ', 'Timne', '2018-01-01 00:00:00', NULL, -1, 'tem', 'timne', 0, '', 0, NULL),
(440, 'Terêna', 'Tereno', '2018-01-01 00:00:00', NULL, -1, 'ter', 'tereno', 0, '', 0, NULL),
(441, 'Lia-Tetun', 'Tetum', '2018-01-01 00:00:00', NULL, -1, 'tet', 'tetum', 0, '', 0, NULL),
(442, 'тоҷикӣ / tojikī', 'Tajik', '2018-01-01 00:00:00', NULL, -1, 'tgk', 'tajik', 0, '', 0, NULL),
(443, 'Wikang Tagalog', 'Tagalog', '2018-01-01 00:00:00', NULL, -1, 'tgl', 'tagalog', 0, '', 0, NULL),
(444, 'ภาษาไทย', 'Thai', '2018-01-01 00:00:00', NULL, -1, 'tha', 'thai', 0, 'Noto Sans Thai', 18, NULL),
(446, 'ትግረ; ትግሬ; ኻሳ; ትግራይት', 'Tigre', '2018-01-01 00:00:00', NULL, -1, 'tig', 'tigre', 0, '', 0, NULL),
(447, 'ትግርኛ', 'Tigrinya', '2018-01-01 00:00:00', NULL, -1, 'tir', 'tigrinya', 0, '', 0, NULL),
(448, 'Tiv', 'Tiv', '2018-01-01 00:00:00', NULL, -1, 'tiv', 'tiv', 0, '', 0, NULL),
(449, 'Tokelau', 'Tokelau', '2018-01-01 00:00:00', NULL, -1, 'tkl', 'tokelau', 0, '', 0, NULL),
(450, ' ', 'Klingon', '2018-01-01 00:00:00', NULL, -1, 'tlh', 'klingon', 0, '', 0, NULL),
(451, 'Lingít', 'Tlingit', '2018-01-01 00:00:00', NULL, -1, 'tli', 'tlingit', 0, '', 0, NULL),
(452, 'Tamasheq', 'Tamashek', '2018-01-01 00:00:00', NULL, -1, 'tmh', 'tamashek', 0, '', 0, NULL),
(453, 'chiTonga', 'Tonga Nyasa', '2018-01-01 00:00:00', NULL, -1, 'tog', 'tonga (nyasa)', 0, '', 0, NULL),
(454, 'lea faka-Tonga', 'Tonga - Tonga Islands', '2018-01-01 00:00:00', NULL, -1, 'ton', 'tonga (tonga islands)', 0, '', 0, NULL),
(455, 'Tok Pisin', 'Tok Pisin', '2018-01-01 00:00:00', NULL, -1, 'tpi', 'tok pisin', 0, '', 0, NULL),
(456, 'Tsimshian', 'Tsimshian', '2018-01-01 00:00:00', NULL, -1, 'tsi', 'tsimshian', 0, '', 0, NULL),
(457, 'Setswana', 'Tswana', '2018-01-01 00:00:00', NULL, -1, 'tsn', 'tswana', 0, '', 0, NULL),
(458, 'Xitsonga', 'Tsonga', '2018-01-01 00:00:00', NULL, -1, 'tso', 'tsonga', 0, '', 0, NULL),
(459, 'Türkmençe / Түркменче / تورکمن تیلی ,تورکمنچه; türkmen dili / түркмен дили', 'Turkmen', '2018-01-01 00:00:00', NULL, -1, 'tuk', 'turkmen', 0, '', 0, NULL),
(460, 'chiTumbuka', 'Tumbuka', '2018-01-01 00:00:00', NULL, -1, 'tum', 'tumbuka', 0, '', 0, NULL);
INSERT INTO `languages` (`id`, `name`, `englishname`, `created`, `info`, `user_id`, `code`, `name_sort`, `bdi`, `fontfamily`, `fontsize`, `characters`) VALUES
(461, 'Tupian languages', 'Tupi languages', '2018-01-01 00:00:00', NULL, -1, 'tup', 'tupi languages', 0, '', 0, NULL),
(462, 'Türkçe', 'Turkish', '2018-01-01 00:00:00', NULL, -1, 'tur', 'turkce', 0, '', 0, NULL),
(463, 'Altaic languages', 'Altaic languages', '2018-01-01 00:00:00', NULL, -1, 'tut', 'altaic languages', 0, '', 0, NULL),
(464, 'Te Ggana Tuuvalu; Te Gagana Tuuvalu', 'Tuvalua', '2018-01-01 00:00:00', NULL, -1, 'tvl', 'tuvalua', 0, '', 0, NULL),
(465, 'Twi', 'Twi', '2018-01-01 00:00:00', NULL, -1, 'twi', 'twi', 0, '', 0, NULL),
(466, 'тыва дыл', 'Tuvinian', '2018-01-01 00:00:00', NULL, -1, 'tyv', 'tuvinian', 0, '', 0, NULL),
(467, 'удмурт кыл', 'Udmurt', '2018-01-01 00:00:00', NULL, -1, 'udm', 'udmurt', 0, '', 0, NULL),
(468, 'Ugaritic', 'Ugaritic', '2018-01-01 00:00:00', NULL, -1, 'uga', 'ugaritic', 0, '', 0, NULL),
(469, 'ئۇيغۇرچە  ; ئۇيغۇر تىلى', 'Uighur; Uyghur', '2018-01-01 00:00:00', NULL, -1, 'uig', 'uighur; uyghur', 0, '', 0, NULL),
(470, 'українська мова', 'Ukrainian', '2018-01-01 00:00:00', NULL, -1, 'ukr', 'ukrainian', 0, '', 0, NULL),
(471, 'Úmbúndú', 'Umbundu', '2018-01-01 00:00:00', NULL, -1, 'umb', 'umbundu', 0, '', 0, NULL),
(472, 'Undetermined', 'Undetermined', '2018-01-01 00:00:00', NULL, -1, 'und', 'undetermined', 0, '', 0, NULL),
(473, 'اُردُو‎', 'Urdu', '2018-01-01 00:00:00', NULL, -1, 'urd', 'urdu', 0, '', 0, NULL),
(474, 'Oʻzbekcha / ўзбекча / ئوزبېچه; oʻzbek tili / ўзбек тили / ئوبېک تیلی', 'Uzbek', '2018-01-01 00:00:00', NULL, -1, 'uzb', 'uzbek', 0, '', 0, NULL),
(475, 'ꕙꔤ', 'Vai', '2018-01-01 00:00:00', NULL, -1, 'vai', 'vai', 0, '', 0, NULL),
(476, 'Tshivenḓa', 'Venda', '2018-01-01 00:00:00', NULL, -1, 'ven', 'venda', 0, '', 0, NULL),
(477, 'Tiếng Việt', 'Vietnamese', '2018-01-01 00:00:00', NULL, -1, 'vie', 'vietnamese', 0, '', 0, NULL),
(478, 'Volapük', 'Volapük', '2018-01-01 00:00:00', NULL, -1, 'vol', 'volapük', 0, '', 0, NULL),
(479, 'vađđa ceeli', 'Votic', '2018-01-01 00:00:00', NULL, -1, 'vot', 'votic', 0, '', 0, NULL),
(480, 'Wakashan languages', 'Wakashan languages', '2018-01-01 00:00:00', NULL, -1, 'wak', 'wakashan languages', 0, '', 0, NULL),
(481, 'Wolaitta; Wolaytta', 'Wolaitta; Wolaytta', '2018-01-01 00:00:00', NULL, -1, 'wal', 'wolaitta; wolaytta', 0, '', 0, NULL),
(482, 'Winaray; Samareño; Lineyte-Samarnon; Binisayâ nga Winaray; Binisayâ nga Samar-Leyte; “Binisayâ nga Waray”', 'Waray', '2018-01-01 00:00:00', NULL, -1, 'war', 'waray', 0, '', 0, NULL),
(483, 'wá:šiw ʔítlu', 'Washo', '2018-01-01 00:00:00', NULL, -1, 'was', 'washo', 0, '', 0, NULL),
(485, 'Serbsce / Serbski', 'Sorbian languages', '2018-01-01 00:00:00', NULL, -1, 'wen', 'sorbian languages', 0, '', 0, NULL),
(486, 'Walon', 'Walloon', '2018-01-01 00:00:00', NULL, -1, 'wln', 'walloon', 0, '', 0, NULL),
(487, 'Wolof', 'Wolof', '2018-01-01 00:00:00', NULL, -1, 'wol', 'wolof', 0, '', 0, NULL),
(488, 'Хальмг келн / Xaľmg keln', 'Kalmyk; Oirat', '2018-01-01 00:00:00', NULL, -1, 'xal', 'kalmyk; oirat', 0, '', 0, NULL),
(489, 'isiXhosa', 'Xhosa', '2018-01-01 00:00:00', NULL, -1, 'xho', 'isixhosa', 0, '', 0, NULL),
(490, 'Yao', 'Yao', '2018-01-01 00:00:00', NULL, -1, 'yao', 'yao', 0, '', 0, NULL),
(491, 'Yapese', 'Yapese', '2018-01-01 00:00:00', NULL, -1, 'yap', 'yapese', 0, '', 0, NULL),
(492, 'ייִדיש, יידיש; אידיש', 'Yiddish', '2018-01-01 00:00:00', NULL, -1, 'yid', 'yiddish', 1, '', 0, NULL),
(493, 'Èdè Yorùbá', 'Yoruba', '2018-01-01 00:00:00', NULL, -1, 'yor', 'ede yoruba', 0, '', 0, NULL),
(494, 'Yupik languages', 'Yupik languages', '2018-01-01 00:00:00', NULL, -1, 'ypk', 'yupik languages', 0, '', 0, NULL),
(495, 'Diidxazá', 'Zapotec', '2018-01-01 00:00:00', NULL, -1, 'zap', 'zapotec', 0, '', 0, NULL),
(496, 'Blissymbols', 'Blissymbols; Blissymbolics; Bliss', '2018-01-01 00:00:00', NULL, -1, 'zbl', 'blissymbols; blissymbolics; bliss', 0, '', 0, NULL),
(497, 'Tuḍḍungiyya', 'Zenaga', '2018-01-01 00:00:00', NULL, -1, 'zen', 'zenaga', 0, '', 0, NULL),
(498, 'ⵜⴰⵎⴰⵣⵉⵖⵜ ⵜⴰⵏⴰⵡⴰⵢⵜ', 'Standard Moroccan Tamazight', '2018-01-01 00:00:00', NULL, -1, 'zgh', 'standard moroccan tamazight', 0, '', 0, NULL),
(499, 'Vahcuengh / 話僮', 'Zhuang; Chuang', '2018-01-01 00:00:00', NULL, -1, 'zha', 'zhuang; chuang', 0, '', 0, NULL),
(501, 'Zande languages', 'Zande languages', '2018-01-01 00:00:00', NULL, -1, '', 'zande languages', 0, '', 0, NULL),
(502, 'isiZulu', 'Zulu', '2018-01-01 00:00:00', NULL, -1, 'zul', 'zulu', 0, '', 0, NULL),
(503, 'Shiwima', 'Zuni', '2018-01-01 00:00:00', NULL, -1, 'zun', 'zuni', 0, '', 0, NULL),
(504, 'No linguistic content; Not applicable', 'No linguistic content; Not applicable', '2018-01-01 00:00:00', NULL, -1, 'zxx', 'no linguistic content; not applicable', 0, '', 0, NULL),
(505, 'Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki', 'Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki', '2018-01-01 00:00:00', NULL, -1, 'zza', 'zaza; dimili; dimli; kirdki; kirmanjki; zazaki', 0, '', 0, NULL),
(511, 'Nheengatu', 'Modern Tupi', '2018-03-22 12:27:08', '', 2, 'nhe', 'modern tupi', 0, '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `itemorder` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb4_unicode_ci,
  `info` text COLLATE utf8mb4_unicode_ci,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `author` int(11) NOT NULL DEFAULT '-1',
  `uid` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_items`
--

CREATE TABLE `lesson_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lesson` int(11) NOT NULL DEFAULT '-1',
  `type` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci,
  `level` int(11) NOT NULL DEFAULT '-1',
  `course` int(11) NOT NULL DEFAULT '-1',
  `extra1` text COLLATE utf8mb4_unicode_ci,
  `extra2` text COLLATE utf8mb4_unicode_ci,
  `image` mediumblob,
  `audio` mediumblob NOT NULL,
  `itemorder` int(11) NOT NULL DEFAULT '0',
  `uid` text COLLATE utf8mb4_unicode_ci,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_items_usage`
--

CREATE TABLE `lesson_items_usage` (
  `id` int(11) NOT NULL,
  `item` int(11) NOT NULL DEFAULT '-1',
  `user` int(11) NOT NULL DEFAULT '-1',
  `course` int(11) NOT NULL DEFAULT '-1',
  `type` int(11) NOT NULL DEFAULT '-1',
  `lastused` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `correct` int(11) NOT NULL DEFAULT '0',
  `wrong` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` int(11) NOT NULL DEFAULT '-1',
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `author` int(11) NOT NULL DEFAULT '-1',
  `uid` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests_active`
--

CREATE TABLE `tests_active` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL DEFAULT '-1',
  `test` int(11) NOT NULL DEFAULT '-1',
  `started` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `uid` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xp` double NOT NULL DEFAULT '0',
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `createkey` char(23) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_alternatives`
--

CREATE TABLE `user_alternatives` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` text COLLATE utf8mb4_unicode_ci,
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL DEFAULT '-1',
  `course` int(11) NOT NULL DEFAULT '-1',
  `info` text COLLATE utf8mb4_unicode_ci,
  `started` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `uid` text COLLATE utf8mb4_unicode_ci,
  `level` int(11) NOT NULL DEFAULT '-1',
  `lesson` int(11) NOT NULL DEFAULT '-1',
  `lessonitem` int(11) NOT NULL DEFAULT '-1',
  `xp` double NOT NULL DEFAULT '0',
  `lastused` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `practice` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_suggestions`
--

CREATE TABLE `user_suggestions` (
  `id` int(11) NOT NULL,
  `target` char(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'course|level|lesson|item',
  `target_id` int(11) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `created` char(19) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2019-01-01 00:00:00',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` text COLLATE utf8mb4_unicode_ci,
  `info` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_levels`
--
ALTER TABLE `course_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_levels_completed`
--
ALTER TABLE `course_levels_completed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_items`
--
ALTER TABLE `lesson_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_items_usage`
--
ALTER TABLE `lesson_items_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests_active`
--
ALTER TABLE `tests_active`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_alternatives`
--
ALTER TABLE `user_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_suggestions`
--
ALTER TABLE `user_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `course_levels`
--
ALTER TABLE `course_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;
--
-- AUTO_INCREMENT for table `course_levels_completed`
--
ALTER TABLE `course_levels_completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=900;
--
-- AUTO_INCREMENT for table `lesson_items`
--
ALTER TABLE `lesson_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23584;
--
-- AUTO_INCREMENT for table `lesson_items_usage`
--
ALTER TABLE `lesson_items_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tests_active`
--
ALTER TABLE `tests_active`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_alternatives`
--
ALTER TABLE `user_alternatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_suggestions`
--
ALTER TABLE `user_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
