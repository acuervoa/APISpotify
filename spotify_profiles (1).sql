-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-02-2018 a las 20:50:26
-- Versión del servidor: 5.6.38-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pajbywzj_spotify_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spotify_profiles`
--

CREATE TABLE `spotify_profiles` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `href` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refreshToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expirationToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `spotify_profiles`
--

INSERT INTO `spotify_profiles` (`id`, `nick`, `email`, `display_name`, `country`, `href`, `image_url`, `accessToken`, `refreshToken`, `expirationToken`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1d404c48-0ddf-11e8-a725-000000000000', 'mivise2012', 'migue.vicedo@gmail.com', NULL, 'ES', 'https://api.spotify.com/v1/users/mivise2012', '1', 'BQBMK4GqGuX7_8Fpzv878fzdAUKXKIxTHMgtko0atwIpO7GylbvsSZPfQgc2iD2HZySIC5FzbSQDCn4e7o-uBpzGafiUGRUcOblBFd2JLBcJ6If3idmK-kiz47SnDPwauWeDtlfiTRW7qrqeP8PoGbRr2iaQ6mh7f_TXnv2f', '', '1518214855', '2018-02-09 12:01:39', '2018-02-09 20:20:55', NULL),
('1d5d9992-0ddf-11e8-a4fc-000000000000', '1119239464', 'r_chano@hotmail.com', 'Rubén Corrochano', 'ES', 'https://api.spotify.com/v1/users/1119239464', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c12.0.162.162/1959937_10202677822402235_2018586536_n.jpg?oh=d6469f03eb3c6226ad2da885beab9b93&oe=5ADEB315', 'BQAENP0W-hFB43dNMGr5raWqBtO2_uhqG9gjvjMUZetIREpbEn5mI9oSY2DQDj6ZaD7tLbHPlMgGEwe8eyN6LW-oymRoWlC8scrtmrlPS1uwjpHMZWU0dGsCvGgPxiH8IfhmJ9eK1izOcYnZyq2VcZMwrWS2abIWNP_idXDYzLzH', '', '1518214855', '2018-02-09 12:53:12', '2018-02-09 20:20:55', NULL),
('1da2db56-0ddf-11e8-9c82-000000000000', 'jesusete1982', 'jesusestebansanchez@gmail.com', 'Jesús Esteban', 'ES', 'https://api.spotify.com/v1/users/jesusete1982', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/12239490_10154073162858488_4313380006669544528_n.jpg?oh=3f6b0e0ec1c35e9526c4c90771b843a5&oe=5B1D8BEA', 'BQDw416sj7-w3bIV5-pkyF4YPmlMYcjsexz7lbRwAit-e15Q0aZ23LRwVR4GPBzRU-NF4oR8qMJjs7G3aYYDXNOnO1UJlY5oz6SwuSChSO317RsOUVOX14FNvJ42dsrCod3ebdait81I9tSvAGfY3Azn05KD1d7YqxU3voKyJlEg32E', '', '1518214856', '2018-02-09 11:58:11', '2018-02-09 20:20:56', NULL),
('1dc73532-0ddf-11e8-a742-000000000000', 'aalex12', 'alexfs92@gmail.com', 'Álex Franco Silva', 'ES', 'https://api.spotify.com/v1/users/aalex12', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/23519079_10213352878770765_194540181166426721_n.jpg?oh=538a82b732c961c5a03c076848ae5294&oe=5AE7C5B5', 'BQA9D8wgzrLD3oEgU1BJrqmelI7HnEdsIp0tCBMH5wPaFXTDHnbIEox0S_N1ric1RZWwGgzG8vIqIZnnyF0AhbPU7NxthFSO6QL3Vr6yaBTqFJJhkAFY9Oj0Cyd3HvxUhcFHRoZA7y1CXB51Mhi0MwftBvoC-UfubD4-mSSS', '', '1518214856', '2018-02-09 12:03:18', '2018-02-09 20:20:56', NULL),
('1dfddde4-0ddf-11e8-9d45-000000000000', 'findelias', 'faltodeimaginacion@gmail.com', 'Rafael Nuño Tamayo', 'ES', 'https://api.spotify.com/v1/users/findelias', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/19113635_10209403752751260_3071298783926959368_n.jpg?oh=2d9c14615c46fc45adc1b4aebb8f5e3c&oe=5B0CA362', 'BQAUi6SytAhwjjkwf11UAWC5TqNbBVfZncWiodXKidEIOd5FQyKnK1src_10pGXz-Wjoe5ML9S0eh4T24bxnnB36ZdaI5wWzWr1BGxob12oF6GP1nHO85SMItR9Lpx9BkIw1gLjbsU6XfCL7Vg9xjWRX_469dBizSgt8W8c', '', '1518214856', '2018-02-09 12:03:24', '2018-02-09 20:20:56', NULL),
('1e22aa98-0ddf-11e8-9f93-000000000000', 'esnoz', 'marga.esnoz@gmail.com', 'Meggy Malone', 'ES', 'https://api.spotify.com/v1/users/esnoz', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c25.0.150.150/1618629_10152231996658104_2046208491_n.jpg?oh=d800723864bd91fff930bb5283890b92&oe=5B24D076', 'BQAF-cBP7av1r4jpa1y2cXS3IsEc-VG-PFvdJeuVCyDCw8gQLRhtnPPFwVv2j_coZ3byQh0PwLyt8ctQAxFHRn3N7bgSa2lCa0v4RdVihfJC9CghP05KHASbds5ggntB8BmFjgpKr88_3hDSTbv5yGhO6XscuFLu7Q', '', '1518214856', '2018-02-09 12:03:37', '2018-02-09 20:20:56', NULL),
('1e3fff4e-0ddf-11e8-85ac-000000000000', 'millirules', 'millanhermana@hotmail.com', 'Millan Hermana', 'ES', 'https://api.spotify.com/v1/users/millirules', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c107.31.391.391/s200x200/10398581_74264098764_1421474_n.jpg?oh=b5cc5aa6aa61e38f0b491e54b6bda93d&oe=5B201966', 'BQB4Htm3mkxKSgsWP7vv4PsFbaPmfMWcNu6A6B0wd4Xh6gBWJweX_kAUScI31tzIGpcFcbdR49IuSasPBUCTiR4kL-3a6HeYp0pqYMYL1r_9uyHqcWIUUaNbHlJ2bF_EloLPcZpB6ln9T3tZDSf7qi6eVdekT0_dpMlPG0UbvyDH', '', '1518214857', '2018-02-09 12:25:51', '2018-02-09 20:20:57', NULL),
('1e8b0656-0ddf-11e8-9b55-000000000000', 'macram', 'macram@macram.es', 'Manu Mateos', 'ES', 'https://api.spotify.com/v1/users/macram', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/25550101_10212881322004991_6389841946881139698_n.jpg?oh=0c6a5340af5bc2ad5a45b28fa9c58eae&oe=5B1DD4E0', 'BQDJJyINpyH7RrBNX3V7nfWmEKOUbby9C1vv35vNr0aHJcIyHUzAHFBxD04MEpZiFuPqeHoCnmk3pYKyqNtGIf3uokuZL0dOhZXVGRaBGUt-kydfhFV87a-ZxTY6dnfYvrk5cYevXesY30i4dyGbV9FxZkQ9VavSI21sKyg', '', '1518214857', '2018-02-09 12:01:57', '2018-02-09 20:20:57', NULL),
('69495cd6-0e40-11e8-8335-000000000000', 'lezepo', 'lezepo@gmail.com', 'Jesús Suárez', 'ES', 'https://api.spotify.com/v1/users/lezepo', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c34.34.423.423/s200x200/1010746_10201261077677430_762393077_n.jpg?oh=46af4161ad62021b431f41fa1ba2a384&oe=5B26525F', 'BQAMKa54fJ4yd0UOyywV6Tn82pF2EKdcgnOT37XvUYJ-OCH4XQ-axYkWfEKQzEEtQuOx5ZUpsbXXRnaEnIWHQuw4GLVs7GdzooQE9nrN6K7p3hoXUpvwpFLXNPI_kzN2l7gWMeWNzbZV_U3vigHCY7whPprEL-vJ1zDV2gs', 'AQAyI_ojnl1iTKEvo4UXhFTdZPzSkhJ2OrrE-E9hMhqc376tnEXZu6Um5KycMXlRs2Q8VxrSq7Vp8ENrHR6WxfLWNeUevnqmKGl_ypatShVVPmjzH2CJ8KLkY2uCfqH2ZsU', '1518256644', '2018-02-09 15:14:25', '2018-02-10 07:57:24', NULL),
('697a1966-0e40-11e8-a0d2-000000000000', 'kuerbo', 'kuerbo@gmail.com', 'Andres Cuervo Adame', 'ES', 'https://api.spotify.com/v1/users/kuerbo', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/1185562_10152183848826832_142916018_n.jpg?oh=c3b1fd6c253120f2ac58e53ab678c7d1&oe=5AD8A311', 'BQCb1paO5eAbXPLJ6NED9FdR2_nqzN1T7uwzNVUduT3iCUOpEwTePLS49-FoL_7RUaXuTLWTVUI6gmMyEjADBEP8ZdaZrU6BzmmZtvPRSvf6Qy_-sghhMGElJHKMdJwdjEikAS-Ff0ZIqVbVYn5YL0O9ZVt65VZQl7GANPY', '', '1518256644', '2018-02-09 10:55:53', '2018-02-10 07:57:24', NULL),
('c0fc494c-0d9c-11e8-90d3-000000000000', '1117954296', 'juan@neuronasmuertas.com', 'Juan Alonso', 'ES', 'https://api.spotify.com/v1/users/1117954296', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c33.0.200.200/p200x200/35688_467884459391_2412780_n.jpg?oh=b0b9080458f9930624d0f447f7431093&oe=5AE2DF5D', 'BQBL59dPmPnqQUOTHXgZTDm87CmAYhAYPB4vOaL6RBxxOvSYtOKy9c1fmIeA1x7MpC8hJaZy8hFVKHrFg-gUA7bkPSqOYrV8a5Uz0BQTnqHACRAbvWl5zQbH43nC149ql7_dg-MMf43_Q52RvqEcZnFxBiamrwXtFeNxslJqenZK', '', '1518214857', '2018-02-09 12:25:53', '2018-02-09 20:20:57', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `spotify_profiles`
--
ALTER TABLE `spotify_profiles`
  ADD UNIQUE KEY `spotify_profiles_id_unique` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
