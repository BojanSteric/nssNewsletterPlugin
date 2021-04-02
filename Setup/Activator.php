<?php

namespace Newsletter\Setup;


class Activator {

	private $db;
	private $tableName;
	private $tableName2;

	public function __construct(\wpdb $db)
	{
		$this->db = $db;
	}

	public function init(): void
	{
		$this->tableName = SUBSCRIBER_TABLE_NAME;
		$this->tableName2 = SUBSCRIBER_TABLE_NAME;

		$this->createSubscriberTable();
		$this->createNewsletterTable();
	}

	private function createSubscriberTable()
	{
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name   = $wpdb->prefix . 'subscriber';
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  `userId` int(50) NOT NULL AUTO_INCREMENT,
		  `wpUserId` int(50) DEFAULT NULL,
		  `email` varchar(30) NOT NULL,
		  `emailStatus` varchar(20) NOT NULL,
		  `actionLink` char(255) NOT NULL,
		  `firstName` varchar(20) DEFAULT NULL,
		  `lastName` varchar(20) DEFAULT NULL,
		  `createdAt` datetime DEFAULT NULL,
		  `updatedAt` datetime DEFAULT NULL,
		  PRIMARY KEY  (userId),
		  CONSTRAINT emailAdress UNIQUE (email)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}
	private function createNewsletterTable()
	{
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name2   = $wpdb->prefix . 'newsletter';
		$sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
		  `newsId` int(50) NOT NULL AUTO_INCREMENT,
		  `newsStatus` varchar(30) NOT NULL,
		  `createdAt` datetime DEFAULT NULL,
		  `scheduledAt` datetime DEFAULT NULL,
		  `title` varchar(30) NOT NULL,
		  `content` TEXT DEFAULT NULL,
		  `templateName` varchar(25) DEFAULT NULL,
		  `products` varchar(200) DEFAULT NULL,
		  PRIMARY KEY  (newsId)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql2 );

	}
}