<?php 
require_once 'inc/utilities.php';
#   custom php page that is used to render the finished 3D image proof for customers 

# 

$util=new utilities();
$result=$util->renderDesign();
#var_dump($_SERVER);
#var_dump($result);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Custom Page</title>
	<link rel="stylesheet" href="css/modelling.css">
	<script src="//code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="//cdn.babylonjs.com/babylon.js"></script>	
	<script src="js/scene.js"></script>
	<script src="js/rendering.js"></script>
</head>
<body>
<?php echo $result?>
</body>
</html>