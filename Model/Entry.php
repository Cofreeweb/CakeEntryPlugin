<?php
App::uses('EntryAppModel', 'Entry.Model');
/**
 * Entry Model
 *
 */
class Entry extends EntryAppModel 
{
  public $useDbConfig = 'mongo';
  
  public $actsAs = array(
		'Upload.Uploadable',
    'Cofree.Deletable',
    'Mongodb.Schemaless',
    'Mongodb.SqlCompatible',
    'Mongodb.Revision',
    'Mongodb.Sortable' => array(
        'rows',
        'rows.blocks'
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
  
  
  
  public $mongoSchema = array(
    'title' => array('type' =>'string'),
    'section_id' => array( 'type' =>'integer'),
    'user_id' => array( 'type' =>'integer'),
    'rows' => array(
        'sort' => array( 'type' => 'integer', 'default' => 0),
        'blocks' => array(
            'type' => array('type' => 'string', 'default' => NULL),
            'title' => array( 'type' => 'string', 'default' => null),
            'body' => array( 'type' => 'text', 'default' => null),
            'sort' => array( 'type' => 'integer', 'default' => 0),
            'cols' => array( 'type' => 'integer', 'default' => 6),
            'emails' => array('type' => 'string', 'default' => NULL),
            'form' => array( 'type' => 'text', 'default' => null),
            'uploads' => array(
                'filename' => array( 'type' => 'string'),
                'path' => array( 'type' => 'string'),
                'extension' => array('type' => 'string', 'default' => NULL),
            		'mimetype' => array('type' => 'string', 'default' => NULL),
            		'duration' => array('type' => 'string', 'default' => NULL),
            		'title' => array('type' => 'string', 'default' => NULL),
            		'subtitle' => array('type' => 'string', 'default' => NULL),
            		'text' => array('type' => 'text', 'default' => NULL),
            )
        ),
    ),
    'deleted' => array( 'type' =>'boolean', 'default' => 0),
    'removed' => array( 'type' =>'boolean', 'default' => 0),
    'created' => array( 'type' =>'datetime'),
    'modified' => array( 'type' =>'datetime'),
  );

/**
 * Los valores por defecto por tipo de bloque
 *
 * @var array
 */
  private $__defaultBlocksData = array(
      'text' => array(
          'body' => '<h1>Un título para el bloque</h1><p>Un texto base para el bloque</p>',
      ),
      'gallery' => array(
          'title' => 'Un título para la galería',
          'uploads' => array()
      ),
      'files' => array(
          'title' => 'Un título para la galería',
          'uploads' => array()
      ),
      'form' => array(
          'body' => array(),
      )
  );
  
/**
 * Crea una entrada dado el id de la sección
 *
 * @param string $section_id 
 * @return void
 */
  public function createEntry( $section_id)
  {
    $section = $this->Section->find( 'first', array(
        'conditions' => array(
            'Section.id' => $section_id
        )
    ));
    
    $data = array(
        'section_id' => $section_id,
        'rows' => array(
            array(
                'id' => new MongoId(),
                'sort' => 1,
                'blocks' => array(
                    $this->putDefaults( $this->setBlockDefaults( array(
                        'id' => new MongoId(),
                        'type' => 'text'
                    )), 'rows.blocks')
                )
            )
        )
    );
    
    $this->create();
    return $this->save( $data, array(
        'revision' => 'draft'
    ));
  }
  
  public function getEntry( $section_id, $revision)
  {
    $entry = $this->find( 'first', array(
        'conditions' => array(
            'Entry.section_id' => $section_id
        ),
        'revision' => $revision
    ));
    
    if( !$entry && $revision == 'draft')
    {
      $this->createEntry( $section_id);
      $entry = $this->find( 'first', array(
          'conditions' => array(
              'Entry.section_id' => (int)$section_id
          ),
          'revision' => $revision
      ));
      return $entry;
    }
    elseif( !$entry)
    {
      return false;
    }
    
    return $entry;
  }
  
/**
 * Setea los valores por defecto según el tipo de bloque
 *
 * @param array $data 
 * @return array
 * @example $this->Entry->setBlockDefaults( $data)
 */
  public function setBlockDefaults( $data)
  {
    return array_merge( $this->__defaultBlocksData [$data ['type']], $data);
  }
  
  public function createBlock( $entry_id)
  {
    $entry = $this->find( 'first', array(
        'conditions' => array(
            'Entry.id' => $this->request->data ['entry_id']
        ),
        'revision' => 'draft'
    ));
  }
  
  public function findBlock( $id, $revision = 'published')
  {
    $block = $this->findSubdocumentById( 'Entry.rows.blocks', $id, $revision);
    return $block ['subdocument'];
  }
}
