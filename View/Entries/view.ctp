<?= $this->Entry->addRow( $entry) ?>

<div class="rows">
  <div class="blocks">
  <? foreach( $entry ['Entry']['rows'] as $row_key => $row): ?>
      <div id="entry-row-<?= $row ['id'] ?>" data-id="<?= $row ['id'] ?>" class="row inline-entry-row-sortable">
        <? if( $this->Inline->isModeEditor()): ?>
          <div class="sortable-move-row"><?= __d( 'admin', 'Mover fila')?></div>
          
        <? endif ?>
        <div class="row-group">
        <?= $this->Entry->addBlock( $row ['id']) ?>
        
        <? foreach( $row ['blocks'] as $block_key => $block): ?>
          <div <?= $this->Inline->isModeEditor() ? 'column-resize="'. $block ['cols'] .'"' : '' ?> data-text-decrease="<?= __d( "admin", 'Disminuir') ?>" data-text-increase="<?= __d( "admin", 'Ampliar') ?>" data-id="<?= $block ['id'] ?>" id="entry-block-<?= $block ['id'] ?>" class="col-<?= $block ['cols'] ?> block connected-sortable inline-entry-block-sortable">
            <?= $this->Entry->buttonDelete( @$block) ?>
            <?= $this->element( '../Blocks/types/'. $block ['type'], array(
                'row' => $row,
                'block' => $block,
                'row_key' => $row_key,
                'block_key' => $block_key
            )) ?>
          </div>
        <? endforeach ?>
        </div>
      </div>
  <? endforeach ?>
  </div>
</div>