/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;
DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities`
(
    `id`                          int unsigned                                                             NOT NULL AUTO_INCREMENT,
    `event_start`                 time                                                                              DEFAULT NULL,
    `event_stop`                  time                                                                              DEFAULT NULL,
    `warmup_start`                double                                                                            DEFAULT '0',
    `counter_start`               double                                                                            DEFAULT '0',
    `counter_stop`                double                                                                            DEFAULT '0',
    `warmup_minutes`              int                                                                               DEFAULT '0',
    `instructor_price_per_minute` decimal(10, 2)                                                                    DEFAULT '0.00',
    `minutes`                     int                                                                               DEFAULT '0',
    `amount`                      double                                                                            DEFAULT '0',
    `departure`                   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci                     DEFAULT NULL,
    `arrival`                     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci                     DEFAULT NULL,
    `split_cost`                  tinyint(1)                                                               NOT NULL DEFAULT '0',
    `event`                       date                                                                     NOT NULL,
    `description`                 longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `created_at`                  timestamp                                                                NULL     DEFAULT NULL,
    `updated_at`                  timestamp                                                                NULL     DEFAULT NULL,
    `deleted_at`                  timestamp                                                                NULL     DEFAULT NULL,
    `user_id`                     int unsigned                                                             NOT NULL,
    `plane_id`                    int unsigned                                                             NOT NULL,
    `type_id`                     int unsigned                                                                      DEFAULT '0',
    `copilot_id`                  int unsigned                                                                      DEFAULT NULL,
    `instructor_id`               int unsigned                                                                      DEFAULT NULL,
    `created_by_id`               int unsigned                                                                      DEFAULT NULL,
    `status`                      enum ('new','approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
    `package_id`                  bigint unsigned                                                                   DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_fk_1169385` (`user_id`),
    KEY `plane_fk_1169386` (`plane_id`),
    KEY `type_fk_1169396` (`type_id`),
    KEY `copilot_fk_1223683` (`copilot_id`),
    KEY `instructor_fk_1223684` (`instructor_id`),
    KEY `created_by_fk_1223685` (`created_by_id`),
    KEY `activities_minutes_index` (`minutes`),
    KEY `activities_amount_index` (`amount`),
    KEY `activities_plane_id_index` (`plane_id`),
    CONSTRAINT `copilot_fk_1223683` FOREIGN KEY (`copilot_id`) REFERENCES `users` (`id`),
    CONSTRAINT `created_by_fk_1223685` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
    CONSTRAINT `instructor_fk_1223684` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`),
    CONSTRAINT `plane_fk_1169386` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`),
    CONSTRAINT `user_fk_1169385` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `asset_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_categories`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp       NULL                                          DEFAULT NULL,
    `updated_at` timestamp       NULL                                          DEFAULT NULL,
    `deleted_at` timestamp       NULL                                          DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `asset_locations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_locations`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp       NULL                                          DEFAULT NULL,
    `updated_at` timestamp       NULL                                          DEFAULT NULL,
    `deleted_at` timestamp       NULL                                          DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `asset_statuses`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_statuses`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp       NULL                                          DEFAULT NULL,
    `updated_at` timestamp       NULL                                          DEFAULT NULL,
    `deleted_at` timestamp       NULL                                          DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets`
(
    `id`                    bigint unsigned NOT NULL AUTO_INCREMENT,
    `serial_number`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `name`                  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `notes`                 longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `start_hours`           int                                                           DEFAULT NULL,
    `start_date`            date                                                          DEFAULT NULL,
    `end_hours`             int                                                           DEFAULT NULL,
    `end_date`              date                                                          DEFAULT NULL,
    `current_running_hours` int                                                           DEFAULT NULL,
    `created_at`            timestamp       NULL                                          DEFAULT NULL,
    `updated_at`            timestamp       NULL                                          DEFAULT NULL,
    `deleted_at`            timestamp       NULL                                          DEFAULT NULL,
    `category_id`           bigint unsigned                                               DEFAULT NULL,
    `status_id`             bigint unsigned                                               DEFAULT NULL,
    `location_id`           bigint unsigned                                               DEFAULT NULL,
    `assigned_to_id`        int unsigned                                                  DEFAULT NULL,
    `plane_id`              int unsigned                                                  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `assets_category_id_foreign` (`category_id`),
    KEY `assets_status_id_foreign` (`status_id`),
    KEY `assets_location_id_foreign` (`location_id`),
    KEY `assets_assigned_to_id_foreign` (`assigned_to_id`),
    KEY `assets_plane_id_foreign` (`plane_id`),
    CONSTRAINT `assets_assigned_to_id_foreign` FOREIGN KEY (`assigned_to_id`) REFERENCES `users` (`id`),
    CONSTRAINT `assets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `asset_categories` (`id`),
    CONSTRAINT `assets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `asset_locations` (`id`),
    CONSTRAINT `assets_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`),
    CONSTRAINT `assets_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `asset_statuses` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `assets_histories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets_histories`
(
    `id`               bigint unsigned NOT NULL AUTO_INCREMENT,
    `created_at`       timestamp       NULL DEFAULT NULL,
    `updated_at`       timestamp       NULL DEFAULT NULL,
    `asset_id`         bigint unsigned      DEFAULT NULL,
    `status_id`        bigint unsigned      DEFAULT NULL,
    `location_id`      bigint unsigned      DEFAULT NULL,
    `assigned_user_id` int unsigned         DEFAULT NULL,
    `plane_id`         int unsigned         DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `assets_histories_asset_id_foreign` (`asset_id`),
    KEY `assets_histories_status_id_foreign` (`status_id`),
    KEY `assets_histories_location_id_foreign` (`location_id`),
    KEY `assets_histories_assigned_user_id_foreign` (`assigned_user_id`),
    KEY `assets_histories_plane_id_foreign` (`plane_id`),
    CONSTRAINT `assets_histories_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
    CONSTRAINT `assets_histories_assigned_user_id_foreign` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `assets_histories_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `asset_locations` (`id`),
    CONSTRAINT `assets_histories_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`),
    CONSTRAINT `assets_histories_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `asset_statuses` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_instructor`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_instructor`
(
    `booking_id` int unsigned NOT NULL,
    `user_id`    int unsigned NOT NULL,
    KEY `booking_instructor_booking_id_foreign` (`booking_id`),
    KEY `booking_instructor_user_id_foreign` (`user_id`),
    CONSTRAINT `booking_instructor_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
    CONSTRAINT `booking_instructor_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_user`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_user`
(
    `booking_id` int unsigned NOT NULL,
    `user_id`    int unsigned NOT NULL,
    KEY `booking_user_booking_id_foreign` (`booking_id`),
    KEY `booking_user_user_id_foreign` (`user_id`),
    CONSTRAINT `booking_user_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
    CONSTRAINT `booking_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings`
(
    `id`                int unsigned NOT NULL AUTO_INCREMENT,
    `reservation_start` datetime     NOT NULL,
    `reservation_stop`  datetime     NOT NULL,
    `description`       longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `mode_id`           int unsigned NOT NULL DEFAULT '1',
    `status`            int unsigned NOT NULL DEFAULT '0',
    `created_at`        timestamp    NULL     DEFAULT NULL,
    `updated_at`        timestamp    NULL     DEFAULT NULL,
    `deleted_at`        timestamp    NULL     DEFAULT NULL,
    `slot_id`           int unsigned          DEFAULT NULL,
    `checkin`           tinyint(1)            DEFAULT NULL,
    `seats`             int unsigned          DEFAULT NULL,
    `seats_taken`       int unsigned          DEFAULT NULL,
    `seats_available`   int unsigned          DEFAULT NULL,
    `instructor_needed` tinyint(1)            DEFAULT NULL,
    `plane_id`          int unsigned NOT NULL,
    `created_by_id`     int unsigned          DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `plane_fk_1172723` (`plane_id`),
    KEY `created_by_fk_1223686` (`created_by_id`),
    KEY `slot_fk_bookings` (`slot_id`),
    KEY `bookings_mode_id_foreign` (`mode_id`),
    KEY `bookings_mode_id_index` (`mode_id`),
    KEY `bookings_reservation_start_index` (`reservation_start`),
    CONSTRAINT `bookings_mode_id_foreign` FOREIGN KEY (`mode_id`) REFERENCES `modes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `created_by_fk_1223686` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
    CONSTRAINT `plane_fk_1172723` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `expense_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_categories`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp    NULL                                             DEFAULT NULL,
    `updated_at` timestamp    NULL                                             DEFAULT NULL,
    `deleted_at` timestamp    NULL                                             DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses`
(
    `id`                  int unsigned NOT NULL AUTO_INCREMENT,
    `entry_date`          date                                                          DEFAULT NULL,
    `amount`              decimal(15, 2)                                                DEFAULT NULL,
    `description`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`          timestamp    NULL                                             DEFAULT NULL,
    `updated_at`          timestamp    NULL                                             DEFAULT NULL,
    `deleted_at`          timestamp    NULL                                             DEFAULT NULL,
    `expense_category_id` int unsigned                                                  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `expense_category_fk_1223668` (`expense_category_id`),
    CONSTRAINT `expense_category_fk_1223668` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factor_type`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factor_type`
(
    `factor_id`   int unsigned  NOT NULL,
    `type_id`     int unsigned  NOT NULL,
    `rate`        double(15, 2) NOT NULL,
    `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    KEY `factor_id_fk_1169147` (`factor_id`),
    KEY `type_id_fk_1169147` (`type_id`),
    CONSTRAINT `factor_id_fk_1169147` FOREIGN KEY (`factor_id`) REFERENCES `factors` (`id`) ON DELETE CASCADE,
    CONSTRAINT `type_id_fk_1169147` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factors`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factors`
(
    `id`          int unsigned                                                  NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `created_at`  timestamp                                                     NULL DEFAULT NULL,
    `updated_at`  timestamp                                                     NULL DEFAULT NULL,
    `deleted_at`  timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `factors_name_unique` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs`
(
    `id`         bigint unsigned                                           NOT NULL AUTO_INCREMENT,
    `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci     NOT NULL,
    `queue`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci     NOT NULL,
    `payload`    longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `exception`  longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `failed_at`  timestamp                                                 NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `income_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `income_categories`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `deposit`    tinyint(1)                                                    DEFAULT '0',
    `created_at` timestamp    NULL                                             DEFAULT NULL,
    `updated_at` timestamp    NULL                                             DEFAULT NULL,
    `deleted_at` timestamp    NULL                                             DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incomes`
(
    `id`                 int unsigned NOT NULL AUTO_INCREMENT,
    `entry_date`         date                                                          DEFAULT NULL,
    `amount`             decimal(15, 2)                                                DEFAULT NULL,
    `description`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`         timestamp    NULL                                             DEFAULT NULL,
    `updated_at`         timestamp    NULL                                             DEFAULT NULL,
    `deleted_at`         timestamp    NULL                                             DEFAULT NULL,
    `income_category_id` int unsigned                                                  DEFAULT NULL,
    `user_id`            int unsigned                                                  DEFAULT NULL,
    `created_by_id`      int unsigned                                                  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `income_category_fk_1223676` (`income_category_id`),
    KEY `user_fk_1223711` (`user_id`),
    KEY `created_by_fk_1223712` (`created_by_id`),
    CONSTRAINT `created_by_fk_1223712` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
    CONSTRAINT `income_category_fk_1223676` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`id`),
    CONSTRAINT `user_fk_1223711` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invitations`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `email`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    `updated_at` timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media`
(
    `id`                bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `model_type`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`          bigint unsigned                                               NOT NULL,
    `collection_name`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `name`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `file_name`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `mime_type`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci      DEFAULT NULL,
    `disk`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `size`              int unsigned                                                  NOT NULL,
    `manipulations`     json                                                          NOT NULL,
    `custom_properties` json                                                          NOT NULL,
    `responsive_images` json                                                          NOT NULL,
    `order_column`      int unsigned                                                       DEFAULT NULL,
    `created_at`        timestamp                                                     NULL DEFAULT NULL,
    `updated_at`        timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `media_model_type_model_id_index` (`model_type`, `model_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations`
(
    `id`        int unsigned                                                  NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch`     int                                                           NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions`
(
    `permission_id` bigint unsigned                                               NOT NULL,
    `model_type`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`      bigint unsigned                                               NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    KEY `model_has_permissions_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles`
(
    `role_id`    bigint unsigned                                               NOT NULL,
    `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`   bigint unsigned                                               NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    KEY `model_has_roles_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modes`
(
    `id`         int unsigned                                          NOT NULL AUTO_INCREMENT,
    `name`       text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `active`     tinyint(1)                                            NOT NULL DEFAULT '1',
    `deleted_at` timestamp                                             NULL     DEFAULT NULL,
    `created_at` timestamp                                             NULL     DEFAULT NULL,
    `updated_at` timestamp                                             NULL     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications`
(
    `id`              char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci     NOT NULL,
    `type`            varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `notifiable_id`   bigint unsigned                                               NOT NULL,
    `data`            text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NOT NULL,
    `read_at`         timestamp                                                     NULL DEFAULT NULL,
    `created_at`      timestamp                                                     NULL DEFAULT NULL,
    `updated_at`      timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`, `notifiable_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens`
(
    `id`         varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id`    bigint                                                             DEFAULT NULL,
    `client_id`  int unsigned                                                  NOT NULL,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci      DEFAULT NULL,
    `scopes`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `revoked`    tinyint(1)                                                    NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    `updated_at` timestamp                                                     NULL DEFAULT NULL,
    `expires_at` datetime                                                           DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes`
(
    `id`         varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id`    bigint                                                        NOT NULL,
    `client_id`  int unsigned                                                  NOT NULL,
    `scopes`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `revoked`    tinyint(1)                                                    NOT NULL,
    `expires_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients`
(
    `id`                     int unsigned                                                  NOT NULL AUTO_INCREMENT,
    `user_id`                bigint                                                             DEFAULT NULL,
    `name`                   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `secret`                 varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `redirect`               text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NOT NULL,
    `personal_access_client` tinyint(1)                                                    NOT NULL,
    `password_client`        tinyint(1)                                                    NOT NULL,
    `revoked`                tinyint(1)                                                    NOT NULL,
    `created_at`             timestamp                                                     NULL DEFAULT NULL,
    `updated_at`             timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `client_id`  int unsigned NOT NULL,
    `created_at` timestamp    NULL DEFAULT NULL,
    `updated_at` timestamp    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens`
(
    `id`              varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `revoked`         tinyint(1)                                                    NOT NULL,
    `expires_at`      datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages`
(
    `id`                  bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `name`                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id`             int unsigned                                                  NOT NULL,
    `price`               decimal(10, 2)                                                NOT NULL,
    `initial_minutes`     int                                                           NOT NULL,
    `remaining_minutes`   int                                                           NOT NULL,
    `valid_from`          date                                                          NOT NULL,
    `valid_until`         date                                                          NOT NULL,
    `type`                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `plane_id`            int unsigned                                                           DEFAULT NULL,
    `created_at`          timestamp                                                     NULL     DEFAULT NULL,
    `updated_at`          timestamp                                                     NULL     DEFAULT NULL,
    `instructor_included` tinyint(1)                                                    NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `packages_user_id_foreign` (`user_id`),
    KEY `packages_plane_id_foreign` (`plane_id`),
    CONSTRAINT `packages_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets`
(
    `email`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    KEY `password_resets_email_index` (`email`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `user_id`    int unsigned                                                  NOT NULL,
    `stripe_id`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `subtotal`   int                                                           NOT NULL DEFAULT '0',
    `tax`        int                                                           NOT NULL DEFAULT '0',
    `total`      int                                                           NOT NULL,
    `created_at` timestamp                                                     NULL     DEFAULT NULL,
    `updated_at` timestamp                                                     NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `payments_user_id_foreign` (`user_id`),
    CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    `updated_at` timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permissions_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens`
(
    `id`             bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tokenable_id`   bigint unsigned                                               NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`          varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL,
    `abilities`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `last_used_at`   timestamp                                                     NULL DEFAULT NULL,
    `created_at`     timestamp                                                     NULL DEFAULT NULL,
    `updated_at`     timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
    KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `plane_user`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plane_user`
(
    `user_id`                     int unsigned   NOT NULL,
    `plane_id`                    int unsigned   NOT NULL,
    `base_price_per_minute`       decimal(10, 2) NOT NULL DEFAULT '0.00',
    `instructor_price_per_minute` decimal(10, 2) NOT NULL DEFAULT '0.00',
    KEY `user_id_fk_2200347` (`user_id`),
    KEY `plane_id_fk_2200347` (`plane_id`),
    CONSTRAINT `plane_id_fk_2200347` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `user_id_fk_2200347` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `plane_user_ratings`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plane_user_ratings`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `user_id`    int unsigned                                                  NOT NULL,
    `plane_id`   int unsigned                                                  NOT NULL,
    `status`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    `updated_at` timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `plane_user_ratings_user_id_plane_id_unique` (`user_id`, `plane_id`),
    KEY `plane_user_ratings_plane_id_foreign` (`plane_id`),
    CONSTRAINT `plane_user_ratings_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `plane_user_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `planes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planes`
(
    `id`                          int unsigned                                                  NOT NULL AUTO_INCREMENT,
    `callsign`                    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `vendor`                      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `model`                       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `prodno`                      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `default_price_per_minute`    decimal(8, 2)                                                 NOT NULL DEFAULT '0.00',
    `instructor_price_per_minute` decimal(8, 2)                                                 NOT NULL DEFAULT '0.00',
    `counter_type`                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `warmup_minutes`              int                                                           NOT NULL DEFAULT '0',
    `pilot_paying_warmup`         tinyint(1)                                                    NOT NULL DEFAULT '0',
    `active`                      tinyint(1)                                                             DEFAULT '0',
    `created_at`                  timestamp                                                     NULL     DEFAULT NULL,
    `updated_at`                  timestamp                                                     NULL     DEFAULT NULL,
    `deleted_at`                  timestamp                                                     NULL     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions`
(
    `permission_id` bigint unsigned NOT NULL,
    `role_id`       bigint unsigned NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    KEY `role_has_permissions_role_id_foreign` (`role_id`),
    CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp                                                     NULL DEFAULT NULL,
    `updated_at` timestamp                                                     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings`
(
    `id`         bigint unsigned                                               NOT NULL AUTO_INCREMENT,
    `group`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `name`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `locked`     tinyint(1)                                                    NOT NULL DEFAULT '0',
    `payload`    json                                                          NOT NULL,
    `created_at` timestamp                                                     NULL     DEFAULT NULL,
    `updated_at` timestamp                                                     NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `settings_group_name_unique` (`group`, `name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types`
(
    `id`          int unsigned                                                  NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `active`      tinyint(1)                                                    NOT NULL DEFAULT '0',
    `instructor`  tinyint(1)                                                    NOT NULL DEFAULT '0',
    `created_at`  timestamp                                                     NULL     DEFAULT NULL,
    `updated_at`  timestamp                                                     NULL     DEFAULT NULL,
    `deleted_at`  timestamp                                                     NULL     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_minute_balances`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_minute_balances`
(
    `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id`           int unsigned    NOT NULL,
    `minutes_purchased` decimal(10, 2)  NOT NULL,
    `minutes_used`      decimal(10, 2)  NOT NULL DEFAULT '0.00',
    `effective_date`    date            NOT NULL,
    `created_at`        timestamp       NULL     DEFAULT NULL,
    `updated_at`        timestamp       NULL     DEFAULT NULL,
    `deleted_at`        timestamp       NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_minute_balances_user_id_foreign` (`user_id`),
    CONSTRAINT `user_minute_balances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users`
(
    `id`                   int unsigned NOT NULL AUTO_INCREMENT,
    `name`                 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email`                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email_verified_at`    datetime                                                      DEFAULT NULL,
    `privacy_confirmed_at` datetime                                                      DEFAULT NULL,
    `password`             varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `remember_token`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `medical_due`          date                                                          DEFAULT NULL,
    `license`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `lang`                 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `taxno`                varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone_1`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone_2`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `address`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `city`                 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `params`               longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `created_at`           timestamp    NULL                                             DEFAULT NULL,
    `updated_at`           timestamp    NULL                                             DEFAULT NULL,
    `deleted_at`           timestamp    NULL                                             DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (1, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (2, '2016_06_01_000001_create_oauth_auth_codes_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (3, '2016_06_01_000002_create_oauth_access_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (5, '2016_06_01_000004_create_oauth_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (7, '2020_03_29_000001_create_permissions_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (8, '2020_03_29_000002_create_incomes_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (9, '2020_03_29_000003_create_expenses_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (10, '2020_03_29_000004_create_income_categories_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (11, '2020_03_29_000005_create_expense_categories_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (12, '2020_03_29_000006_create_parameters_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (13, '2020_03_29_000007_create_bookings_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (14, '2020_03_29_000008_create_activities_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (15, '2020_03_29_000009_create_types_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (16, '2020_03_29_000010_create_factors_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (17, '2020_03_29_000011_create_planes_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (18, '2020_03_29_000012_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (19, '2020_03_29_000013_create_roles_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (20, '2020_03_29_000014_create_role_user_pivot_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (21, '2020_03_29_000015_create_permission_role_pivot_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (22, '2020_03_29_000016_add_relationship_fields_to_activities_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (23, '2020_03_29_000017_add_relationship_fields_to_bookings_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (24, '2020_03_29_000018_add_relationship_fields_to_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (25, '2020_03_29_000019_add_relationship_fields_to_expenses_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (26, '2020_03_29_000020_add_relationship_fields_to_incomes_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (27, '2020_05_03_065401_add_split_to_activities_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (28, '2020_05_17_100000_add_description_to_activities_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (29, '2099_03_20_000001_create_factor_type_pivot_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (30, '2099_03_20_000002_add_fields_to_pivot_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (31, '2020_06_09_132442_add_fields_to_users_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (32, '2020_06_18_121145_add_privacy_column_user_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (33, '2020_06_29_135202_add_counter_type_column_to_planes_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (34, '2020_07_02_132627_create_failed_jobs_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (35, '2020_07_10_060739_add_warmup_type_column_to_planes_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (36, '2019_12_14_000001_create_personal_access_tokens_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (37, '2020_08_09_151855_add_type_id_column_to_bookings_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (38, '2020_08_21_083600_add_instructor_id_column_to_bookings_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (39, '2020_08_21_083800_add_status_column_to_bookings_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (40, '2020_09_17_000015_create_plane_user_pivot_table', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (41, '2020_09_17_110411_drop_types_bookings_foreign_key', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (42, '2020_09_19_135807_rearrange_columns_bookings_table', 9);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (43, '2020_09_23_000006_create_slots_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (44, '2020_09_23_000010_create_slot_user_pivot_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (45, '2020_09_26_150904_modify_user_id_bookings_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (46, '2020_10_13_093344_create_webhook_calls_table', 11);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (47, '2020_10_13_094851_create_payments_table', 11);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (48, '2020_10_21_100300_add_profile_permissions', 12);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (49, '2020_10_23_082405_add_user_booking_pivot_table', 13);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (50, '2020_10_23_110442_create_booking_modes_table', 13);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (51, '2020_10_24_085220_add_instrutor_booking_pivot_table', 13);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (52, '2020_11_11_091741_create_notifications_table', 14);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (53, '2020_11_18_000001_create_media_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (54, '2020_11_18_000002_create_asset_categories_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (55, '2020_11_18_000004_create_assets_histories_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (56, '2020_11_18_000006_create_assets_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (57, '2020_11_18_000009_create_asset_statuses_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (58, '2020_11_18_000010_create_asset_locations_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (59, '2020_11_18_000022_add_relationship_fields_to_assets_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (60, '2020_11_18_000023_add_relationship_fields_to_assets_histories_table', 15);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (61, '2022_07_23_160409_remove_instructor_column_users_table', 16);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (62, '2022_12_14_083707_create_settings_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (63, '2024_06_25_145612_alter_activites_table_add_status', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (64, '2024_06_28_053002_create_user_minute_balances_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (65, '2024_06_28_140931_alter_plane_user_table_adding_pivot', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (66, '2024_07_01_140932_alter_plane_user_table_adding_pivot_instructor', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (67, '2024_07_01_154702_alter_activities_table_add_instructor_price', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (68, '2024_09_28_164148_drop_foreign_type_id_activities_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (70, '2024_10_04_163838_create_user_invitation_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (71, '2024_10_25_150222_create_index_mode_id_bookings_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (72, '2024_10_25_150456_create_index_plane_id_activities_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (73, '2024_11_29_165438_create_permission_tables', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (75, '2024_12_16_102521_create_index_bookings_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (76, '2024_12_16_160649_add_default_price_per_minute_to_planes_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (77, '2024_12_16_164628_add_instructor_price_per_minute_to_planes_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (78, '2024_12_16_173432_create_plane_user_ratings_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (79, '2024_12_22_104557_create_packages_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (80, '2024_12_22_114013_remove_obsolete_columns_from_activities_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (81, '2024_12_22_114419_add_traceability_columns_to_activities_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (82, '2024_12_23_083843_update_planes_table_for_warmup', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (83, '2024_12_23_173016_update_packages_table_replace_instructor_id', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (84, '2024_12_28_123313_remove_rating_status_from_plane_user_table', 17);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (86, '2025_01_17_090453_drop_unused_tables', 18);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (87, '2024_10_04_111013_create_general_settings', 19);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (88, '2024_12_13_101311_email_settings', 19);
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (89, '2025_01_17_093307_remove_factor_id_from_users_table', 20);
