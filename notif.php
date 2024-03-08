<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Notifications</h2>
    <ul class="nav navbar-nav navbar-right">
     <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="label label-pill label-danger count" style="border-radius:10px;"></span> 
        <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span>
      </a>
      <ul class="dropdown-menu"></ul>
     </li>
    </ul>
</div>
<a href="index.php"><button>GO COMMENT</button></a>
<script>

$(document).ready(function(){

// updating the view with notifications using ajax

function load_unseen_notification(view = '')

{

 $.ajax({

  url:"fetch.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data)

  {

   $('.dropdown-menu').html(data.notification);

   if(data.unseen_notification > 0)
   {
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


</script>

</body>
</html>
