<? if( $this->Inline->isModeEditor()): ?>
  <div class="sortable-move"><?= __d( 'admin', 'Mover')?></div>
  <?#= $this->Entry->buttonDeleteBlock( @$block) ?>
<? endif ?>
<div <?= $this->Inline->isModeEditor() ? 'ckeditor' : '' ?> data-url="/entry/blocks/field.json" data-field="body" data-id="<?= $this->Seter->val( @$block ['id'], 'block.id') ?>" ng-model="<?= isset( $block_key) ? 'entry.Entry.rows.'. $row_key .'.blocks.'. $block_key .'.body' : 'entry.Entry.rows[block.row_key].blocks[block.key].body' ?>">
  <?= $this->Seter->val( @$block ['body'], 'block.body') ?>
</div>