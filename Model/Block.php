<?php
App::uses('EntryAppModel', 'Entry.Model');
/**
 * Block Model
 *
 * @property Entry $Entry
 */
class Block extends EntryAppModel 
{

  public $actsAs = array(
    // 'Upload.Uploadable',
    'Cofree.Sluggable' => array(
    		'fields' => array(
    		    'title',
    		),
    ),
	);
	
	public $belongsTo = array(
		'Entry' => array(
			'className' => 'Entry.Entry',
		)
	);
	
	public $hasMany = array( 
      'Photo' => array(
          'className' => 'Upload.Upload',
          'foreignKey' => 'content_id',
          'conditions' => array(
              'Photo.model' => 'Block',
              'Photo.content_type' => 'Block'
          )
      ),
  );
	
	public function beforeSave()
	{
	  if( empty( $this->id))
	  {
	    $this->data [$this->alias]['position'] = $this->__getPosition();
	  }
	  
	  return true;
	}
	
	private function __getPosition()
	{
	  $count = $this->find( 'count', array(
	    'conditions' => array(
	      $this->alias . '.entry_id' => $this->data [$this->alias]['entry_id'],
	    )
	  ));
	  
	  return ($count + 1);
	}
}
