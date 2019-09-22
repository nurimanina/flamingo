<?php
	error_reporting(0);
	$msg ="";
	
	if (isset($_POST['upload'])){
		
		$target = "images/".basename($_FILES['image']['name']);
		
		$db = mysqli_connect("localhost","root","","cc"); 
		
		$image = $_FILES['image']['name'];
		$text = $_POST['text'];
		
		$sql = "INSERT INTO images (image,text) VALUES ('$image','$text')";
		mysqli_query($db,$sql);
		
		if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
			$msg = "Image uploaded successfully"; 
		}else{
			$msg = "There was a problem uploading image";
		}
		
		
	}
	$id =$_GET['ID'];
	$db = mysqli_connect("localhost","root","","cc"); 
	$sql1 = "DELETE FROM images WHERE ID = '".$id."'";
	mysqli_query($db,$sql1);


?>

<?php 

$db = mysqli_connect("localhost","root","","cc"); 

if(isset($_POST['search'])){
	$searchq = $_POST['search'];
	$searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
	$query = "SELECT * FROM images WHERE text LIKE '%$searchq%'";
	$result1= mysqli_query($db,$query) or die( mysqli_error($db));
    echo "<h2>Searched keyword = '$searchq'</h2>";
	while( $row = mysqli_fetch_array($result1)){
		echo "<div>";

		echo "<div id ='img_div'>";
				echo "<img src='images/".$row['image']."' width='20%'>";
				echo "<p style='font-family:Calibri;font-weight:bold;color:#cc00cc'>".$row['text']."</p>";
			echo "</div>";
	}
	
}



?>

<!DOCTYPE html>
<html>
<head><title>Image CMS </title>
<style>
#content{
	width:50%;
	margin: 20px auto;
	border: 1px solid #cbcbcb;

}

form{
	width: 50%;
	margin: 20px auto;

}

form div{
	margin-top:5px;
}

#img_div{
	width:80%;
	padding: 5px;
	margin: 15px auto;
	border: 1px solid #cbcbcb;

}


#img_div:after{
	content: "";
	display: block;
	clear: both;
}

img{
	float: left;
	margin: 5px;
	width: 300px
	height: 140px;
	
	
}

</style>	

</head>

<body style="background-color:#f2e6ff;">

<form method="post" action="index.php" enctype="multipart/form-data">
<h3>Insert Image : </h3> </br>
<input type="file" name="image"><br>

 
<h3>Insert Image Tag : </h3> </br> 
<textarea name="text" cols="40" rows="4" placeholder="Enter tags"></textarea> <br><br>

<input type="submit" name="upload" value="Upload Image"><br>
</form>

<form method="post" action="index.php" enctype="multipart/form-data">
<input type="text" name="search" placeholder="Search for tags"/>
<input type="submit" value=">>"/>
</form>
	<div id="content" style="background-color:#00b3b3;">
<?php 
	$db = mysqli_connect("localhost","root","","cc"); 
	$sql = "SELECT * FROM images";  
	$result = mysqli_query($db, $sql);
		while( $row = mysqli_fetch_array($result)){
			echo "<div id ='img_div' style='background-color:#b3ff1a;'>";
				echo "<img src='images/".$row['image']."' width='30%'>";
				echo "<p style='font-family:Calibri;font-weight:bold;color:#00b33c'>Tags: ".$row['text']."</p>";
				echo "<td><a href ='index.php?ID=$row[ID] ' style='font-family:Calibri;font-weight:bold;color:#0000ff'>Delete Image</a></td>";
			echo "</div>";
			
		}


?>	
	</div>
</body>

</html>