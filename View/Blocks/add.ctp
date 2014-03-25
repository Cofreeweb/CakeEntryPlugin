<div>
  <? foreach( Configure::read( 'Block.types') as $type => $info): ?>
      <a href="#/blocks/type/{{row_id}}/<?= $info ['key'] ?>"><?= $info ['name'] ?></a>
  <? endforeach ?>
</div>