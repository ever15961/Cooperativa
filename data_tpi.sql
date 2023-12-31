-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-01-2024 a las 22:31:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `data_tpi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE `cuota` (
  `id` int(11) NOT NULL,
  `prestamo` int(11) NOT NULL,
  `numeroCuota` int(11) NOT NULL,
  `montoCuota` double NOT NULL,
  `fechavencimiento` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL COMMENT '1-Pagado,2-No pagado',
  `interes` double NOT NULL,
  `principal` double NOT NULL,
  `saldoPendiente` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuota`
--

INSERT INTO `cuota` (`id`, `prestamo`, `numeroCuota`, `montoCuota`, `fechavencimiento`, `estado`, `interes`, `principal`, `saldoPendiente`) VALUES
(710, 94, 1, 106.61854641400993, '2023-12-01 06:00:00', 2, 12, 94.61854641400993, 1105.3814535859901),
(711, 94, 2, 106.61854641400993, '2024-01-01 06:00:00', 2, 11.053814535859901, 95.56473187815003, 1009.8167217078401),
(712, 94, 3, 106.61854641400993, '2024-02-01 06:00:00', 2, 10.098167217078402, 96.52037919693153, 913.2963425109085),
(713, 94, 4, 106.61854641400993, '2024-03-01 06:00:00', 2, 9.132963425109086, 97.48558298890084, 815.8107595220076),
(714, 94, 5, 106.61854641400993, '2024-04-01 06:00:00', 2, 8.158107595220077, 98.46043881878985, 717.3503207032178),
(715, 94, 6, 106.61854641400993, '2024-05-01 06:00:00', 2, 7.173503207032178, 99.44504320697774, 617.90527749624),
(716, 94, 7, 106.61854641400993, '2024-06-01 06:00:00', 2, 6.1790527749624005, 100.43949363904753, 517.4657838571925),
(717, 94, 8, 106.61854641400993, '2024-07-01 06:00:00', 2, 5.174657838571925, 101.443888575438, 416.0218952817545),
(718, 94, 9, 106.61854641400993, '2024-08-01 06:00:00', 2, 4.160218952817545, 102.45832746119238, 313.5635678205621),
(719, 94, 10, 106.61854641400993, '2024-09-01 06:00:00', 2, 3.135635678205621, 103.48291073580431, 210.08065708475783),
(720, 94, 11, 106.61854641400993, '2024-10-01 06:00:00', 2, 2.1008065708475785, 104.51773984316235, 105.56291724159549),
(721, 94, 12, 106.61854641400993, '2024-11-01 06:00:00', 2, 1.0556291724159548, 105.56291724159549, 0),
(722, 95, 1, 484.86648046951166, '2024-02-03 06:00:00', 2, 125, 359.86648046951166, 9640.13351953049),
(723, 95, 2, 484.86648046951166, '2024-03-03 06:00:00', 2, 120.50166899413112, 364.3648114753805, 9275.768708055108),
(724, 95, 3, 484.86648046951166, '2024-04-03 06:00:00', 2, 115.94710885068885, 368.9193716188228, 8906.849336436286),
(725, 95, 4, 484.86648046951166, '2024-05-03 06:00:00', 2, 111.33561670545357, 373.5308637640581, 8533.318472672228),
(726, 95, 5, 484.86648046951166, '2024-06-03 06:00:00', 1, 106.66648090840286, 378.1999995611088, 8155.11847311112),
(727, 95, 6, 484.86648046951166, '2024-07-03 06:00:00', 1, 101.938980913889, 382.92749955562266, 7772.190973555497),
(728, 95, 7, 484.86648046951166, '2024-08-03 06:00:00', 1, 97.15238716944373, 387.71409330006793, 7384.476880255429),
(729, 95, 8, 484.86648046951166, '2024-09-03 06:00:00', 1, 92.30596100319286, 392.5605194663188, 6991.9163607891105),
(730, 95, 9, 484.86648046951166, '2024-10-03 06:00:00', 1, 87.39895450986388, 397.4675259596478, 6594.448834829463),
(731, 95, 10, 484.86648046951166, '2024-11-03 06:00:00', 1, 82.4306104353683, 402.43587003414336, 6192.012964795319),
(732, 95, 11, 484.86648046951166, '2024-12-03 06:00:00', 1, 77.4001620599415, 407.46631840957014, 5784.546646385749),
(733, 95, 12, 484.86648046951166, '2025-01-03 06:00:00', 1, 72.30683307982187, 412.55964738968976, 5371.98699899606),
(734, 95, 13, 484.86648046951166, '2025-02-03 06:00:00', 1, 67.14983748745075, 417.7166429820609, 4954.270356013999),
(735, 95, 14, 484.86648046951166, '2025-03-03 06:00:00', 1, 61.92837945017499, 422.93810101933667, 4531.332254994662),
(736, 95, 15, 484.86648046951166, '2025-04-03 06:00:00', 1, 56.641653187433285, 428.22482728207837, 4103.1074277125845),
(737, 95, 16, 484.86648046951166, '2025-05-03 06:00:00', 1, 51.288842846407306, 433.57763762310435, 3669.5297900894802),
(738, 95, 17, 484.86648046951166, '2025-06-03 06:00:00', 1, 45.869122376118504, 438.99735809339313, 3230.5324319960873),
(739, 95, 18, 484.86648046951166, '2025-07-03 06:00:00', 1, 40.38165539995109, 444.48482506956054, 2786.047606926527),
(740, 95, 19, 484.86648046951166, '2025-08-03 06:00:00', 1, 34.825595086581586, 450.04088538293007, 2336.006721543597),
(741, 95, 20, 484.86648046951166, '2025-09-03 06:00:00', 1, 29.200084019294962, 455.66639645021667, 1880.3403250933802),
(742, 95, 21, 484.86648046951166, '2025-10-03 06:00:00', 1, 23.504254063667254, 461.3622264058444, 1418.9780986875357),
(743, 95, 22, 484.86648046951166, '2025-11-03 06:00:00', 1, 17.737226233594196, 467.1292542359175, 951.8488444516183),
(744, 95, 23, 484.86648046951166, '2025-12-03 06:00:00', 1, 11.89811055564523, 472.9683699138664, 478.8804745377519),
(745, 95, 24, 484.86648046951166, '2026-01-03 06:00:00', 1, 5.986005931721899, 478.8804745377519, 0),
(746, 96, 1, 484.86648046951166, '2023-09-01 06:00:00', 2, 125, 359.86648046951166, 9640.13351953049),
(747, 96, 2, 484.86648046951166, '2023-10-01 06:00:00', 2, 120.50166899413112, 364.3648114753805, 9275.768708055108),
(748, 96, 3, 484.86648046951166, '2023-11-01 06:00:00', 2, 115.94710885068885, 368.9193716188228, 8906.849336436286),
(749, 96, 4, 484.86648046951166, '2023-12-01 06:00:00', 2, 111.33561670545357, 373.5308637640581, 8533.318472672228),
(750, 96, 5, 484.86648046951166, '2024-01-01 06:00:00', 2, 106.66648090840286, 378.1999995611088, 8155.11847311112),
(751, 96, 6, 484.86648046951166, '2024-02-01 06:00:00', 2, 101.938980913889, 382.92749955562266, 7772.190973555497),
(752, 96, 7, 484.86648046951166, '2024-03-01 06:00:00', 2, 97.15238716944373, 387.71409330006793, 7384.476880255429),
(753, 96, 8, 484.86648046951166, '2024-04-01 06:00:00', 1, 92.30596100319286, 392.5605194663188, 6991.9163607891105),
(754, 96, 9, 484.86648046951166, '2024-05-01 06:00:00', 1, 87.39895450986388, 397.4675259596478, 6594.448834829463),
(755, 96, 10, 484.86648046951166, '2024-06-01 06:00:00', 1, 82.4306104353683, 402.43587003414336, 6192.012964795319),
(756, 96, 11, 484.86648046951166, '2024-07-01 06:00:00', 1, 77.4001620599415, 407.46631840957014, 5784.546646385749),
(757, 96, 12, 484.86648046951166, '2024-08-01 06:00:00', 1, 72.30683307982187, 412.55964738968976, 5371.98699899606),
(758, 96, 13, 484.86648046951166, '2024-09-01 06:00:00', 1, 67.14983748745075, 417.7166429820609, 4954.270356013999),
(759, 96, 14, 484.86648046951166, '2024-10-01 06:00:00', 1, 61.92837945017499, 422.93810101933667, 4531.332254994662),
(760, 96, 15, 484.86648046951166, '2024-11-01 06:00:00', 1, 56.641653187433285, 428.22482728207837, 4103.1074277125845),
(761, 96, 16, 484.86648046951166, '2024-12-01 06:00:00', 1, 51.288842846407306, 433.57763762310435, 3669.5297900894802),
(762, 96, 17, 484.86648046951166, '2025-01-01 06:00:00', 1, 45.869122376118504, 438.99735809339313, 3230.5324319960873),
(763, 96, 18, 484.86648046951166, '2025-02-01 06:00:00', 1, 40.38165539995109, 444.48482506956054, 2786.047606926527),
(764, 96, 19, 484.86648046951166, '2025-03-01 06:00:00', 1, 34.825595086581586, 450.04088538293007, 2336.006721543597),
(765, 96, 20, 484.86648046951166, '2025-04-01 06:00:00', 1, 29.200084019294962, 455.66639645021667, 1880.3403250933802),
(766, 96, 21, 484.86648046951166, '2025-05-01 06:00:00', 1, 23.504254063667254, 461.3622264058444, 1418.9780986875357),
(767, 96, 22, 484.86648046951166, '2025-06-01 06:00:00', 1, 17.737226233594196, 467.1292542359175, 951.8488444516183),
(768, 96, 23, 484.86648046951166, '2025-07-01 06:00:00', 1, 11.89811055564523, 472.9683699138664, 478.8804745377519),
(769, 96, 24, 484.86648046951166, '2025-08-01 06:00:00', 1, 5.986005931721899, 478.8804745377519, 0),
(770, 97, 1, 22.2121971695854, '2024-02-04 06:00:00', 1, 2.5, 19.7121971695854, 230.2878028304146),
(771, 97, 2, 22.2121971695854, '2024-03-04 06:00:00', 1, 2.302878028304146, 19.909319141281255, 210.37848368913333),
(772, 97, 3, 22.2121971695854, '2024-04-04 06:00:00', 1, 2.103784836891333, 20.10841233269407, 190.27007135643927),
(773, 97, 4, 22.2121971695854, '2024-05-04 06:00:00', 1, 1.9027007135643927, 20.30949645602101, 169.96057490041827),
(774, 97, 5, 22.2121971695854, '2024-06-04 06:00:00', 1, 1.6996057490041827, 20.51259142058122, 149.44798347983703),
(775, 97, 6, 22.2121971695854, '2024-07-04 06:00:00', 1, 1.4944798347983703, 20.717717334787032, 128.73026614505),
(776, 97, 7, 22.2121971695854, '2024-08-04 06:00:00', 1, 1.2873026614504999, 20.9248945081349, 107.8053716369151),
(777, 97, 8, 22.2121971695854, '2024-09-04 06:00:00', 1, 1.078053716369151, 21.13414345321625, 86.67122818369884),
(778, 97, 9, 22.2121971695854, '2024-10-04 06:00:00', 1, 0.8667122818369885, 21.345484887748412, 65.32574329595043),
(779, 97, 10, 22.2121971695854, '2024-11-04 06:00:00', 1, 0.6532574329595043, 21.5589397366259, 43.76680355932453),
(780, 97, 11, 22.2121971695854, '2024-12-04 06:00:00', 1, 0.4376680355932453, 21.774529133992157, 21.992274425332372),
(781, 97, 12, 22.2121971695854, '2025-01-04 06:00:00', 1, 0.21992274425332373, 21.992274425332372, 0),
(794, 100, 1, 22.564578086289306, '2024-02-02 06:00:00', 1, 3.125, 19.439578086289306, 230.56042191371068),
(795, 100, 2, 22.564578086289306, '2024-03-02 06:00:00', 1, 2.8820052739213837, 19.682572812367923, 210.87784910134275),
(796, 100, 3, 22.564578086289306, '2024-04-02 06:00:00', 1, 2.6359731137667843, 19.92860497252252, 190.94924412882023),
(797, 100, 4, 22.564578086289306, '2024-05-02 06:00:00', 1, 2.386865551610253, 20.177712534679053, 170.77153159414118),
(798, 100, 5, 22.564578086289306, '2024-06-02 06:00:00', 1, 2.134644144926765, 20.429933941362542, 150.34159765277863),
(799, 100, 6, 22.564578086289306, '2024-07-02 06:00:00', 1, 1.879269970659733, 20.685308115629574, 129.65628953714906),
(800, 100, 7, 22.564578086289306, '2024-08-02 06:00:00', 1, 1.6207036192143633, 20.94387446707494, 108.71241507007412),
(801, 100, 8, 22.564578086289306, '2024-09-02 06:00:00', 1, 1.3589051883759264, 21.20567289791338, 87.50674217216073),
(802, 100, 9, 22.564578086289306, '2024-10-02 06:00:00', 1, 1.093834277152009, 21.470743809137296, 66.03599836302342),
(803, 100, 10, 22.564578086289306, '2024-11-02 06:00:00', 1, 0.8254499795377929, 21.73912810675151, 44.296870256271916),
(804, 100, 11, 22.564578086289306, '2024-12-02 06:00:00', 1, 0.5537108782033989, 22.010867208085905, 22.28600304818601),
(805, 100, 12, 22.564578086289306, '2025-01-02 06:00:00', 1, 0.27857503810232515, 22.28600304818601, 0),
(806, 101, 1, 22.564578086289306, '2023-11-04 06:00:00', 1, 3.125, 19.439578086289306, 230.56042191371068),
(807, 101, 2, 22.564578086289306, '2023-12-04 06:00:00', 1, 2.8820052739213837, 19.682572812367923, 210.87784910134275),
(808, 101, 3, 22.564578086289306, '2024-01-04 06:00:00', 1, 2.6359731137667843, 19.92860497252252, 190.94924412882023),
(809, 101, 4, 22.564578086289306, '2024-02-04 06:00:00', 1, 2.386865551610253, 20.177712534679053, 170.77153159414118),
(810, 101, 5, 22.564578086289306, '2024-03-04 06:00:00', 1, 2.134644144926765, 20.429933941362542, 150.34159765277863),
(811, 101, 6, 22.564578086289306, '2024-04-04 06:00:00', 1, 1.879269970659733, 20.685308115629574, 129.65628953714906),
(812, 101, 7, 22.564578086289306, '2024-05-04 06:00:00', 1, 1.6207036192143633, 20.94387446707494, 108.71241507007412),
(813, 101, 8, 22.564578086289306, '2024-06-04 06:00:00', 1, 1.3589051883759264, 21.20567289791338, 87.50674217216073),
(814, 101, 9, 22.564578086289306, '2024-07-04 06:00:00', 1, 1.093834277152009, 21.470743809137296, 66.03599836302342),
(815, 101, 10, 22.564578086289306, '2024-08-04 06:00:00', 1, 0.8254499795377929, 21.73912810675151, 44.296870256271916),
(816, 101, 11, 22.564578086289306, '2024-09-04 06:00:00', 1, 0.5537108782033989, 22.010867208085905, 22.28600304818601),
(817, 101, 12, 22.564578086289306, '2024-10-04 06:00:00', 1, 0.27857503810232515, 22.28600304818601, 0),
(818, 104, 1, 22.80118801959418, '2024-02-28 06:00:00', 1, 3.541666666666667, 19.25952135292751, 230.74047864707248),
(819, 104, 2, 22.80118801959418, '2024-03-28 06:00:00', 1, 3.2688234475001936, 19.532364572093986, 211.20811407497848),
(820, 104, 3, 22.80118801959418, '2024-04-28 06:00:00', 1, 2.992114949395529, 19.80907307019865, 191.39904100477983),
(821, 104, 4, 22.80118801959418, '2024-05-28 06:00:00', 1, 2.7114864142343813, 20.089701605359796, 171.30933939942003),
(822, 104, 5, 22.80118801959418, '2024-06-28 06:00:00', 1, 2.4268823081584507, 20.374305711435728, 150.9350336879843),
(823, 104, 6, 22.80118801959418, '2024-07-28 06:00:00', 1, 2.1382463105797775, 20.6629417090144, 130.27209197896988),
(824, 104, 7, 22.80118801959418, '2024-08-28 06:00:00', 1, 1.8455213030354067, 20.95566671655877, 109.31642526241112),
(825, 104, 8, 22.80118801959418, '2024-09-28 06:00:00', 1, 1.5486493578841576, 21.25253866171002, 88.0638866007011),
(826, 104, 9, 22.80118801959418, '2024-10-28 06:00:00', 1, 1.2475717268432656, 21.553616292750913, 66.51027030795018),
(827, 104, 10, 22.80118801959418, '2024-11-28 06:00:00', 1, 0.9422288293626276, 21.858959190231552, 44.65131111771863),
(828, 104, 11, 22.80118801959418, '2024-12-28 06:00:00', 1, 0.6325602408343473, 22.16862777875983, 22.482683338958797),
(829, 104, 12, 22.80118801959418, '2025-01-28 06:00:00', 1, 0.31850468063524967, 22.482683338958797, 0),
(830, 105, 1, 22.80118801959418, '2024-02-25 06:00:00', 1, 3.541666666666667, 19.25952135292751, 230.74047864707248),
(831, 105, 2, 22.80118801959418, '2024-03-25 06:00:00', 1, 3.2688234475001936, 19.532364572093986, 211.20811407497848),
(832, 105, 3, 22.80118801959418, '2024-04-25 06:00:00', 1, 2.992114949395529, 19.80907307019865, 191.39904100477983),
(833, 105, 4, 22.80118801959418, '2024-05-25 06:00:00', 1, 2.7114864142343813, 20.089701605359796, 171.30933939942003),
(834, 105, 5, 22.80118801959418, '2024-06-25 06:00:00', 1, 2.4268823081584507, 20.374305711435728, 150.9350336879843),
(835, 105, 6, 22.80118801959418, '2024-07-25 06:00:00', 1, 2.1382463105797775, 20.6629417090144, 130.27209197896988),
(836, 105, 7, 22.80118801959418, '2024-08-25 06:00:00', 1, 1.8455213030354067, 20.95566671655877, 109.31642526241112),
(837, 105, 8, 22.80118801959418, '2024-09-25 06:00:00', 1, 1.5486493578841576, 21.25253866171002, 88.0638866007011),
(838, 105, 9, 22.80118801959418, '2024-10-25 06:00:00', 1, 1.2475717268432656, 21.553616292750913, 66.51027030795018),
(839, 105, 10, 22.80118801959418, '2024-11-25 06:00:00', 1, 0.9422288293626276, 21.858959190231552, 44.65131111771863),
(840, 105, 11, 22.80118801959418, '2024-12-25 06:00:00', 1, 0.6325602408343473, 22.16862777875983, 22.482683338958797),
(841, 105, 12, 22.80118801959418, '2025-01-25 06:00:00', 1, 0.31850468063524967, 22.482683338958797, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `identificacion` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `apellido`, `identificacion`, `usuario`) VALUES
(1, 'Admin', 'Admin', 1, 1),
(24, 'Otoniel', 'Garmendia', 38, 31),
(26, 'Jose', 'Vaquerano', 44, 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion`
--

CREATE TABLE `identificacion` (
  `id` int(11) NOT NULL,
  `numero` varchar(25) NOT NULL,
  `tipoIdentificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `identificacion`
--

INSERT INTO `identificacion` (`id`, `numero`, `tipoIdentificacion`) VALUES
(1, '1234567-8', 1),
(31, '05418560-8', 1),
(33, '05418560-8', 1),
(34, '05418560-8', 1),
(36, '05418560-8', 1),
(37, '05418560-8', 1),
(38, '05418560-8', 1),
(42, '05418560-8', 1),
(43, '05418560-8', 1),
(44, '05418560-8', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interes`
--

CREATE TABLE `interes` (
  `id` int(11) NOT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `tasaInteres` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `interes`
--

INSERT INTO `interes` (`id`, `destino`, `tasaInteres`) VALUES
(1, 'Cultivo', 10),
(2, 'Personal', 13),
(3, 'Financiamiento', 15),
(4, 'Construccion', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id` int(11) NOT NULL,
  `codigo` varchar(7) NOT NULL,
  `montoPrestamo` double NOT NULL,
  `destinoPrestamo` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `estadoPrestamo` int(11) NOT NULL COMMENT '1-Activo, 2-Inactivo',
  `amortizacion` double NOT NULL,
  `socio` int(11) NOT NULL,
  `plazo_anio` int(11) NOT NULL,
  `plazo_cuota` int(11) DEFAULT NULL COMMENT '1-mensual, 2-trimestral, 3-semestral',
  `tasaInteres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id`, `codigo`, `montoPrestamo`, `destinoPrestamo`, `fechaInicio`, `estadoPrestamo`, `amortizacion`, `socio`, `plazo_anio`, `plazo_cuota`, `tasaInteres`) VALUES
(94, '133-10', 1200, 1, '2023-11-01', 2, 0, 7, 1, 1, 11),
(95, '2-0030', 10000, 1, '2024-01-03', 1, 0, 10, 2, 1, 11),
(96, '000902', 10000, 1, '2023-08-01', 1, 0, 9, 2, 1, 11),
(97, '20-2-8', 250, 1, '2024-01-04', 1, 0, 9, 1, 1, 11),
(100, '029422', 250, 3, '2024-01-02', 1, 0, 9, 1, 1, 15),
(101, '4-0210', 250, 3, '2023-10-04', 1, 0, 9, 1, 1, 15),
(104, '008261', 250, 4, '2024-01-28', 1, 0, 9, 1, 1, 17),
(105, '024-95', 250, 4, '2024-01-25', 1, 0, 10, 1, 1, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'Empleado'),
(2, 'Administrador'),
(3, 'Socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `identificacion` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `codigoSocio` varchar(50) NOT NULL,
  `usuario` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `nombre`, `apellido`, `identificacion`, `direccion`, `telefono`, `codigoSocio`, `usuario`, `correo`) VALUES
(5, 'Naydelin', 'Alvarado', 33, 'San vicente', '23933339', '2dlney', 26, 'lizvm@gmail.com'),
(7, 'Jairo', 'Vaquerano', 34, 'San vicente,Apastepeque', '23897514', 'r5evrr', 27, 'gtav15966@gmail.com'),
(9, 'Antonio', 'Vaquera', 36, 'San Salvador', '23876655', 'to9nuA', 29, 'va17020@ues.edu.sv'),
(10, 'Otoniel', 'Zuniga', 37, 'Apastepeque', '23453322', 'etZng4', 30, 'SV234@gmail.com'),
(13, 'Antonio', 'Ortiz', 42, 'El salvador,San salvador', '23897514', 'oOnrn1', 35, 'ortiz2@gmail.com'),
(14, 'german', 'vaquerano', 43, 'san vicente', '23897514', '2raaeu', 36, 'ortiz233@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoidentificacion`
--

CREATE TABLE `tipoidentificacion` (
  `id` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoidentificacion`
--

INSERT INTO `tipoidentificacion` (`id`, `tipo`) VALUES
(1, 'DUI'),
(2, 'NIT'),
(3, 'Pasaporte'),
(4, 'Carnet de minoridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `foto` longblob DEFAULT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `foto`, `rol`) VALUES
(1, 'admin', 'bNKsJo2DppW/9TzqxQ+BBQ==', NULL, 2),
(26, 'nay', '23897514', NULL, 3),
(27, 'w', 'L7rer4IWSYEivkjiavCOog==', NULL, 3),
(29, 'ever', 'bNKsJo2DppW/9TzqxQ+BBQ==', NULL, 3),
(30, 'Oto', 'kDxfjI5EIJQrV66ChiFG9A==', NULL, 3),
(31, 'oro', 'BSdF6JW2rsSW56HuUg3mSA==', NULL, 1),
(32, 'e', 'bNKsJo2DppW/9TzqxQ+BBQ==', NULL, 1),
(35, 'Ortiz', 'O/effi6NC43x4DmCl+jVGQ==', NULL, 3),
(36, 'ever12', 'bNKsJo2DppW/9TzqxQ+BBQ==', NULL, 3),
(37, 'ever21', 'bNKsJo2DppW/9TzqxQ+BBQ==', NULL, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuenta` (`prestamo`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identificacion` (`identificacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipoIdentificacion` (`tipoIdentificacion`);

--
-- Indices de la tabla `interes`
--
ALTER TABLE `interes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_socio` (`socio`),
  ADD KEY `fk-interes` (`destinoPrestamo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identificacion` (`identificacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `tipoidentificacion`
--
ALTER TABLE `tipoidentificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuota`
--
ALTER TABLE `cuota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=842;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `interes`
--
ALTER TABLE `interes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipoidentificacion`
--
ALTER TABLE `tipoidentificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD CONSTRAINT `cuota_ibfk_1` FOREIGN KEY (`prestamo`) REFERENCES `prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`identificacion`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD CONSTRAINT `identificacion_ibfk_1` FOREIGN KEY (`tipoIdentificacion`) REFERENCES `tipoidentificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_interes` FOREIGN KEY (`destinoPrestamo`) REFERENCES `interes` (`id`),
  ADD CONSTRAINT `fk_socio` FOREIGN KEY (`socio`) REFERENCES `socio` (`id`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`identificacion`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `socio_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
