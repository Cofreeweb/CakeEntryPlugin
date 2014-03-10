<h3><?= $entry ['Entry']['title'] ?></h3>

<?= $this->Entry->adminAdd() ?>
<a href="#blocks/add/<?= $entry ['Entry']['id'] ?>">Añadir bloque</a>

<div ng-controller="EntriesViewCtrl" class="blocks">
  <? foreach( $entry ['Block'] as $key => $block): ?>
    <div id="entry-block-<?= $block ['id'] ?>" class="inline-entry-block-sortable">
      <? if( $this->Auth->isEditor()): ?>
        <div class="sortable-move">Mover</div>
      <? endif ?>
      <?= $this->element( '../Blocks/types/'. $block ['type'], array(
          'block' => $block,
          'key' => $key
      )) ?>
    </div>
  <? endforeach ?>
</divt