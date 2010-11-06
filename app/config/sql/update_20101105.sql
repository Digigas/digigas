ALTER TABLE  `ordered_products` CHANGE  `quantity`  `quantity` DECIMAL( 10, 2 ) NOT NULL COMMENT  'numero di pezzi acquistati';

ALTER TABLE  `products` CHANGE  `number`  `number` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '1' COMMENT  'moltiplicatore per calcolo del prezzo';

