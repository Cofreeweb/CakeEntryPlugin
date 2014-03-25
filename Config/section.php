<?php

/**
 * La configuración de los tipos de secciones que habrá en este plugin
 *
 */
$config ['SectionSettings'] = array(
    'name' => 'Páginas',
    'url' => array(
        'plugin' => 'entry',
        'controller' => 'entries',
        'action' => 'view'
    ),
    'admin' => array(
        array(
            'plugin' => 'entry',
            'controller' => 'entries',
            'action' => 'edit'
        ),
        array(
            'plugin' => 'entry',
            'controller' => 'entries',
            'action' => 'published',
            'edit' => false
        ),
        array(
            'plugin' => 'entry',
            'controller' => 'entries',
            'action' => 'discard',
            'edit' => false
        )
    ),
    'settings' => array(
        
    )
);