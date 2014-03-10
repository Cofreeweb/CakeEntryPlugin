<div ckeditor data-url="/rest/entry/blocks/field.json" data-field="body" data-id="<?= $this->Seter->val( @$block ['id'], 'block.id') ?>" ng-model="<?= isset( $key) ? 'entry.Block.'. $key .'.body' : 'entry.Block[block.key].body' ?>">
  <?= $this->Seter->val( @$block ['body'], 'block.body') ?>
</div>