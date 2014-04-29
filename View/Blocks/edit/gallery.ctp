<form ng-submit="submitBlock()" name="EntryForm">
  <?= $this->Form->input( 'Block.title', array(
      'ng-model' => 'block.title',
      'label' => 'Título'
  )) ?>


  <div upload-gallery upload-scope="block.uploads" uploaded-files-model="modelName" upload-destination="/entry/entries/upload.json?model=Block&content_id={{block.id}}&key=gallery&alias=Photo" upload-extensions="jpg,jpeg,gif,png"></div>

  <ul ui-sortable ng-model="block.uploads">
    <li id="upload_{{ asset.id }}" ng-repeat="asset in block.uploads">
      <img src="{{ asset.paths.thm }}" />
      <input type="text" ng-model="block.uploads[$index].title" />
      <span delete-content delete-scope="block.uploads" delete-scope-index="{{$index}}" data-header="<?= __d( "admin", "¿Estás seguro de que quieres borrar esta foto?") ?>" data-remove="#upload_{{ asset.id }}" flexslider="#flexslider_{{ block.id }}" data-id="{{ asset.id }}"><?= __d( 'admin', 'Borrar') ?></span>
    </li>
  </ul>

  <?= $this->Form->submit( __d( 'admin', 'Guardar'))?>
</form>
<!-- <pre style="font-size: 9px">{{ block.uploads | json }}</pre> -->