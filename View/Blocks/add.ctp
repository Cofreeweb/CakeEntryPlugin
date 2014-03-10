<div ng-controller="BlocksAddCtrl">
  <? foreach( Configure::read( 'Block.types') as $type => $info): ?>
      <a href="#blocks/type/{{entry_id}}/<?= $info ['key'] ?>"><?= $info ['name'] ?></a>
  <? endforeach ?>
</div>