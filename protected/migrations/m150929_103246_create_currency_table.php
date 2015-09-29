<?php

class m150929_103246_create_currency_table extends CDbMigration
{
	public function safeUp()
	{
		$this->getDbConnection()->createCommand(<<<SQL
			CREATE TABLE `currency` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`date` DATE NOT NULL,
				`num_code` SMALLINT(5) UNSIGNED NOT NULL,
				`char_code` CHAR(3) NOT NULL,
				`name_ru` VARCHAR(50) NULL DEFAULT NULL,
				`name_ua` VARCHAR(50) NULL DEFAULT NULL,
				`nominal_ru` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '1',
				`nominal_ua` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '1',
				`cost_rub` DECIMAL(10,4) NULL DEFAULT NULL,
				`cost_uah` DECIMAL(10,4) NULL DEFAULT NULL,
				`diff` DECIMAL(10,6) NULL DEFAULT NULL,
				PRIMARY KEY (`id`),
				UNIQUE INDEX `date_num_code` (`date`, `num_code`),
				INDEX `date` (`date`)
			)
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB
SQL
	)->execute();
//	) createTable('currency', array(
//			'id' => 'pk',
//			'date' => 'DATETIME NOT NULL',
//			'num_code' => 'SMALLINT(5) UNSIGNED NOT NULL',
//			'char_code' => 'CHAR(3) NOT NULL',
//			'name_ru' => 'VARCHAR(50) NULL DEFAULT NULL',
//			'name_ua' => 'VARCHAR(50) NULL DEFAULT NULL',
//			'cost_rub' => 'DECIMAL(10,4) NULL DEFAULT NULL',
//			'cost_uah' => 'DECIMAL(10,4) NULL DEFAULT NULL',
//			'diff' => 'DECIMAL(10,6) NOT NULL DEFAULT \'0\'',
//		));

		return true;
	}

	public function safeDown()
	{
		echo "m150929_103246_create_currency_table does not support migration down.\n";

		return true;
	}
}