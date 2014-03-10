<?php 

class EntrySchema extends CakeSchema {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Entry';

/**
 * Before callback
 *
 * @param string Event
 * @return boolean
 */
	public function before($event = array()) {
		return true;
	}

/**
 * After callback
 *
 * @param string Event
 * @return boolean
 */
	public function after($event = array()) {
		return true;
	}

/**
 * Schema for taggeds table
 *
 * @var array
 */
	public $entries = array(
		'id' => array('type' =>'integer', 'null' => false, 'key' => 'primary'),
		'section_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'antetitle' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'subtitle' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => null, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'comment_count' => array('type' =>'integer', 'null' => true, 'default' => 0),
		'published_at' => array('type' =>'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' =>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'active' => array('column' => 'active', 'unique' => 0),
			'section_id' => array('column' => 'active', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 1),
		)
	);
	
	public $blocks = array(
		'id' => array('type' =>'integer', 'null' => false, 'key' => 'primary'),
		'entry_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'type' => array('type' => 'string', 'length' => 20, 'null' => true, 'default' => NULL, 'key' => 'index'),
		'position' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'antetitle' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'subtitle' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => null, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' =>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'active' => array('column' => 'active', 'unique' => 0),
			'entry_id' => array('column' => 'entry_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'type' => array('column' => 'type', 'unique' => 0),
			'position' => array('column' => 'position', 'unique' => 0),
		)
	);
	
	

}
