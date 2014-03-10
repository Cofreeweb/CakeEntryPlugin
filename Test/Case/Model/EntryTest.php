<?php
App::uses('Entry', 'Entry.Model');

/**
 * Entry Test Case
 *
 */
class EntryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.entry.entry'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Entry = ClassRegistry::init('Entry.Entry');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Entry);

		parent::tearDown();
	}

}
