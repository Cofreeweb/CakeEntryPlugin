<div>
  <h3><?= $block ['title'] ?></h3>
  <div id="flexslider_<?= $block ['id'] ?>" class="flexslider" style="width: 200px">
    <ul class="slides">
    <? foreach( $block ['Photo'] as $photo): ?>  
        <li><?= $this->Asset->image( $photo, array(
            'size' => 'big'
        )) ?></li>
    <? endforeach ?>
    </ul>
  </div>
</div>
<a href="#/blocks/edit/<?= $block ['id'] ?>"><?= __d( "admin", "Editar") ?></a>

<? $this->append( 'scriptBottom') ?>
  <script type="text/javascript">
    $(function(){
      $('#flexslider_<?= $block ['id'] ?>').flexslider({
        animation: "slide"
      });
    })
  </script>
<? $this->end() ?>