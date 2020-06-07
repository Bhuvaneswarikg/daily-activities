<?php  
  
interface interfaceMethods{ 
  
    public function addMethod(); 
    public function substractMethod(); 
    public function multiplyMethod(); 
    public function divideMethod(); 
  
} 
  
class Calculator implements interfaceMethods{ 

    public $num1;
    public $num2;

    public function __construct ($value1,$value2)
    {
    $this->num1 = $value1;
    $this->num2 = $value2;
    }

    public function addMethod(){               
        return $this->num1 + $this->num2;
    }
    public function substractMethod(){ 
        return $this->num1 - $this->num2;
    }
    public function multiplyMethod(){ 
        return $this->num1 * $this->num2;
    }
    public function divideMethod(){ 
        return $this->num1 / $this->num2;
    } 
}  

class Area extends Calculator{

    public function areaMethod(){
            return $this->num1 * $this->num2;
    }
}

$obj         = new Calculator(8,4);   
$objArea     = new Area(5,2);
$Addition    = $obj->addMethod(); 
$Subtraction = $obj->substractMethod(); 
$Multiply    = $obj->multiplyMethod();
$Division    = $obj->divideMethod();
$Area        = $objArea->areaMethod();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<div class="container">          
  <table class="table" width="50%">
    <thead>
      <tr>
        <th>Addition</th>
        <th>Subtraction</th>
        <th>Multiplication</th>
        <th>Division</th>
        <th>Area</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $Addition; ?></td>
        <td><?php echo $Subtraction; ?></td>
        <td><?php echo $Multiply; ?></td>
        <td><?php echo $Division; ?></td>
        <td><?php echo $Area; ?></td>
      </tr>
      
    </tbody>
  </table>
</div>

</body>
</html>

  
