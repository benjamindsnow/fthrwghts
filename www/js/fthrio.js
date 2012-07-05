var currentDirection;
$(document).keydown(function(e){
  switch(e.which){
    case 37:
      e.preventDefault();
      fthrio("l");
      break;
    case 38:
      e.preventDefault();
      fthrio("f");
      break;
    case 39:
      e.preventDefault();
      fthrio("r");
      break;
    case 40:
      e.preventDefault();
      fthrio("b");
      break;
    case 65:
      e.preventDefault();
      fthrio("ack");
      break;
    /*case 66:
      e.preventDefault();
      fthrio("x");
      break;*/
  }
});
$(document).keyup(function(e){if(e.which > 36 && e.which < 41)fthrio("s");});

function fthrio(req){
  if(currentDirection != req){
    $.post('fthrio.php', {'req': req},
      function(data){
        $('.alert').remove();
        if(data=='Connection refused')
          $('.span6').prepend("<div class='alert alert-error'><button class='close' data-dismiss='alert'>×</button><strong>Oh no!</strong> There's no answer from the Featherdome.</div>");
        else if(data=='ack')
          $('.span6').prepend("<div class='alert alert-success'><button class='close' data-dismiss='alert'>×</button><strong>Ack!</strong> Fthrio is online.</div>");
        currentDirection=req;
      });
  }
}
