-- add two column to ct_admin_info
ALTER TABLE ct_admin_info ADD COLUMN stripe_account_id VARCHAR(255) DEFAULT NULL, ADD COLUMN stripe_account_status TINYINT DEFAULT 0;

ALTER TABLE ct_bookings ADD COLUMN payment_intent_id VARCHAR(255) DEFAULT NULL, ADD COLUMN payment_status TINYINT DEFAULT 0,ADD COLUMN payment_capture_status TEXT DEFAULT NULL;


