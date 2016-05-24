<?php

namespace SS6\ShopBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use ShopSys\MigrationBundle\Component\Doctrine\Migrations\AbstractMigration;

class Version20160512152113 extends AbstractMigration {

	/**
	 * @param \Doctrine\DBAL\Schema\Schema $schema
	 */
	public function up(Schema $schema) {
		$this->sql(
			'CREATE TABLE countries (
				id SERIAL NOT NULL,
				name VARCHAR(255) NOT NULL,
				visible BOOLEAN NOT NULL,
				domain_id INT NOT NULL,
				PRIMARY KEY(id))'
		);
		$this->sql(
			'INSERT INTO countries (name, visible, domain_id) VALUES
			(\'Česká republika\', TRUE, 1),
			(\'Czech republic\', TRUE, 2)
			'
		);
		$czechRepublicCountryId = $this->sql('SELECT id FROM countries WHERE domain_id = 1')->fetchColumn();

		$this->sql('ALTER TABLE billing_addresses ADD COLUMN country_id INT DEFAULT NULL');
		$this->sql(
			'ALTER TABLE billing_addresses ADD CONSTRAINT FK_DBD91748F92F3E70 FOREIGN KEY (country_id)
			REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
		);
		$this->sql('CREATE INDEX IDX_DBD91748F92F3E70 ON billing_addresses (country_id)');
		$this->sql('ALTER TABLE delivery_addresses ADD country_id INT DEFAULT NULL');
		$this->sql(
			'ALTER TABLE delivery_addresses ADD CONSTRAINT FK_2BAF3984E76AA954 FOREIGN KEY (country_id)
			REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
		);
		$this->sql('CREATE INDEX IDX_2BAF3984F92F3E70 ON delivery_addresses (country_id)');

		$this->sql('ALTER TABLE orders ADD country_id INT NOT NULL DEFAULT ' . $czechRepublicCountryId);
		$this->sql('ALTER TABLE orders ALTER country_id DROP DEFAULT');

		$this->sql(
			'ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF92F3E70 FOREIGN KEY (country_id)
			REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
		);
		$this->sql('CREATE INDEX IDX_E52FFDEEF92F3E70 ON orders (country_id)');
		$this->sql('ALTER TABLE orders ADD delivery_country_id INT DEFAULT NULL');
		$this->sql(
			'ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE76AA954 FOREIGN KEY (delivery_country_id)
			REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->sql('CREATE INDEX IDX_E52FFDEEE76AA954 ON orders (delivery_country_id)');

		$this->sql('ALTER TABLE countries DROP visible');
	}

	/**
	 * @param \Doctrine\DBAL\Schema\Schema $schema
	 */
	public function down(Schema $schema) {

	}

}