-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 17, 2026 at 02:07 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskforge`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_created_by_foreign` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `contact_email`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Holden Adams IV', 'ggutmann@example.net', 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(2, 'Aurelie McKenzie', 'hschmidt@example.net', 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(3, 'Pearlie Heller', 'zieme.bryce@example.org', 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(4, 'Prof. Jonathan Connelly Jr.', 'dpagac@example.org', 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(5, 'Luciano Morissette', 'marlee05@example.org', 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_05_112150_create_clients_table', 1),
(5, '2026_08_05_112227_create_projects_table', 1),
(6, '2026_08_05_112247_create_tasks_table', 1),
(7, '2026_08_05_112306_create_time_logs_table', 1),
(8, '2026_08_05_112332_create_project_user_table', 1),
(9, '2026_08_06_060746_remove_email_verified_at_from_users_table', 1),
(10, '2026_08_06_061027_add_phone_to_users_table', 1),
(11, '2026_08_07_135325_add_is_logged_in_to_users_table', 1),
(12, '2026_08_10_112056_add_priority_and_assigned_to_to_tasks_table', 1),
(13, '2026_08_17_071618_add_is_active_to_users_table', 1),
(14, '2026_08_17_071847_add_is_active_to_users_table', 1),
(15, '2026_08_17_094714_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','In Progress','Completed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_client_id_foreign` (`client_id`),
  KEY `projects_created_by_foreign` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `name`, `status`, `start_date`, `due_date`, `archived_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Numquam quisquam vero.', 'In Progress', '1994-01-03', '1994-03-31', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(2, 1, 'Officia aut.', 'In Progress', '1994-07-24', '2014-06-04', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(3, 2, 'Commodi neque ea veniam.', 'Completed', '2012-04-15', '2020-05-07', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(4, 2, 'Et exercitationem eum dolor.', 'Pending', '1995-11-02', '1987-03-21', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(5, 3, 'Eos fugiat ut autem.', 'Pending', '1974-05-26', '2001-09-26', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(6, 3, 'Eaque assumenda enim vel officia.', 'Pending', '1976-07-19', '1979-08-01', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(7, 4, 'Exercitationem quia rem molestias.', 'Completed', '1978-01-02', '1994-09-29', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(8, 4, 'Est aut autem.', 'Completed', '2009-10-12', '1997-06-27', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(9, 5, 'Omnis quod.', 'Completed', '1993-04-19', '1978-11-07', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(10, 5, 'Natus libero voluptas vel.', 'Pending', '1973-01-09', '2019-08-09', NULL, 2, '2026-08-17 08:51:20', '2026-08-17 08:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

DROP TABLE IF EXISTS `project_user`;
CREATE TABLE IF NOT EXISTS `project_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_user_project_id_foreign` (`project_id`),
  KEY `project_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Todo','In Progress','Done') COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medium',
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  KEY `tasks_assigned_to_foreign` (`assigned_to`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `status`, `priority`, `assigned_to`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Est odit similique.', 'Similique incidunt doloremque natus animi nostrum esse. Excepturi quos quia ad cum. Laboriosam odio dolor harum est magnam cumque cum. Natus nulla nisi beatae labore inventore.', 'Todo', 'Medium', 4, '2026-08-23', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(2, 1, 'Animi rerum odit illum possimus.', 'Facere officia nisi in et quis. Quis veritatis quis ipsum voluptas neque. Ab deleniti recusandae architecto sequi. Consectetur ab omnis dignissimos quis officiis aspernatur similique.', 'In Progress', 'Medium', 4, '2026-09-16', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(3, 1, 'Ut ut debitis voluptatem.', 'Incidunt est animi maiores et ut quasi. Vero minima ipsum voluptatem voluptas dolorem et sequi. Culpa et dolor atque cumque culpa itaque tempore. Quo quisquam hic facere architecto.', 'Todo', 'Medium', 4, '2026-09-04', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(4, 2, 'Quis consequatur sapiente.', 'Illum ducimus expedita molestiae alias quibusdam molestiae delectus. Facere esse molestias id eaque minima sit illum.', 'Todo', 'Medium', 6, '2026-08-31', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(5, 2, 'Ipsum recusandae ipsa reiciendis.', 'Accusamus consectetur qui porro pariatur animi ut quae. Libero sint veritatis maxime et. Aut dolores possimus aliquam voluptas consequatur.', 'Todo', 'Medium', 6, '2026-09-10', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(6, 2, 'Voluptatem culpa ratione dolores.', 'Temporibus error sapiente exercitationem ab suscipit explicabo. Id officiis aut atque quae natus repudiandae necessitatibus. A sint atque numquam sunt quia odit non.', 'Todo', 'Medium', 6, '2026-09-10', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(7, 3, 'Explicabo deserunt enim.', 'Dolores sit quae sequi quod. Minus adipisci excepturi ut. Quidem repudiandae repudiandae sed qui natus. Esse laudantium et placeat occaecati ab quia.', 'In Progress', 'Medium', 4, '2026-08-28', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(8, 3, 'Ipsam temporibus aliquam distinctio.', 'Aut est nostrum iure deleniti natus quas. Enim autem saepe enim quas. Itaque voluptas veritatis voluptatem architecto explicabo inventore inventore. Quas nulla est omnis hic.', 'Done', 'Medium', 4, '2026-09-12', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(9, 3, 'Est pariatur velit.', 'Sunt et non iste officia officia quam est. Dolores nisi qui nam.', 'Done', 'Medium', 4, '2026-08-19', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(10, 4, 'Illo esse tempora impedit.', 'Consequatur at cupiditate illum beatae corrupti nam. Laudantium voluptatum aut eius dolor quia omnis voluptatibus nisi.', 'Todo', 'Medium', 4, '2026-08-24', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(11, 4, 'Quia molestias voluptatem.', 'Id quis omnis eos. Est assumenda est expedita voluptate doloremque. Minima consectetur assumenda voluptatem enim. Voluptates nisi quia suscipit molestiae.', 'Done', 'Medium', 4, '2026-08-31', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(12, 4, 'Impedit officia recusandae doloremque.', 'Rerum et dolorem ut reprehenderit minima. Quo voluptatibus beatae illum. Quod quam eius quis vel consequatur.', 'Todo', 'Medium', 4, '2026-08-24', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(13, 5, 'Occaecati velit et.', 'Voluptates enim dolores voluptates eius nostrum. Ut natus quibusdam iste modi.', 'Todo', 'Medium', 6, '2026-08-22', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(14, 5, 'Consequatur id et dolores.', 'Natus nobis temporibus libero occaecati et. Quaerat repellendus quidem dignissimos odit reiciendis. Esse eos consectetur quos a quae molestiae ut ducimus. Ipsam consectetur consequuntur id dignissimos ducimus consequatur est.', 'In Progress', 'Medium', 6, '2026-09-02', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(15, 5, 'Dolore omnis assumenda.', 'Quibusdam quis minima nemo eum officiis ipsum numquam. Enim voluptates eaque earum dolorem exercitationem deleniti. In cupiditate alias laudantium ut dolor ducimus.', 'Todo', 'Medium', 6, '2026-08-26', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(16, 6, 'Distinctio vel aperiam.', 'Tempora tenetur aliquam ex consequatur sequi. Eos sed magni dolor maiores reiciendis. Ducimus temporibus fuga qui ad. Aut et aut consequatur cupiditate nemo.', 'Done', 'Medium', 6, '2026-09-12', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(17, 6, 'Exercitationem possimus praesentium et.', 'Quaerat doloribus sint error amet ducimus. Tempora eveniet maxime eveniet nihil. Maiores eum explicabo quos. Hic itaque consequatur et numquam sit qui.', 'Todo', 'Medium', 6, '2026-08-26', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(18, 6, 'Tenetur qui aliquid sed.', 'Ea totam et sed eius expedita mollitia sed. Cupiditate quia maxime in quia. Molestias eum animi voluptatibus harum dicta cum velit. Qui aliquid aut quia repellendus enim.', 'Todo', 'Medium', 6, '2026-09-12', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(19, 7, 'Quam repellat quo excepturi.', 'Quia et libero ea aut voluptate. Est esse recusandae exercitationem aut. Laudantium natus dolores officiis asperiores. Rerum itaque vel molestiae inventore aut deserunt repellendus.', 'In Progress', 'Medium', 5, '2026-09-11', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(20, 7, 'Et sint et.', 'Maxime quis et ut officiis aut quibusdam ea sit. Amet quis numquam quo dolores sed nobis. Quae et tempore optio officiis porro deleniti reiciendis.', 'Todo', 'Medium', 5, '2026-08-30', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(21, 7, 'Iusto cum sunt ut.', 'Debitis necessitatibus sed animi quod nihil libero quia. Aperiam itaque odio omnis necessitatibus consequatur. Id voluptatem fugiat error reprehenderit doloremque rerum.', 'Todo', 'Medium', 5, '2026-09-07', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(22, 8, 'Non velit aut facere.', 'Sed fuga qui sed voluptatem placeat. Similique fugiat eos est tempora officia maxime. Beatae rem aut maiores officia et porro deserunt. Et quas a rerum.', 'In Progress', 'Medium', 4, '2026-09-01', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(23, 8, 'Nihil aperiam distinctio.', 'Repudiandae dolorem aut ratione quam. Nobis reiciendis amet earum dolore. Labore nam provident blanditiis. Laborum praesentium adipisci saepe praesentium qui eum nemo.', 'Todo', 'Medium', 4, '2026-09-02', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(24, 8, 'Nesciunt et.', 'Dolorem eos blanditiis magni debitis est est maxime. Voluptatum earum qui ipsa. Hic natus voluptate soluta fugit.', 'Todo', 'Medium', 4, '2026-09-08', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(25, 9, 'Omnis tempora omnis molestiae.', 'Velit et deserunt consequatur. Quis asperiores sunt repellat aspernatur occaecati culpa. Eum est odio est similique corrupti velit repudiandae. Voluptatem architecto maxime repellendus reiciendis reiciendis aut temporibus.', 'In Progress', 'Medium', 6, '2026-08-31', '2026-08-17 08:51:20', '2026-08-17 08:51:20'),
(26, 9, 'Nam laborum molestias excepturi.', 'Ut ea voluptatem asperiores odio rerum ex. Quasi eum consequatur animi tempora nesciunt odit est. Ut eum quae qui incidunt distinctio. Accusamus enim ut nesciunt temporibus cumque.', 'Done', 'Medium', 6, '2026-08-27', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(27, 9, 'Provident maiores omnis nam.', 'Similique deleniti quas voluptas aspernatur ducimus ab at. Ut sapiente odit aperiam nesciunt molestiae. Suscipit deserunt maxime alias aperiam ipsum quasi similique.', 'In Progress', 'Medium', 6, '2026-08-23', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(28, 10, 'Dolorem ea similique.', 'Quisquam rerum repellat impedit quod ut voluptatem architecto. Nihil saepe consequatur quaerat qui omnis possimus saepe voluptatum. Corporis itaque quidem dolorem nihil adipisci tenetur voluptates.', 'Done', 'Medium', 6, '2026-09-16', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(29, 10, 'Doloremque dolores facere.', 'Quod nihil dolor labore nemo molestias sapiente non. Et enim pariatur pariatur quisquam quo libero. Fugiat fuga aspernatur accusamus.', 'In Progress', 'Medium', 6, '2026-08-30', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(30, 10, 'Quia a dolore.', 'Possimus repellendus quia a tenetur suscipit ut. Itaque alias qui quas facere quas et. Aut minus debitis modi eaque natus porro aut cumque. Maiores possimus odit aspernatur in eum ea et.', 'Done', 'Medium', 6, '2026-08-25', '2026-08-17 08:51:21', '2026-08-17 08:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

DROP TABLE IF EXISTS `time_logs`;
CREATE TABLE IF NOT EXISTS `time_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `minutes` int NOT NULL,
  `logged_at` datetime NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_logs_task_id_foreign` (`task_id`),
  KEY `time_logs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_logs`
--

INSERT INTO `time_logs` (`id`, `task_id`, `user_id`, `minutes`, `logged_at`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 284, '2026-07-30 07:47:10', 'Ex consequatur animi modi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(2, 1, 6, 401, '2026-07-29 22:50:39', 'Animi ipsam dolor alias quod rerum dolorum fugit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(3, 1, 6, 348, '2026-08-07 07:39:15', 'Sunt rerum numquam qui dolores.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(4, 2, 5, 240, '2026-07-29 18:25:01', 'Natus earum facere voluptates sed quis voluptatum et ipsa.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(5, 2, 5, 136, '2026-08-09 09:03:05', 'Maiores et expedita ullam delectus velit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(6, 2, 5, 65, '2026-07-19 21:45:33', 'Omnis esse rerum aut veniam rerum perspiciatis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(7, 3, 5, 74, '2026-08-14 22:55:19', 'Quasi veritatis error facilis provident.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(8, 3, 5, 128, '2026-07-31 06:20:50', 'Quaerat libero blanditiis aut cupiditate voluptatem.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(9, 3, 5, 444, '2026-08-13 06:46:23', 'Aut enim commodi voluptas maxime soluta suscipit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(10, 4, 5, 439, '2026-08-16 17:47:31', 'Et unde eligendi cupiditate aut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(11, 4, 5, 347, '2026-08-04 14:11:22', 'Et accusantium illum quae sequi voluptas reiciendis quam.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(12, 4, 5, 97, '2026-07-29 02:57:52', 'Est eum hic similique quibusdam incidunt voluptatem blanditiis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(13, 5, 4, 287, '2026-08-03 20:45:52', 'Nisi et rerum dignissimos qui et.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(14, 5, 4, 408, '2026-08-15 03:07:21', 'Illum libero quis autem ea omnis laborum voluptates.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(15, 5, 4, 51, '2026-08-05 19:14:06', 'Velit est exercitationem voluptatem tenetur.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(16, 6, 6, 91, '2026-08-06 01:17:27', 'Nihil amet exercitationem ipsam officia eligendi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(17, 6, 6, 457, '2026-08-16 15:59:27', 'Dolorem ut qui accusantium pariatur modi saepe repellat.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(18, 6, 6, 228, '2026-08-06 13:39:36', 'Vel sint occaecati velit deleniti dolores et.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(19, 7, 6, 67, '2026-07-26 19:07:29', 'Autem dolores dolores et cupiditate reiciendis veniam provident.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(20, 7, 6, 40, '2026-08-06 02:28:39', 'Autem consectetur voluptatem dolores distinctio dolorum.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(21, 7, 6, 263, '2026-08-13 13:34:46', 'Velit aliquid eveniet expedita velit officiis est.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(22, 8, 4, 379, '2026-07-26 17:48:45', 'Ex non consequatur corporis rerum labore doloremque.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(23, 8, 4, 327, '2026-07-27 11:11:25', 'Dolor adipisci laudantium ab.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(24, 8, 4, 177, '2026-08-14 23:47:30', 'Et soluta ea deserunt distinctio.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(25, 9, 5, 45, '2026-08-05 21:28:23', 'Voluptatum repellat aut aut ipsa vel incidunt.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(26, 9, 5, 67, '2026-08-11 15:46:44', 'Id ducimus odit dolorum voluptatibus ad sunt explicabo repudiandae.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(27, 9, 5, 274, '2026-08-01 00:18:43', 'Ipsam nulla magni nisi minus quisquam ratione delectus.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(28, 10, 4, 466, '2026-08-02 05:38:53', 'Quod soluta et recusandae vel accusantium adipisci.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(29, 10, 4, 105, '2026-08-02 00:30:41', 'Atque est molestias doloremque explicabo.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(30, 10, 4, 433, '2026-07-26 04:50:33', 'Libero sint nobis labore.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(31, 11, 6, 321, '2026-07-30 03:15:35', 'Ut id asperiores sequi expedita corporis maxime quis fuga.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(32, 11, 6, 83, '2026-08-07 03:53:07', 'Fugiat natus assumenda mollitia consequuntur.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(33, 11, 6, 331, '2026-08-01 23:22:16', 'Sunt deserunt voluptatem nostrum enim nisi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(34, 12, 4, 285, '2026-07-20 06:18:31', 'Nostrum quidem magni id nihil maiores quasi similique blanditiis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(35, 12, 4, 364, '2026-07-27 07:02:51', 'In porro ab ab sint veniam fugiat exercitationem.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(36, 12, 4, 41, '2026-08-04 15:12:21', 'Sunt vitae alias cum quos sint ea.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(37, 13, 6, 118, '2026-08-12 22:21:35', 'Odit fugit nemo ipsum veniam minima velit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(38, 13, 6, 272, '2026-08-15 00:21:52', 'Repudiandae quisquam distinctio nostrum ab.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(39, 13, 6, 282, '2026-08-06 20:06:54', 'Sed eum sit laborum quam nihil sint.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(40, 14, 5, 243, '2026-07-26 20:24:07', 'Sit iusto aliquid explicabo sit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(41, 14, 5, 102, '2026-08-15 08:46:20', 'Et doloribus saepe rerum voluptatem.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(42, 14, 5, 68, '2026-08-02 20:44:55', 'Pariatur illum reprehenderit ut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(43, 15, 4, 220, '2026-08-14 09:08:47', 'Rerum rem eius sint quia ut ut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(44, 15, 4, 128, '2026-07-20 18:08:13', 'Dolorem aut consequatur fugiat in eligendi perspiciatis similique aut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(45, 15, 4, 359, '2026-07-20 05:58:04', 'Consequuntur eligendi qui enim in id.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(46, 16, 6, 82, '2026-08-11 22:51:25', 'Sunt doloribus et qui deserunt quibusdam minima.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(47, 16, 6, 160, '2026-08-14 12:28:41', 'Velit iusto in animi sit itaque est.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(48, 16, 6, 99, '2026-08-16 18:20:23', 'Dolorem sit dicta reprehenderit quibusdam laboriosam.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(49, 17, 4, 404, '2026-07-25 21:58:57', 'Voluptas numquam delectus officia et facilis illum tenetur.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(50, 17, 4, 140, '2026-08-15 22:23:27', 'Ut ullam velit earum velit.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(51, 17, 4, 443, '2026-07-25 23:12:24', 'Nihil omnis ut non omnis vel quis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(52, 18, 4, 204, '2026-08-11 16:03:46', 'Modi et eius similique recusandae non ab maxime.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(53, 18, 4, 221, '2026-07-26 08:50:08', 'Ab a quae magni eum officiis occaecati.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(54, 18, 4, 442, '2026-07-28 05:41:00', 'Maxime alias totam minima excepturi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(55, 19, 4, 212, '2026-08-12 03:00:43', 'Autem molestias molestiae possimus quibusdam laborum aut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(56, 19, 4, 409, '2026-07-25 00:51:53', 'Laboriosam sed praesentium molestiae quis vero ab.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(57, 19, 4, 71, '2026-08-06 02:50:23', 'Dolores eos accusantium modi nisi sunt molestiae possimus perspiciatis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(58, 20, 6, 288, '2026-07-23 15:29:46', 'Voluptatibus tenetur aut vel nihil iusto ipsum eaque.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(59, 20, 6, 272, '2026-08-16 20:08:30', 'Occaecati consectetur vitae aliquid officiis ad.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(60, 20, 6, 284, '2026-08-10 09:34:55', 'Velit explicabo voluptatem amet omnis neque.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(61, 21, 5, 240, '2026-08-07 16:13:59', 'In ad omnis culpa molestias non.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(62, 21, 5, 281, '2026-07-22 00:14:10', 'Iure doloremque atque ipsa eius quia ut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(63, 21, 5, 187, '2026-08-08 12:01:50', 'Blanditiis tempora ut aut cumque.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(64, 22, 6, 431, '2026-08-03 01:30:20', 'Nulla id repudiandae et ab.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(65, 22, 6, 58, '2026-07-28 04:13:55', 'Iste sunt enim corporis commodi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(66, 22, 6, 292, '2026-07-23 00:47:59', 'Sit nisi impedit tenetur culpa.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(67, 23, 6, 370, '2026-07-20 07:59:39', 'Debitis hic et quis iste nesciunt culpa enim et.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(68, 23, 6, 264, '2026-08-06 08:20:21', 'Corrupti nobis excepturi nemo animi.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(69, 23, 6, 358, '2026-07-20 19:36:46', 'Laboriosam dicta provident aliquid consectetur.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(70, 24, 5, 149, '2026-07-25 14:48:26', 'Laboriosam facere quis voluptatibus voluptas accusamus debitis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(71, 24, 5, 317, '2026-07-20 04:56:25', 'Exercitationem maxime et debitis porro aut illum.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(72, 24, 5, 361, '2026-08-14 17:06:40', 'Saepe magnam nemo laboriosam iure ipsam id.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(73, 25, 6, 95, '2026-08-14 02:36:44', 'Qui rerum eos dolor sit sed rerum repudiandae praesentium.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(74, 25, 6, 84, '2026-07-20 13:19:05', 'Maiores corrupti repudiandae et et explicabo.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(75, 25, 6, 148, '2026-07-24 04:43:48', 'Molestiae fugit officia non reprehenderit molestiae et provident.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(76, 26, 4, 314, '2026-07-29 13:17:42', 'Aut ex aperiam dolorem repellat expedita.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(77, 26, 4, 465, '2026-07-23 17:15:35', 'Fugiat sed ducimus libero omnis.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(78, 26, 4, 150, '2026-08-02 09:12:28', 'Quia nobis repellendus enim error sint quos.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(79, 27, 5, 415, '2026-07-26 10:04:05', 'Tempore eos sint et quia laudantium quam.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(80, 27, 5, 411, '2026-08-17 11:03:20', 'Molestiae sit et tenetur nulla magnam rerum consequatur.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(81, 27, 5, 376, '2026-08-09 07:40:03', 'Aut illo quos delectus voluptatem.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(82, 28, 4, 350, '2026-08-05 03:48:27', 'Maiores expedita accusamus aut.', '2026-08-17 08:51:21', '2026-08-17 08:51:21'),
(83, 28, 4, 172, '2026-07-30 23:14:26', 'Inventore ea eligendi et minima.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(84, 28, 4, 77, '2026-08-07 16:46:49', 'Vel culpa minus necessitatibus dicta.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(85, 29, 6, 66, '2026-08-07 18:43:32', 'Nobis dolor illum molestias dolorem atque quo.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(86, 29, 6, 146, '2026-08-08 03:54:40', 'Maxime aut dolor eos omnis.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(87, 29, 6, 425, '2026-07-26 20:58:24', 'Est ut animi in quae ea.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(88, 30, 4, 132, '2026-08-05 06:12:43', 'Autem maiores libero et illo dignissimos reprehenderit perspiciatis.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(89, 30, 4, 458, '2026-07-30 06:47:57', 'Voluptas quia incidunt recusandae odio atque aut enim.', '2026-08-17 08:51:22', '2026-08-17 08:51:22'),
(90, 30, 4, 427, '2026-08-04 14:30:05', 'Ratione accusamus nesciunt cumque sint asperiores.', '2026-08-17 08:51:22', '2026-08-17 08:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Admin','Manager','Member') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_logged_in`, `is_active`) VALUES
(1, 'Admin User', 'admin@taskforge.com', NULL, 'Admin', '2026-08-17 08:51:20', '$2y$12$0Nlz5M1BrV6PkuAnbmhY.OUCHo5j6jIRg9Yj832ksqUrsWuR4eOqC', '0BZfcGLbzV', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(2, 'Manager One', 'manager1@taskforge.com', NULL, 'Manager', '2026-08-17 08:51:20', '$2y$12$ZCkze88yUOM8dBeJMeAUAOCNIkY.D/ulVUNEqrcOx4eMc//e0JoaC', 'amCPx7n7mK', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(3, 'Manager Two', 'manager2@taskforge.com', NULL, 'Manager', '2026-08-17 08:51:20', '$2y$12$b2.5xuZa5a5hIvzyngghH.qYKkWiNoVHx4bIUL1donx/CO1biMfBe', '6Jy7LgM45M', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(4, 'Member One', 'member1@taskforge.com', NULL, 'Member', '2026-08-17 08:51:20', '$2y$12$y1cYggcpGFfO7HKbkY0cG.f4pNs79YXtTQdIoJUf0Wg5AbEMWeZy6', 'zkuxNKABYI', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(5, 'Member Two', 'member2@taskforge.com', NULL, 'Member', '2026-08-17 08:51:20', '$2y$12$mVGmctHd.47P3D1iIeeVw.ejJY/hOFij0JytQKbXuyv1gbuusTM6G', 'ZEI4WCJdmF', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(6, 'Member Three', 'member3@taskforge.com', NULL, 'Member', '2026-08-17 08:51:20', '$2y$12$HRVZ3qkGvw9C75MPVLmZt.3l8Yq.7D.9CAyH5yYOOG9c6toWtgxS6', 'W35S3sgwM5', '2026-08-17 08:51:20', '2026-08-17 08:51:20', 0, 1),
(7, 'Muddasir Amin', 'muddasirapplicansoft@gmail.com', NULL, 'Admin', NULL, '$2y$12$jUbDxZq5tfcUb/7PzDmXT.sjdI68tJu36GFCGI.1h3W82O8q2e.rW', NULL, '2026-08-17 08:52:10', '2026-08-17 08:52:10', 0, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `project_user_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD CONSTRAINT `time_logs_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `time_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
