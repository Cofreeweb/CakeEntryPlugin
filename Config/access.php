<?php

$config ['Access'] = array(
    'entry' => array(
      'name' => __d( 'admin', 'Páginas'),
      'urls' => array(
          array(
                'admin' => true,
                'plugin' => 'entry',
                'controller' => 'blocks',
                'action' => 'edit'
          ),
          array(
                'plugin' => 'entry',
                'controller' => 'entries',
                'action' => 'edit'
          ),
          array(
                'plugin' => 'entry',
                'controller' => 'entries',
                'action' => 'published'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'entries',
              'action' => 'orderblocks'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'add'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'edit'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'delete'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'field'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'view'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'addrow'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'blocks',
              'action' => 'resize'
          ),
      ),
      'front' => array(
          array(
              'plugin' => 'entry',
              'controller' => 'entries',
              'action' => 'view'
          ),
          array(
              'plugin' => 'entry',
              'controller' => 'entries',
              'action' => 'edit'
          )
      ),
      'adminLinks' => array(
          'noEdit' => array(
              array(
                  'label' => __d( 'admin', 'Editar página'),
                  'url' => array(
                      'plugin' => 'entry',
                      'controller' => 'entries',
                      'action' => 'edit',
                      'edit' => true
                  )
              )
          ),
          'editMode' => array(
              array(
                  'label' => __d( 'admin', 'Publicar cambios'),
                  'url' => array(
                      'plugin' => 'entry',
                      'controller' => 'entries',
                      'action' => 'published',
                      'published' => true,
                      'edit' => false
                  )
              ),
              array(
                  'label' => __d( 'admin', 'Descartar cambios'),
                  'url' => array(
                      'plugin' => 'entry',
                      'controller' => 'entries',
                      'action' => 'discard',
                      'discard' => true,
                      'edit' => false
                  )
              ),

          )
      )
    )
);
