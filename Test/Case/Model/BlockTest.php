<?php
App::uses('Block', 'Entry.Model');

/**
 * Block Test Case
 *
 */
class BlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.entry.block',
		'plugin.entry.entry'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Block = ClassRegistry::init('Entry.Block');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Block);

		parent::tearDown();
	}

}
