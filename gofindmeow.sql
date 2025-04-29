-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 29. 15:06
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `gofindmeow`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `report` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` varchar(250) NOT NULL,
  `photo` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`report`, `user`, `created_at`, `updated_at`, `content`, `photo`) VALUES
(1, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'A környéken láttam egy hasonló cicát, lehet, hogy ő az?', NULL),
(1, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Nagyon hasonlít a szomszéd macskájára, de nem vagyok biztos benne.', NULL),
(1, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Láttam a játszótér mellett egy cicát, ami így nézett ki!', '/kepek/commentKep2.jpg'),
(2, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Szerintem ezt a macskát már korábban is keresték.', '/kepek/commentKep.jpg'),
(2, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Én a bolt mögött láttam egy ilyet.', NULL),
(2, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Nagyon aranyos cica, remélem hamar hazakerül!', NULL),
(2, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'A buszmegállónál is feltűnt egy ilyen színű macska.', NULL),
(5, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Tegnap este láttam hasonlót az utcán.', NULL),
(5, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Szerintem ő lehet az, bár nehéz volt megfigyelni.', NULL),
(5, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Nagyon ismerős a mintázata!', NULL),
(6, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Sajnos nem tudtam megközelíteni, de hasonlított rá.', '/kepek/commentKep3.jpg'),
(6, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'De drága!', NULL),
(6, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'A parkolónál bóklászott egy ilyen macska.', NULL),
(4, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Lehet, hogy ismerem a gazdáját, meghívom ide!', NULL),
(4, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Sziasztok ő az én cicám, írtam nektek e-mailt.', NULL),
(4, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Az állatorvosnál hallottam róla.', NULL),
(3, 6, '2025-04-29 12:48:46', '2025-04-29 12:48:46', '😍😍😍', NULL),
(3, 8, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Volt régen egy ilyen cicám :(.', NULL),
(10, 7, '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Már régóta szeretnék egy ilyen cicát!.', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_02_092857_create_personal_access_tokens_table', 1),
(5, '2025_01_21_132206_create_reports_table', 1),
(6, '2025_01_21_132223_create_sheltered_cats_table', 1),
(7, '2025_01_21_132235_create_comments_table', 1),
(8, '2025_02_25_103608_m_allapot_menhely_trigger', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reports`
--

CREATE TABLE `reports` (
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `other_identifying_marks` varchar(250) DEFAULT NULL,
  `health_status` varchar(250) DEFAULT NULL,
  `photo` varchar(2048) DEFAULT NULL,
  `chip_number` bigint(20) DEFAULT NULL,
  `circumstances` varchar(250) DEFAULT NULL,
  `number_of_individuals` int(11) DEFAULT 1,
  `event_date` date DEFAULT NULL,
  `activity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `reports`
--

INSERT INTO `reports` (`report_id`, `creator_id`, `status`, `created_at`, `updated_at`, `address`, `lat`, `lon`, `color`, `pattern`, `other_identifying_marks`, `health_status`, `photo`, `chip_number`, `circumstances`, `number_of_individuals`, `event_date`, `activity`) VALUES
(1, 6, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Andrássy út 60.', 47.5076, 19.0655, 'fehér-bézs', 'egyszínű', 'MIÓ', 'egészséges', 'http://localhost:8000/uploads/c1.jpg', 123456789876543, 'játszott a parkban', 1, '2025-04-29', 1),
(2, 7, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Váci utca 12.', 47.4947, 19.0538, 'vörör', 'cirmos', 'Safraneknek', 'egészséges', 'http://localhost:8000/uploads/c2.jpg', NULL, 'udvaron ült', 1, '2025-04-29', 1),
(3, 8, 'm', '2025-04-29 12:48:46', '2025-04-29 12:51:05', 'Budapest, Oktogon tér 1.', 47.5064, 19.0629, 'fekete-fehér', 'foltos', 'zöld szem', 'beteg', 'http://localhost:8000/uploads/c3.jpg', NULL, 'forgalmas úton látták', 1, '2025-03-20', 1),
(4, 6, 'm', '2025-04-29 12:48:46', '2025-04-29 12:51:14', 'Budapest, Rákóczi út 10.', 47.4975, 19.0663, 'barna', 'foltos', 'sántít', 'sérült', 'http://localhost:8000/uploads/c4.jpg', NULL, 'bolt előtt kóborolt', 1, '2025-02-10', 1),
(5, 7, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Király utca 8.', 47.5002, 19.0594, 'fehér', 'egyszínű', 'pici kölyök', 'egészséges', 'http://localhost:8000/uploads/c5.jpg', NULL, 'játszótéren találták', 1, '2024-05-15', 1),
(6, 8, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Kossuth Lajos utca 5.', 47.4958, 19.0552, 'barna', 'egyszínű', 'kis seb a fülén', 'egészséges', 'http://localhost:8000/uploads/c6.jpg', NULL, 'parkolóban kóborolt', 1, '2025-04-29', 1),
(7, 6, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Üllői út 4.', 47.4856, 19.0747, 'barna-bézs', 'foltos', 'sziámi kölyök', 'sérült', 'http://localhost:8000/uploads/c7.jpg', NULL, 'tegnap elszökött', 1, '2025-04-09', 1),
(8, 7, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Bartók Béla út 62.', 47.4774, 19.0437, 'fehér', 'egyszínű', 'zöld nyakörv', 'egészséges', 'http://localhost:8000/uploads/c8.jpg', NULL, 'terasz alatt feküdt', 1, '2024-03-12', 1),
(9, 8, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Dózsa György út 41.', 47.5202, 19.0728, 'fehér', 'egyszínű', 'karmolt szem', 'beteg', 'http://localhost:8000/uploads/c9.jpg', NULL, 'forgalmas tér', 1, '2025-04-02', 1),
(10, 6, 'm', '2025-04-29 12:48:46', '2025-04-29 12:51:39', 'Budapest, Váci út 30.', 47.5291, 19.0706, 'barna', 'foltos', 'hosszú bajusz', 'egészséges', 'http://localhost:8000/uploads/c10.jpg', NULL, 'kávézó előtt feküdt', 1, '2024-02-20', 1),
(11, 7, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Vámház körút 5.', 47.4888, 19.0586, 'vörös', 'cirmos', 'fél farka hiányzik', 'sérült', 'http://localhost:8000/uploads/c11.jpg', NULL, 'bolt előtt látták', 1, '2025-03-30', 1),
(12, 8, 'l', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Haller utca 27.', 47.4758, 19.0715, 'vörös', 'cirmos', 'sebes láb', 'sérült', 'http://localhost:8000/uploads/c12.jpg', NULL, 'áruház udvarán', 1, '2025-04-05', 1),
(13, 6, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Széll Kálmán tér 1.', 47.5075, 19.0267, 'fehér', 'egyszínű', 'három lába van', 'beteg', 'http://localhost:8000/uploads/c13.jpg', NULL, 'elszökött otthonról', 1, '2025-04-11', 1),
(14, 7, 'm', '2025-04-29 12:48:46', '2025-04-29 12:52:02', 'Budapest, Lövőház utca 2.', 47.5083, 19.0274, 'fekete-fehér-vörös', 'kalokó', 'nagy tappancsok', 'egészséges', 'http://localhost:8000/uploads/c14.jpg', NULL, 'játszott más macskákkal', 1, '2024-01-01', 1),
(15, 8, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Alkotás utca 1.', 47.4956, 19.0225, 'fehér-szürke', 'cirmos', 'sebes fül', 'sérült', 'http://localhost:8000/uploads/c15.jpg', 123454321234543, 'udvarban feküdt', 1, '2025-01-29', 1),
(16, 6, 'l', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Margit körút 50.', 47.5116, 19.0357, 'teknöctarka', 'cirmos', 'napozott', 'egészséges', 'http://localhost:8000/uploads/c16.jpg', NULL, 'háztetőn látták', 1, '2025-04-21', 1),
(17, 7, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Pesti út 40.', 47.4873, 19.2459, 'barna-bézs', 'foltos', 'nagy kék szemek', 'egészséges', 'http://localhost:8000/uploads/c17.jpg', NULL, 'játszótér közelében', 1, '2024-04-02', 1),
(18, 8, 'm', '2025-04-29 12:48:46', '2025-04-29 12:52:25', 'Budapest, József körút 10.', 47.4916, 19.0722, 'teknőctarka', 'cirmos', 'fehér csík a hasán', 'sérült', 'http://localhost:8000/uploads/c18.jpg', NULL, 'a kertemben láttam', 1, '2024-11-11', 1),
(19, 6, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Erzsébet körút 30.', 47.4991, 19.0657, 'fehér-barna', 'foltos', 'csonka farok', 'beteg', 'http://localhost:8000/uploads/c19.jpg', NULL, 'kirakat előtt feküdt', 1, '2025-03-11', 1),
(20, 7, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Mester utca 22.', 47.4787, 19.0695, 'vörös', 'cirmos', 'hosszú szőrű', 'egészséges', 'http://localhost:8000/uploads/c20.jpg', NULL, 'udvaron pihent', 3, '2025-02-21', 1),
(21, 8, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Árpád út 90.', 47.5558, 19.0786, 'teknőctarka', 'cirmos', 'bal szeme sérült', 'sérült', 'http://localhost:8000/uploads/c21.jpg', NULL, 'piacon kóborolt', 1, '2025-04-21', 1),
(22, 6, 'm', '2025-04-29 12:48:46', '2025-04-29 12:52:44', 'Budapest, Zrínyi utca 5.', 47.5003, 19.0488, 'teknőctarka', 'cirmos', 'kis fekete folt a fülén', 'egészséges', 'http://localhost:8000/uploads/c22.jpg', NULL, 'iskola előtt ült', 1, '2024-05-10', 1),
(23, 7, 'm', '2025-04-29 12:48:46', '2025-04-29 12:54:11', 'Budapest, Nagykörút 88.', 47.4939, 19.0702, 'teknőctarka', 'cirmos', 'zöld szemek', 'egészséges', 'http://localhost:8000/uploads/c23.jpg', NULL, 'buszmegálló mellett', 1, '2025-04-13', 1),
(24, 8, 'l', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Bajcsy-Zsilinszky út 17.', 47.5011, 19.0536, 'fehér-teknőctarka', 'kalikó', 'kis vágás az oldalán', 'sérült', 'http://localhost:8000/uploads/c24.jpg', NULL, 'üzlet mögött látták', 1, '2025-04-04', 1),
(25, 6, 'm', '2025-04-29 12:48:46', '2025-04-29 12:53:16', 'Budapest, Thököly út 150.', 47.5098, 19.1084, 'szürke', 'cirmos', 'egy egész alomnyi cica', 'egészséges', 'http://localhost:8000/uploads/c25.jpg', NULL, 'parkoló autók alatt bújkáltak', 5, '2024-02-18', 1),
(26, 7, 'l', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Szentendrei út 1.', 47.5505, 19.0467, 'vörös', 'cirmos', 'kis heg a bal oldalán', 'egészséges', 'http://localhost:8000/uploads/c26.jpg', NULL, 'kertben játszott', 1, '2025-04-21', 1),
(27, 8, 'm', '2025-04-29 12:48:46', '2025-04-29 12:53:51', 'Budapest, Bécsi út 52.', 47.5382, 19.0344, 'szürke-fehér', 'cirmos', 'sérült jobb fül', 'sérült', 'http://localhost:8000/uploads/c27.jpg', NULL, 'egy fán találták', 1, '2025-03-21', 1),
(28, 6, 'k', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Kőbányai út 48.', 47.4875, 19.1162, 'teknőctarka', 'cirmos', 'nagy tappancs', 'egészséges', 'http://localhost:8000/uploads/c28.jpg', NULL, 'vasútállomásnál látták', 1, '2025-03-12', 1),
(29, 7, 'm', '2025-04-29 12:48:46', '2025-04-29 12:53:26', 'Budapest, Hungária körút 2.', 47.5009, 19.097, 'vörös-fehér', 'cirmos', 'fehér csík az orrán', 'egészséges', 'http://localhost:8000/uploads/c29.jpg', NULL, 'bokorba bújt', 1, '2023-11-11', 1),
(30, 8, 't', '2025-04-29 12:48:46', '2025-04-29 12:48:46', 'Budapest, Szépvölgyi út 5.', 47.5367, 19.0369, 'fekete-fehér', 'foltos', 'ketten kóborolnak', 'sérült', 'http://localhost:8000/uploads/c30.jpg', NULL, 'parkoló közelében', 2, '2025-03-12', 1);

--
-- Eseményindítók `reports`
--
DELIMITER $$
CREATE TRIGGER `createShelteredCatAfterReportInsert` AFTER INSERT ON `reports` FOR EACH ROW BEGIN 
            IF NEW.status = 'm' THEN
                INSERT INTO sheltered_cats (rescuer, report, owner, s_status, chip_number, breed)
                VALUES (NEW.creator_id, NEW.report_id, NULL, NULL, NULL, NULL);
            END IF;
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sheltered_cats`
--

CREATE TABLE `sheltered_cats` (
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `rescuer` bigint(20) UNSIGNED NOT NULL,
  `report` bigint(20) UNSIGNED NOT NULL,
  `owner` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `adoption_date` date DEFAULT NULL,
  `kennel_number` int(11) DEFAULT NULL,
  `medical_record` varchar(200) DEFAULT NULL,
  `s_status` varchar(1) NOT NULL DEFAULT 'a',
  `chip_number` bigint(20) DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `sheltered_cats`
--

INSERT INTO `sheltered_cats` (`cat_id`, `rescuer`, `report`, `owner`, `created_at`, `updated_at`, `adoption_date`, `kennel_number`, `medical_record`, `s_status`, `chip_number`, `breed`) VALUES
(1, 3, 3, NULL, '2025-04-29 12:51:05', '2025-04-29 12:51:05', NULL, NULL, NULL, 'a', NULL, NULL),
(2, 3, 4, NULL, '2025-04-29 12:51:14', '2025-04-29 12:51:14', NULL, NULL, NULL, 'a', NULL, NULL),
(3, 3, 10, NULL, '2025-04-29 12:51:39', '2025-04-29 12:51:39', NULL, NULL, NULL, 'a', NULL, NULL),
(4, 3, 14, NULL, '2025-04-29 12:52:02', '2025-04-29 12:52:02', NULL, NULL, NULL, 'a', NULL, NULL),
(5, 3, 18, NULL, '2025-04-29 12:52:25', '2025-04-29 12:52:25', NULL, NULL, NULL, 'a', NULL, NULL),
(6, 3, 22, NULL, '2025-04-29 12:52:44', '2025-04-29 12:52:44', NULL, NULL, NULL, 'a', NULL, NULL),
(7, 3, 25, NULL, '2025-04-29 12:53:16', '2025-04-29 12:53:16', NULL, NULL, NULL, 'a', NULL, NULL),
(8, 3, 29, NULL, '2025-04-29 12:53:26', '2025-04-29 12:53:26', NULL, NULL, NULL, 'a', NULL, NULL),
(9, 3, 27, NULL, '2025-04-29 12:53:51', '2025-04-29 12:53:51', NULL, NULL, NULL, 'a', NULL, NULL),
(10, 3, 23, 8, '2025-04-29 12:54:11', '2025-04-29 12:59:46', '2025-04-29', NULL, NULL, 'o', NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(500) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone_number`, `profile_picture`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gofindmeow.hu', NULL, '$2y$12$yjZhiNiVjZdZitkYpw9r.ODHKNTHVJc3wveq7DO2.qSf47WrG00QK', '12345677876', '/kepek/user.jpg', 0, NULL, '2025-04-29 12:48:44', '2025-04-29 12:48:44'),
(2, 'Staff Ügyfélszolgálat', 'staffugyf@gofindmeow.hu', NULL, '$2y$12$TOC3rnQtUuiKHFpdaE148ukRwOCRlsNk36mwKs7DxYFteACRIMNYa', '12345677876', '/kepek/user.jpg', 1, NULL, '2025-04-29 12:48:44', '2025-04-29 12:48:44'),
(3, 'Staff1', 'staff1@gofindmeow.hu', NULL, '$2y$12$4HlWjpYLqI/ete7h.0hVTuE6cxHkY.4Mwl3D61xwKRIp1S.Bfkxn2', '12345677876', '/kepek/user.jpg', 1, NULL, '2025-04-29 12:48:44', '2025-04-29 12:48:44'),
(4, 'Staff2', 'staff2@gofindmeow.hu', NULL, '$2y$12$cjNYKc.udzpmL0m/P6y6Z.4HdTRqlMppwOGk9ZIFrPtWCd31MJGE6', '12345677876', '/kepek/user.jpg', 1, NULL, '2025-04-29 12:48:44', '2025-04-29 12:48:44'),
(5, 'Staff3', 'staff3@gofindmeow.hu', NULL, '$2y$12$9jY6wtfbxzFAImXXpwnCcOanrM8qOHQ.HitgOJI4ivpAiBC6Tsxfm', '12345677876', '/kepek/user.jpg', 1, NULL, '2025-04-29 12:48:45', '2025-04-29 12:48:45'),
(6, 'User1', 'user1@gofindmeow.hu', NULL, '$2y$12$a.wFwllBHl4vMGUwH/UtseizYvGPaQ.d3cNcEAUGiFhQsmCwGUGmG', '12345677876', '/kepek/user.jpg', 2, NULL, '2025-04-29 12:48:45', '2025-04-29 12:48:45'),
(7, 'User2', 'user2@gofindmeow.hu', NULL, '$2y$12$4JrE2LSaXcUyKvVwuzQnCeRx2tEeN/gkX89RXKPUjq1wY4YkQT1/y', '12345677876', '/kepek/user.jpg', 2, NULL, '2025-04-29 12:48:45', '2025-04-29 12:48:45'),
(8, 'User3', 'user3@gofindmeow.hu', NULL, '$2y$12$6G43m/ywCPmgZhliNAHQYu1Y1GqLqNsTUcZmYsLNtxTX.qEkhm7Fe', '12345677876', '/kepek/user.jpg', 2, NULL, '2025-04-29 12:48:46', '2025-04-29 12:48:46'),
(9, 'Test User', 'test@example.com', '2025-04-29 12:48:47', '$2y$12$sLto2106IFOqydV98xvHSuMKa9S9IGk3u2KWqX5vT.4EVxqQLahqa', NULL, NULL, 2, 'dkrDVhaPMX', '2025-04-29 12:48:47', '2025-04-29 12:48:47');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD KEY `comments_report_foreign` (`report`),
  ADD KEY `comments_user_foreign` (`user`);

--
-- A tábla indexei `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- A tábla indexei `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- A tábla indexei `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- A tábla indexei `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reports_creator_id_foreign` (`creator_id`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- A tábla indexei `sheltered_cats`
--
ALTER TABLE `sheltered_cats`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `sheltered_cats_rescuer_foreign` (`rescuer`),
  ADD KEY `sheltered_cats_report_foreign` (`report`),
  ADD KEY `sheltered_cats_owner_foreign` (`owner`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `sheltered_cats`
--
ALTER TABLE `sheltered_cats`
  MODIFY `cat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_report_foreign` FOREIGN KEY (`report`) REFERENCES `reports` (`report_id`),
  ADD CONSTRAINT `comments_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `sheltered_cats`
--
ALTER TABLE `sheltered_cats`
  ADD CONSTRAINT `sheltered_cats_owner_foreign` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sheltered_cats_report_foreign` FOREIGN KEY (`report`) REFERENCES `reports` (`report_id`),
  ADD CONSTRAINT `sheltered_cats_rescuer_foreign` FOREIGN KEY (`rescuer`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
