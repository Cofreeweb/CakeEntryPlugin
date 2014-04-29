<?php

Router::connect( '/entry/entries/block/*', array(
  'plugin' => 'entry',
  'controller' => 'entries', 
  'action' => 'block',
  'edit' => true
));