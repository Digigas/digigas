



INSERT INTO `sellers` 
(`id`, `name`               , `business_name`, `address`, `phone`, `email`) VALUES
(1, 'Corte Ba'              , 'Corte Ba'        , 'Via Stradone 15 - Fraz. Roncolevà - 37060 Trevenzuolo (VR)', '045 7350561', ''),
(2, 'Emporio Bio'           , 'Emporio Bio'     , '', '', ''),
(3, 'Buona Terra'           , 'Buona Terra'     , '', '340 9514869', 'labuonaterra@tele2.it'),
(4, 'Donatella'             , 'Donatella'       , '', '', ''),
(5, 'Erba Madre Agriturismo', 'Erba Madre'      , '', '', ''),
(6, 'Bio Caseificio Tomasoni', 'Tomasoni'       , 'Via Roma 30, Gottolengo (Bs)', '030 951007', ''),
(7, 'Ca Magre'              , 'Ca Magre'        , '', '', ''),
(8, 'IRIS - A.S.T.R.A. bio' , 'IRIS'            , '', '', ''),
(9, 'Biomacelleria'         , 'Biomacelleria'   , 'Contrada Negri n. 14, San Rocco di Piegara, 37028 Roverè Veronese (Vr) ', '045-7848006', 'info@carnebiolessinia.com'),
(10, 'Ceres'                , 'Ceres'           , '', '', '');



INSERT INTO `product_categories` (`id`, `name`, `text`, `parent_id`, `lft`, `rght`, `created`, `modified`) VALUES
(1, 'Pasta', 'Pasta', 0, -42, -42, '2010-05-21', '2010-05-21'),
(2, 'Pasta Integrale', '<p>\r\n Pasta Integrale</p>\r\n', 1, -42, -41, '2010-05-21', '2010-05-21'),
(3, 'Pasta di Semola', '<p>\r\n Pasta di Semola</p>\r\n', 1, -42, -41, '2010-05-21', '2010-05-21'),
(4, 'Pasta di Farro', '<p>\r\n  Pasta di Farro</p>\r\n', 1, -42, -41, '2010-05-21', '2010-05-21'),
(5, 'Agricoltura', 'Agricoltura', 0, -42, -42, '2010-05-21', '2010-05-21'),
(6, 'Verdura', '<p>\r\n Verdura</p>\r\n', 1, -42, -31, '2010-05-21', '2010-05-21'),
(7, 'Frutta', '<p>\r\n  Frutta</p>\r\n', 1, -42, -31, '2010-05-21', '2010-05-21'),
(8, 'Frutta e Verdura', '<p>\r\n    Frutta e Verdura</p>\r\n', 1, -42, -31, '2010-05-21', '2010-05-21'),
(9, 'Formaggio', 'Formaggio', 0, -42, -42, '2010-05-21', '2010-05-21'),
(10, 'Zuppe', 'Zuppe', 0, -42, -42, '2010-05-21', '2010-05-21');


INSERT INTO `products` 
(`id`, `product_category_id`, `seller_id`, `name`, `text`, `packing`, `image`, `weight`, `number`, `value`, `created`, `modified`) VALUES
(1, 7, 4, 'cassetta frutta' , '', '', '', '', 1, 8.00, '2010-05-21', '2010-05-21'),
(2, 6, 4, 'Cassetta Verdura', '', '', '', '', 1, 8.00, '2010-05-21', '2010-05-21'),
(98, 10, 3, 'MINESTRONE VERDURE ANMORO 110 GR', '', '', '', '', 10, 2.850, '2010-05-21', '2010-05-21'),
(136, 10, 3, 'ZUPPA FARRO LEGUMI BAUL 400 GR', '', '', '', '', 12, 0.800, '2010-05-21', '2010-05-21'),
(137, 10, 3, 'ZUPPA FARRO/LENTICCHIE BAUL 400 GR', '', '', '', '', 6, 1.820, '2010-05-21', '2010-05-21'),
(138, 10, 3, 'ZUPPA ORZO E PISELLI BAUL 400 GR', '', '', '', '', 6, 1.820, '2010-05-21', '2010-05-21'),
(139, 10, 3, 'ZUPPA RIBOLLITA BAUL 550 GR', '', '', '', '', 6, 4.540, '2010-05-21', '2010-05-21'),
(140, 10, 3, 'ZUPPA TOSCANA BAUL 400 GR', '', '', '', '', 6, 2.350, '2010-05-21', '2010-05-21');



-- SELECT `id` , 10, 3, '', '', '', '', '', `pezziconf` , `prezzogas` , '2010-05-21', '2010-05-21' FROM `paniere` WHERE `categoria` =12
