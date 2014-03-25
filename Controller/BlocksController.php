<?php
App::uses('EntryAppController', 'Entry.Controller');
/**
 * Blocks Controller
 *
 */
class BlocksController extends EntryAppController 
{
  
  public $uses = array( 'Entry.Entry');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }
  
  public function admin_edit()
  {
    if( $this->request->is( 'post', 'put'))
    {
      if( isset( $this->request->data ['photos']))
      {
        unset( $this->request->data ['photos']);
      }
      
      $this->Entry->updateSubdocument( 'rows.blocks', $this->request->data ['id'], $this->request->data, array(
          'revision' => 'draft'
      ));
      
      $this->set( 'success', true);
      $this->set( '_serialize', array( 'success'));
    }
  }
  
  public function addrow()
  {
    $row_id = $this->Entry->addSubdocument( array(
        'blocks' => array()
    ), array(
        'id' => $this->request->data ['entry_id'],
        'path' => 'rows'
    ));
    
    $this->set( array(
        'row_id' => $row_id,
        '_serialize' => array( 'row_id')
    ));
  }
  
  public function add()
  {
    $data = array(
        'type' => $this->request->data ['type'],
    );
    
    $data = $this->Entry->setBlockDefaults( $data);
    
    $block_id = $this->Entry->addSubdocument( $data, array(
        'id' => $this->request->data ['row_id'],
        'path' => 'rows.blocks'
    ));
    
    $entry = $this->Entry->findSubdocumentById( 'Entry.rows', $this->request->data ['row_id'], 'draft');
    $count = count( $entry ['document']['Entry']['rows']['blocks']);
    
    $block = array(
        'id' => $block_id,
        'key' => ($count - 1),
        'row_key' => $entry ['path']['rows']
    );
    
    $after = Configure::read( 'Block.types.'. $this->request->data ['type'] . '.afterCreate');
    
    $this->set( array(
        'success' => true,
        'afterCreate' => $after,
        'block' => array_merge( $data, $block),
        '_serialize' => array( 'success', 'block', 'render', 'afterCreate')
    ));
  }
  
  public function edit( $id)
  {
    $entry = $this->Entry->find( 'first', array(
        'conditions' => array(
            'Entry.rows.blocks.id' => new MongoId( $id)
        ),
        'revision' => 'draft'
    ));
    $entry = $this->Entry->findSubdocumentById( 'Entry.rows.blocks', $id, 'draft');

    $this->set( array( 'block' => $entry ['subdocument'], '_serialize' => array( 'block')));
  }
  
  public function delete( $id)
  {
    $this->Entry->deleteSubdocument( 'rows.blocks', $id);
    
    $this->set( array(
        'success' => true,
        '_serialize' => array( 'success')
    ));
  }
  
  public function field()
  {
    $data = $this->request->data;
    
    if( !isset( $data ['id']) || !isset( $data ['field']) || !isset( $data ['value']))
    {
      $success = false;
    }
    else
    {
      $this->Entry->updateSubdocument( 'rows.blocks', $data ['id'], array(
          $data ['field'] => $data ['value'],
      ), array(
          'revision' => 'draft'
      ));

      $success = true;
    }
    
    $this->set( array(
        'success' => $success,
        '_serialize' => array(
            'success'
        )
    ));
  }
  
/**
 * Renderiza los bloques por AJAX.
 * Es usado tan solo en la edición con el objetivo de mostrar los cambios en tiempo real
 *
 * @param string $id 
 * @return void
 */
  public function view( $id)
  {
    $this->layout = 'ajax';
    $_block = $this->Block->find( 'first', array(
        'conditions' => array(
            'Block.id' => $id
        )
    ));

    $block = $_block ['Block'];
    $block ['Photo'] = $_block ['Photo'];
    
    $this->set( compact( 'block'));
    $this->render( 'Blocks/types/'. $block ['type']);
  }
  
  
  public function resize()
  {
    $this->Entry->updateSubdocument( 'rows.blocks', $this->request->data ['id'], array(
        'cols' => $this->request->data ['value']
    ), array(
        'revision' => 'draft'
    ));
    
    $this->set( array(
        'success' => true,
        '_serialize' => array(
            'success'
        )
    ));  
    
  }
}
