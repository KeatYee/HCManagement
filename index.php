<!DOCTYPE html>
<html>
<head>
 <title>Notification using PHP Ajax Bootstrap</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

 <br /><br />

<div class="container">


  <form method="post" id="comment_form">

   <div class="form-group">
    <label>Enter Subject</label>
    <input type="text" name="subject" id="subject" class="form-control">
   </div>

   <div class="form-group">
    <label>Enter Comment</label>
    <textarea name="comment" id="comment" class="form-control" rows="5"></textarea>
   </div>

   <div class="form-group">
    <input type="submit" name="post" id="post" class="btn btn-info" value="Post" />
   </div>

  </form>

  <a href="notif.php"><button>CHECK NOTIF</button></a>
  <a href="homepage.php"><button>Homepage</button></a>


 </div>
 <script>

$(document).ready(function(){
// submit form and get new records

$('#comment_form').on('submit', function(event){
 event.preventDefault();

 if($('#subject').val() != '' && $('#comment').val() != ''){

  var form_data = $(this).serialize();

  $.ajax({

   url:"insert.php",
   method:"POST",
   data:form_data,
   success:function(data){
    $('#comment_form')[0].reset();
    load_unseen_notification();
   }

  });

 }
 else{
  alert("Both Fields are Required");
 }

});


});

</script>
</body>

</html>