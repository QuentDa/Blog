-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 01 fév. 2018 à 11:33
-- Version du serveur :  5.7.20-18-log
-- Version de PHP :  7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `content` longtext NOT NULL,
  `summary` text NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `category_id`, `title`, `created_at`, `content`, `summary`, `is_published`) VALUES
(1, 1, '« Le Crime de l’Orient Express » : rencontre avec Kenneth Branagh', '2018-01-10', '<p>Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat.</p>', 'Résumé de l\'article Le Crime de l’Orient Express', 1),
(2, 4, 'Pourquoi \"Mario + Lapins Crétins : Kingdom Battle\" est le jeu de la rentrée', '2018-01-16', '<p>Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>', 'Résumé de l\'article Mario + Lapins Crétins', 0),
(3, 4, 'Pourquoi \"Destiny 2\" est un remède à l’ultra-moderne solitude', '2018-01-14', '<p>Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam.</p>', ' Résumé de l\'article Destiny 2', 1),
(4, 2, 'BO de « Les seigneurs de Dogtown » : l’époque bénie du rock.', '2018-01-03', '<p>Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula.</p>', 'Résumé de l\'article Les seigneurs de Dogtown', 1),
(5, 4, 'Comment “Assassin’s Creed” trouve un nouveau souffle en Egypte', '2018-01-06', '<p>Ut velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar.</p>', 'Résumé de l\'article Assassin’s Creed', 0),
(6, 4, 'De “Skyrim” à “L.A. Noire” ou “Doom” : pourquoi les vieux jeux sont meilleurs sur la Switch', '2018-01-17', '<p>Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>', 'Résumé de l\'article Switch', 1),
(7, 2, 'Revue - The Ramones', '2018-01-08', '<p>Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh.</p>', 'Résumé de l\'article The Ramones', 1),
(8, 1, 'Critique « Star Wars 8 – Les derniers Jedi » de Rian Johnson : le renouveau de la saga ?', '2018-01-01', '<p>Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue.</p>', 'Résumé de l\'article Star Wars 8', 0),
(9, 2, 'Hellfest 2018, l\'affiche quasi-complète', '2018-01-13', '<p>Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. </p>', 'Résumé de l\'article Hellfest', 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Cinéma', 'Trailers, infos, sorties...'),
(2, 'Musique', 'Concerts, sorties d\'albums, festivals...'),
(3, 'Théâtre', 'Dates, représentations, avis...'),
(4, 'Jeux vidéos', 'Videos, tests...');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(225) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `is_admin`, `bio`) VALUES
(1, 'Maxime', 'Basset', 'maxime.basset31@gmail.com', 'pooloo', 1, 'Bio de l\'utilisateur'),
(2, 'qDQSD', 'KHGG', 'maxime.basset31@gmail.comDS', 'K%KJLKJ', 0, 'KJ%MKJMKJ%P H%LKHJOMGMHIGLIGM'),
(5, 'Tomy', 'Hilfinger', 'jetesttonblog@leback.com', 'coucouc\'estmùoi', 1, 'je suis né depuis j\'improvise'),
(6, 'ah ', 'ouais', 'c\'estpasmal@relouilsveulentuneadressemail.com', 'maisbon', 0, 'apresvoilàquoi'),
(7, 'fgvbjkl,m', 'vhbn,l;', 'toto@lola.42', 'totolola42', 1, 'toto'),
(8, 'jaipas', 'faitlephp', 'jesuisdsl@gmail.com', 'jesperejauraispas0', 1, 'maxvametaper'),
(9, 'yavaitduphp', 'àfaireserieux', 'maxtauraipunous@prevenirserieux.com', 'okok', 0, ''),
(10, 'ouaismême', 'quesic\'estpas', 'faitbahje@vousallume', '', 0, ''),
(11, 'jhsdf', 'dfgdfg', 'dgdfg@dfgdfg.com', 'fgdfgd', 1, 'dgdgdf'),
(12, '\'\'(', 'gftr\'', 'kfdjj@lmf', 'fgdfg', 0, 'ggfgf'),
(13, 'Nikita', 'azerty', 'azerty@ytreza.com', '3399977', 1, 'un fou'),
(14, '<b>bonsoir</b>', '', '', '', 1, ''),
(15, '<b>salut</b>', 'chocolat', '', '', 0, ''),
(16, '<script>alert(\'coucou\');</script>', '', '', '', 1, ''),
(17, '<script>alert(\'Yoann le plus beau\');</script>', '', '', '', 0, ''),
(18, 'J\'aime les canards', '', '', '', 0, ''),
(19, '<script>alert(\'test\');</script>', '', '', '', 0, ''),
(20, 'jaurais', 'peutetrecinq', 'minutesde@xn--retardtoutlheure-6lb.com', '', 0, ''),
(21, '', '', '', '', 0, ''),
(22, 'console.log(ok);', '', '', '', 0, ''),
(23, 'omg', '', '', '', 0, ''),
(24, 'je suis un nouveau pirate', '', '', '', 0, ''),
(25, 'bvarzoivjiozarbjizrabjioboijrijobzraijobzarijijbzraijbzraijijbzraijbrziajbijzriobzrijojibzrzrbz', 'arboaizrjbiopeiomvjioazjbviojzairbjiojeaibjoiajbjjbiozijobaijobazzar', 'aikefiojaeoazghuzjr@jiorebiojibjioaheiobjoaeberabarb', 'fzzefz', 0, 'aijeifjioaje'),
(26, 'putain de la merde', '', '', '', 0, ''),
(27, 'm\'en balle les couilles  du php', '', '', '', 0, ''),
(28, '<script>alert(\'test\');</script>', '', '', '', 0, ''),
(29, 'je vais hacker ton formulaire de merdeeeeeeeeeee', '', '', '', 0, '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
