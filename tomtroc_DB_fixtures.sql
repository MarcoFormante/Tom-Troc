-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 16, 2026 alle 12:30
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tomtroc`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(255) NOT NULL,
  `sold_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `books`
--

INSERT INTO `books` (`id`, `title`, `image`, `description`, `status`, `created_at`, `author`, `sold_by`) VALUES
(224, 'L’Ombre de la Ville Silencieuse', 'bookDefault.webp', 'Dans une ville où les rues semblent écouter chaque pas, un homme découvre que le silence cache des vérités oubliées. Entre souvenirs effacés et mystères urbains, ce roman explore la solitude moderne et le poids du passé.', 1, '2026-01-16 10:38:12', 'Alain Mercier', 271),
(225, 'Au-delà du Dernier Horizon', 'bookDefault.webp', 'Lorsqu’un voyage ordinaire se transforme en quête intérieure, une jeune femme affronte ses peurs et ses désirs les plus profonds. Un récit poétique sur le changement, la liberté et le courage de recommencer.', 1, '2026-01-16 10:39:32', 'Claire Beaumont', 267),
(226, 'Les Mécanismes du Cœur', 'bookDefault.webp', 'À mi-chemin entre science et émotion, ce livre raconte l’histoire d’un ingénieur incapable de comprendre ses propres sentiments. Une réflexion sensible sur l’amour, la rationalité et ce qui échappe à toute logique.', 1, '2026-01-16 10:44:24', 'Julien Lefort', 270),
(227, 'La Lumière Sous la Cendre', 'bookDefault.webp', 'Après une catastrophe qui a bouleversé une région entière, des vies brisées tentent de se reconstruire. Ce roman intimiste parle de résilience, d’espoir et de la force discrète qui renaît après la chute.', 1, '2026-01-16 10:47:30', 'Nathalie Courtois', 269);

-- --------------------------------------------------------

--
-- Struttura della tabella `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_one_id` int(11) NOT NULL,
  `user_two_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `created_at`, `user_one_id`, `user_two_id`) VALUES
('ROOM-696a19801629d1768561024', '2026-01-16 10:57:04', 271, 267);

-- --------------------------------------------------------

--
-- Struttura della tabella `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chatroom_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sent_by_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `messages`
--

INSERT INTO `messages` (`id`, `chatroom_id`, `content`, `sent_at`, `sent_by_user_id`) VALUES
(165, 'ROOM-696a19801629d1768561024', 'Salut Marie 🙂 J’ai vu que tu as \"Au-delà du Dernier Horizon\" dans ta bibliothèque...', '2026-01-16 10:57:38', 271),
(168, 'ROOM-696a19801629d1768561024', 'Salut ! Oui, je l’ai ajouté il n’y a pas longtemps. Tu le connais ?', '2026-01-16 11:02:18', 267),
(169, 'ROOM-696a19801629d1768561024', 'Pas encore, mais le résumé m’a vraiment donné envie. Tu le prêtes en ce moment ou il est disponible ?', '2026-01-16 11:04:44', 271),
(170, 'ROOM-696a19801629d1768561024', 'Il est disponible, je viens de le récupérer. Je peux le prêter sans problème.', '2026-01-16 11:05:12', 267),
(171, 'ROOM-696a19801629d1768561024', 'Génial ! Ce serait possible de te l’emprunter pour quelques semaines ?', '2026-01-16 11:08:29', 271),
(172, 'ROOM-696a19801629d1768561024', 'Oui, quand tu veux. Merci encore pour le partage 😊', '2026-01-16 11:11:36', 267);

-- --------------------------------------------------------

--
-- Struttura della tabella `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `chatroom_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` datetime NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`email`, `pseudo`, `password`, `signup_date`, `id`, `profile_image`) VALUES
('jean.dupont@gmail.com', 'Jean Dupont', '$2y$13$jJOcs87IvHSV3iHjEcbhz.GdPrVIKJTfAJVKPv9c/SAVKssUrKtWu', '2026-01-16 10:32:42', 266, 'userDefault.webp'),
('marie.martin@gmail.com', 'Marie Martin', '$2y$13$rLiEcFkeRBMzpBfdE3xaguFdvvCpcQ01r40MCvo9Fawin.GwwrB56', '2026-01-16 10:33:08', 267, 'userDefault.webp'),
('pierre.durand@gmail.com', 'Pierre Durand', '$2y$13$j4X8OK1Y2v.kS5rkhrTmB.oZ3xPJ6UNyy93h4S4UwpEWlvbIr0eyW', '2026-01-16 10:33:35', 268, 'userDefault.webp'),
('sophie.bernard@gmail.com', 'Sophie Bernard', '$2y$13$wXxQ4eg8XUraUJuYixQcZODiWfOOJOxCsfM32GnPA.75yH1oNJd5i', '2026-01-16 10:34:06', 269, 'userDefault.webp'),
('luc.moreau@gmail.com', 'Luc Moreau', '$2y$13$zoZAVBtRgF/xlGLRAcB3GeqW80oLVfwg8scZV6nunUXLbfIDD8lf2', '2026-01-16 10:34:36', 270, 'userDefault.webp'),
('user2026@gmail.com', 'user2026', '$2y$13$Hc7gtX5wrEjItZajvddleeh5Z2mxYERwkv42cMCr88McqxdS.622e', '2026-01-16 10:34:58', 271, 'userDefault.webp');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sold_by` (`sold_by`);

--
-- Indici per le tabelle `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_one_id` (`user_one_id`),
  ADD KEY `user_two_id` (`user_two_id`);

--
-- Indici per le tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatroom_id` (`chatroom_id`),
  ADD KEY `sent_by_user_id` (`sent_by_user_id`);

--
-- Indici per le tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_message` (`id_message`),
  ADD KEY `chatroom_id` (`chatroom_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT per la tabella `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT per la tabella `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`sold_by`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD CONSTRAINT `chatrooms_ibfk_1` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chatrooms_ibfk_2` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chatroom_id`) REFERENCES `chatrooms` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sent_by_user_id`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`id_message`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`chatroom_id`) REFERENCES `chatrooms` (`id`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_ibfk_4` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
