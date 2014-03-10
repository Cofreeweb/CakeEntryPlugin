<form ng-submit="submitBlock( 'edit')" name="EntryForm">
  <label>Título</label>
  <?= $this->Form->input( 'Block.title', array(
      'ng-model' => 'block.Block.title',
      'label' => 'Título'
  )) ?>
  <input type="submit" value="Guardar" />
</form>

<div upload-gallery uploaded-files-model="modelName" upload-destination="/upload/uploads/multiple.json?model=Block&content_id={{block.Block.id}}&key=block&alias=Photo" upload-extensions="jpg,gif,png"></div>


<ul>
  <li id="upload_{{asset.id}}" ng-repeat="asset in block.Photo">
    <img src="{{asset.paths.thm}}" />
    <a data-rel="#upload_{{asset.id}}" data-filename="asset.filename" data-model="{{asset.model}}" data-id="{{asset.id}}" data-delete-once="true" data-alert="<?= __d( "admin", "¿Estás seguro?") ?>" class="upload-delete" ng-click="deleteUpload( this)"><?= __d( 'admin', 'Borrar') ?></a>
  </li>
</ul>