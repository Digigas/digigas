ALTER TABLE `hampers` ADD `user_id`  INT NULL  ;
ALTER TABLE `hampers` ADD `last_comment_user_id` INT NULL  ;
ALTER TABLE `hampers` ADD `comments_count` INT NULL  ;
ALTER TABLE `hampers` ADD `last_comment_id` INT NULL  ;


ALTER TABLE `products` ADD `user_id` INT NULL  ;
ALTER TABLE `products` ADD `last_comment_user_id` INT NULL  ;
ALTER TABLE `products` ADD `comments_count` INT NULL  ;
ALTER TABLE `products` ADD `last_comment_id` INT NULL  ;

ALTER TABLE `comments` ADD `last_comment_user_id` INT NULL  ;
ALTER TABLE `comments` ADD `comments_count` INT NULL  ;
ALTER TABLE `comments` ADD `last_comment_id` INT NULL  ;


ALTER TABLE `news` ADD `last_comment_user_id` INT NULL  ;
ALTER TABLE `news` ADD `comments_count` INT NULL  ;
ALTER TABLE `news` ADD `last_comment_id` INT NULL  ;

ALTER TABLE `forums` ADD `last_comment_user_id` INT NULL  ;
ALTER TABLE `forums` ADD `comments_count` INT NULL  ;
ALTER TABLE `forums` ADD `last_comment_id` INT NULL  ;