-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql5
-- Generation Time: Aug 11, 2016 at 05:18 PM
-- Server version: 5.5.49-0+deb7u1
-- PHP Version: 5.6.24-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kblumenstein_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `lehre_einme`
--

CREATE TABLE `lehre_einme` (
  `id` int(11) NOT NULL,
  `matrikelnummer` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lektion` int(11) NOT NULL,
  `code_html` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `code_css` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lehre_einme`
--

INSERT INTO `lehre_einme` (`id`, `matrikelnummer`, `lektion`, `code_html`, `code_css`, `timestamp`) VALUES
(2397, 'admin', 2, '<html>\n  <head>\n    <title></title>\n  </head>\n  <body>\n    am wichtigsten\n    sehr wichtig\n    wichtig\n    weniger wichtig\n    noch weniger wichtig\n    am wenigsten wichtig\n  </body>\n</html>', '', '2014-08-09 13:17:34'),
(2399, 'admin', 3, '<!DOCTYPE html>\n<html>\n  <head></head>\n  <body>\n    Was ich mir wÃ¼nsche:\n	iPhone6\n    schÃ¶nes Wetter\n    und noch viel mehr\n    \n    Was ich mir nicht wÃ¼nsche:\n    Nokia 1100\n    Regen\n    und sonst nichts \n  </body>\n</html>', '', '2014-08-09 13:34:10'),
(2402, 'admin', 4, '', '', '2014-08-09 13:45:43'),
(2403, 'admin', 5, '<!DOCTYPE html>\n<html>\n  	<head>\n    		<title>Inline-Styling mit CSS</title>\n  	</head>\n	<body>\n      	<p style="color:blue;">Ich will grÃ¼n sein!</p>\n      	<p style="color:#00FFFF;">Ich will rot als RGB-Wert sein!</p>\n      \n        	<p>\n          	Ãœberall dieselbe alte Leier.<br/>\n          	Das Layout ist fertig, der Text lÃ¤sst auf sich warten.\n      	</p>\n      	<p>\n          	Damit das Layout nun nicht nackt im Raume steht und sich klein und leer vorkommt,<br/>\n          	springe ich ein: der Blindtext.\n      	</p>\n  	</body>\n</html>\n', '', '2014-08-09 13:45:58'),
(2404, 'admin', 6, '<!DOCTYPE html>\n<html>\n  	<head>\n      	<title>\n      		Styling mit Internal Style Sheet\n      	</title>\n      	<style type="text/css">\n          	h1{\n            	font-size: 12px;\n          	}\n      	</style>\n  	</head>\n  	<body>\n		<h1>\n          	Gib mir die SchriftgrÃ¶ÃŸe 20px.\n      	</h1>\n      	<p>\n          	Ãœberall dieselbe alte Leier. Das Layout ist fertig, der Text lÃ¤sst auf sich warten.\n      	</p>\n\n		<p>\n          	Damit das Layout nun nicht nackt im Raume steht und sich klein und leer vorkommt, springe ich ein: der Blindtext.\n      	</p>\n\n		<p>\n          	Genau zu diesem Zwecke erschaffen, immer im Schatten meines groÃŸen Bruders Â»Lorem IpsumÂ«, freue ich mich jedes Mal, wenn Sie ein paar Zeilen lesen. Denn esse est percipi - Sein ist wahrgenommen werden. Und weil Sie nun schon die GÃ¼te haben, mich ein paar weitere SÃ¤tze lang zu begleiten, mÃ¶chte ich diese Gelegenheit nutzen, Ihnen nicht nur als LÃ¼ckenfÃ¼ller zu dienen, sondern auf etwas hinzuweisen, das\n      	</p>\n  	</body>\n</html>', '', '2014-08-09 13:46:40'),
(2405, 'admin', 7, '<!DOCTYPE html>\n<html>\n  <head>\n    <title>Box Modell</title>\n    <style type="text/css">\n      .content{\n        font-size: 32px;\n        background-color: rgb(128,128,255);\n        color: white;\n      }\n      \n      #box1{\n        width: 350px;\n        padding: 10px;\n        border: solid black 5px;\n        background-color: rgb(255,255,128);\n      }\n      \n      #box2{\n        width: 380px;\n        background-color: rgb(255,192,255);\n        font-size: 16px;\n        font-weight: bold;\n      }\n      \n      #box3{\n        width: 350px;\n        padding: 10px;\n        border: solid black 5px;\n        background-color: rgb(255,255,128);\n        margin: 30px;\n      }\n    </style>\n  </head>\n  <body>\n    <div id="box1">\n      <div class="content">Content</div>\n    </div>\n    <div id="box2">380px</div>\n    <div id="box3">\n      <div class="content">Content</div>\n    </div>\n  </body>\n</html>\n', '', '2014-08-09 13:52:53');
INSERT INTO `lehre_einme` (`id`, `matrikelnummer`, `lektion`, `code_html`, `code_css`, `timestamp`) VALUES
(2406, 'admin', 8, '<!DOCTYPE html>\n<html>\n	<head>\n  	</head>\n  	<body>\n      <h1>Wer tastet</h1>\n		<p>Wer tastet sich nachts die Finger klamm?<br>\n		Es ist der Programmierer mit seinem Programm!	<br>\n		Er tastet und tastet, er tastet schnell,<br>\n        im Osten wird schon der Himmel hell.<br>\n        Sein Haar ist ergraut, seine HÃ¤nde zittern,<br>\n          vom unablÃ¤ssigen Kernspeicher fÃ¼ttern.</p>\n  		\n      <h2>Das GeflÃ¼ster</h2>\n		<p>Da - aus dem Kernspeicher ertÃ¶nt ein GeflÃ¼ster:<br>\n        "Wer popelt in meinem Basisregister?"<br>\n        Nur ruhig, nur ruhig ihr lieben Bits,<br>\n        es ist doch nur ein kleiner Witz.<br>\n        Mein Meister, mein Meister, sieh mal dort,<br>\n        da schleicht sich ein Vorzeichen fort!<br>\n        Bleib ruhig, bleib ruhig, mein liebes Kind,<br>\n        ich hol es wieder - ganz bestimmt.<br>\n        Mein Meister, mein Meister, hÃ¶rst du das Grollen?<br>\n        Die wilden Bits durch den Kernspeicher tollen.<br>\n        Nur ruhig, nur ruhig, das haben wir gleich,<br>\n        die sperren wir in den Pufferbereich. \n      </p>\n      <h2>Der Anfang vom Ende</h2>\n        <p>Er tastet und tastet wie besessen,<br>\n        ScheiÃŸe! - jetzt hat er zu SAVEn vergessen.<br>\n        Der Programmierer schreit auf in hÃ¶chster Qual,<br>\n        da zuckt durch das Fenster ein Sonnenstrahl.<br>\n        Der Bildschirm flimmert im Morgenrot,<br>\n          das Programm ist gestorben, der Programmierer - tot.</p>\n      <p>Autor unbekannt</p>\n  	</body>\n</html>\n', '', '2014-10-06 06:18:16'),
(2407, 'admin', 9, '<!DOCTYPE html>\n<html>\n  <head>\n    <title>Positionierung</title>\n    <style type="text/css">\n      div{\n        background-color: lightgrey;\n      }\n    </style>\n  </head>\n  <body>\n    <div></div>\n  </body>\n</html>', '', '2014-08-09 15:19:33'),
(2408, 'admin', 10, '<!DOCTYPE html>\n<html>\n	<head>\n		<title>Positionierung</title>\n		<style type="text/css">\n			#left{\n				background: yellow;\n          	}\n			nav{\n            	color: white;\n            	background: black;\n			}\n			aside{\n            	background: cyan;\n          	}\n		</style>\n	</head>\n	<body>\n      	<article id="left">\n    		<div id="first">\n          		<img width="140px" src="http://www.wallpapers.net/robot-hd-wallpaper9135.jpg">\n      		</div><!-- #first -->\n			<p>\n        		Weit hinten, hinter den Wortbergen, fern der LÃ¤nder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen Sie in Buchstabhausen an der KÃ¼ste des Semantik, eines groÃŸen Sprachozeans. Ein kleines BÃ¤chlein namens Duden flieÃŸt durch ihren Ort und versorgt sie mit den nÃ¶tigen Regelialien. Es ist ein paradiesmatisches Land, in dem\n    		</p>\n      	</article><!-- #left -->\n      	<aside>\n          	<p>\n              	Weit hinten, hinter den Wortbergen, fern der LÃ¤nder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen Sie in Buchstabhausen an der KÃ¼ste des Semantik, eines groÃŸen Sprachozeans. Ein kleines BÃ¤chlein namens Duden flieÃŸt durch ihren Ort und versorgt sie mit den nÃ¶tigen Regelialien. Es ist ein paradiesmatisches Land, in dem\n          </p>\n    	</aside>\n		<nav>\n        	<ul>\n        	    <li>Home</li>\n        	    <li>About</li>\n        	    <li>Products</li>\n        	    <li>Contact</li>\n        	</ul>\n    	</nav>\n	</body>\n</html>', '', '2014-08-09 15:27:35'),
(2395, 'admin', 1, '<!DOCTYPE html>\n<html>\n	<head>\n     	<title></title>\n  	</head>\n	<body>\n  		<!-- sichtbarer Seiteninhalt -->\n  	</body>\n</html>', '', '2014-08-09 13:10:09'),
(2415, 'admin', 11, '<html>\n  <head>\n    <style type="text/css">\n        *{\n          	font-family: Arial, sans-serif;\n          	backgroundColor: lime;\n        }\n        #red{\n          	font-size: 0.8em;\n        }\n        .left, .img{\n        	float: lef;\n        }\n        left{\n          	width: 60%;\n          	margin-left: 5%;\n        }\n        img{\n        	width: 140px;\n        }\n        .left h1{\n          	color: white;\n        }\n     </style>\n  </head>\n  <body>\n  	<article id="red">\n  		<div class="img">\n      		<img src="http://www.wallpapers.net/little-robot-hd-wallpaper357.jpg">\n      	</div>\n      	<div class="left">\n        	<p><h1>Wer tastet </h1></p>\n        	<p>\n              	Wer tastet sich nachts die Finger klamm?<br>\n              	Es ist der Programmierer mit seinem Programm!	<br>\n                Er tastet und tastet, er tastet schnell,<br>\n                im Osten wird schon der Himmel hell.<br>\n                Sein Haar ist ergraut, seine HÃ¤nde zittern,<br>\n                vom unablÃ¤ssigen Kernspeicher fÃ¼ttern.\n            </p>\n		</div>\n	</article>\n    <article id="red">\n        <div class="img">\n            <img src="http://diremirth.files.wordpress.com/2012/04/sad_robot_by_natdatnl.jpg" alt="Sad Robot 2">\n        </div>\n        <div class="left">\n            <h1>Das GeflÃ¼ster</h2>\n            <p>\n            	Da - aus dem Kernspeicher ertÃ¶nt ein GeflÃ¼ster:<br>\n             	"Wer popelt in meinem Basisregister?"<br>\n              	Nur ruhig, nur ruhig ihr lieben Bits,<br>\n              	es ist doch nur ein kleiner Witz.<br>\n              	Mein Meister, mein Meister, sieh mal dort,<br>\n              	da schleicht sich ein Vorzeichen fort!<br>\n              	Bleib ruhig, bleib ruhig, mein liebes Kind,<br>\n              	ich hol es wieder - ganz bestimmt.<br>\n              	Mein Meister, mein Meister, hÃ¶rst du das Grollen?<br>\n              	Die wilden Bits durch den Kernspeicher tollen.<br>\n              	Nur ruhig, nur ruhig, das haben wir gleich,<br>\n              	die sperren wir in den Pufferbereich. \n        	</p>\n		</div>\n  	</article>\n  </body>\n</html>', '', '2014-10-05 09:07:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lehre_einme`
--
ALTER TABLE `lehre_einme`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lehre_einme`
--
ALTER TABLE `lehre_einme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4718;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
