
$(document).ready(function(){

// updating the view with notifications using ajax

function load_unseen_notification(view = ''){

 $.ajax({

  url:"fetchData.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data){

   $('.dropdown-menu').html(data.notification);

   if(data.unseen_notification > 0){
    $('.count').html(data.unseen_notification);
   }

  }

 });

}

load_unseen_notification();
// load new notifications

$(document).on('click', '.dropdown-toggle', function(){

$('.count').html('');
load_unseen_notification('yes');

});

setInterval(function(){
  load_unseen_notification();;
}, 5000);

});
