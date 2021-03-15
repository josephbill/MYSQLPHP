<?php
//set up variables to store your server details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";

//create and execute connection based off creds
$conn = new mysqli($servername,$username,$password,$dbname);

// the connection 
if ($conn->connect_error) {
	# code...
	echo "connection failed <br> " . $conn->connect_error;
} 

//create a db using SQL 
// $sql = "CREATE DATABASE school";
// //checking if db has been created 
// if ($conn->query($sql) === TRUE) {
// 	# code...
// 	echo "database created <br> ";
// } else {
// 	echo "database not created <br>" . $conn->error;
// }

//create a table 
// sql to create table
// $sql = "CREATE TABLE staff (
// id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// staffName VARCHAR(250) NOT NULL,
// email VARCHAR(250) NULL,
// phoneNumber VARCHAR(250) NOT NULL,
// gender VARCHAR(250),
// age INT(11),
// salary VARCHAR(250),
// reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// // //checking if table has been created 
// if ($conn->query($sql) === TRUE) {
// 	# code...
// 	echo "table created <br> ";
// } else {
// 	echo "table not created <br>" . $conn->error;
// }


// //insert records to db 
// $sql = "INSERT INTO students (studentname,email,phoneNumber,gender,age) VALUES ('Joseph Mbugua', 'josephbill00@gmail.com','0798501657','male',25)";

// // // //checking if data has been created 
// if ($conn->query($sql) === TRUE) {
// 	# code...
// 	echo "record created <br> ";
// } else {
// 	echo "record not created <br>" . $conn->error;
// }


//variables to store users input
$name = $age = $email = $phone = $gender =  '';
$studentImage = '';

//update variables
$id = 0;
$update = false;
$newTarget = '';

//variables for errors
$nameErr = $ageErr = $emailErr = $phoneErr = $genderErr = '';

//check if submit is clicked 
if (isset($_POST['save'])) {
	# code...
	// $name = $_POST['studentName'];
	// $age = $_POST['studentAge'];
	// $email = $_POST['studentEmail'];
	// $phone = $_POST['studentPhone'];
	// $gender = $_POST['studentGender'];

    //this is the path that will store our image 
    $target = "studentImages/" .basename($_FILES['studentImage']['name']);


  if (empty($_POST['studentName'])) {
      # code..
      $nameErr = "Student cannot be empty";  
  } else {
    $name = $_POST['studentName'];
   // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }


  if (empty($_POST['studentEmail'])) {
      # code..
      $emailErr = "Email cannot be empty";  
  } else {
    $email = $_POST['studentEmail'];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }


  if (empty($_POST['studentPhone'])) {
      # code..
      $phoneErr = "Phone Input cannot be empty";  
  } else {
    $phone = $_POST['studentPhone'];

  }




  if (empty($_POST['studentGender'])) {
      # code..
      $genderErr = "Gender cannot be empty";  
  } else {
    $gender = $_POST['studentGender'];

  }





  if (empty($_POST['studentAge'])) {
      # code..
      $ageErr = "Age cannot be empty";  
  } else {
    $age = $_POST['studentAge'];

  }


  $studentImage = $_FILES['studentImage']['name'];



if (empty($nameErr)) {
    # code...
    $stmt = $conn->prepare("INSERT INTO students (studentname,email,phoneNumber,gender,age,studentImage) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssis",$name,$email,$phone,$gender,$age,$studentImage);


    if ($stmt->execute() === TRUE) {
    //get last inserted id
    // $last_id = $conn->insert_id;
    # code...
    //here moving uploaded file to the folder
    move_uploaded_file($_FILES['studentImage']['tmp_name'], $target);
    echo "record created <br>  " ;
    echo "<script>
         alert('image moved');

    </script>";
    // header('location: index.php');
    // header('location: connection.php'); //redirec$conn->close();
        } else {
            echo "record not created <br>" . $conn->error;
        }  //execution of the query  
        } //check error variables if empty
        else {
            echo "invalid details";
        }

// $sql = "INSERT INTO students (studentname,email,phoneNumber,gender,age,studentImage) VALUES ('$name','$email','$phone','$gender','$age','$studentImage')";

// // // //checking if data has been created 
// if ($conn->query($sql) === TRUE) {
//     //get last inserted id
//     // $last_id = $conn->insert_id;
//     # code...
//     //here moving uploaded file to the folder
//     move_uploaded_file($_FILES['studentImage']['tmp_name'], $target);
//     echo "record created <br>  " ;
//     // header('location: connection.php'); //redirec$conn->close();
// } else {
//     echo "record not created <br>" . $conn->error;
// }  //execution of the query  
// } //check error variables if empty
// else {
//     echo "invalid details";
// }


} //isset check if


//delete logic 
if (isset($_GET['delete'])) {
    # code...

    $id = $_GET['delete'];

    //delete sql 
    $deleteSql = "DELETE FROM students WHERE id='$id'";

    if ($conn->query($deleteSql) === TRUE) {
        # code...
        echo "<script>
            alert('Record deleted');
        </script>";
        // header('location: index.php');
    } else {
           echo "<script>
            alert('Record not deleted');
        </script>";
        // header('location: index.php');

    }

}


//update 
 if (isset($_GET['edit'])) {
     # code...
    $id = $_GET['edit'];
    $update = true;

    //picking existing data from db 
    $result = $conn->query("SELECT * FROM students WHERE id='$id'") or die($conn->error);
 
    $row = $result->fetch_array();

    $name = $row['studentname']; //column name as in db
    $email = $row['email']; //column name as in db
    $phone = $row['phoneNumber']; //column name as in db
    $gender = $row['gender']; //column name as in db
    $age = $row['age']; //column name as in db
    $studentImage = $row['studentImage']; //column name as in db


 }


 //update functionality
 if (isset($_POST['update'])) {
     # code...
    //this is the path that will store our image 
    $newTarget = "studentImages/" .basename($_FILES['studentImage']['name']);


  if (empty($_POST['studentName'])) {
      # code..
      $nameErr = "Student cannot be empty";  
  } else {
    $name = $_POST['studentName'];
   // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }


  if (empty($_POST['studentEmail'])) {
      # code..
      $emailErr = "Email cannot be empty";  
  } else {
    $email = $_POST['studentEmail'];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }


  if (empty($_POST['studentPhone'])) {
      # code..
      $phoneErr = "Phone Input cannot be empty";  
  } else {
    $phone = $_POST['studentPhone'];

  }




  if (empty($_POST['studentGender'])) {
      # code..
      $genderErr = "Gender cannot be empty";  
  } else {
    $gender = $_POST['studentGender'];

  }





  if (empty($_POST['studentAge'])) {
      # code..
      $ageErr = "Age cannot be empty";  
  } else {
    $age = $_POST['studentAge'];

  }


  $studentImage = $_FILES['studentImage']['name'];
  $id = $_POST['id'];


  if (empty($nameErr)) {
      # code...
    $updateSQL = "UPDATE students SET studentname='$name', email='$email', phoneNumber = '$phone' , gender = '$gender', age='$age' , studentImage= '$studentImage' WHERE id='$id' ";

    if ($conn->query($updateSQL) === TRUE) {
        # code...
        move_uploaded_file($_FILES['studentImage']['name'], $newTarget);
        echo "record updated";
    } else {
        echo "records not updated";
    }
  } else {
    echo "Invalid details";
  }

 

 }



//close 


?>