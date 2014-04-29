<?= $this->Form->input( 'input'. $input ['id'], array(
    'type' => 'radio',
    'legend' => $input ['label'],
    'options' => array_combine( $input ['options'], $input ['options']),
)) ?>