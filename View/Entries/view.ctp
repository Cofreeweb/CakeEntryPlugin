<?
/**
 * Vista de la entrada
 * 
 * @partials 
 *    Entries/_row.ctp
 *    Blocks/types/*
 *
 * @ids
 *    entry-row-:row_id
 *
 * @package Entry.Entries.View
 */
?>
<?= $this->Entry->addRow( $entry) ?>

<div class="rows">
  <div class="blocks">
  <? foreach( $entry ['Entry']['rows'] as $row_key => $row): ?>
      <div id="entry-row-<?= $row ['id'] ?>" data-id="<?= $row ['id'] ?>" class="row inline-entry-row-sortable">
        <?= $this->element( '../Entries/_row', array(
            'row' => $row,
            'row_key' => $row_key
        ))?>
      </div>
  <? endforeach ?>
  </div>
</div>