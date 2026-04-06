-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-04-2026 a las 16:37:55
-- Versión del servidor: 10.4.26-MariaDB-log
-- Versión de PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `TailAndPaws`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `logo`, `website`, `country`, `is_active`) VALUES
(1, 'Royal Canin', 'royal-canin', 'Премиальные корма для кошек и собак', 'Royal-Canin-Logo.png', 'https://www.royalcanin.com', 'Франция', 1),
(2, 'ABBA', 'abba', 'Качественные корма для домашних животных', 'abba.png', 'https://abba.ru', 'Россия', 1),
(3, 'RURRI', 'rurri', 'Одежда и амуниция для собак', 'rurri.png', NULL, 'Россия', 1),
(4, 'Ownat', 'ownat', 'Натуральные корма премиум-класса', 'ownat.png', 'https://www.ownat.com', 'Испания', 1),
(5, 'Grandin', 'grandin', 'Корма и лакомства для собак', 'grandin.png', 'https://www.grandin-pet.ru/', 'Россия', 1),
(6, 'Triol', 'triol', 'Российский производитель качественных кормов и лакомств для собак и кошек.', 'triol.png', 'https://triol.pet/', 'Россия', 1),
(10, 'Rungo', 'rungo', 'RUNGO – продукция предназначенная для качественного ухода за собаками.\r\n\r\nОдежда и аксессуары RUNGO соответствуют современным потребностям домашних животных и хозяев. Эти изделия отличаются высоким качеством, сохраняют свои технические характеристики и внешний вид в хорошем состоянии в течение длительного срока эксплуатации. В ассортимент RUNGO входят следующие группы товаров: светящиеся игрушки, маячки, ошейники, попоны и дождевики.\r\n\r\nС применением изделий RUNGO многие практические задачи будут решены быстро, точно и с комфортом.', 'rungo.jpeg', NULL, 'Россия', 1),
(11, 'Klicker', 'klicker', 'Турецкий бренд сухих и влажных кормов супер-премиум класса для кошек и собак, производимый компанией Hermos Pet Food с 2017 года. Корма производятся в Турции, являются беззерновыми, монопротеиновыми и экспортируются во многие страны.', 'klicker.png', NULL, 'Турция', 1),
(12, 'AlphaPet', 'alphapet', 'Российский бренд высококачественных кормов для собак и кошек классов суперпремиум и холистик. Продукция производится в России на современном оборудовании с высоким содержанием свежего мяса (до 95% во влажных рационах), разработанная с учетом физиологических потребностей животных и принципов здорового питания.', 'alphapet.png', 'https://alphapet.ru/', 'Россия', 1),
(13, 'Tetra', 'tetra', 'Мировой лидер в производстве товаров для аквариумистики, основанный в Германии, который первым разработал сухой корм для рыб в виде хлопьев', 'tetra.jpg', 'https://www.tetra.net/ru-ru', 'Германия', 1),
(14, 'Little One', 'little-one', 'Бренд Little One (корма и лакомства для грызунов и птиц) производится в России. Торговая марка принадлежит компании Mealberry, которая специализируется на выпуске товаров для мелких домашних животных. Продукция, включая корма, лакомства и витамины, широко представлена на российском рынке.', 'little-one.jpg', NULL, 'Россия', 1),
(15, 'GRANDORF', 'grandorf', 'Это бельгийский бренд высококачественных кормов класса холистик, предназначенных для кошек и собак. Продукция славится высоким содержанием мяса (до 70%), гипоаллергенными составами без кукурузы, пшеницы и субпродуктов, а также наличием живых пробиотиков для пищеварения. Подходит для животных с чувствительным ЖКТ.', 'grandorf.jpg', 'https://grandorf.ru/', 'Бельгия', 1),
(16, 'Rogz', 'rogz', 'Известный южноафриканский бренд товаров для домашних животных, основанный в 1995 году в Кейптауне Полом Фуллером и Ирен Раубенхаймер. Марка производит безопасные, функциональные и стильные аксессуары (ошейники, поводки, шлейки, игрушки) для собак и кошек, отличающиеся ярким дизайном и высоким качеством материалов.', 'rogz.png', 'https://rogz.com/', 'Южно-Африканская Республика', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `session_id`, `variation_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(20, 1, 'FsRQjMKDSOThcwwPUvflAKIrh9FN4myyQTqA0M3B', 46, 1, '1999.00', '2026-04-06 06:51:52', '2026-04-06 06:51:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `image`, `parent_id`, `sort_order`, `is_active`) VALUES
(1, 'Для собак', 'dlya-sobak', 'Всё необходимое для вашего четвероногого друга: от качественного питания до удобной амуниции и развивающих игрушек. Позаботьтесь о здоровье и счастье вашей собаки вместе с TailAndPaws!', 'dlya-sobak.svg', 'dlia-sobak_image.jpg', NULL, 10, 1),
(2, 'Корма', 'korma-dlya-sobak', 'Правильное питание — основа здоровья вашего питомца. У нас представлены корма премиум-класса для собак всех возрастов, пород и особенностей здоровья.', NULL, 'korma_image.jpg', 1, 10, 1),
(3, 'Сухие корма', 'suhie-korma', 'Сбалансированные сухие корма с высоким содержанием белка, витаминов и минералов. Удобный формат хранения и кормления для активных собак.', NULL, 'suxie-korma_image.jpg', 2, 10, 1),
(4, 'Влажные корма', 'vlazhnye-korma', 'Ароматные паштеты, кусочки в соусе и консервы, которые ваша собака полюбит с первого раза. Идеально для привередливых питомцев.', NULL, 'vlaznye-korma_image.jpg', 2, 20, 1),
(5, 'Диетическое питание', 'dieticheskoe-pitanie', 'Специализированные корма для собак с чувствительным пищеварением, аллергиями или особыми потребностями. Только одобренные ветеринарами формулы.', NULL, NULL, 2, 30, 1),
(6, 'Амуниция', 'amunitsiya', 'Качественная амуниция для комфортных прогулок и безопасного содержания. Ошейники, поводки, шлейки и аксессуары на любой вкус.', NULL, NULL, 1, 20, 1),
(7, 'Ошейники и поводки', 'osheyniki-i-povodki', 'Надёжные и стильные ошейники и поводки из качественных материалов. Регулируемые размеры, светоотражающие элементы и удобные застёжки.', NULL, 'oseiniki-i-povodki_image.jpg', 6, 10, 1),
(8, 'Намордники', 'namordniki', 'Безопасные и комфортные намордники для прогулок и посещения ветеринара. Различные размеры и материалы для любой породы.', NULL, NULL, 6, 20, 1),
(10, 'Игрушки', 'igrushki', 'Развивающие, интерактивные и просто весёлые игрушки для активных собак. Помогают направить энергию в мирное русло и укрепить связь с хозяином.', NULL, NULL, 1, 30, 1),
(11, 'Мячики и фрисби', 'myachiki-i-frisbi', 'Идеальный выбор для активных игр на свежем воздухе. Прочные мячики, летающие тарелки и снаряды для апортировки, которые выдержат любую нагрузку.', NULL, NULL, 10, 10, 1),
(12, 'Канаты и кости', 'kanaty-i-kosti', 'Прочные канатные игрушки и безопасные кости для жевания. Помогают чистить зубы, массировать дёсны и надолго увлечь питомца.', NULL, NULL, 10, 20, 1),
(13, 'Лежанки и домики', 'lezhanki-i-domiki', 'Уютные и тёплые места для отдыха вашего питомца. Выбирайте из широкого ассортимента лежанок и домиков для собак любых размеров.', 'lezhanki-i-domiki.svg', 'lezhanki-i-domiki.jpg', 1, 40, 1),
(14, 'Лежанки', 'lezhanki', 'Мягкие лежанки с ортопедическими свойствами для комфортного сна и отдыха. Съёмные чехлы, водоотталкивающие материалы — уют в каждой детали.', 'lezhanki.svg', 'lezhanki.jpg', 13, 10, 1),
(15, 'Домики', 'domiki', 'Уютные домики и будки, где ваш питомец будет чувствовать себя в полной безопасности. Для квартиры, дома или уличного содержания.', 'domiki.svg', 'domiki.jpg', 13, 20, 1),
(16, 'Миски и кормушки', 'miski-i-kormushki', 'Практичные миски и автоматические кормушки для правильного режима питания. Нержавеющая сталь, керамика, пластик — выбор за вами.', NULL, NULL, 1, 50, 1),
(17, 'Миски', 'miski', 'Удобные миски для воды и корма на любой вкус. С нескользящими ножками, подставками и регулируемой высотой для правильной осанки питомца.', 'miski.svg', 'miski.jpg', 16, 10, 1),
(18, 'Автокормушки', 'avtokormushki', 'Современные автоматические кормушки с программируемым временем подачи. Идеально для занятых хозяев и питомцев, которым нужен режим.', 'avtokormushki.svg', 'avtokormushki.jpg', 16, 20, 1),
(19, 'Для кошек', 'dlya-koshek', 'Всё, что нужно для счастливой и здоровой жизни вашей кошки. Корма премиум-класса, удобные наполнители, когтеточки и уютные домики.', 'dlya-koshek.svg', 'dlia-kosek_image.jpg', NULL, 20, 1),
(20, 'Корма', 'korma-dlya-koshek', 'Качественные корма для кошек всех возрастов. Сухие и влажные рационы, лакомства и специализированное питание для здоровья и долголетия.', 'korma-dlya-koshek.svg', 'korma-dlya-koshek.jpg', 19, 10, 1),
(21, 'Сухие корма', 'suhie-korma-dlya-koshek', 'Сбалансированные сухие корма с высоким содержанием таурина, витаминов и минералов. Для поддержания здоровья шерсти, зубов и пищеварения.', 'suhie-korma-dlya-koshek.svg', 'suxie-korma_image.jpg', 20, 10, 1),
(22, 'Паучи и консервы', 'pauchi-i-konservy', 'Аппетитные паучи и консервы в удобной порционной упаковке. Натуральный состав, высокое содержание мяса — идеальный выбор для гурманов.', 'pauchi-i-konservy.svg', 'pauci-i-konservy_image.jpg', 20, 20, 1),
(23, 'Лакомства', 'lakomstva-dlya-koshek', 'Вкусные и полезные лакомства для поощрения и разнообразия рациона. Палочки, подушечки, крема — ваша кошка будет в восторге!', 'lakomstva-dlya-koshek.svg', 'lakomstva_image.jpg', 20, 30, 1),
(24, 'Наполнители', 'napolniteli', 'Качественные наполнители для кошачьего туалета с отличной впитываемостью и контролем запаха. Выбирайте оптимальный вариант для вашего питомца.', 'napolniteli.svg', 'napolniteli.jpg', 19, 20, 1),
(25, 'Древесные', 'drevesnye', 'Экологичные древесные наполнители из натуральных материалов. Отличная абсорбция, приятный аромат и бережное отношение к природе.', 'drevesnye.svg', 'drevesnye.jpg', 24, 10, 1),
(26, 'Силикагелевые', 'silikagelevye', 'Современные силикагелевые наполнители с максимальной впитываемостью. Долго сохраняют сухость и нейтрализуют неприятные запахи.', 'silikagelevye.svg', 'silikagelevye.jpg', 24, 20, 1),
(27, 'Комкующиеся', 'komkuyuschiesya', 'Удобные комкующиеся наполнители на основе бентонитовой глины. Легко убирать, экономичный расход и отличный контроль запаха.', 'komkuyuschiesya.svg', 'komkuyuschiesya.jpg', 24, 30, 1),
(28, 'Когтеточки и домики', 'kogtetochki-i-domiki', 'Всё для активных и спокойных кошек. Когтеточки для стачивания когтей, уютные домики и развлекательные комплексы.', 'kogtetochki-i-domiki.svg', 'kogtetochki-i-domiki.jpg', 19, 30, 1),
(29, 'Когтеточки', 'kogtetochki', 'Качественные когтеточки разных форм и размеров. Спасите вашу мебель и подарите кошке любимое место для точения когтей.', 'kogtetochki.svg', 'kogtetochki.jpg', 28, 10, 1),
(30, 'Лежанки для кошек', 'lezhanki-dlya-koshek', 'Мягкие и тёплые лежанки для любимых кошек. Уютные места для сна и отдыха, которые так любят наши пушистые друзья.', 'lezhanki-dlya-koshek.svg', 'lezhanki-dlya-koshek.jpg', 28, 20, 1),
(31, 'Игровые комплексы', 'igrovye-kompleksy', 'Многоуровневые игровые комплексы с когтеточками, домиками и подвесными игрушками. Идеальное решение для активных кошек.', 'igrovye-kompleksy.svg', 'igrovye-kompleksy.jpg', 28, 30, 1),
(32, 'Для грызунов', 'dlya-gryzunov', 'Всё для комфортной жизни маленьких питомцев: хомяков, морских свинок, крыс и шиншилл. Качественные корма, уютные клетки и развивающие аксессуары.', 'dlya-gryzunov.svg', 'dlia-gryzunov_image.jpg', NULL, 30, 1),
(33, 'Корма', 'korma-dlya-gryzunov', 'Сбалансированные корма для грызунов с учётом их видовых потребностей. Зерновые смеси, сено, травяные гранулы и полезные лакомства.', 'korma-dlya-gryzunov.svg', 'korma-dlya-gryzunov.jpg', 32, 10, 1),
(34, 'Зерновые смеси', 'zernovye-smesi', 'Питательные зерновые смеси с добавлением овощей, фруктов и витаминов. Обеспечивают организм грызунов всеми необходимыми веществами.', 'zernovye-smesi.svg', 'zernovye-smesi.jpg', 33, 10, 1),
(35, 'Сено и травы', 'seno-i-travy', 'Ароматное сено и полезные травы для правильного пищеварения и стачивания зубов грызунов. Натуральные и экологически чистые продукты.', 'seno-i-travy.svg', 'seno-i-travy.jpg', 33, 20, 1),
(36, 'Лакомства', 'lakomstva-dlya-gryzunov', 'Вкусные и полезные лакомства для поощрения и разнообразия рациона. Палочки, сухофрукты, злаковые батончики — здоровое угощение для вашего питомца.', 'lakomstva-dlya-gryzunov.svg', 'lakomstva-dlya-gryzunov.jpg', 33, 30, 1),
(37, 'Клетки и аксессуары', 'kletki-i-aksessuary', 'Просторные клетки и всё необходимое для обустройства дома грызуна. Миски, поилки, домики, колеса для бега и другие аксессуары.', 'kletki-i-aksessuary.svg', 'kletki-i-aksessuary.jpg', 32, 20, 1),
(38, 'Клетки', 'kletki', 'Качественные клетки разных размеров с глубокими поддонами, удобными дверцами и аксессуарами в комплекте. Безопасные и комфортные.', 'kletki.svg', 'kletki.jpg', 37, 10, 1),
(39, 'Поилки и миски', 'poilki-i-miski', 'Удобные поилки и миски для грызунов. Автоматические поилки с шариковым механизмом, керамические миски, которые сложно перевернуть.', 'poilki-i-miski.svg', 'poilki-i-miski.jpg', 37, 20, 1),
(40, 'Наполнители', 'napolniteli-dlya-gryzunov', 'Безопасные наполнители для клеток грызунов. Древесные гранулы, кукурузный наполнитель, бумажные пеллеты — отличная абсорбция и контроль запаха.', 'napolniteli-dlya-gryzunov.svg', 'napolniteli-dlya-gryzunov.jpg', 37, 30, 1),
(41, 'Для птиц', 'dlya-ptic', 'Всё для пернатых друзей: от качественных кормов до просторных клеток и развивающих игрушек. Подарите своим птицам здоровую и счастливую жизнь.', 'dlya-ptic.svg', 'dlia-ptic_image.jpg', NULL, 40, 1),
(42, 'Корма', 'korma-dlya-ptic', 'Сбалансированные кормовые смеси для разных видов птиц. Попугаи, канарейки, амадины — подбирайте питание с учётом потребностей вашего питомца.', 'korma-dlya-ptic.svg', 'korma-dlya-ptic.jpg', 41, 10, 1),
(43, 'Корма для попугаев', 'korma-dlya-popugaev', 'Питательные смеси для попугаев всех видов. Злаки, орехи, семена, сухофрукты — всё для энергии, яркого оперения и долголетия.', 'korma-dlya-popugaev.svg', 'korma-dlia-popugaev_image.jpg', 42, 10, 1),
(44, 'Корма для канареек', 'korma-dlya-kanareek', 'Специализированные корма для канареек с высоким содержанием семян, витаминов и минералов. Для здоровья, красивого пения и яркого оперения.', 'korma-dlya-kanareek.svg', 'korma-dlya-kanareek.jpg', 42, 20, 1),
(45, 'Минеральные камни', 'mineralnye-kamni', 'Минеральные камни и сепии для стачивания клюва и восполнения запаса кальция. Необходимый элемент в клетке каждой птицы.', 'mineralnye-kamni.svg', 'mineralnye-kamni.jpg', 42, 30, 1),
(46, 'Аксессуары', 'aksessuary-dlya-ptic', 'Всё для обустройства комфортной жизни птиц. Удобные клетки, жердочки, купалки, игрушки и другие необходимые аксессуары.', 'aksessuary-dlya-ptic.svg', 'aksessuary-dlya-ptic.jpg', 41, 20, 1),
(47, 'Клетки и жердочки', 'kletki-i-zherdochki', 'Просторные клетки и удобные жердочки из натурального дерева. Обеспечивают комфортное пространство для жизни и возможность для полётов.', 'kletki-i-zherdochki.svg', 'kletki-i-zerdocki_image.jpg', 46, 10, 1),
(48, 'Игрушки для птиц', 'igrushki-dlya-ptic', 'Развивающие игрушки для птиц: качели, колокольчики, лесенки, зеркала. Стимулируют умственную активность и предотвращают скуку.', 'igrushki-dlya-ptic.svg', 'igrushki-dlya-ptic.jpg', 46, 20, 1),
(49, 'Для рыб', 'dlya-ryb', 'Всё для красивого и здорового аквариума. Качественные корма, современное оборудование, декорации и грунт — создайте подводный мир мечты.', 'dlya-ryb.svg', 'dlia-ryb_image.jpg', NULL, 50, 1),
(50, 'Корма для рыб', 'korma-dlya-ryb', 'Сбалансированные корма для аквариумных рыб. Хлопья, гранулы, таблетки для донных рыб — подбирайте питание по типу и размеру обитателей.', 'korma-dlya-ryb.svg', 'korma-dlya-ryb.jpg', 49, 10, 1),
(51, 'Аквариумы', 'akvariumy', 'Аквариумы разных форм и объёмов от проверенных производителей. Полный комплект с подсветкой, фильтром и крышкой для быстрого старта.', 'akvariumy.svg', 'akvariumy.jpg', 49, 20, 1),
(52, 'Фильтрация и помпы', 'filtratsiya-i-pompy', 'Надёжные фильтры, помпы и системы очистки воды. Обеспечивают биологическое, механическое и химическое очищение для здоровой экосистемы.', 'filtratsiya-i-pompy.svg', 'filtratsiya-i-pompy.jpg', 49, 30, 1),
(53, 'Освещение', 'osveschenie', 'Качественное освещение для аквариумов. Светодиодные лампы, люминесцентные светильники, которые подчёркивают красоту рыб и стимулируют рост растений.', 'osveschenie.svg', 'osveschenie.jpg', 49, 40, 1),
(54, 'Грунт и декор', 'grunt-i-dekor', 'Декоративный грунт, коряги, камни, искусственные и живые растения. Создайте уникальный дизайн вашего аквариума.', 'grunt-i-dekor.svg', 'grunt-i-dekor.jpg', 49, 50, 1),
(55, 'Здоровье и уход', 'zdorovie-i-uhod', 'Всё для здоровья и ухода за домашними питомцами. Шампуни, витамины, средства от паразитов и ветеринарные препараты для поддержания отличного самочувствия.', 'zdorovie-i-uhod.svg', 'zdorove-i-uxod_image.jpg', NULL, 60, 1),
(56, 'Шампуни и косметика', 'shampuni-i-kosmetika', 'Качественные шампуни, кондиционеры и косметические средства для ухода за шерстью, кожей, когтями и зубами ваших питомцев.', 'shampuni-i-kosmetika.svg', 'shampuni-i-kosmetika.jpg', 55, 10, 1),
(57, 'Витамины и добавки', 'vitaminy-i-dobavki', 'Витаминно-минеральные комплексы и биологически активные добавки для поддержания здоровья питомцев. Укрепление иммунитета, здоровье суставов, красивая шерсть.', 'vitaminy-i-dobavki.svg', 'vitaminy-i-dobavki_image.jpg', 55, 20, 1),
(58, 'Средства от паразитов', 'sredstva-ot-parazitov', 'Надёжная защита от блох, клещей, гельминтов и других паразитов. Капли, спреи, ошейники, таблетки — выбирайте удобный формат.', 'sredstva-ot-parazitov.svg', 'sredstva-ot-parazitov.jpg', 55, 30, 1),
(59, 'Аптечка', 'aptechka', 'Всё для домашней ветеринарной аптечки: перевязочные материалы, антисептики, средства для обработки ран, глаз, ушей. Будьте готовы к любым ситуациям.', 'aptechka.svg', 'aptecka_image.jpg', 55, 40, 1),
(60, 'Груминг', 'gruming', 'Инструменты для профессионального и домашнего груминга. Расчёски, щётки, пуходёрки, когтерезы, триммеры и машинки для стрижки.', 'gruming.svg', 'gruming.jpg', 55, 50, 1),
(65, 'Одежда', 'odezda', 'Стильная и функциональная одежда для собак всех пород. Дождевики, попоны, комбинезоны, свитера — защита от непогоды и яркий образ для вашего питомца.', NULL, NULL, 6, 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Хвостики и лапки',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vkontakte` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `description`, `logo`, `favicon`, `phone`, `email`, `address`, `work_hours`, `telegram`, `whatsapp`, `vkontakte`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'Хвостики и лапки', NULL, 'logo.svg', 'favicon.svg', '+7(985)-070-56-33', 'tailandpaws_info@gmail.com', 'г. Челябинск, ул. Дружбы, д. 15', '10:00 - 18:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(14, '2014_10_12_000000_create_users_table', 1),
(15, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(18, '2026_03_12_171109_create_roles_table', 1),
(19, '2026_03_12_171110_create_permissions_table', 1),
(20, '2026_03_12_171110_create_role_user_table', 1),
(21, '2026_03_12_171111_create_permission_role_table', 1),
(22, '2026_03_14_102454_create_categories_table', 1),
(23, '2026_03_14_124100_create_brands_table', 1),
(24, '2026_03_14_124103_create_products_table', 1),
(25, '2026_03_14_135714_create_product_variations_table', 1),
(26, '2026_03_14_201029_create_reviews_table', 1),
(27, '2026_03_14_213006_create_contacts_table', 2),
(28, '2026_03_14_213427_add_meta_fields_to_products_table', 2),
(29, '2026_03_16_191828_add_phone_to_users_table', 3),
(30, '2026_03_16_192010_add_email_index_to_users_table', 3),
(31, '2026_03_18_191033_add_unique_constraint_to_role_user_table', 4),
(32, '2026_03_18_192641_add_role_id_to_users_table', 5),
(33, '2026_03_28_191947_fix_products_and_variations_structure', 6),
(34, '2026_04_01_142406_create_cart_items_table', 7),
(35, '2026_04_01_142423_create_orders_table', 7),
(36, '2026_04_01_142428_create_order_items_table', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'courier',
  `delivery_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `subtotal`, `shipping_cost`, `discount`, `total`, `payment_method`, `payment_status`, `delivery_method`, `delivery_status`, `comment`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20260402-69CDC5BBD6FEB', 1, 'duckinahatt', 'margaritaborodovskih@gmail.com', '+7(909)-090-86-13', NULL, '5403.00', '0.00', '0.00', '5403.00', 'cash', 'paid', 'pickup', 'delivered', NULL, '2026-04-01 22:26:19', '2026-04-06 06:04:06'),
(2, 'ORD-20260406-69D3808EA5C09', 1, 'duckinahat', 'margaritaborodovskih@gmail.com', '+7(909)-090-86-13', NULL, '5208.00', '0.00', '0.00', '5208.00', 'cash', 'pending', 'pickup', 'pending', NULL, '2026-04-06 06:44:46', '2026-04-06 06:44:46'),
(3, 'ORD-20260406-69D380D6CE7B4', 1, 'duckinahat', 'margaritaborodovskih@gmail.com', '+7(909)-090-86-13', NULL, '1435.00', '0.00', '0.00', '1435.00', 'online', 'pending', 'pickup', 'pending', NULL, '2026-04-06 06:45:58', '2026-04-06 06:45:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variation_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variation_id`, `product_name`, `variation_name`, `sku`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 60, 'AlphaPet Сухой корм для стерилизованных кошек', 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой, 1,5 кг', '1053741', 1, '1969.00', '1969.00', '2026-04-01 22:26:19', '2026-04-01 22:26:19'),
(2, 1, 53, 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением', 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением, с ягненком, 1 кг', '1065459', 1, '1435.00', '1435.00', '2026-04-01 22:26:19', '2026-04-01 22:26:19'),
(3, 1, 46, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет', 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет, 2 кг', '1002774', 1, '1999.00', '1999.00', '2026-04-01 22:26:19', '2026-04-01 22:26:19'),
(4, 2, 57, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет', 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 400 гр.', '1000724', 2, '635.00', '1270.00', '2026-04-06 06:44:46', '2026-04-06 06:44:46'),
(5, 2, 60, 'AlphaPet Сухой корм для стерилизованных кошек', 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой, 1,5 кг', '1053741', 2, '1969.00', '3938.00', '2026-04-06 06:44:46', '2026-04-06 06:44:46'),
(6, 3, 53, 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением', 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением, с ягненком, 1 кг', '1065459', 1, '1435.00', '1435.00', '2026-04-06 06:45:58', '2026-04-06 06:45:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `group`, `description`) VALUES
(1, 'Доступ в личный кабинет', 'cabinet_access', 'cabinet', 'Возможность входить в личный кабинет и просматривать свои данные'),
(2, 'Просматривать заказы', 'view_orders', 'orders', 'Просмотр списка заказов'),
(3, 'Редактировать заказы', 'edit_orders', 'orders', 'Редактирование заказов (статус, удаление, подтверждение)'),
(4, 'Оформлять заказы', 'checkout', 'orders', 'Оформление заказов на сайте'),
(5, 'Управлять корзиной', 'manage_cart', 'cart', 'Добавление/удаление товаров из корзины'),
(6, 'Добавлять товары', 'create_products', 'products', 'Создание новых товаров'),
(7, 'Редактировать товары', 'edit_products', 'products', 'Редактирование товаров'),
(8, 'Управлять количеством товара', 'manage_stock', 'products', 'Изменение остатков товаров на складе'),
(9, 'Просматривать пользователей', 'view_users', 'users', 'Просмотр списка пользователей'),
(10, 'Создавать пользователей', 'create_users', 'users', 'Создание новых пользователей'),
(11, 'Управлять ролями', 'manage_roles', 'rbac', 'Создание/редактирование ролей'),
(12, 'Управлять правами', 'manage_permissions', 'rbac', 'Создание/редактирование прав доступа'),
(13, 'Редактировать данные магазина', 'edit_shop_settings', 'shop', 'Изменение настроек магазина'),
(14, 'Доступ в админ-панель', 'admin_access', 'admin', 'Возможность входить в административную панель');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 14, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(2, 1, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(3, 4, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(4, 6, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(5, 10, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(6, 3, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(7, 7, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(8, 13, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(9, 5, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(10, 12, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(11, 11, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(12, 8, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(13, 2, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(14, 9, 2, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(15, 14, 3, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(16, 1, 3, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(17, 6, 3, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(18, 7, 3, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(19, 2, 3, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(20, 14, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(21, 1, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(22, 4, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(23, 3, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(24, 2, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(25, 9, 4, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(26, 14, 5, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(27, 1, 5, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(28, 8, 5, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(29, 2, 5, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(30, 1, 6, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(31, 4, 6, '2026-03-14 18:11:29', '2026-03-14 18:11:29'),
(32, 5, 6, '2026-03-14 18:11:29', '2026-03-14 18:11:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `brand_id`, `category_id`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(12, 'Rungo Ошейник нейлоновый с ручкой для собак K-9, L', 'rungo-oseinik-neilonovyi-s-ruckoi-dlia-sobak-k-9-l', 'Ошейник K-9 от бренда RUNGO – надежный аксессуар для дополнительного контроля собаки на прогулках, в поездках, при дрессировке.\r\nРазмер: обхват шеи 42-65 см, ширина 3,8 см', 10, 7, 1, 'Вот вариант для этого товара:  Meta Title: Rungo ошейник нейлоновый с ручкой K-9 для собак, L', 'Прочный нейлоновый ошейник Rungo K-9 с удобной ручкой для контроля собаки. Размер L, надежная посадка и комфорт в ежедневном использовании.', 'rungo ошейник, ошейник для собак, нейлоновый ошейник, ошейник с ручкой, rungo k-9, ошейник l, ошейник для крупных собак, амуниция для собак', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(21, 'Grandin Hypoallergenic ягненок', 'grandin-hypoallergenic-iagnenok', 'Гипоаллергенный сухой корм для собак всех пород с ягненком. Беззерновой суперпремиум класс без курицы и говядины.', 5, 3, 1, 'Grandin Hypoallergenic сухой корм ягненок', 'Гипоаллергенный корм Grandin с ягненком для собак всех пород без злаков суперпремиум класс', 'grandin hypoallergenic,сухой корм собак,ягненок,гипоаллергенный корм собак', '2026-03-29 12:20:24', '2026-03-29 13:18:29'),
(22, 'Klicker Adult', 'klicker-adult', 'Сухой корм для собак мелких пород с лососем. Высокая усвояемость и поддержка пищеварения.', 11, 3, 1, 'Klicker Adult сухой корм лосось мелкие породы', 'Премиум корм Klicker для мелких пород с лососем поддержка пищеварения', 'klicker корм,сухой корм мелких собак,лосось собак', '2026-03-29 12:20:24', '2026-03-29 13:41:32'),
(23, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет', 'royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let', 'Сухой корм для взрослых собак мелких пород. Поддержка кожи и шерсти, высокая калорийность.', 1, 3, 1, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет', 'Корм Royal Canin для мелких взрослых собак поддержка кожи шерсти', 'royal canin mini adult,сухой корм собак мелких пород', '2026-03-29 12:20:24', '2026-03-29 14:07:02'),
(24, 'АВВА Adult Сухой корм на основе свежего мяса для взрослых собак мелких пород, с ягненком и индейкой', 'avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi', 'Сухой корм суперпремиум с ягненком для всех пород. Естественные ингредиенты без ГМО.', 2, 3, 1, 'АВВА Adult Сухой корм на основе свежего мяса для взрослых собак мелких пород, с ягненком и индейкой', 'ABBA суперпремиум корм с ягненком для собак всех пород натуральные ингредиенты', 'abba premium,ягненок сухой корм,суперпремиум собак', '2026-03-29 12:20:24', '2026-03-29 17:16:40'),
(25, 'AlphaPet Adult Monoprotein Сухой корм для собак средних и крупных пород, белая рыба', 'alphapet-adult-monoprotein-suxoi-korm-dlia-sobak-srednix-i-krupnyx-porod-belaia-ryba', 'Здоровый и активный питомец – главная задача каждого хозяина. Команда AlphaPet® создает и производит полезные корма высшей категории качества Holistiс, давая возможность каждому владельцу быть уверенным в правильном выборе кормления для своего животного. AlphaPet® MONOPROTEIN на основе белой рыбы - благодаря единственному источнику животного белка, подойдет животным с пищевой непереносимостью.\r\n\r\nБелая рыба - отличный источник легкоусвояемого белка, микроэлементов: железа, селена, цинка, йода и витаминов B12 и D. Также рыба ценный источник ненасыщенных жирных кислот Омега 3, благодаря которым кожа и шерсть животных будут в прекрасном состоянии. Диетическое мясо белой рыбы хорошо сбалансированно и несет в себе максимум пользы для питомцев.\r\n\r\nПриготовленно по инновационной технологии из свежей белой рыбы и с содержанием большого процента животного белка!', 12, 3, 1, 'AlphaPet Adult Monoprotein Сухой корм для собак средних и крупных пород, белая рыба', 'Здоровый и активный питомец – главная задача каждого хозяина. Команда AlphaPet® создает и производит полезные корма высшей категории качества Holistiс, давая возможность каждому владельцу быть уверенным в правильном выборе кормления для своего животного. AlphaPet® MONOPROTEIN на основе белой рыбы - благодаря единственному источнику животного белка, подойдет животным с пищевой непереносимостью.\r\n\r\nБелая рыба - отличный источник легкоусвояемого белка, микроэлементов: железа, селена, цинка, йода и витаминов B12 и D. Также рыба ценный источник ненасыщенных жирных кислот Омега 3, благодаря которым кожа и шерсть животных будут в прекрасном состоянии. Диетическое мясо белой рыбы хорошо сбалансированно и несет в себе максимум пользы для питомцев.\r\n\r\nПриготовленно по инновационной технологии из свежей белой рыбы и с содержанием большого процента животного белка!', 'alphapet monoprotein, сухой корм собак, белая рыба корм, корм средних пород, корм крупных собак, монобелковый корм, корм при аллергии, холистик корм собак, alphapet adult', '2026-03-29 12:20:24', '2026-03-29 18:45:42'),
(26, 'Ownat Grain Free Just Сухой корм беззерновой для собак', 'ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak', 'В основе корма лежит максимальное количество натуральных ингредиентов: свежее мясо, свежие овощи и фрукты, а также водоросли, что позволяет донести до питомца пользу продуктов в том виде, в каком задумала природа.', 4, 3, 1, 'Ownat Grain Free Just Сухой корм беззерновой для собак, с лососем и морепродуктами', 'Ownat Grain Free Just беззерновой сухой корм для собак. Доступны вкусы: лосось и морепродукты, курица, утка, ягненок. 70% мяса, 20% свежего, холистик класс беззлаковый.', 'ownat grain free just, беззерновой корм собак, корм лосось морепродукты, ownat курица, ownat утка, ownat ягненок, сухой корм беззлаковый, холистик корм собак, ownat grain free вкусы', '2026-03-29 12:20:24', '2026-03-29 19:03:16'),
(27, 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением', 'klicker-adult-sensitive-digestion-suxoi-korm-dlia-kosek-s-cuvstvitelnym-pishhevareniem', 'Сухой корм для кошек с чувствительным пищеварением. Легкоусвояемые ингредиенты.', 11, 21, 1, 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением, с ягненком, 1 кг', 'Корм для кошек с чувствительным пищеварением Klicker легкоусвояемые ингредиенты', 'klicker sensitive,сухой корм кошек,пищеварение кошки', '2026-03-29 12:20:24', '2026-03-29 19:06:53'),
(28, 'Grandin Holistic Влажный корм (консервы) для взрослых кошек', 'grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek', 'GRANDIN Holistic Health Privilege в желе - высококачественный консервированный корм для взрослых кошек с повышенным содержанием рыбы.', 5, 22, 1, 'Grandin Holistic влажный корм для взрослых кошек, консервы без злаков', 'Grandin Holistic влажный корм (консервы) для взрослых кошек. Высокое содержание мяса, без злаков и ГМО, нежное желе/соус, подходит для привередливых и чувствительных кошек.', 'grandin holistic, влажный корм для кошек, консервы для кошек, корм для взрослых кошек, беззлаковый влажный корм, grandin консервы, тунец в желе, курица в желе, индейка в соусе', '2026-03-29 12:20:24', '2026-03-29 19:12:47'),
(29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет', 'royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let', 'Поддержание оптимального веса. Помогает поддерживать оптимальный вес благодаря ограниченному содержанию жиров, оптимальному уровню белков и входящему в состав корма L-карнитину.\r\nПоддержание мышечного тонуса. Помогает поддерживать мышечный тонус благодаря повышенному содержанию белка и L-карнитину.\r\nПоддержание здоровья мочевыделительной системы. Способствует профилактике заболеваний мочевыделительной системы за счет сбалансированного содержания минеральных веществ и поддержания рН мочи.', 1, 21, 1, 'Royal Canin Sterilised сухой корм кошки', 'Корм Royal Canin для стерилизованных кошек поддержка мочевыводящей системы', 'royal canin sterilised,корм стерилизованных кошек', '2026-03-29 12:20:24', '2026-03-29 19:22:45'),
(30, 'AlphaPet Сухой корм для стерилизованных кошек', 'alphapet-suxoi-korm-dlia-sterilizovannyx-kosek', '80% мясного белка;\r\n30% свежего мяса;\r\nНизкое содержание жира и оптимальный уровень клетчатки помогают ограничивать набор избыточного веса;\r\nБаланс магния, кальция и фосфора для здоровья мочевыделительной системы;\r\nУникальный комплекс натуральных добавок AlphaPetBIO®;\r\nНатуральные ингредиенты;\r\nНе содержит ГМО, искусственных красителей и ароматизаторов;\r\nИнгредиенты, пригодные в пищу человеку, уровня Human Grade;\r\nБережная технология, сохраняющая вкусовые и питательные свойства свежего мяса.', 12, 21, 1, 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой', 'AlphaPet Superpremium Sterilised сухой корм для стерилизованных кошек с ягненком и индейкой. 80% мясного белка, 30% свежего мяса, контроль веса, профилактика МКБ.', 'alphapet sterilised, корм стерилизованных кошек, ягненок индейка корм, alphapet суперпремиум, сухой корм кошки стерилизованные, корм мкб кошки, alphapet ягненок', '2026-03-29 12:20:24', '2026-03-29 19:44:22'),
(31, 'Tetra Min Holiday корм желе', 'tetra-min-holiday-korm-zele', 'Сухой корм для кошек с курицей. Полнорационное питание.', 13, 50, 1, 'Tetra Min Holiday корм желе аквариумные рыбы 14 дней 30г', 'Tetra Min Holiday гелевый корм-желе для аквариумных рыб на 14 дней. 100% съедобный блок с дафнией, витаминами, минералами. Не мутит воду, немецкое качество.', 'tetra min holiday, корм желе рыбы, корм на отпуск 14 дней, tetra holiday желе, аквариумный корм желе, корм дафния рыбы, tetra 30г желе', '2026-03-29 12:20:24', '2026-03-29 19:58:14'),
(32, 'Little One Корм для морских свинок', 'little-one-korm-dlia-morskix-svinok', 'Полнорационный корм с добавлением витаминов и минеральных веществ. Разработан с учетом специфических потребностей морских свинок и содержит повышенное количество витамина С, жизненно необходимого для их здоровья.\r\n\r\nРазнообразный состав корма включает в себя травяные гранулы, воздушные ингредиенты и хлопья, семена, овощи и редкие плоды.', 14, 34, 1, 'Little One корм для морских свинок полнорационный витамин С', 'Little One корм для морских свинок с повышенным содержанием витамина С. Полнорационный состав: травяные гранулы, семена, овощи, воздушные хлопья. 35-50г/сутки на зверька.', 'little one морские свинки, корм морских свинок, корм с витамином с, little one грызуны, полнорационный корм свинки, корм травяные гранулы свинок', '2026-03-29 12:20:24', '2026-03-29 20:00:36'),
(34, 'Little One Корм для морских свинок Зелёная долина', 'little-one-korm-dlia-morskix-svinok-zelenaia-dolina', 'Little One «Зеленая долина» — это полнорационный беззерновой корм для морских свинок, в состав которого входит 60 разновидностей трав.\r\nДополнительно его состав обогащен шиповником и лепестками розы, которые богаты витамином С, а также добавлены другие полезные и любимые морскими свинками ингредиенты – тыква, пастернак, яблоко и др.\r\nБлагодаря использованию специальной технологии холодного прессования, травяные гранулы сохранили все витамины и минералы, входящие в состав растений.\r\nКорм богат длинными волокнами клетчатки, а также обогащен фруктоолигосахаридами для поддержания роста полезной микрофлоры в кишечнике и жирными кислотами ω-3 и ω-6 для здоровья кожи и блестящей шерсти.\r\nКорм отлично подходит для диетического питания.', 14, 34, 1, 'Little One Зелёная долина корм морских свинок разнотравье 750г', 'Little One \"Зелёная долина\" корм для морских свинок из разнотравья 750г. 60 трав холодного прессования, 24% клетчатки, без зерна, витамин С, диетический для пищеварения.', 'little one зеленая долина, корм морских свинок разнотравье, корм без зерна свинки, little one 750г, корм 60 трав свинок, диетический корм свинок', '2026-03-29 12:20:24', '2026-03-29 20:05:17'),
(35, 'Rungo Комбинезон теплый для собак породы мопс', 'rungo-kombinezon-teplyi-dlia-sobak-porody-mops', 'Теплый комбинезон для собак от бренд RUNGO – простой и эффективный способ сделать прогулку с собакой комфортной в любую непогоду. Комбинезон защитит Вашего питомца от сырости, загрязнений и переохлаждения.', 10, 65, 1, 'Ferplast парашютный ошейник собака', 'Легкий парашютный ошейник Ferplast для собак', 'ferplast парашютный,ошейник легкий собака', '2026-03-29 12:20:24', '2026-03-29 20:12:19'),
(36, 'Rogz ошейник Utility', 'rogz-oseinik-utility', 'Усиленный нейлон с мягкой подкладкой. 5 точек фиксации.', 16, 7, 1, 'Rogz Utility ошейник собака', 'Прочный ошейник Rogz Utility усиленный нейлон', 'rogz utility,ошейник собака усиленный', '2026-03-29 12:20:24', '2026-03-30 09:47:30'),
(37, 'Hunter кожаный плетеный', 'hunter-kozhanii-pletenyi', 'Ручная плетка из натуральной кожи. Эксклюзивный дизайн.', NULL, 7, 1, 'Hunter плетеный кожаный ошейник', 'Эксклюзивный плетеный кожаный ошейник Hunter', 'hunter плетеный,кожаный ошейник эксклюзив', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(38, 'Petzl ошейник альпинистский', 'petzl-alpinistskii-osheynik', 'Сверхпрочный для рабочих собак. Используется кинологами.', NULL, 7, 1, 'Petzl альпинистский ошейник собака', 'Сверхпрочный ошейник Petzl для рабочих собак', 'petzl альпинистский,ошейник рабочие собаки', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(39, 'Ever Clean Extra Strength', 'ever-clean-extra-strength', 'Древесный наполнитель для кошек. Сильная комкуемость отличная нейтрализация запаха.', NULL, 25, 1, 'Ever Clean Extra Strength древесный наполнитель', 'Премиум древесный наполнитель Ever Clean сильная комкуемость', 'ever clean,древесный наполнитель кошки,премиум наполнитель', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(40, 'Cat\'s Best Original', 'cats-best-original', 'Натуральный гранулированный наполнитель из волокон целлюлозы. 100% биоразлагаемый.', NULL, 25, 1, 'Cat\'s Best Original древесный наполнитель', 'Натуральный древесный наполнитель Cat\'s Best из целлюлозы', 'cats best,древесный натуральный,наполнитель кошки', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(41, 'Barsik Premium древесный', 'barsik-premium-drevesnyi', 'Древесный наполнитель из опилок хвойных пород. Высокая впитываемость.', NULL, 25, 1, 'Barsik Premium древесный наполнитель кошки', 'Древесный наполнитель Barsik Premium из хвойных пород', 'barsik древесный,наполнитель кошки хвойный', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(42, 'Perfect Fit древесный', 'perfect-fit-drevesnyi', 'Комкующийся древесный наполнитель. Натуральный состав без химии.', NULL, 25, 1, 'Perfect Fit древесный наполнитель', 'Комкующийся древесный наполнитель Perfect Fit натуральный', 'perfect fit древесный,комкующийся наполнитель', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(43, 'Сибирский лес премиум', 'sibirskii-les-premium', 'Премиум древесный наполнитель. Сильный контроль запаха.', NULL, 25, 1, 'Сибирский лес премиум древесный наполнитель', 'Премиум древесный наполнитель Сибирский лес контроль запаха', 'сибирский лес,древесный премиум наполнитель', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(44, 'Травка-Сено древесный', 'travka-seno-drevesnyi', 'Натуральный древесный наполнитель с экстрактами трав.', NULL, 25, 1, 'Травка-Сено древесный наполнитель кошки', 'Древесный наполнитель Травка-Сено с экстрактами трав', 'травка сено,древесный с травами наполнитель', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(45, 'Kong Classic красный', 'kong-classic-krasnyi', 'Классическая резиновая игрушка для жевания и апортировки. Неотъемлемый элемент дрессировки.', NULL, 11, 1, 'Kong Classic красный мячик собака', 'Резиновая игрушка Kong Classic для собак жевание апортировка', 'kong classic,мячик собака резиновый,игрушка для жевания', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(46, 'Trixie теннисный мячик', 'trixie-tennisnyi-myachik', 'Теннисный мячик для собак. Прочная резина с войлоком.', NULL, 11, 1, 'Trixie теннисный мячик собака', 'Теннисный мячик Trixie для апортировки собак', 'trixie теннисный,мячик собака апортировка', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(47, 'Ferplast фрисби Flyer', 'ferplast-frisbi-flyer', 'Пластиковый фрисби для активных игр на улице. Легкий и прочный.', NULL, 11, 1, 'Ferplast Flyer фрисби собака', 'Фрисби Ferplast Flyer для собак активные игры', 'ferplast фрисби,фрисби собака уличные игры', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(48, 'K9 Granit мячик', 'k9-granit-myachik', 'Прочный резиновый мячик для сильных челюстей. Выдерживает давление.', NULL, 11, 1, 'K9 Granit мячик собака', 'Резиновый мячик K9 Granit для мощных собак', 'k9 granit,мячик собака прочный челюсти', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(49, 'Chuckit! Ultra мячик', 'chuckit-ultra-myachik', 'Яркий мячик для метателя Chuckit. Увеличенная дальность броска.', NULL, 11, 1, 'Chuckit Ultra мячик собака метатель', 'Мячик Chuckit Ultra для метателя собак', 'chuckit ultra,мячик метатель собака', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(50, 'Rogz Grinz мячик зубастый', 'rogz-grinz-myachik-zubastyi', 'Резиновый мячик с зубастой мордочкой. Массаж десен.', NULL, 11, 1, 'Rogz Grinz зубастый мячик собака', 'Мячик Rogz Grinz массаж десен собак', 'rogz grinz,мячик зубастый собака десны', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(51, 'Trixie Ортопедическая лежанка', 'trixie-ortopedicheskaya-lezhanka', 'Лежанка с ортопедической пеной memory foam. Для собак с проблемами суставов.', NULL, 14, 1, 'Trixie ортопедическая лежанка собака', 'Ортопедическая лежанка Trixie memory foam для собак суставы', 'trixie ортопедическая,лежанка memory foam,собаки суставы', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(52, 'Good Boy плед лежанка', 'good-boy-pled-lezhanka', 'Мягкая лежанка-плед из флиса. Съемный чехол машинная стирка.', NULL, 14, 1, 'Good Boy плед лежанка собака', 'Лежанка-плед Good Boy флис съемный чехол', 'good boy плед,лежанка флис собака', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(53, 'Ferplast лежанка Carlotta', 'ferplast-lezhanka-carlotta', 'Круглая лежанка с бортиками. Машинная стирка 30°C.', NULL, 14, 1, 'Ferplast Carlotta лежанка собака', 'Круглая лежанка Ferplast Carlotta с бортиками', 'ferplast carlotta,лежанка круглая бортики', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(54, 'Hunter лежанка Bavaria', 'hunter-lezhanka-bavaria', 'Немецкое качество. Прочная ткань водоотталкивающая подкладка.', NULL, 14, 1, 'Hunter Bavaria лежанка собака', 'Лежанка Hunter Bavaria немецкое качество водоотталкивающая', 'hunter bavaria,лежанка немецкая качество', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(55, 'PetFusion ортопедическая', 'petfusion-ortopedicheskaya', 'Лежанка с ортопедической пеной. Экологичные материалы гипоаллергенная.', NULL, 14, 1, 'PetFusion ортопедическая лежанка собака', 'Ортопедическая лежанка PetFusion экологичные гипоаллергенная', 'petfusion ортопедическая,лежанка экологичная', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(56, 'Laifugy лежанка домик', 'laifugy-lezhanka-domik', 'Лежанка-домик с крышей. Для маленьких собак и щенков.', NULL, 14, 1, 'Laifugy лежанка домик собака', 'Лежанка-домик Laifugy для маленьких собак щенков', 'laifugy домик,лежанка маленькие собаки', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек', 'grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek', 'GRANDORF Holistic Adult Sterilised — суперпремиальный беззерновой сухой корм для взрослых стерилизованных кошек.', 15, 21, 1, 'GRANDORF Holistic Adult Sterilised сухой корм стерилизованные кошки', 'GRANDORF Holistic Adult Sterilised сухой корм для взрослых стерилизованных кошек. 70% мяса (индейка+ягненок), беззерновой, таурин, L-карнитин, контроль веса, здоровье мочевыводящей системы.', 'grandorf sterilised, корм стерилизованных кошек, grandorf holistic adult, беззерновой корм кошки, корм с таурином кошки, grandorf индейка ягненок, holistic корм стерилизованные', '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(58, 'Ownat Adult Sterilized Grain Free Prime Сухой корм для стерилизованных кошек', 'ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek', 'OWNAT GRAIN FREE PRIME STERILIZES – это полнорационный сбалансированный корм для стерилизованных кошек и кастрированных котов.\r\nПовышенное содержание белков: мясные и рыбные ингредиенты в составе обеспечивают чувство сытости и наполняют организм незаменимыми аминокислотами.\r\nКорм содержит полный комплекс необходимых микро- и макроэлементов.\r\nНе содержит злаки, поэтому снижает риск возникновения пищевой аллергии.', 4, 21, 1, 'Ownat Adult Sterilized Grain Free Prime корм стерилизованные кошки', 'Ownat Grain Free Prime Adult Sterilized сухой корм для стерилизованных кошек. Беззерновой, 70% мяса, таурин, L-карнитин, контроль веса, профилактика МКБ, суперпремиум.', 'ownat grain free, корм стерилизованных кошек, ownat sterilized prime, беззерновой корм кошки, ownat кролик тунец, корм с таурином кошки, super premium sterilized', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(59, 'AlphaPet WOW Сухой корм для стерилизованных кошек', 'alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek', '80% мясного белка;\r\nСвежее мясо в составе;\r\nНизкое содержание жира и оптимальный уровень клетчатки помогают ограничивать набор избыточного веса;\r\nБаланс магния, кальций и фосфора для здоровья мочевыделительной системы;\r\nУникальный комплекс натуральных добавок AlphaPetBIO®;\r\nНатуральные ингредиенты;\r\nНе содержит ГМО, искусственных красителей и ароматизаторов;\r\nИнгредиенты, пригодные в пищу человеку, уровня Human Grade;\r\nБережная технология, сохраняющая вкусовые и питательные свойства свежего мяса.', 12, 21, 1, 'AlphaPet WOW Сухой корм стерилизованных кошек с индейкой', 'AlphaPet WOW Grain Free сухой корм для стерилизованных кошек с индейкой. 65% мяса, беззерновой, L-карнитин, таурин 0.2%, контроль веса, здоровье мочевыводящей системы, суперпремиум класс.', 'alphapet wow, корм стерилизованных кошек индейка, alphapet grain free, сухой корм кошки стерилизованные, alphapet l-карнитин, корм с таурином кошки, суперпремиум стерилизованные', '2026-03-30 07:01:27', '2026-03-30 07:05:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(19, 12, 'Размер питомца', 'Все размеры', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(20, 12, 'Материал изготовления', 'Нейлон', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(71, 37, 'Материал', 'Натуральная кожа (плетеный)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(72, 38, 'Материал', 'Альпинистский нейлон', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(73, 39, 'Тип наполнителя', 'Древесный, комкующийся', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(74, 40, 'Тип наполнителя', 'Древесный, целлюлозный', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(75, 41, 'Тип наполнителя', 'Древесный (хвойные породы)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(76, 42, 'Тип наполнителя', 'Древесный, комкующийся', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(77, 43, 'Тип наполнителя', 'Древесный премиум', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(78, 44, 'Тип наполнителя', 'Древесный с травами', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(79, 45, 'Материал', 'Натуральная резина', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(80, 45, 'Тип игрушки', 'Для жевания, апортировки', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(81, 46, 'Материал', 'Резина с войлоком', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(82, 47, 'Материал', 'Пластик', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(83, 47, 'Тип игрушки', 'Фрисби', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(84, 48, 'Материал', 'Прочная резина', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(85, 49, 'Материал', 'Резина', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(86, 49, 'Особенности', 'Для метателя Chuckit', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(87, 50, 'Материал', 'Резина', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(88, 50, 'Особенности', 'Массаж десен', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(89, 51, 'Материал', 'Memory foam', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(90, 51, 'Особенности', 'Ортопедическая', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(91, 52, 'Материал', 'Флис', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(92, 52, 'Особенности', 'Съемный чехол', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(93, 53, 'Форма', 'Круглая с бортиками', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(94, 54, 'Особенности', 'Водоотталкивающая', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(95, 55, 'Материал', 'Ортопедическая пена', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(96, 55, 'Особенности', 'Гипоаллергенная', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(97, 56, 'Тип', 'Лежанка-домик', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(101, 21, 'Класс корма', 'Суперпремиум', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(102, 21, 'Особенности', 'Беззерновой, гипоаллергенный', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(103, 21, 'Размер питомца', 'Все размеры', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(104, 21, 'Тип корма', 'Сухой', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(105, 22, 'Класс корма', 'Премиум', '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(106, 22, 'Размер питомца', 'Мелкие породы', '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(107, 22, 'Тип корма', 'Сухой', '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(132, 25, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(133, 25, 'Размер питомца', 'Средний и крупный', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(134, 25, 'Тип корма', 'Сухой', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(135, 26, 'Класс корма', 'Холистик', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(136, 26, 'Размер питомца', 'Все размеры', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(137, 26, 'Тип корма', 'Сухой', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(138, 27, 'Специальные показания', 'Для чувствительного пищеварения', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(139, 27, 'Тип корма', 'Сухой', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(140, 27, 'Возраст питомца', 'Все возрасты', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(141, 27, 'Размер питомца', 'Все размеры', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(142, 27, 'Особенности ингредиентов', 'Беззерновой корм', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(143, 28, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(144, 28, 'Особенности ингредиентов', 'Холистик', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(145, 28, 'Тип корма', 'Влажный', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(150, 23, 'Возраст', 'Взрослые (1-8 лет)', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(151, 23, 'Размер питомца', 'Мелкие породы', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(152, 23, 'Тип корма', 'Сухой', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(153, 24, 'Класс корма', 'Суперпремиум', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(154, 24, 'Размер питомца', 'Все размеры', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(155, 24, 'Тип корма', 'Сухой', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(156, 29, 'Возраст питомца', 'Для взрослых 1-7 лет', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(157, 29, 'Размер питомца', 'Все размеры', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(158, 29, 'Специальные показания', 'Кастраты и стерилизованные', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(159, 29, 'Тип корма', 'Сухой', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(180, 30, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(181, 30, 'Особенности ингредиентов', 'Свежее мясо', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(182, 30, 'Размер питомца', 'Все размеры', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(183, 30, 'Тип корма', 'Сухой', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(186, 31, 'Тип упаковки', 'Пакет, саше или коробка', '2026-03-29 19:58:14', '2026-03-29 19:58:14'),
(187, 32, 'Возраст питомца', 'Все возрасты', '2026-03-29 20:00:36', '2026-03-29 20:00:36'),
(188, 34, 'Возраст питомца', 'Все возрасты', '2026-03-29 20:05:17', '2026-03-29 20:05:17'),
(191, 35, 'Материал изготовления', 'Мембрана', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(192, 35, 'Пол животного', 'Девочка', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(196, 58, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(197, 58, 'Особенности ингредиентов', 'Беззерновой корм', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(198, 58, 'Специальные показания', 'Кастраты и стерилизованные', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(201, 59, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(202, 59, 'Размер питомца', 'Все размеры', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(203, 36, 'Материал', 'Усиленный нейлон', '2026-03-30 09:47:30', '2026-03-30 09:47:30'),
(204, 57, 'Возраст питомца', 'Для взрослых 1-6 лет', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(205, 57, 'Размер питомца', 'Все размеры', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(206, 57, 'Специальные показания', 'Кастраты и стерилизованные', '2026-03-31 16:14:19', '2026-03-31 16:14:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `name`, `sku`, `price`, `old_price`, `stock`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(22, 12, 'Rungo Ошейник нейлоновый с ручкой для собак K-9, L, обхват шеи 42-65 см, ширина 3,8 см, черный', '1064128', '1749.00', NULL, 25, 1, 1, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(23, 12, 'Rungo Ошейник нейлоновый с ручкой для собак K-9, M, обхват шеи 38-48 см, ширина 3,2 см, красный', '1064127', '1499.00', '1599.00', 10, 0, 1, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(41, 21, 'Grandin Hypoallergenic ягненок, 2.7 кг', '1049894', '4499.00', '4200.00', 50, 1, 1, '2026-03-29 12:20:24', '2026-03-29 13:18:29'),
(42, 21, 'Grandin Hypoallergenic ягненок, 11.2 кг', '1049893', '10999.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 13:18:29'),
(43, 22, 'Klicker Adult лосось, 0.5 кг', '1060933', '779.00', NULL, 100, 1, 1, '2026-03-29 12:20:24', '2026-03-29 13:41:32'),
(45, 23, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет, 800 гр.', '1005371', '755.00', '855.00', 75, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:24:15'),
(46, 23, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет, 2 кг', '1002774', '1999.00', '2200.00', 39, 1, 1, '2026-03-29 12:20:24', '2026-04-01 22:26:19'),
(47, 24, 'АВВА Adult Сухой корм на основе свежего мяса для взрослых собак мелких пород, с ягненком и индейкой, 400 гр.', '1065978', '489.00', NULL, 60, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:24:26'),
(48, 24, 'АВВА Adult Сухой корм на основе свежего мяса для взрослых собак мелких пород, с ягненком и индейкой, 1,5 кг', 'ABBA-YAG-12KG', '1559.00', NULL, 30, 1, 1, '2026-03-29 12:20:24', '2026-03-29 19:24:26'),
(49, 25, 'AlphaPet Adult Monoprotein Сухой корм для собак средних и крупных пород, белая рыба, 2 кг', '1060824', '2019.00', '2219.00', 80, 1, 1, '2026-03-29 12:20:24', '2026-03-29 18:45:42'),
(50, 25, 'AlphaPet Adult Monoprotein Сухой корм для собак средних и крупных пород, белая рыба, 12 кг', '1060825', '10529.00', NULL, 30, 0, 1, '2026-03-29 12:20:24', '2026-03-29 18:45:42'),
(51, 26, 'Ownat Grain Free Just Сухой корм беззерновой для собак, с лососем и морепродуктами, 3 кг', '1042255', '3179.00', NULL, 45, 1, 1, '2026-03-29 12:20:24', '2026-03-29 19:03:16'),
(52, 26, 'Ownat Grain Free Just Сухой корм беззерновой для собак, с лососем и морепродуктами, 14 кг', '1061428', '9999.00', '12000.00', 15, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:03:16'),
(53, 27, 'Klicker Adult Sensitive Digestion Сухой корм для кошек с чувствительным пищеварением, с ягненком, 1 кг', '1065459', '1435.00', '1793.00', 78, 1, 1, '2026-03-29 12:20:24', '2026-04-06 06:45:58'),
(55, 28, 'Grandin Holistic Влажный корм (консервы) для взрослых кошек, тунец в желе, 80 гр.', '1064817', '199.00', NULL, 50, 1, 1, '2026-03-29 12:20:24', '2026-03-29 19:12:47'),
(56, 28, 'Grandin Holistic Влажный корм (консервы) для взрослых кошек, тунец с топпингом из лосося, 80 гр.', '1064818', '199.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:12:47'),
(57, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 400 гр.', '1000724', '635.00', NULL, 48, 0, 1, '2026-03-29 12:20:24', '2026-04-06 06:44:46'),
(58, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 200 гр.', '1051781', '339.00', NULL, 30, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:22:45'),
(59, 30, 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой, 400 гр.', '1053776', '639.00', NULL, 55, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:44:22'),
(60, 30, 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой, 1,5 кг', '1053741', '1969.00', NULL, 17, 1, 1, '2026-03-29 12:20:24', '2026-04-06 06:44:46'),
(61, 31, 'Tetra Min Holiday корм желе на 14 дней, 30 г', '1006487', '499.00', NULL, 65, 1, 1, '2026-03-29 12:20:24', '2026-03-29 19:49:44'),
(63, 32, 'Little One Корм для морских свинок, 400 гр.', '1007511', '255.00', NULL, 75, 1, 1, '2026-03-29 12:20:24', '2026-03-29 19:55:44'),
(64, 32, 'Little One Корм для морских свинок, 900 гр.', '1015934', '537.00', NULL, 15, 0, 1, '2026-03-29 12:20:24', '2026-03-29 19:55:44'),
(67, 34, 'Little One Корм для морских свинок Зелёная долина, 750 гр.', '1015722', '615.00', NULL, 40, 1, 1, '2026-03-29 12:20:24', '2026-03-29 20:05:17'),
(69, 35, 'Rungo Комбинезон теплый для собак породы мопс, обхват шеи 34 см, обхват груди 57 см, длина спины 34 см, шоколад (девочка)', '1063488', '2599.00', NULL, 5, 1, 1, '2026-03-29 12:20:24', '2026-03-29 20:12:19'),
(70, 35, 'Rungo Комбинезон с флисовой подкладкой для мопса, 57х34х34 см, пудра-бордо (девочка)', '1059683', '2599.00', NULL, 10, 0, 1, '2026-03-29 12:20:24', '2026-03-29 20:12:19'),
(71, 36, 'Rogz Utility ошейник, M', 'ROGZ-UTILITY-M', '2999.00', NULL, 30, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(72, 36, 'Rogz Utility ошейник, L', 'ROGZ-UTILITY-L', '3499.00', NULL, 15, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(73, 37, 'Hunter кожаный плетеный, M', 'HUNTER-PLET-M', '4999.00', NULL, 10, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(74, 37, 'Hunter кожаный плетеный, L', 'HUNTER-PLET-L', '5999.00', NULL, 5, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(75, 38, 'Petzl ошейник альпинистский, L/XL', 'PETZL-ALP-LXL', '7999.00', NULL, 8, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(76, 39, 'Ever Clean Extra Strength, 10 л', 'EVERCLEAN-10L', '1499.00', NULL, 40, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(77, 39, 'Ever Clean Extra Strength, 20 л', 'EVERCLEAN-20L', '2599.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(78, 40, 'Cat\'s Best Original, 6 кг', 'CATS-BEST-6KG', '1299.00', NULL, 60, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(79, 40, 'Cat\'s Best Original, 17 кг', 'CATS-BEST-17KG', '2999.00', NULL, 30, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(80, 41, 'Barsik Premium древесный, 5 л', 'BARSIK-5L', '899.00', NULL, 80, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(81, 41, 'Barsik Premium древесный, 10 л', 'BARSIK-10L', '1499.00', NULL, 50, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(82, 42, 'Perfect Fit древесный, 8 л', 'PERFECTFIT-8L', '1099.00', NULL, 70, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(83, 42, 'Perfect Fit древесный, 15 л', 'PERFECTFIT-15L', '1999.00', NULL, 40, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(84, 43, 'Сибирский лес премиум, 10 л', 'SIBLES-10L', '1399.00', NULL, 45, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(85, 43, 'Сибирский лес премиум, 20 л', 'SIBLES-20L', '2499.00', NULL, 20, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(86, 44, 'Травка-Сено древесный, 7 л', 'TRAVKA-7L', '1199.00', NULL, 55, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(87, 44, 'Травка-Сено древесный, 14 л', 'TRAVKA-14L', '2099.00', NULL, 30, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(88, 45, 'Kong Classic красный, S', 'KONG-CLASSIC-S', '1999.00', NULL, 35, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(89, 45, 'Kong Classic красный, M', 'KONG-CLASSIC-M', '2499.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(90, 46, 'Trixie теннисный мячик, стандарт', 'TRIXIE-TENNIS-STD', '399.00', NULL, 100, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(91, 46, 'Trixie теннисный мячик, большой', 'TRIXIE-TENNIS-L', '599.00', NULL, 70, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(92, 47, 'Ferplast фрисби Flyer, средний', 'FERPLAST-FLYER-M', '799.00', NULL, 60, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(93, 47, 'Ferplast фрисби Flyer, большой', 'FERPLAST-FLYER-L', '999.00', NULL, 40, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(94, 48, 'K9 Granit мячик, M', 'K9-GRANIT-M', '1499.00', NULL, 30, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(95, 48, 'K9 Granit мячик, L', 'K9-GRANIT-L', '1999.00', NULL, 20, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(96, 49, 'Chuckit! Ultra мячик, средний', 'CHUCKIT-ULTRA-M', '1299.00', NULL, 50, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(97, 49, 'Chuckit! Ultra мячик, большой', 'CHUCKIT-ULTRA-L', '1699.00', NULL, 35, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(98, 50, 'Rogz Grinz мячик зубастый, M', 'ROGZ-GRINZ-M', '1199.00', NULL, 45, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(99, 50, 'Rogz Grinz мячик зубастый, L', 'ROGZ-GRINZ-L', '1499.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(100, 51, 'Trixie Ортопедическая лежанка, S (50x40 см)', 'TRIXIE-ORTHO-S', '7999.00', NULL, 15, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(101, 51, 'Trixie Ортопедическая лежанка, M (70x50 см)', 'TRIXIE-ORTHO-M', '10999.00', NULL, 10, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(102, 52, 'Good Boy плед лежанка, S (60x45 см)', 'GOODBOY-PLED-S', '2999.00', NULL, 40, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(103, 52, 'Good Boy плед лежанка, L (90x65 см)', 'GOODBOY-PLED-L', '5999.00', NULL, 25, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(104, 53, 'Ferplast лежанка Carlotta, S (50 см диаметр)', 'FERPLAST-CARL-S', '3499.00', NULL, 35, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(105, 53, 'Ferplast лежанка Carlotta, M (70 см диаметр)', 'FERPLAST-CARL-M', '5999.00', NULL, 20, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(106, 54, 'Hunter лежанка Bavaria, M (75x55 см)', 'HUNTER-BAV-M', '6999.00', NULL, 20, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(107, 54, 'Hunter лежанка Bavaria, L (95x70 см)', 'HUNTER-BAV-L', '9999.00', NULL, 12, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(108, 55, 'PetFusion ортопедическая, M (71x53 см)', 'PETFUSION-M', '8999.00', NULL, 18, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(109, 55, 'PetFusion ортопедическая, L (91x66 см)', 'PETFUSION-L', '12999.00', NULL, 8, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(110, 56, 'Laifugy лежанка домик, S (60x45x30 см)', 'LAIFUGY-S', '4499.00', NULL, 30, 1, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(111, 56, 'Laifugy лежанка домик, M (80x60x35 см)', 'LAIFUGY-M', '6999.00', NULL, 20, 0, 1, '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(112, 23, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет, 4 кг', '1027343', '3739.00', NULL, 25, 0, 1, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(115, 23, 'Royal Canin Mini Adult Сухой корм для взрослых собак мелких размеров в возрасте от 10 месяцев до 8 лет, 8 кг', '1002775', '6719.00', NULL, 15, 0, 1, '2026-03-29 14:30:52', '2026-03-29 14:30:52'),
(116, 26, 'Ownat Adult Grain Free Сухой корм беззерновой для взрослых собак, с ягненком, 3 кг', '1042254', '3179.00', NULL, 5, 0, 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(117, 26, 'Ownat Adult Grain Free Сухой корм беззерновой для взрослых собак, с ягненком, 14 кг', '1044809', '9999.00', NULL, 10, 0, 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(118, 26, 'Ownat Adult Grain Free Сухой корм для взрослых собак, с уткой, 14 кг', '1044810', '8999.00', '9999.00', 0, 0, 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(119, 26, 'Ownat Adult Grain Free Сухой корм для взрослых собак, с уткой, 3 кг', '1044811', '3179.00', NULL, 15, 0, 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(120, 26, 'Ownat Adult Grain Free Сухой корм для взрослых собак, с курицей, 3 кг', '1040783', '2507.00', '2949.00', 20, 0, 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(121, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 1,2 кг', '1051779', '1839.00', NULL, 0, 1, 1, '2026-03-29 19:22:45', '2026-03-29 19:24:35'),
(122, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 2 кг', '1000715', '2945.00', NULL, 10, 0, 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(123, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 4 кг', '1003418', '5669.00', NULL, 0, 0, 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(124, 29, 'Royal Canin Sterilised 37 Regular Сухой корм для стерилизованных кошек с 1 до 7 лет, 10 кг', '1002563', '12815.00', NULL, 25, 0, 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(127, 30, 'AlphaPet Сухой корм для стерилизованных кошек, с ягненком и индейкой, 7 кг', '1066740', '7499.00', NULL, 0, 0, 1, '2026-03-29 19:45:46', '2026-03-29 19:45:46'),
(128, 35, 'Rungo Комбинезон теплый для собак породы мопс, длина спины 30 см, обхват шеи 43 см, обхват груди 60 см, красный (девочка)', '1054814', '2399.00', '2599.00', 3, 0, 1, '2026-03-29 20:12:19', '2026-03-29 20:12:19'),
(129, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, с кроликом и индейкой, 2 кг', '1040169', '3735.00', NULL, 5, 1, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(130, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, с кроликом и индейкой, 400 гр.', '1040168', '1125.00', NULL, 15, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(131, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, с кроликом и индейкой, 8 кг', '1063077', '11255.00', NULL, 5, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(132, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для стерилизованных кошек, с индейкой, 2 кг', '1063079', '3435.00', '3735.00', 5, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(133, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для стерилизованных кошек, с индейкой, 400 гр.', '1063078', '900.00', '1125.00', 0, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(134, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, четыре вида мяса, 400 гр.', '1040174', '1185.00', NULL, 8, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(135, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, четыре вида мяса, 2 кг', '1040175', '3915.00', NULL, 8, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(136, 57, 'GRANDORF Holistic Adult Sterilised Сухой корм для взрослых стерилизованных кошек, четыре вида мяса, 8 кг', '1065210', '11669.00', NULL, 15, 0, 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(137, 58, 'Ownat Adult Sterilized Grain Free Prime Сухой корм для стерилизованных кошек, с курицей и индейкой, 1 кг', '1040784', '1929.00', NULL, 10, 1, 1, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(138, 58, 'Ownat Adult Sterilized Grain Free Prime Сухой корм для стерилизованных кошек, с рыбой, 1 кг', '1061427', '2169.00', NULL, 5, 0, 1, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(139, 59, 'AlphaPet WOW Сухой корм для стерилизованных кошек с индейкой, 350 г', '1053735', '339.00', NULL, 10, 1, 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(140, 59, 'AlphaPet WOW Сухой корм для стерилизованных кошек с индейкой, 1,5 кг', '1053736', '1129.00', NULL, 10, 0, 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(141, 59, 'AlphaPet WOW Сухой корм для стерилизованных кошек с цыпленком, 350 г', '1053779', '339.00', NULL, 15, 0, 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `advantages` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disadvantages` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `unhelpful_count` int(11) NOT NULL DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Супер администратор', 'super_admin', 'Полный доступ ко всем функциям системы (обходит все проверки прав)'),
(2, 'Администратор магазина', 'shop_admin', 'Полное управление магазином, товарами и заказами'),
(3, 'Менеджер по товарам', 'product_manager', 'Управление каталогом товаров'),
(4, 'Менеджер по заказам', 'order_manager', 'Обработка заказов'),
(5, 'Кладовщик', 'warehouse_manager', 'Управление остатками товаров'),
(6, 'Зарегистрированный пользователь', 'registered_user', 'Обычный пользователь сайта');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'duckinahat', 'margaritaborodovskih@gmail.com', '+7(909)-090-86-13', NULL, '$2y$12$DA50T5Pr3l1EYQyf4/LYd.PmtAVm9bIXcF5lpqV5qiLV3hrCrOP2e', 'QncGrCIXhpPDpCigKEchTXoSyE2dFs9G0eCKTfnKBqKMFgfk1ltjx5mHBAmM', '2026-03-18 15:31:55', '2026-04-06 04:51:11', 1),
(2, 'user11', 'user1@mail.com', '+7(888)-888-88-88', NULL, '$2y$12$9Z5wZFaeK7UZ00o9MNvjDurBEc6.D.iWqYd3k3LauTmtgh3MNYw.S', NULL, '2026-04-01 14:45:38', '2026-04-04 12:16:40', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variation_attributes`
--

CREATE TABLE `variation_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `variation_attributes`
--

INSERT INTO `variation_attributes` (`id`, `variation_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 22, 'color', 'Черный', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(2, 22, 'size', 'L', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(3, 23, 'color', 'Красный', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(4, 23, 'size', 'M', '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(49, 76, 'объем', '10 л', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(50, 77, 'объем', '20 л', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(51, 78, 'вес', '6 кг', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(52, 79, 'вес', '17 кг', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(53, 80, 'объем', '5 л', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(54, 81, 'объем', '10 л', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(55, 88, 'размер', 'S', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(56, 89, 'размер', 'M', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(57, 90, 'размер', 'стандарт', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(58, 91, 'размер', 'большой', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(59, 100, 'размер', 'S (50x40 см)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(60, 101, 'размер', 'M (70x50 см)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(61, 102, 'размер', 'S (60x45 см)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(62, 103, 'размер', 'L (90x65 см)', '2026-03-29 12:20:24', '2026-03-29 12:20:24'),
(63, 41, 'flavor', 'Ягненок', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(64, 41, 'weight', '2.7', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(65, 42, 'flavor', 'Ягненок', '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(66, 43, 'flavor', 'Лосось', '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(67, 43, 'weight', '0.5', '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(118, 49, 'flavor', 'Белая рыба', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(119, 49, 'weight', '2', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(120, 50, 'flavor', 'Белая рыба', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(121, 50, 'weight', '12', '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(122, 51, 'flavor', 'Лосось', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(123, 51, 'weight', '3', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(124, 52, 'flavor', 'Лосось', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(125, 52, 'weight', '14', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(126, 116, 'flavor', 'Ягненок', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(127, 116, 'weight', '3', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(128, 117, 'flavor', 'Ягненок', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(129, 117, 'weight', '14', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(130, 118, 'flavor', 'Утка', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(131, 118, 'weight', '14', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(132, 119, 'flavor', 'Утка', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(133, 119, 'weight', '3', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(134, 120, 'flavor', 'Курица', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(135, 120, 'weight', '3', '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(136, 53, 'flavor', 'Ягненок', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(137, 53, 'weight', '1', '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(138, 55, 'flavor', 'Тунец', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(139, 55, 'weight', '0.08', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(140, 56, 'flavor', 'Тунец с топпингом из лосося', '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(153, 45, 'flavor', 'Кукуруза', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(154, 45, 'weight', '0.8', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(155, 46, 'flavor', 'Кукуруза', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(156, 46, 'weight', '2', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(157, 112, 'flavor', 'Кукуруза', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(158, 112, 'weight', '4', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(159, 115, 'flavor', 'Кукуруза', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(160, 115, 'weight', '8', '2026-03-29 19:24:15', '2026-03-29 19:24:15'),
(161, 47, 'flavor', 'Ягненок, индейка', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(162, 47, 'weight', '0.4', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(163, 48, 'flavor', 'Ягненок, индейка', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(164, 48, 'weight', '1.5', '2026-03-29 19:24:26', '2026-03-29 19:24:26'),
(165, 57, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(166, 57, 'weight', '0.4', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(167, 58, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(168, 58, 'weight', '0.2', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(169, 121, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(170, 121, 'weight', '1.2', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(171, 122, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(172, 122, 'weight', '2', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(173, 123, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(174, 123, 'weight', '4', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(175, 124, 'flavor', 'Птица', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(176, 124, 'weight', '10', '2026-03-29 19:24:35', '2026-03-29 19:24:35'),
(200, 59, 'flavor', 'Ягненок, индейка', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(201, 59, 'weight', '0.4', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(202, 60, 'flavor', 'Ягненок, индейка', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(203, 60, 'weight', '1.5', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(204, 127, 'flavor', 'Ягненок, индейка', '2026-03-29 19:46:02', '2026-03-29 19:46:02'),
(208, 61, 'weight', '0.03', '2026-03-29 19:58:14', '2026-03-29 19:58:14'),
(209, 63, 'weight', '0.4', '2026-03-29 20:00:36', '2026-03-29 20:00:36'),
(210, 64, 'weight', '0.9', '2026-03-29 20:00:36', '2026-03-29 20:00:36'),
(211, 67, 'weight', '0.75', '2026-03-29 20:05:17', '2026-03-29 20:05:17'),
(217, 69, 'color', 'Шоколад', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(218, 69, 'size', 'XL', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(219, 70, 'color', 'Пудровый', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(220, 70, 'size', 'XL', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(221, 128, 'color', 'Красный', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(222, 128, 'size', 'L', '2026-03-29 20:12:37', '2026-03-29 20:12:37'),
(239, 137, 'flavor', 'Курица, индейка', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(240, 137, 'weight', '1', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(241, 138, 'flavor', 'Рыба', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(242, 138, 'weight', '1', '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(249, 139, 'flavor', 'Индейка', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(250, 139, 'weight', '0.35', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(251, 140, 'flavor', 'Индейка', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(252, 140, 'weight', '1.5', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(253, 141, 'flavor', 'Цыпленок', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(254, 141, 'weight', '0.35', '2026-03-30 07:05:45', '2026-03-30 07:05:45'),
(255, 129, 'flavor', 'Кролик, индейка', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(256, 129, 'weight', '2', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(257, 130, 'flavor', 'Кролик, индейка', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(258, 130, 'weight', '0.4', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(259, 131, 'flavor', 'Кролик, индейка', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(260, 131, 'weight', '8', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(261, 132, 'flavor', 'Индейка', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(262, 132, 'weight', '2', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(263, 133, 'flavor', 'Индейка', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(264, 133, 'weight', '0.4', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(265, 134, 'flavor', 'Мясо', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(266, 134, 'weight', '0.4', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(267, 135, 'flavor', 'Мясо', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(268, 135, 'weight', '2', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(269, 136, 'flavor', 'Мясо', '2026-03-31 16:14:19', '2026-03-31 16:14:19'),
(270, 136, 'weight', '8', '2026-03-31 16:14:19', '2026-03-31 16:14:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variation_images`
--

CREATE TABLE `variation_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `variation_images`
--

INSERT INTO `variation_images` (`id`, `variation_id`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(25, 22, 'assets/images/products/rungo-oseinik-neilonovyi-s-ruckoi-dlia-sobak-k-9-l/variation_22/0.webp', 0, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(26, 22, 'assets/images/products/rungo-oseinik-neilonovyi-s-ruckoi-dlia-sobak-k-9-l/variation_22/1.webp', 1, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(27, 23, 'assets/images/products/rungo-oseinik-neilonovyi-s-ruckoi-dlia-sobak-k-9-l/variation_23/0.webp', 0, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(28, 23, 'assets/images/products/rungo-oseinik-neilonovyi-s-ruckoi-dlia-sobak-k-9-l/variation_23/1.webp', 1, '2026-03-28 18:14:26', '2026-03-28 18:14:26'),
(29, 41, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_41/0.webp', 0, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(30, 41, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_41/1.webp', 1, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(31, 41, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_41/2.webp', 2, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(32, 42, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_42/0.jpeg', 0, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(33, 42, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_42/1.webp', 1, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(34, 42, 'assets/images/products/grandin-hypoallergenic-iagnenok/variation_42/2.webp', 2, '2026-03-29 13:18:29', '2026-03-29 13:18:29'),
(35, 43, 'assets/images/products/klicker-adult/variation_43/0.webp', 0, '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(36, 43, 'assets/images/products/klicker-adult/variation_43/1.webp', 1, '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(37, 43, 'assets/images/products/klicker-adult/variation_43/2.webp', 2, '2026-03-29 13:41:32', '2026-03-29 13:41:32'),
(38, 45, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_45/0.webp', 0, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(39, 45, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_45/1.webp', 1, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(40, 45, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_45/2.webp', 2, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(41, 46, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_46/0.webp', 0, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(42, 46, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_46/1.webp', 1, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(43, 46, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_46/2.webp', 2, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(44, 112, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_112/0.webp', 0, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(45, 112, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_112/1.webp', 1, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(46, 112, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_112/2.webp', 2, '2026-03-29 14:07:03', '2026-03-29 14:07:03'),
(56, 115, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_115/0.webp', 0, '2026-03-29 14:30:52', '2026-03-29 14:30:52'),
(57, 115, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_115/1.webp', 1, '2026-03-29 14:30:52', '2026-03-29 14:30:52'),
(58, 115, 'assets/images/products/royal-canin-mini-adult-suxoi-korm-dlia-vzroslyx-sobak-melkix-razmerov-v-vozraste-ot-10-mesiacev-do-8-let/variation_115/2.webp', 2, '2026-03-29 14:30:52', '2026-03-29 14:30:52'),
(59, 47, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_47/0.webp', 0, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(60, 47, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_47/1.webp', 1, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(61, 47, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_47/2.webp', 2, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(62, 48, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_48/0.webp', 0, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(63, 48, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_48/1.webp', 1, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(64, 48, 'assets/images/products/avva-adult-suxoi-korm-na-osnove-svezego-miasa-dlia-vzroslyx-sobak-melkix-porod-s-iagnenkom-i-indeikoi/variation_48/2.webp', 2, '2026-03-29 17:16:40', '2026-03-29 17:16:40'),
(65, 49, 'assets/images/products/alphapet-adult-monoprotein-suxoi-korm-dlia-sobak-srednix-i-krupnyx-porod-belaia-ryba/variation_49/0.webp', 0, '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(66, 49, 'assets/images/products/alphapet-adult-monoprotein-suxoi-korm-dlia-sobak-srednix-i-krupnyx-porod-belaia-ryba/variation_49/1.webp', 1, '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(67, 50, 'assets/images/products/alphapet-adult-monoprotein-suxoi-korm-dlia-sobak-srednix-i-krupnyx-porod-belaia-ryba/variation_50/0.webp', 0, '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(68, 50, 'assets/images/products/alphapet-adult-monoprotein-suxoi-korm-dlia-sobak-srednix-i-krupnyx-porod-belaia-ryba/variation_50/1.webp', 1, '2026-03-29 18:45:42', '2026-03-29 18:45:42'),
(69, 51, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_51/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(70, 51, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_51/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(71, 51, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_51/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(72, 52, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_52/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(73, 52, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_52/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(74, 52, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_52/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(75, 116, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_116/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(76, 116, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_116/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(77, 116, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_116/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(78, 117, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_117/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(79, 117, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_117/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(80, 117, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_117/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(81, 118, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_118/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(82, 118, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_118/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(83, 118, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_118/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(84, 119, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_119/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(85, 119, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_119/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(86, 119, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_119/2.webp', 2, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(87, 120, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_120/0.webp', 0, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(88, 120, 'assets/images/products/ownat-grain-free-just-suxoi-korm-bezzernovoi-dlia-sobak/variation_120/1.webp', 1, '2026-03-29 19:03:16', '2026-03-29 19:03:16'),
(89, 53, 'assets/images/products/klicker-adult-sensitive-digestion-suxoi-korm-dlia-kosek-s-cuvstvitelnym-pishhevareniem/variation_53/0.webp', 0, '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(90, 53, 'assets/images/products/klicker-adult-sensitive-digestion-suxoi-korm-dlia-kosek-s-cuvstvitelnym-pishhevareniem/variation_53/1.webp', 1, '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(91, 53, 'assets/images/products/klicker-adult-sensitive-digestion-suxoi-korm-dlia-kosek-s-cuvstvitelnym-pishhevareniem/variation_53/2.webp', 2, '2026-03-29 19:06:53', '2026-03-29 19:06:53'),
(92, 55, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_55/0.webp', 0, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(93, 55, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_55/1.webp', 1, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(94, 55, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_55/2.webp', 2, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(95, 56, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_56/0.webp', 0, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(96, 56, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_56/1.webp', 1, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(97, 56, 'assets/images/products/grandin-holistic-vlaznyi-korm-konservy-dlia-vzroslyx-kosek/variation_56/2.webp', 2, '2026-03-29 19:12:47', '2026-03-29 19:12:47'),
(98, 57, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_57/0.webp', 0, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(99, 57, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_57/1.webp', 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(100, 57, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_57/2.webp', 2, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(101, 57, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_57/3.webp', 3, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(102, 58, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_58/0.webp', 0, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(103, 58, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_58/1.webp', 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(104, 58, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_58/2.webp', 2, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(105, 58, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_58/3.webp', 3, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(106, 121, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_121/0.webp', 0, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(107, 121, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_121/1.webp', 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(108, 121, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_121/2.webp', 2, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(109, 121, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_121/3.webp', 3, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(110, 122, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_122/0.webp', 0, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(111, 122, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_122/1.webp', 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(112, 122, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_122/2.webp', 2, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(113, 122, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_122/3.webp', 3, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(114, 123, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_123/0.webp', 0, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(115, 123, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_123/1.webp', 1, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(116, 123, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_123/2.webp', 2, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(117, 123, 'assets/images/products/royal-canin-sterilised-37-regular-suxoi-korm-dlia-sterilizovannyx-kosek-s-1-do-7-let/variation_123/3.webp', 3, '2026-03-29 19:22:45', '2026-03-29 19:22:45'),
(118, 59, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_59/0.webp', 0, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(119, 59, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_59/1.webp', 1, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(120, 59, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_59/2.webp', 2, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(121, 60, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_60/0.webp', 0, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(122, 60, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_60/1.webp', 1, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(123, 60, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_60/2.webp', 2, '2026-03-29 19:44:22', '2026-03-29 19:44:22'),
(133, 127, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_127/0.webp', 0, '2026-03-29 19:45:46', '2026-03-29 19:45:46'),
(134, 127, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_127/1.webp', 1, '2026-03-29 19:45:46', '2026-03-29 19:45:46'),
(135, 127, 'assets/images/products/alphapet-suxoi-korm-dlia-sterilizovannyx-kosek/variation_127/2.webp', 2, '2026-03-29 19:45:46', '2026-03-29 19:45:46'),
(136, 61, 'assets/images/products/tetra-min-holiday-korm-zele/variation_61/0.webp', 0, '2026-03-29 19:49:44', '2026-03-29 19:49:44'),
(137, 63, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_63/0.webp', 0, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(138, 63, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_63/1.webp', 1, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(139, 63, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_63/2.webp', 2, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(140, 64, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_64/0.webp', 0, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(141, 64, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_64/1.webp', 1, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(142, 64, 'assets/images/products/little-one-korm-dlia-morskix-svinok/variation_64/2.webp', 2, '2026-03-29 19:55:44', '2026-03-29 19:55:44'),
(143, 67, 'assets/images/products/little-one-korm-dlia-morskix-svinok-zelenaia-dolina/variation_67/0.webp', 0, '2026-03-29 20:05:17', '2026-03-29 20:05:17'),
(144, 67, 'assets/images/products/little-one-korm-dlia-morskix-svinok-zelenaia-dolina/variation_67/1.webp', 1, '2026-03-29 20:05:17', '2026-03-29 20:05:17'),
(145, 67, 'assets/images/products/little-one-korm-dlia-morskix-svinok-zelenaia-dolina/variation_67/2.webp', 2, '2026-03-29 20:05:17', '2026-03-29 20:05:17'),
(146, 69, 'assets/images/products/rungo-kombinezon-teplyi-dlia-sobak-porody-mops/variation_69/0.webp', 0, '2026-03-29 20:12:19', '2026-03-29 20:12:19'),
(147, 70, 'assets/images/products/rungo-kombinezon-teplyi-dlia-sobak-porody-mops/variation_70/0.webp', 0, '2026-03-29 20:12:19', '2026-03-29 20:12:19'),
(148, 128, 'assets/images/products/rungo-kombinezon-teplyi-dlia-sobak-porody-mops/variation_128/0.webp', 0, '2026-03-29 20:12:19', '2026-03-29 20:12:19'),
(149, 129, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_129/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(150, 129, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_129/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(151, 129, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_129/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(152, 130, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_130/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(153, 130, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_130/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(154, 130, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_130/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(155, 131, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_131/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(156, 131, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_131/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(157, 131, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_131/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(158, 132, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_132/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(159, 132, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_132/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(160, 132, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_132/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(161, 133, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_133/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(162, 133, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_133/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(163, 133, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_133/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(164, 134, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_134/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(165, 134, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_134/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(166, 134, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_134/2.webp', 2, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(167, 135, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_135/0.webp', 0, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(168, 135, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_135/1.webp', 1, '2026-03-30 06:08:32', '2026-03-30 06:08:32'),
(169, 137, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_137/0.webp', 0, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(170, 137, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_137/1.webp', 1, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(171, 137, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_137/2.webp', 2, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(172, 138, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_138/0.webp', 0, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(173, 138, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_138/1.webp', 1, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(174, 138, 'assets/images/products/ownat-adult-sterilized-grain-free-prime-suxoi-korm-dlia-sterilizovannyx-kosek/variation_138/2.webp', 2, '2026-03-30 06:56:38', '2026-03-30 06:56:38'),
(175, 139, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_139/0.webp', 0, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(176, 139, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_139/1.webp', 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(177, 140, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_140/0.webp', 0, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(178, 140, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_140/1.webp', 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(179, 141, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_141/0.webp', 0, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(180, 141, 'assets/images/products/alphapet-wow-suxoi-korm-dlia-sterilizovannyx-kosek/variation_141/1.webp', 1, '2026-03-30 07:01:27', '2026-03-30 07:01:27'),
(181, 135, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_135/2.webp', 2, NULL, NULL),
(182, 136, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_136/0.webp', 0, NULL, NULL),
(183, 136, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_136/1.webp', 1, NULL, NULL),
(184, 136, 'assets/images/products/grandorf-holistic-adult-sterilised-suxoi-korm-dlia-vzroslyx-sterilizovannyx-kosek/variation_136/2.webp', 2, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_variation_id_foreign` (`variation_id`),
  ADD KEY `cart_items_user_id_session_id_index` (`user_id`,`session_id`),
  ADD KEY `cart_items_session_id_index` (`session_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD UNIQUE KEY `categories_name_parent_id_unique` (`name`,`parent_id`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_sort_order_index` (`sort_order`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_variation_id_foreign` (`variation_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_role_permission_id_role_id_unique` (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_index` (`brand_id`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_is_active_index` (`is_active`);

--
-- Indices de la tabla `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_key_index` (`product_id`,`key`);

--
-- Indices de la tabla `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variations_sku_unique` (`sku`),
  ADD KEY `product_variations_sku_index` (`sku`),
  ADD KEY `product_variations_product_id_index` (`product_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_rating_index` (`rating`),
  ADD KEY `reviews_is_approved_index` (`is_approved`),
  ADD KEY `reviews_created_at_index` (`created_at`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_phone_index` (`phone`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `variation_attributes`
--
ALTER TABLE `variation_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_attributes_variation_id_key_index` (`variation_id`,`key`);

--
-- Indices de la tabla `variation_images`
--
ALTER TABLE `variation_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_images_variation_id_sort_order_index` (`variation_id`,`sort_order`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de la tabla `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `variation_attributes`
--
ALTER TABLE `variation_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT de la tabla `variation_images`
--
ALTER TABLE `variation_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `variation_attributes`
--
ALTER TABLE `variation_attributes`
  ADD CONSTRAINT `variation_attributes_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `variation_images`
--
ALTER TABLE `variation_images`
  ADD CONSTRAINT `variation_images_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
