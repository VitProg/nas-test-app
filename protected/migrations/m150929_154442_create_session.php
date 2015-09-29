<?php

class m150929_154442_create_session extends CDbMigration
{
/*
	public function up()
	{
	}

	public function down()
	{
		echo "m150929_154442_create_session does not support migration down.\n";
		return false;
	}
*/
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->getDbConnection()->createCommand(<<<SQL
			CREATE TABLE session (
			   id CHAR(32) PRIMARY KEY,
			   expire INTEGER,
			   data TEXT 
			)
SQL
		)->execute();
	}

	public function safeDown()
	{
	}
}