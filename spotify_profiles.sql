-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-02-2018 a las 14:54:38
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
('0d2f6b06-0d92-11e8-8149-000000000000', 'kuerbo', 'kuerbo@gmail.com', 'Andres Cuervo Adame', 'ES', 'https://api.spotify.com/v1/users/kuerbo', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/1185562_10152183848826832_142916018_n.jpg?oh=c3b1fd6c253120f2ac58e53ab678c7d1&oe=5AD8A311', 'BQCfR33WU2BTtVh_6LwoCxBYXxaMwFhEPYnr5MwWMjBlAKPsEcixAHpT7KMr2YelNIeSEIqGuQEJQHd90gCf3TAM96NRSsgs2N_4NUfgUHzJFQdBcxVJWgesI58ysZLs_B9buAamIBcmGRuJdkqTXGP8a8VSp5bSiN4FnQQ', 'AQDqVuQqZzpswFxXQs767woCLa1k6_dgPQCxb38UUOZkfPHpBNXYHzbHblPCb2F5lm8hcvDFzsImMdbuG2LPrHfRsRUYWNYa4Sb_W9gB5zaECrL6r09KS8vomXqszU97bss', '1518185596', '2018-02-09 10:55:53', '2018-02-09 12:13:16', NULL),
('5e50af52-0d99-11e8-b265-000000000000', 'mivise2012', 'migue.vicedo@gmail.com', NULL, 'ES', 'https://api.spotify.com/v1/users/mivise2012', '1', 'BQCSxT22RRpt6zr0BIKHExSKAB-AmCDMHUZdHUkOZE4aTD34f0wnM89YTAQa71Mub_d7n1ZR2xm4Q7U850Ln__wIWY3V-xEQOer1SQaw06qc2PPKmG1Co3wWYGj_U-JWa-dPfmje9kBhVsoVwy3D6plTyJ93QizW0mGUr1i_', 'AQATfopAt1SfoHMVz46HIb1QEls-nuy_6leE9GW0xJGwuFtMX_V2ZSoPJCapzEt0JW74GKKJqrS-xhxRlFO7dqfCHuYGPjqIKZ12m52XNkZk3wvZNJflo3Y0_0GzjeH3W6c', '1518184899', '2018-02-09 12:01:39', '2018-02-09 12:01:39', NULL),
('91c364f4-0da0-11e8-ba46-000000000000', '1119239464', 'r_chano@hotmail.com', 'Rubén Corrochano', 'ES', 'https://api.spotify.com/v1/users/1119239464', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c12.0.162.162/1959937_10202677822402235_2018586536_n.jpg?oh=d6469f03eb3c6226ad2da885beab9b93&oe=5ADEB315', 'BQAJUPMMw4TMp4InWupHmNOzNa6od8DwBeOW4CjOgeQq_UxIqeYphuAU-kmF7wNHc8G7eKr7CBmiwv09OkOn1cXrdpkTEZs4hL44X9IApesGKwcPRB3HQyzA2NkEYgH0kbPOl7PnhtCM4k3BiwnMaCNrAd9pIk3FLY7jEqRvs4x5', 'AQDYMUvbsT1EcqOlvROB8MKBPHiXBbbE5z-DiZ6NF8an6MByDGpaodZ9YK9b_yxTVJwp87hMNrzBcWbzwXZvhgou3Cd-vW6b1WYgF0ZP1yPdFG4PZNMZoEC0jrbFtD8f14g', '1518187992', '2018-02-09 12:53:12', '2018-02-09 12:53:12', NULL),
('94a46c24-0d99-11e8-a368-000000000000', 'jesusete1982', 'jesusestebansanchez@gmail.com', 'Jesús Esteban', 'ES', 'https://api.spotify.com/v1/users/jesusete1982', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/12239490_10154073162858488_4313380006669544528_n.jpg?oh=3f6b0e0ec1c35e9526c4c90771b843a5&oe=5B1D8BEA', 'BQCfoQSfjftpIxRPbtVcORPMjwWskanPqi2e9XHHHnP47-8zTWXkGvnL18Cdr7Ko6qIb7wbQONnehwVcH-IgvFQNHUfnJM-ZbMQW9IjaxYHWMawXEKY0Da0cHZ9HPJrHXlOCntFqlkrsUrBD5eSAgSsDVjF0WROsH-_K5W-LMwzizS8', 'AQDyIxAbfbY4ncitpBul7tfKiohrSxabjKuTQK0QsY-MB9t7MSTN89l0ExXaU_ikje8ZFGs73LMMCerz2dPMQADW1-d2BgcDY1gk37jsfWuRBT_65I-zFzklbu5e9SSzwzM', '1518184990', '2018-02-09 11:58:11', '2018-02-09 12:03:10', NULL),
('991b6c80-0d99-11e8-92b8-000000000000', 'aalex12', 'alexfs92@gmail.com', 'Álex Franco Silva', 'ES', 'https://api.spotify.com/v1/users/aalex12', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/23519079_10213352878770765_194540181166426721_n.jpg?oh=538a82b732c961c5a03c076848ae5294&oe=5AE7C5B5', 'BQAX2twojYCPKiyBagqx5Cun1u9xdSeciJCf6_Wz0h_Tpxo_qTZ3sgV3MSz5uSOfJvFjTQhSgG27IxgUHz6hLZXmGLvGoAYfDFlr5dtONPSveinsI_mTi3t6e0-i2A7fFnUop_4_ukEEYXNCNtkSSIUpXA1anRqzL8OilIOQ', 'AQB5oGHVJKJQ9LLmSw-UaM9ylfq1xhGo4QFln8XC2ZvcB1Fk9nrS8BjzkF6ZwRTYDSwThxYAxOyRWTABlmRtTHtYC5MYwcVvAlRIQkDcwC6qjmI747-5G5BNMOChhd2iyeg', '1518184998', '2018-02-09 12:03:18', '2018-02-09 12:03:18', NULL),
('9ce27bb0-0d99-11e8-a77b-000000000000', 'findelias', 'faltodeimaginacion@gmail.com', 'Rafael Nuño Tamayo', 'ES', 'https://api.spotify.com/v1/users/findelias', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/19113635_10209403752751260_3071298783926959368_n.jpg?oh=2d9c14615c46fc45adc1b4aebb8f5e3c&oe=5B0CA362', 'BQDkFReVCCQI0D0AeT7mdu91I-6hGmZo0Ljc4e7HZ5ArcJc4WqvPccAMBxJqTUIF2sExxXM-Y5p0h4YdHxBxJHrrjCHyuaOuhk9HVKg4uQ352Z7ONz_LIBqp9yQQsoklu2jiLwqY27kLmB7nhGtNXceIfd9y7HfRqjJDGkk', 'AQAp7GbxgyachkliAfJnUdz1kOfXArQlI3kPfE4yhBgeQfy3CMlbCfV3b4wTmkgmIbyFZKCEC1YuB6jM7Zaa_EjUZNu2o_d5Y6YnpAhF-cz7luW1b_2420MxzuhiGTBTWwQ', '1518185004', '2018-02-09 12:03:24', '2018-02-09 12:03:24', NULL),
('a493b3ce-0d99-11e8-ba83-000000000000', 'esnoz', 'marga.esnoz@gmail.com', 'Meggy Malone', 'ES', 'https://api.spotify.com/v1/users/esnoz', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c25.0.150.150/1618629_10152231996658104_2046208491_n.jpg?oh=d800723864bd91fff930bb5283890b92&oe=5B24D076', 'BQDlF_qBIxZmby_NWh6lZ-sPuepBEYBU6uSMQ_XxfdbWWAthL64hFRvRI8vyuV1NcDTMbMDIgaOwGmh13A-ChC5QSGAfTfydu4wKUfC27k2Evg-DAVWPJDAuqJ4YcZa5LIosgK33F-b5BpKai1hOAPyahOPkcglerQ', 'AQAUmAaNwrTQ5PrMoZvLhb5Of8KnP-Sn_OG0ZQlOIHQmyAGF_vSB5X-PYXXyZpV-l5IEhnIqAhwVN5iu8pLgq75uEQ9rHOLXJ2Q-sUUjDwbIg2CYJeux76uzYBGwXLp6aWY', '1518185017', '2018-02-09 12:03:37', '2018-02-09 12:03:37', NULL),
('bfd3dfb2-0d9c-11e8-9c6a-000000000000', 'millirules', 'millanhermana@hotmail.com', 'Millan Hermana', 'ES', 'https://api.spotify.com/v1/users/millirules', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c107.31.391.391/s200x200/10398581_74264098764_1421474_n.jpg?oh=b5cc5aa6aa61e38f0b491e54b6bda93d&oe=5B201966', 'BQBxkJ4vlzxZOOgGzn6EnhhDrdTAsleTujS9H9vjUt1RqOlUMcvQ7OFZKAMDrqAkXIloDEn_XDTJIpX13TqJsts20CNtB4hVFg1UEfpffk7uBT1kR8x7YvgVe2hpuOz90qjrHI9WgQUtz-GyAKqQf_WoyG9edjN-jHW0bXp8HNgt', 'AQCB10PdL2fSuoCc0kHQ7YSLUcjmUL9ZoFk4qVtwyOo12nHLQSa_RQtcfXiA09AvEeZBbWcBwmoWc-QnXIdVxuIuU-t5Aau7JVG3kc49k4g5tb28fdL0cncCIg7wxjjQat8', '1518186351', '2018-02-09 12:25:51', '2018-02-09 12:25:51', NULL),
('c0fc494c-0d9c-11e8-90d3-000000000000', '1117954296', 'juan@neuronasmuertas.com', 'Juan Alonso', 'ES', 'https://api.spotify.com/v1/users/1117954296', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c33.0.200.200/p200x200/35688_467884459391_2412780_n.jpg?oh=b0b9080458f9930624d0f447f7431093&oe=5AE2DF5D', 'BQCEh9hU6Rj2Npb-4mCzBy5_EBz52tDb6OyHVbT4TYQGWATYCSCpQ1SuH_wjO2I_xIs72JFYCCRgR-8yC0BBbCYeItqhgSz-H4ihXu9n9MoQpemE-MU8ZnWouiXqhEiwJ8MpVMV124X8In4vC8nll-tS5NMJ8kF_471yPbseIOsO', 'AQD2NH8uHqK6GO1rkI8fAjyWUFiHRhuQciP3CmTyv4iAV5tWoz7dcPogTn2jzyAxnWoBS6v5J19ulEKRAZWLEI2znBTnfcYWwz8jSVKrmdnHjYGUd7hsBuiBxjYaF2Gokjg', '1518186353', '2018-02-09 12:25:53', '2018-02-09 12:25:53', NULL),
('fd3ae6c2-0d9a-11e8-93fd-000000000000', 'macram', 'macram@macram.es', 'Manu Mateos', 'ES', 'https://api.spotify.com/v1/users/macram', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/25550101_10212881322004991_6389841946881139698_n.jpg?oh=0c6a5340af5bc2ad5a45b28fa9c58eae&oe=5B1DD4E0', 'BQAqz1mEDxtO-DbLDmK_poQBzKutkSvT6S-rMw8S-3MR6QTyfmZQAc9LzbkurhURlgq4X9mGe_dlVUYH4kXOjQhDUqApn0ewLkvbLXSRY2eDy9fD0jR63ezVwIvBFKn6NV7Vydut4014GzNF5aoXO6zU_FyzORC82UX3x_o', 'AQAL7eI0noHqdwRjw-k-iHs0Jo6vQWVZd4udDTG9UWSISM6iDcFoauXjT7y5jWAKja9AAzvXWw-FRuxFo8y4aF9uuXv5lB1qiWyaGW_aNYT9BSaz4upfbak-wg3Rx0iiTxk', '1518187641', '2018-02-09 12:01:57', '2018-02-09 12:47:21', NULL),
('69495cd6-0e40-11e8-8335-000000000000', 'lezepo', 'lezepo@gmail.com', 'Jesús Suárez', 'ES', 'https://api.spotify.com/v1/users/lezepo', 'https://scontent.xx.fbcdn.net/v/t1.0-1/c34.34.423.423/s200x200/1010746_10201261077677430_762393077_n.jpg?oh=46af4161ad62021b431f41fa1ba2a384&oe=5B26525F', 'BQAMKa54fJ4yd0UOyywV6Tn82pF2EKdcgnOT37XvUYJ-OCH4XQ-axYkWfEKQzEEtQuOx5ZUpsbXXRnaEnIWHQuw4GLVs7GdzooQE9nrN6K7p3hoXUpvwpFLXNPI_kzN2l7gWMeWNzbZV_U3vigHCY7whPprEL-vJ1zDV2gs', 'AQAyI_ojnl1iTKEvo4UXhFTdZPzSkhJ2OrrE-E9hMhqc376tnEXZu6Um5KycMXlRs2Q8VxrSq7Vp8ENrHR6WxfLWNeUevnqmKGl_ypatShVVPmjzH2CJ8KLkY2uCfqH2ZsU', '1518256644', '2018-02-09 15:14:25', '2018-02-10 07:57:24', NULL);
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
