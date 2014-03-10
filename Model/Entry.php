<?php
App::uses('EntryAppModel', 'Entry.Model');
/**
 * Entry Model
 *
 */
class Entry extends EntryAppModel 
{
  public $actsAs = array(
		'Upload.Uploadable',
    'Cofree.Sluggable' => array(
    		'fields' => array(
    		    'title',
    		),
    ),
	);
  
  
  public $belongsTo = array(
      'Section' => array(
          'className' => 'Section.Section'
      )
  );
  
  public $hasMany = array(
      'Block' => array(
          'className' => 'Entry.Block',
          'order' => array(
              'Block.position'
          )
      )
  );
  
  public function createEntry( $section_id)
  {
    $section = $this->Section->find( 'first', array(
        'conditions' => array(
            'Section.id' => $section_id
        )
    ));
    
    $data = array(
        'section_id' => $section_id,
        'title' => $section ['Section']['title']
    );
    
    
    $this->create();
    return $this->save( $data);
  }
  
  public function getEntry( $section_id)
  {
    $entry = $this->find( 'first', array(
        'conditions' => array(
            'Entry.section_id' => $section_id
        ),
        'recursive' => 2,
        'contain' => array(
            'Block' => array(
                'Photo'
            ),
            'Section'
        )
    ));
    
    if( !$entry)
    {
      $this->createEntry( $section_id);
      $entry = $this->find( 'first', array(
          'conditions' => array(
              'Entry.section_id' => $section_id
          ),
          'recursive' => 2,
          'contain' => array(
              'Block' => array(
                  'Photo'
              ),
              'Section'
          )
      ));
      
      return $entry;
    }
    
    return $entry;
  }
}
