<?php
/**
 * TODO
 *  Write DPO statements to create following tables:
 *
 *  # airports
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *   - code (varchar)
 *   - city_id (relation to the cities table)
 *   - state_id (relation to the states table)
 *   - address (varchar)
 *   - timezone (varchar)
 *
 *  # cities
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *
 *  # states
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';
try {
// cities
    $sql = <<<'SQL'
    CREATE TABLE `cities` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
        PRIMARY KEY (`id`)
    );
    SQL;
    $pdo->exec($sql);

// states
    $sql = <<<'SQL'
    CREATE TABLE `states` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
        PRIMARY KEY (`id`)
    );
    SQL;
    $pdo->exec($sql);

// airports
    $sql = <<<'SQL'
    CREATE TABLE `airports` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
        `code` VARCHAR(3) NOT NULL COLLATE 'utf8_general_ci',
        `city_id` INT(10) UNSIGNED,
        `state_id` INT(10) UNSIGNED,
        `address` VARCHAR(255) NOT NULL,
        `timezone` VARCHAR(50) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`),
        FOREIGN KEY (`state_id`) REFERENCES `states`(`id`)
    );
    SQL;
    $pdo->exec($sql);
} catch (PDOException $exception) {
    echo 'Error!!! ' . $exception->getMessage();
    die();
}