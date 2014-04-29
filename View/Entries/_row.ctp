<?
/**
 * Partial de la fila (row) de una entrada
 *
 * @package Entry.Entries.View
 */
?>
<? if( $this->Inline->isModeEditor()): ?>
    <? $row_id = isset( $row_id) ? $row_id : $row ['id'] ?>
    <div class="sortable-move-row"><?= __d( 'admin', 'Mover fila') ?></div>
    <?= $this->Entry->buttonDeleteRow( $row_id) ?>
<? endif ?>

<div class="row-group">
  <? if( $this->Inline->isModeEditor()): ?>
      
      <?= $this->Entry->addBlock( $row_id) ?>
  <? endif ?>

<? if( isset( $row ['blocks'])): ?>
    <? foreach( $row ['blocks'] as $block_key => $block): ?>
      <div <?= $this->Inline->isModeEditor() ? 'column-resize="'. $block ['cols'] .'"' : '' ?> data-text-decrease="<?= __d( "admin", 'Disminuir') ?>" data-text-increase="<?= __d( "admin", 'Ampliar') ?>" data-id="<?= $block ['id'] ?>" id="entry-block-<?= $block ['id'] ?>" class="col-<?= $block ['cols'] ?> block connected-sortable inline-entry-block-sortable">
        <?= $this->Entry->buttonDeleteBlock( @$block) ?>
        <?= $this->element( '../Blocks/types/'. $block ['type'], array(
            'row' => $row,
            'block' => $block,
            'row_key' => $row_key,
            'block_key' => $block_key
        )) ?>
      </div>
    <? endforeach ?>
<? endif ?>
</div>