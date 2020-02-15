<?php

include 'connection.php';

if (isset($_POST['submit'])){

    $date = ($_POST['date']);
    $input1 = ($_POST['input1']);
    $input2 = ($_POST['input2']);
    $input3 = ($_POST['input3']);

    $input11 =  mysqli_query($connection,"SELECT input1 FROM vertical_data ORDER BY id DESC LIMIT 1");
    while ($row = $input11->fetch_assoc()){
        $input1_last = $row['input1'];
        echo $input1_last;
        } 
    
    $input22 = mysqli_query($connection,"SELECT input2 FROM vertical_data ORDER BY id DESC LIMIT 1");
    while ($row = $input22->fetch_assoc()){
        $input2_last = $row['input2'];
        echo $input2_last;
        }
    $input33 = mysqli_query($connection,"SELECT input3 FROM vertical_data ORDER BY id DESC LIMIT 1");
    while ($row = $input33->fetch_assoc()){
        $input3_last = $row['input3'];
        echo $input3_last;
    }
    
    $input11_first = mysqli_query($connection,"SELECT input1 FROM vertical_data LIMIT 1");
    while ($row = $input11_first->fetch_assoc()){
        $input1_first = $row['input1'];
        echo $input1_first;
    }

    $input22_first = mysqli_query($connection,"SELECT input2 FROM vertical_data LIMIT 1");
    while ($row = $input22_first->fetch_assoc()){
        $input2_first = $row['input2'];
        echo $input2_first;
    }

    $input33_first = mysqli_query($connection,"SELECT input3 FROM vertical_data LIMIT 1");
    while ($row = $input33_first->fetch_assoc()){
        $input3_first = $row['input3'];
        echo $input3_first;
    }

    $data = mysqli_query($connection, "SELECT input1 FROM vertical_data");
    $total_rows = mysqli_num_rows($data);
    echo $total_rows;

    if($total_rows >= 1){
        $input_v1 = ($input1-$input1_last)/$input1_last * 100;
        $input_v2 = ($input2-$input2_last)/$input2_last *100;
        $input_v3 = ($input3-$input3_last)/$input3_last *100;

        $output_v1 = ($input1-$input1_first)/$input1_first *100;
        $output_v2 = ($input2-$input2_first)/$input2_first *100;
        $output_v3 = ($input3-$input3_first)/$input3_first *100;


        $diff_v1 = $output_v2 - $output_v1;
        $diff_v2 = $output_v2 - $output_v3;
        $diff_v3 = $diff_v1 - $diff_v2; 

    }else{
        $input_v1 = 0;
        $input_v2 = 0;
        $input_v3 = 0;
        $output_v1 = 0;
        $output_v2 = 0;
        $output_v3 = 0;
        $diff_v1 = 0;
        $diff_v2 = 0;
        $diff_v3 = 0;
    }

    $sql = "INSERT INTO vertical_data (date,input1,input2,input3,input_v1,input_v2,input_v3,output_v1,output_v2,output_v3,diff_v1,diff_v2,diff_v3) VALUES ('$date','$input1','$input2','$input3','$input_v1','$input_v2','$input_v3','$output_v1','$output_v2','$output_v3','$diff_v1','$diff_v2','$diff_v3')";

    if (mysqli_query($connection, $sql)) {
        echo "";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
      }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <br>
    <div class="container">
    <form class="form-inline" method="POST">
      <label for="date">Date:</label>
      <input type="date" id="date" placeholder="" name="date" required>
      <label for="input1">Input1:</label>
      <input type="text" id="input1" placeholder="" name="input1" required>
      <label for="input2">Input2:</label>
      <input type="text" id="input2" placeholder="" name="input2" required>
      <label for="input3">Input3:</label>
      <input type="text" id="input3" placeholder="" name="input3" required>
      <div class="break"></div>
      <input type="submit" name="submit" value ="Calculate" class="btn btn-primary">
    
    
</form>
    </div>
<?php

echo '<div class="table-responsive-sm  table-responsive-lg">';
echo '<table class="table table-bordered">';
echo '<thead class="thead-dark">';
echo '<tbody>';
echo '<tr>
  <th scope="col">Date</th>
  <th scope="col">Input Vertical 1</th>
  <th scope="col">Input Verticle 2</th>
  <th scope="col">Input Vertical 3</th>
  <th scope="col">Output Vertical 1</th>
  <th scope="col">Output Vertical 2</th>
  <th scope="col">Output Vertical 3</th>
  <th scope="col">Diffential Vertical 1</th>
  <th scope="col">Diffential Vertical 2</th>
  <th scope="col">Diffential Vertical 3</th>
  </tr>';
    
  if($result = mysqli_query($connection,"SELECT date,input1,input2,input3,input_v1,input_v2,input_v3,output_v1,output_v2,output_v3,diff_v1,diff_v2,diff_v3 FROM vertical_data")){
 
  while ($row = mysqli_fetch_array($result)) {
        echo "<tr>"; 
        echo "<td>" . $row['date'] . "</td>"; 
        echo "<td>" . $row['input_v1'] . "</td>"; 
        echo "<td>" . $row['input_v2'] . "</td>";
        echo "<td>" . $row['input_v3'] . "</td>";
        echo "<td>" . $row['output_v1'] . "</td>";
        // if($row['output_v1']==10.00){
        //     echo "<td style = 'background-color :#00FF00;'>" .$row['output_v1'] ."</td>";
        // }
        echo "<td>" . $row['output_v2'] . "</td>";
        echo "<td>" . $row['output_v3'] . "</td>";
        echo "<td>" . $row['diff_v1'] . "</td>";
        // if($row['diff_v1']==500) {
        //         echo "<td style='background-color: #00FF00;'>".$row['diff_v1']."</td>";
        //         }
        echo "<td>" . $row['diff_v2'] . "</td>";
        echo "<td>" . $row['diff_v3'] . "</td>"; 
        echo "</tr>"; 

           
    } 
    $result->free();  
    echo '</thead>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>'; 

}

?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
</body>
</html>