<?php
App::uses('CakeEventListener', 'Event');

class EntryEvents extends Object implements CakeEventListener
{
  public function implementedEvents()
  {
    return array(
      'Section.Controller.Sections.create.Entry' => array(
        'callable' => 'afterCreateSection',
      ),
    );
  }

/**
 * Llamado después de la creación de una sección
 * Crea el entry vinculandolo a la sección y setea en el controller la url de la nueva sección creada
 *
 * @param object $event 
 * @return void
 */
  public function afterCreateSection( $event)
  {
    $controller = $event->subject();
    $Entry = ClassRegistry::init( 'Entry.Entry');
    
    if( $Entry->createEntry( $controller->Section->id))
    {
      $sections = ClassRegistry::init( 'Section.Section')->find( 'threaded', array(
          'recursive' => -1,
      ));

      Routable::nestedRoutes( $sections);
      Router::reload();
      $controller->set( 'redirect', Sections::url( $controller->Section->id, true));
    }
  }
}



?>