<?php

require_once('Configuration.php');


$limit = '5';

if (isset($_POST['page_no'])) {
	$page_no = $_POST['page_no'];
}else{
	$page_no = 1;
}

$offset = ($page_no-1) * $limit;

$query = "
SELECT course.course_name,course.course_description, department.department_name, professor.professor_name
FROM ((course
INNER JOIN department ON course.did = department.department_id)
INNER JOIN professor ON course.pid = professor.professor_id)
";

if($_POST['key'] != '')
{
  $key=$_POST['key'];
  $query .= "WHERE REPLACE(course.course_name , ' ', '') LIKE '%$key%' OR REPLACE(course.course_description, ' ', '') LIKE '%$key%' OR REPLACE(department.department_name, ' ', '') LIKE '%$key%' OR REPLACE(professor.professor_name, ' ', '') LIKE '%$key%'";
}



$filter_query = $query . 'LIMIT '.$offset.', '.$limit.'';

$result = mysqli_query($conn, $filter_query);
$output = "";

if (mysqli_num_rows($result) > 0) {

	$output.="<table class='fixing'class='table table-dark'>
		    <thead>
		        <tr>
		       <th>Course Name</th>
    	       <th>Course Description</th>
			   <th>Department Name</th>
			   <th>Professor Name</th>
	            </tr>
		    </thead>
	         <tbody>";
	while ($row = mysqli_fetch_assoc($result)) {
        
      
	    $output.="<tr>
	            <td>{$row['course_name']}</td>
	            <td>{$row['course_description']}</td>
	            <td>{$row['department_name']} </td>
	            <td>{$row['professor_name']}</td>
		 </tr>";
	} 
	$output.='</tbody>
		</table>
		<br/>';
		/////////////////////////////////////////////////////////////////////////////



$records = mysqli_query($conn, $query);

$totalRecords = mysqli_num_rows($records);
			

$total_links = ceil($totalRecords/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';



$output.="<ul class='pagination justify-content-center' style='margin:20px 0'>";

 

for ($i=1; $i <= $total_links ; $i++) { 
   if ($i == $page_no) {
	$active = "active";

	$previous_id = $page_no - 1;
    if($previous_id > 0)
    {
      $previous_link = "<p class='page-item' style='display: inline-block'><a class='page-link'  id='$previous_id' href=''>Prev.</a></p>";
    }
    else
    {
      $previous_link = "<p class='page-item disabled' style='display: inline-block'><a >Prev.</a></p>";
	}
	
	$next_id = $page_no + 1;
    if($next_id <= $total_links)
    {
		
		$next_link = "<p class='page-item' style='display: inline-block'><a class='page-link' id='$next_id' href=''>Next</a></p>";
    }
    else
    {
		$next_link = "<p class='page-item disabled' style='display: inline-block'><a id='$next_id' >Next</a></p>";
		
    }
   }
   else{
	$active = "";
   }

	$page_link.="<p class='page-item $active' style='display: inline-block'><a class='page-link' id='$i' href=''>$i</a></p>";
}
$output .= $previous_link . $page_link . $next_link;
$output .= "</ul>";

echo $output;
}

?>