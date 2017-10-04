<?php

namespace App\Models;

use Core\Model;

class Post extends Model
{

	/**
	 * Calling parent constructor for database connection and 
	 * creating posts table if doesn't exist
	 * 
	 * @param array $options database connection details
	 */
	public function __construct()
	{
		parent::__construct();
		$this->initPostsTable();
	}


	/**
	 * Creates the posts table if doesn't exists
	 * 
	 * @return void
	 */
	public function initPostsTable()
	{
		$sql = "
			CREATE TABLE IF NOT EXISTS posts
			(
				id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
				title VARCHAR(100),
				content TEXT,
				created_at DATETIME,
				updated_at DATETIME

			) ENGINE INNODB CHARACTER SET utf8
		";

		$this->execute($sql);
	}
}