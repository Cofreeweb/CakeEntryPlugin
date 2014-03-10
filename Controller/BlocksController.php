<?php
App::uses('EntryAppController', 'Entry.Controller');
/**
 * Blocks Controller
 *
 */
class BlocksController extends EntryAppController 
{
  
  public $uses = array( 'Entry.Block');

  public function beforeFilter()
  {
    parent::beforeFilter();
    $this->Auth->allow();
  }
  
  public function admin_edit()
  {
    if( $this->request->is( 'post', 'put'))
    {
      $this->Block->create();
      
      if( $this->Block->save( $this->request->data))
      {
        $this->set( 'success', true);
        $this->set( '_serialize', array( 'success'));
      }
    }
  }
  
  public function rest_add()
  {
    $data = array(
        'entry_id' => $this->request->data ['entry_id'],
        'type' => $this->request->data ['type'],
    );
    
    $this->Block->create();
    $this->Block->save( $data);
    
    $block = $this->Block->findById( $this->Block->id);    
    
    $count = $this->Block->find( 'count', array(
        'conditions' => array(
            'Block.entry_id' => $this->request->data ['entry_id'],
        )
    ));
    
    $block ['Block']['key'] = ($count - 1);
    
    $block = array(
        'id' => (int)$block ['Block']['id'],
        'body' => 'leches',
        'key' => $block ['Block']['key']
    );
    
    // $block = array(
    //     'id' => 4,
    //     'body' => 'hostia',
    //     'key' => 3
    // );
    
    $this->set( array(
        'success' => true,
        'block' => $block,
        '_serialize' => array( 'success', 'block')
    ));
  }
  
  public function rest_edit( $id)
  {
    $block = $this->Block->find( 'first', array(
        'conditions' => array(
            'Block.id' => $id
        )
    ));
    
    $this->set( array( 'block' => $block, '_serialize' => array( 'block')));
  }
  
  public function rest_field()
  {
    $data = $this->request->data;
    
    if( !isset( $data ['id']) || !isset( $data ['field']) || !isset( $data ['value']))
    {
      $success = false;
    }
    else
    {
      $this->Block->id = $data ['id'];
      $this->Block->saveField( $data ['field'], $data ['value']);
      $success = true;
    }
    
    $this->set( array(
        'success' => $success,
        '_serialize' => array(
            'success'
        )
    ));
  }
  
  
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
}
