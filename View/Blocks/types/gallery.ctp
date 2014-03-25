<div>
  <? if( $this->Inline->isModeEditor()): ?>
    <div class="sortable-move"><?= __d( 'admin', 'Mover')?></div>
    <?#= $this->Entry->buttonDelete( @$block) ?>
  <? endif ?>
  <?= $this->Entry->buttonDelete( @$block) ?>
  <h3><?= $block ['title'] ?></h3>
  <div id="flexslider_<?= $block ['id'] ?>" class="flexslider">
    <ul class="slides">
    <? foreach( $block ['photos'] as $photo): ?>  
        <li><?= $this->Asset->image( $photo, array(
            'size' => 'big'
        )) ?></li>
    <? endforeach ?>
    </ul>
  </div>
</div>

<? if( $this->Inline->isModeEditor()): ?>
  <a href="#/blocks/edit/<?= $block ['id'] ?>"><?= __d( "admin", "Editar") ?></a>
<? endif ?>
<? $this->append( 'scriptBottom') ?>
  <script type="text/javascript">
    $(function(){
      $('#flexslider_<?= $block ['id'] ?>').flexslider({
        animation: "slide"
      });
    })
  </script>
<? $this->end() ?>