<!DOCTYPE html>
<style>
<?php include 'mainStyle.css'; ?>
</style>
<html>
<header>
    <meta charset="utf-8">
    <title>Main Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
</header>

<body>

    <div class="wrap">
        <div class="search">
            <input id="key" type="text" class="searchTerm" placeholder="What are you looking for?">
            <button type="submit" class="searchButton"disabled>
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive" id="courses">

            </div>




 <script type="text/javascript"> //
  $(document).ready(function(){ //
    loadData();                 //
    function loadData(page, key=''){ //
      $.ajax({
        url  : "Search.php",
        type : "POST",
        cache: false,
        data : {page_no:page , key:key},
        success:function(response){
          $("#courses").html(response);
        }
      });
    }  
    // Pagination code
    $(document).on("click", ".page-link", function(e){
      e.preventDefault();
      var pageId = $(this).attr("id");
      var key = $('#key').val();
      loadData(pageId,key);
    });

    $("#key").keyup(function(){
      var key =$('#key').val();
     // console.log(key);
        if(key.length>=3){
          loadData(1, key);
        }
        else if(key==""){
          loadData()
        }
    });
  });
</script>


</body>



</html>

