<div>
  <? if( $this->Inline->isModeEditor()): ?>
    <div class="sortable-move"><?= __d( 'admin', 'Mover')?></div>
  <? endif ?>
  <h3><?= $block ['title'] ?></h3>

  <? foreach( $block ['form'] as $input): ?>
      <?= $this->element( '../Blocks/types/form/'. $input ['component'], array(
          'input' => $input
      )) ?>
  <? endforeach ?>
</div>

<? if( $this->Inline->isModeEditor()): ?>
  <a href="#/blocks/edit/<?= $block ['id'] ?>"><?= __d( "admin", "Editar") ?></a>
<? endif ?>