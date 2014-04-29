<form ng-submit="submitForm()" name="EntryForm">
  <div class="">
    <h1><?= __d( 'admin', "Edición de formulario")?></h1>
    <hr/>

    <div class="col-md-6">
        <div class="panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $this->Form->input( 'Block.title', array(
                    'ng-model' => 'block.title',
                    'label' => 'Título'
                )) ?></h3>
                
                <?= $this->Form->input( 'Block.email', array(
                    'ng-model' => 'block.email',
                    'label' => 'Email'
                )) ?>
            </div>
            <div fb-builder="default"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div fb-components></div>
    </div>
  </div>

  <?= $this->Form->submit( __d( 'admin', 'Guardar')) ?>
</form>

<pre style="font-size: 8px">{{ form | json }}</pre>