<form ng-submit="submitBlock()" name="EntryForm">
  <?= $this->Form->input( 'Block.title', array(
      'ng-model' => 'block.title',
      'label' => 'Título'
  )) ?>
  
  <div upload-gallery upload-scope="block.uploads" uploaded-files-model="modelName" upload-destination="/entry/entries/upload.json?model=Block&content_id={{ block.id }}&key=document&alias=Photo" upload-extensions="doc,docx,pdf,xls,xlsx,jpg,jpeg,png,gif"></div>


  <ul ui-sortable ng-model="block.uploads">
    <li id="upload_{{ asset.id }}" ng-repeat="asset in block.uploads">
      <p>{{ asset.filename }}</p>
      <input type="text" ng-model="block.uploads[$index].title" />
      <span delete-content delete-scope="block.uploads" delete-scope-index="{{$index}}" data-header="<?= __d( "admin", "¿Estás seguro de que quieres borrar este archivo?") ?>" data-remove="#upload_{{ asset.id }}" flexslider="#flexslider_{{ block.id }}" data-id="{{ asset.id }}"><?= __d( 'admin', 'Borrar') ?></span>
    </li>
  </ul>
  <?= $this->Form->submit( __d( 'admin', 'Guardar')) ?>
</form>
<!-- <pre style="font-size: 9px">{{ block.uploads | json }}</pre> -->