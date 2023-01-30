-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 12:09 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `autor-text hilfstabelle`
--

CREATE TABLE `autor-text hilfstabelle` (
  `HID` int(11) NOT NULL,
  `TextID` int(11) NOT NULL,
  `AuthorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `autor-text hilfstabelle`
--

INSERT INTO `autor-text hilfstabelle` (`HID`, `TextID`, `AuthorID`) VALUES
(8, 8, 12),
(9, 9, 12),
(25, 25, 12),
(30, 30, 12),
(31, 31, 12),
(32, 32, 12),
(33, 33, 12),
(34, 34, 12),
(35, 35, 12),
(36, 36, 12),
(37, 37, 12),
(38, 38, 12),
(39, 39, 15),
(40, 40, 15),
(41, 41, 15),
(53, 53, 15),
(54, 54, 15),
(55, 55, 15),
(56, 56, 15),
(57, 57, 15),
(58, 58, 15),
(59, 59, 15),
(60, 60, 12),
(61, 61, 12),
(62, 62, 15),
(63, 63, 15),
(64, 64, 15),
(65, 65, 15),
(66, 66, 15),
(67, 67, 12),
(68, 68, 12),
(69, 69, 12),
(70, 70, 12),
(71, 71, 12),
(72, 72, 12),
(73, 73, 12),
(74, 74, 23),
(76, 76, 23),
(77, 77, 23),
(78, 78, 23),
(79, 79, 12),
(80, 80, 12),
(81, 81, 12),
(82, 82, 24),
(83, 83, 24),
(84, 84, 12),
(85, 85, 12);

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

CREATE TABLE `text` (
  `TextID` int(11) NOT NULL,
  `ArticleID` int(11) NOT NULL,
  `Title` text NOT NULL COMMENT 'Überschrift',
  `Content` mediumtext NOT NULL COMMENT 'Text des Artikels',
  `Position` int(11) NOT NULL,
  `Type` varchar(4) NOT NULL DEFAULT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `text`
--

INSERT INTO `text` (`TextID`, `ArticleID`, `Title`, `Content`, `Position`, `Type`) VALUES
(8, 14, 'Überfälle', 'err', 0, 'text'),
(9, 14, 'Bürgermeister', 'err', 0, 'text'),
(25, 23, 'Title 3', '__**--Text 3--**__', 0, 'text'),
(30, 12, 'Foolshope', 'Foolshope is a medium sized town in the south of {{Vuswil}}. It\'s a place often visited by sailors to entertain themselves\r\nGambling is the largest business in town and how most sailors lose their new found coin.', 0, 'text'),
(31, 12, 'Society', 'The city is ruled by a single family, the {{Montagus} Montagu Family} who profits off of the rampant gambling and sex work in the city.\r\nMost of the people there are only staying for a short while, being sailors. Those who live there are usually quite poor, unable\r\nto leave the city, being trapped in the system. The richer area is closer to the city centre where the institutions are.', 2, 'text'),
(32, 12, 'History', 'The city was founded by the {{Montagu family}} on top of the treasures of a dragon that had its home in the area. Foolshope is still ruled by the Montagu family to this day. {{William Montagu} Montagu Family}, who is in charge\r\nof security and the initial plot starter to {{campaign 2}}, {{Krea Montagu}}, who runs the city\r\nand {{Maurits Montagu}} who runs the harbour.', 3, 'text'),
(33, 12, 'Locations', '__Lady Luck Montagu Casino:__\r\n* It\'s a casino owned and operated by the Montagu family.\r\n\r\n__Safe Lady:__ \r\n* Local inn in the eastern part of the city. The place, the party uses to sleep.\r\n\r\n__Temple of Ephios; Goddess of love:__\r\n* It\'s essentially a brothel. {{Dreni} Drens} is a regular at this establishment.\r\n\r\n__Entrance Towers:__\r\n* Instead of gates, Foolshope has 2 usually, heavily guarded towers in front of the city.\r\n\r\n__Temple of Maara; Goddess of Luck:__\r\n* unknown\r\n\r\n__Kalte Spinne:__\r\n* Local Tavern\r\n\r\n__Vuswil bar:__\r\n* Vuswil\'s chain of taverns; not very popular among locals. ', 4, 'text'),
(34, 27, 'Montagu Family', 'The montagus are a wealthy family of drows who founded the city of Foolshope, 3 of the siblings currently rule over the city. ', 0, 'text'),
(35, 28, 'Ascua', 'Ascua is a flourishing country with extensive trade-circles, and is the northernmost civilization on the west side of {{Geran}}.', 0, 'text'),
(36, 28, 'Society', 'The god of Arts, {{Laton}}, is heavily represented within Ascua.', 2, 'text'),
(37, 28, 'History', 'unknown', 3, 'text'),
(38, 28, 'Locations', '__Geographic Locations:__\r\n* {{Pantheon\'s Summit}}', 4, 'text'),
(39, 29, 'Edofast', 'Edofast is Vuswil\'s capital and is located upon the river next to {{Covencona Forest}}.\r\nThe city is also known as a scientific centre thanks to its university.', 0, 'text'),
(40, 29, 'Society', 'Large portions of Edofast\'s population are eager to acquire knowledge and those who are not able to\r\nstudy at the university are frowned upon. They strongly believe in the god of {{knowledge}}.[[22]]', 0, 'text'),
(41, 29, 'History', 'unknown', 0, 'text'),
(53, 37, 'Geography of Geran', 'To the civilizations of Geran, this continent is the entire world. No other landmasses have been discovered\r\nand so the planet on which they live has been named after the continent Geran. ', 0, 'text'),
(54, 37, 'Division of power', 'As of today, 7 nations control the contient.\r\n{{Vuswil}}, to the south-west\r\n{{Quake}}, to the west\r\n{{Ascua}}, north to Vuswil in the north-western region\r\n{{Ushana}}, lying at the centre, the desert region of Ushana poses a great challange to any traveler\r\n{{Torr}}, separated from Ascua by Ushana and the sea, Torr lies at the north-eastern end of Geran\r\n{{Afril}} lies beneath Ushana and Torr, and finally\r\n{{Xoana}} at the very east end of the continent. ', 2, 'text'),
(55, 37, 'Geographical Features', 'currently unknown ', 3, 'text'),
(56, 37, 'The seas', 'currently unknown', 4, 'text'),
(57, 38, 'Laton', 'Laton is the {{God} Gods} of art.', 0, 'text'),
(58, 39, 'Pantheon', 'The Pantheon\'s summit is the largest mountain located within the country of {{Ascua}}.', 0, 'text'),
(59, 39, 'History', 'unknown', 1, 'text'),
(60, 40, 'History', 'Calendar: A year on geran has 4 months with 28 days. Oen, Odem, Zenith and Ripe. A year is therefore 112 days long.\r\n{{Odem\'s} Odem} death marks the year 1AF (After fall | As(s) fuck).\r\nThe ancient empire that used to rule has almost perfected the art of magic and created a lot of powerful magical items.\r\nThe king however, wanted to bring as many magical items as possible under his own control and only gave out weak items.\r\nHe soon became the most powerful person in the world.\r\nSomeone of similar strength, a gnome named \"Nermin Akiko\"\r\nstood against the king for freedom and lead a revolution against the king.\r\n\r\nConsidering how much knowledge of the past was lost and the destruction that was caused in the battle between them, it is believed that the revolution succeeded.\r\nSome believe it may have lasted only hours, others believe the destruction was spread over many hundreds of years.\r\nAll survivors of the war decided that something like this should not happen again and destroyed as most knowledge about magic and science as they could and removed the memories of others.\r\nThe few who do remember, kept the knowledge to themselves.\r\nThe king, in his power, created a race of people. {{Tieflings}}, who are hated for their heritage of the king and carry the burden that is the name Odem.\r\n{{Geran}} is now in a somewhat peaceful era that has lasted for over 1.500 years.\r\nThere have been lots of developments but also a few conflicts. There are now 7 independent countries and a so called North-west alliance, consisting of the countries\r\n{{Vuswil}}, {{Quake}} and {{Ascua}} has been formed.\r\n{{Afril}} and {{Ushana}} are both warmongering countries.\r\nNothing about the other two countries {{Xoana}} and {{Torr}} was dropped. ', 0, 'text'),
(61, 40, 'Timeline', 'coming in the future', 1, 'text'),
(62, 41, 'Odem', 'Odem was the king of {{Gruran}}, an ancient civilization that once ruled over Geran.\r\nHis hunger for power, reaching that of the gods, has resulted in the creation of numerous artefacts and magical items.\r\nMany of them are still hidden within the deepest corners of Geran. Odem\'s death marks the start of a new era\r\nand thus the year 0. ', 0, 'text'),
(63, 42, 'Gruran', 'In ancient history, approximately 1500 years ago, Gruran was an enormous kingdom, spanning over the entire continent of {{Geran}}. It is believed that the name \"Geran\" developed from this civilization.\r\nIt was said to be ruled by a king named {{Odem}}, who craved the power of the {{gods} Gods}.\r\nSome say that most of the world\'s remaining artefacts and powerful items once belonged to Odem.', 0, 'text'),
(64, 42, 'Society', 'Government: Monarchy', 1, 'text'),
(65, 42, 'History', 'The king\'s greed for power grew and grew and soon became the most powerful person on the continent.\r\nA gnome \"Nermin Akiko\", the only person who could rival his strength stood against the king and lead a revolution that resulted in a full out war, resulting in the death of the king and the fall of Gruran. ', 2, 'text'),
(66, 42, 'Locations', 'unknown', 3, 'text'),
(67, 43, 'Xoana', 'Xoana is the country located at the very east of the continent.', 0, 'text'),
(68, 43, 'Society', 'unknown', 1, 'text'),
(69, 43, 'History', 'unknown', 2, 'text'),
(70, 43, 'Locations', '__Cities:__\r\n* {{Faen}}', 3, 'text'),
(71, 44, 'Faen', 'Faen is {{Xoana\'s} Xoana} capital.', 0, 'text'),
(72, 44, 'Society', 'unknown', 1, 'text'),
(73, 44, 'History', 'unknown', 2, 'text'),
(74, 46, 'Vuswil', 'Vuswil is a region in the south-west of Geran. It has a temperate climate and access to the sea.\r\nIt\'s capital is {{Edofast}}.', 0, 'text'),
(76, 46, 'Society', '__Government:__ Monarchy\r\nUnlike many other monarchies, Vuswil\'s ruler isn\'t decided by one family tree,\r\ninstead something like a \"king\'s hunt\" is performed. ', 2, 'text'),
(77, 46, 'History', 'About 4 years ago, Vuswil lost their old king, who was heavily\r\ninfluenced by the god {{Taas}} and banned the worship of\r\nvarious gods, including {{Rabu}}. Now king Charles rules over Vuswil\r\nbut hasn\'t really found his place in the kingdom.\r\nIn response to {{Ushana\'s} Ushana} aggressions, Charles decided to\r\nconstruct {{Belfort}} and build up a military. ', 3, 'text'),
(78, 46, 'Locations', '**__Cities:__**\r\n* {{Edofast}}\r\n* {{Oregate}}\r\n* {{Whitebay}}\r\n* {{Orkrin}}\r\n* {{Belfort}}\r\n* {{Foolshope}}\r\n* {{Silveroak}}\r\n* {{Merrihill}}\r\n* {{Leerwick}}\r\n* {{Deepmarsh}}\r\n* {{Lochfog}}\r\n* {{Tow}}\r\n* {{Mirestone}}\r\n**__Geographic Locations:__**\r\n* {{Covencona Forest}}\r\n* {{Calm Woods}}\r\n* {{Starpeak}}\r\n* {{Misty Rise}}', 4, 'text'),
(79, 27, 'William', 'William Montagu is a brown haired and eyed drow, who is approximately 400 years old and 2 metres tall.\r\nHe is responsible for the security of {{Foolshope}}.\r\nHe died during Campaign 2 of reasons we jet don\'t know.', 1, 'text'),
(80, 27, 'Krea', 'Krea Montagu is William\'s older sister. She has a slightly thinner stature and is also a bit shorter\r\nthan her brother. She also has brown hair and eyes. She is managing the ciy.\r\nShe was invoved in riots against her brother William Montagu and send letters to an underground organisation, to whom she is known as Nildax. Almost all of these letters were decyphered with the exception of \"Phantom Erwache\" at the end of each letter.', 2, 'text'),
(81, 27, 'Maurits', 'Maurits is the last of the three Montagu siblings. He is the harbour-master of {{Foolshope}} but spends a lot of his time drinking instead.\r\n', 3, 'text'),
(82, 54, 'Party', '__**Core Members:**__\r\n* {{Aurazil}}\r\n* {{Daisy}}\r\n* {{Klonk}}\r\n* {{Lucy}}\r\n* {{Vardos}}\r\n\r\n__**Guests:**__\r\n* {{Varus} Campaign 3 - Guests}\r\n* {{Seneth} Campaign 3 - Guests}', 0, 'text'),
(83, 54, 'Sessions', '__**Sessions:**__\r\n* {{S01: DnDie Bärenjagt}}\r\n* {{S02: DnDie Exekution}}\r\n* {{S03: DnDas Ungeheuer}}\r\n* {{S04: DnDas Pilzdorf}}\r\n* {{S05: DnDie Ent-führung}}\r\n* {{S06: DnDie Dornen}}\r\n* {{S07: DnDie Nachtwache}}\r\n* {{S08: DnDas Neue Zeitalter}}\r\n* {{S09: DnDiplomatisnt}}\r\n* {{S10: DnDie Waisenkinder}}\r\n* {{S11: DnDie Apprentices}}', 1, 'text'),
(84, 55, 'Log', 'The TT’s wake up in their Tiny Hut that was set on the centre of the marketplace in Leerwick, where everyone except Vardos and the Children Helen and Jan, got up in time and notice that it is pretty crowded with many rough looking individuals. After an unrestingly sleep Vardos gets picked up by Klonk, who throws him after the instructions of Aurazil in the near by stream of water to get him cleaned and waken up.\r\nAfter the short dispute the two of them head to the smith Luan, who after close inspection isn’t blinking while he isn’t interacting with any living creature and seems to be stuck in the same motion of hammering on a glowing-hot sword. As they ask him for the orders form yesterday, he firstly puts the blade aside before greeting them and exchanging the gold for a breastplate for Aurazil and a warhammer for Klonk. When they leave him for Loan, the leather worker, he returns to his idle animation. He seems to be stuck in the same situation as well, where he tends a large piece of leather before talking to the two customers. They notice as they talk to him, that he has huge bags under his eyes and looks overall pretty tiered. From him they acquire two sets of leather armour and head off to the woodworker Lian to receive the ordered bows and arrows.\r\nIn the meantime, Lucy, Dacy, Helen, Jan, and Vardos head back to their carts and ready the horses for the journey, at least Dacy and Lucy are doing the work, Vardos is continuing his sleep in the back of the cart wrapped in a blanked like a dorito.\r\nAs the two shoppers return from their morning mission all of them set up a travelling order and make their way out of the town, where they are confronted with the gate guard who is engaged in a heated discussion with a commoner, who wants to seek refuge in the town from the horrors of Foolshope, but his plea is denied. When the guard is asked for leaving he happily lets the TT’s go. Upon opening the gate, a over a hundred metres long line of desperate creatures is revealed to the heroes, who seam to take no particular notice of them and instead ride along the road. Some hours into their trip Klonk is asked by Helen, if is frightened some times and what to do in times of sorrow to what he responses with a emotionally touching and honest answer, that fades into silence as both of them reflect on these moving words.\r\nAs the sun sets, they make halt and enter their hut for an evening’s rest, but to Klonks astonishment his bows is half eaten by seemingly a larger creature, which sets his personal nightly obligation to protect everyone from whatever thing that was. Aurazil starts the training of Jan and Helen in shooting the bow, in which Helen is far better in achieving good result, like shooting twice in the exact same spot in the middle of the bedroll , as Jan, who gets a bit upset, but trains long after the twilight has faded and the light casted by Aurazil is gone out. In this time, as the others are going to bed, Aurazil discovers a Lute in the hut and tries to play it on the roof while the thunderstorm has started in his shift. As their shifts come to an end, they move Aurazils bed to the fireplace to get him dry, but in doing so they wake up Helen and Vardos, who take their turn for the watch, in which Helen asks Vardos if he has a Mother and after explaining, that he has lost contact with her, she tell asks why to which he isn’t replying properly and instead suggests writing a letter to deal with the feeling. Afterwards they both sink into writing, Vardos in his book and Helen into supposedly a letter for her parents. The third shift is held by Dacy, who had a uneventful time and is enjoying the beautiful sunrise.\r\nThe second day of travel isn’t much different than the first. They take the right turn to Foolshope at the intersection and travel alongside the Misty Rise mountain range and further distancing themselves from the Covencona Forest and the high Starpeak. \r\nThey continue traveling for the next one and a half days, until they see a camp with many creatures in white/blue armour, that are the Griwarn guard -  the royal guard of Vuswil -, in the distance and approach them. After a perfect parallel parking of Dacy and a not as effortless attempt of Lucy to do the same the party meets the Leader Manu of this checkpoint. He tells them of the happenings in Foolshope, that some cult has arisen and nothing, but death and despair is left there, and thinks that they are nothing more than just some greedy mercenaries with no stive for honour or the common interest but solely money, to which the party isn’t really helping with explaining about expanses and wear of the utilities to counter this accusation. They agree on giving him the information of Foolshope that he seeks in return of free passage and money on return. They are shortly afterwards led by Mitre to the clerics for buying diamonds for 600 GP, so that in the case of death Aurazil could give last aid and revive those who have fallen. As they are about to go Manu gives each of them a emblem of the Griwarn so that they can identify themselves to the regularly sent patrols of the guard. As the TT’s realise, that they don’t have enough arrows to fight the possible dangers ahead, the two younglings get a brief introduction to fighting with an handaxe on which Helen outcompetes Jan as well. \r\nAs they come close to Foolshope they see the huge crater in the town centre and make out a cliff to their right from which they could get a good overview of the situation ahead. As they inspect the city they notice some patrols, the two towers of the entrance (one of which is broken down), piles of corpses everywhere, destroyed buildings, a underground tunnel system, that is revealed by the crater and a tree in the distance, that got split in two by a lightning strike. As they discuss on their options to get to the harbour area, that seamed to be empty of patrols, they decide to walk on the lower edge of the outer cliffs until they reach the sea. The execution of this plan hasn’t worked as sneaky as intended due to some rocks falling down and alerting the patrols. The TraumaTeam manages to find shelter in time, before a group of dragonborn come to the marketplace but can’t find them and stay suspicious. The Group waits some time after the Dragonborns have left the area and make their way to the pear. Aurazil notices a corpse on the beach and check for its source of death, which was the mast falling down on its head. He as well reads from this situation, that the it was once a dwarven lady who had three children, one of them would have been in the future.\r\nOn entering the underdeck of the two-master Klonk notices many pairs of glowing yellow eyes staring at him from the dark and in a sudden movement many of them race toward him and bite him in the chest. It takes some time, until the other members realise what’s happening and start helping their friend, at least most of them. After the danger is dealt with Aurazil spots a chest that turns out to be a mimic and sucks its self to his face. \r\nThe session ends with the TT’s defeating the mimic.\r\n', 1, 'text'),
(85, 55, 'Quick Info', 'Date: 14th January 2023', 0, 'text');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor-text hilfstabelle`
--
ALTER TABLE `autor-text hilfstabelle`
  ADD PRIMARY KEY (`HID`),
  ADD KEY `TextID` (`TextID`),
  ADD KEY `autor-text hilfstabelle_autor_AutorID_fk` (`AuthorID`);

--
-- Indexes for table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`TextID`),
  ADD KEY `ArtikelID` (`ArticleID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `autor-text hilfstabelle`
--
ALTER TABLE `autor-text hilfstabelle`
  ADD CONSTRAINT `autor-text hilfstabelle_autor_AutorID_fk` FOREIGN KEY (`AuthorID`) REFERENCES `author` (`AuthorID`),
  ADD CONSTRAINT `autor-text hilfstabelle_ibfk_1` FOREIGN KEY (`TextID`) REFERENCES `text` (`TextID`);

--
-- Constraints for table `text`
--
ALTER TABLE `text`
  ADD CONSTRAINT `text_ibfk_1` FOREIGN KEY (`ArticleID`) REFERENCES `article` (`ArticleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
