<?php

class addUsers extends Mrl_Migration
{
    /**
     * Do the migration
     */
    public function upInTransaction()
    {
        $db = $this->getDb();

        $db->query('DROP TABLE IF EXISTS users;');
        $db->query('
          CREATE TABLE users (
            id INT(11) NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(100) NOT NULL,
            name VARCHAR(255) NOT NULL,
            status TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
            date_reg INT(11) NOT NULL,
            date_last_login INT(11) DEFAULT NULL ,
            PRIMARY KEY (id),
            INDEX IX_users_date_reg (date_reg),
            INDEX IX_users_name (name),
            INDEX IX_users_status (status),
            UNIQUE INDEX UK_users_email (email)
          )
          ENGINE = INNODB
          AUTO_INCREMENT = 4
          CHARACTER SET utf8
          COLLATE utf8_general_ci;
        ');
    }

    /**
     * Undo the migration
     */
    public function downInTransaction()
    {
        $db = $this->getDb();

        $db->query('DROP TABLE IF EXISTS users;');
    }
}
