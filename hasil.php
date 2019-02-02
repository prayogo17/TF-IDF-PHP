<?php
session_start();
if (isset($_SESSION['table1'])) {
    // code...?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body >
<div class="container">

  <table style="margin-top:30px;" class="table table-bordered">
<thead>
 <tr>
   <th>Q</th>
   <?php
   $table1=$_SESSION['table1'];
    $f=1;
    foreach ($table1[0]['dok'] as $key) {
        echo "<th>D".$f."</th>";
        ++$f;
    } ?>
   <th>df</th>
   <th>D/df</th>
   <th>IDF</th>
   <th>IDF+1</th>
 </tr>
</thead>
<tbody>
<?php
$p=0;
    foreach ($table1 as $key) {
        echo "<tr>
    <td>".$key['term']."</td>";
        foreach ($key['dok'] as $key1) {
            echo "<td>".$key1."</td>";
        }

        echo "<td>".$key['df']."</td>
<td>".$key['Ddf']."</td>
<td>".$key['idf']."</td>
<td>".$key['idf1']."</td>
</tr>";


        ++$p;
    }


    //echo json_encode($_SESSION['table2']);?>


</tbody>
</table>

<table class="table table-bordered">
   <thead>
     <tr>
       <?php
       $table2=$_SESSION['table2'];
    $f=1;
    foreach ($table2 as $key) {
        echo "<th>Kalimat ".$f."</th>";
        ++$f;
    } ?>
     </tr>
   </thead>
   <tbody>


     <?php
     $counter=count($table2[0]['a']);
    for ($h=0;$h<$counter;++$h) {
        echo "<tr>";
        for ($e=0;$e<count($table2);++$e) {
            echo "<td>".$table2[$e]['a'][$h]."</td>";
        }
        echo "</tr>";
        //  print_r($table2[$q][1]);
    } ?>

   </tbody>
 </table>


 <table class="table table-bordered">
    <thead>
      <tr>
        <th>Kalimat</th>
        <th>Score Pembobotan</th>

      </tr>
    </thead>
    <tbody>
      <?php
      $urutan2=$_SESSION['urutan2'];
foreach ($urutan2 as $key => $value) {

 echo "<tr>
   <td>Kalimat ".($key+1)."</td>
   <td>".$value."</td>
 </tr>";
}
      ?>


    </tbody>
  </table>

<div style="margin-bottom:30px;">
  <h3 style="text-align:center;">Hasil Rigkasan</h3>
  <?php
  $data_asli=explode(".",$_SESSION['original_data']);
  $s=0;
  foreach ($urutan2 as $key => $value) {
    echo $data_asli[$key].".";
  if($s==1){
    break;
  }
  ++$s;
  }
  ?>
</div>



</div>

  </body>

</html>

<?php
}
session_destroy();
?>
