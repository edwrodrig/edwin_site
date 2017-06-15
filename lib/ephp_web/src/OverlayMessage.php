<?php
namespace ephp\web;

class OverlayMessage extends Overlay {

public $message;
public $done;

function __construct(...$args) {
  parent::__construct([style(['align' => 'center'])]);
  $this->message = tag('#', ...$args);
  $this->done = tag('#', ...$args);
}

function js_set_message($message) {
?>
(function() {
 <?=$this->js_open()?>;
 var message = document.getElementById('<?=$this->message->id?>');
 var done = document.getElementById('<?=$this->done->id?>');
 message.style.display = 'block';
 done.style.display = 'none';
 message.innerHTML = '<?=$message?>';
})()
<?php
}

function js_set_done_message($message) {?>
(function() {
 var message = document.getElementById('<?=$this->message->id?>');
 var done = document.getElementById('<?=$this->done->id?>');
 message.style.display = 'none';
 done.style.display = 'block';
 done.innerHTML = <?=$message?>;
})()
<?php
}

function body($content = '') {
  $this->message->open();
  $this->message->close();
  $this->done->open();
  $this->done->close();
?>
<script>
document.getElementById('<?=$this->done->id?>').addEventListener('click', function() {
  <?=$this->js_close()?>;
});
</script>
<?php
}

}


