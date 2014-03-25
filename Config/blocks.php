<?php

/**
 * Tipos de bloque
 * 
 * @param 'key' El nombre único de key
 * @param 'name' El nombre humano del tipo de bloque
 * @param 'afterCreate' Que es lo que hace después de ser creado
 *          'render': añade el nuevo bloque directamente en la vista
 *          'edit': abre el cuadro de dialogo de edición
 */
 
$config ['Block']['types'] = array(
    'text' => array(
        'key' => 'text',
        'name' => __d( 'admin', 'Texto'),
        'afterCreate' => 'render'
    ),
    'gallery' => array(
        'key' => 'gallery',
        'name' => __d( 'admin', 'Galería de fotos'),
        'afterCreate' => 'edit'
    ),
    'video' => array(
        'key' => 'video',
        'name' => __d( 'admin', 'Video'),
        'afterCreate' => false
    ),
    'files' => array(
        'key' => 'files',
        'name' => __d( 'admin', 'Archivos'),
        'afterCreate' => false
    ),
);