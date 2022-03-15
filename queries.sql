-- add two column to ct_admin_info
ALTER TABLE ct_admin_info ADD COLUMN stripe_account_id VARCHAR(255) DEFAULT NULL, ADD COLUMN stripe_account_status TINYINT DEFAULT 0;

ALTER TABLE ct_bookings ADD COLUMN payment_intent_id VARCHAR(255) DEFAULT NULL, ADD COLUMN payment_status TINYINT DEFAULT 0,ADD COLUMN payment_capture_status TEXT DEFAULT NULL;


CREATE TABLE `ct_pro_balances_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'This amount is coming from stripe',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--edit the data type of coloum 
