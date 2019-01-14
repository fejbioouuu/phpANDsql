<?php
/**
 * Created by PhpStorm.
 * User: Fabio
 * Date: 14.01.2019
 * Time: 10:44
 */

$host = "localhost";
$user = "root";
$password = "";
$database = "test_db";

$id = "";
$fname = "";
$lname = "";
$age = "";


//mysqli_report(mysqli_report_error | mysqli_report_strict);

try{
    $connect = mysqli_connect($host, $user, $password, $database);
}catch (Exception $ex){
    echo 'Error';
}

function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['id'];
    $posts[1] = $_POST['fname'];
    $posts[2] = $_POST['lname'];
    $posts[3] = $_POST['age'];
    return $posts;
}

//search
if(isset($_POST['search'])){

    $data = getPosts();

    $searchQuery = 'SELECT * FROM  users WHERE id = '.$data[0];
    echo $searchQuery;
    $search_Result = mysqli_query($connect, $searchQuery);


    if($search_Result){
        if(mysqli_num_rows($search_Result)){
            while($row = mysqli_fetch_array($search_Result)){
                $id = $row['id'];
                $fname = $row['fname'];
                $lname= $row['lname'];
                $age = $row['age'];
            }
        }else{
            echo 'No Data fot this Id';
        }
    }else{
        echo 'Result Error';
    }

}




if(isset($_POST['delete'])){
    $data = getPosts();
    $delete_Query = 'DELETE FROM users WHERE id = '.$data[0];

    try{
        $delete_Result = mysqli_query($connect, $delete_Query);

        if($delete_Result){
            if(mysqli_affected_rows($connect)>0){
                echo 'Data Deleted';
            }else{
                echo 'Data not Deleted';
            }
        }

    }catch (Exception $ex){
        echo 'Error Delete '.$ex->getMessage();
    }

}


if(isset($_POST['insert'])){
    $data = getPosts();
    $insert_Query = 'INSERT INTO users (fname, lname, age) VALUES ("'.$data[1].'", "'.$data[2].'", '.$data[3].');';
    echo $insert_Query ;

    try{
        $insert_Result = mysqli_query($connect, $insert_Query);

        if($insert_Result){
            if(mysqli_affected_rows($connect)>0){
                echo 'Data Inserted';
            }else{
                echo 'Data not Inserted';
            }
        }

    }catch (Exception $ex){
        echo 'Error Insert '.$ex->getMessage();
    }

}

if(isset($_POST['update'])){
    $data = getPosts();
    $update_Query = 'UPDATE users SET fname="'.$data[1].'", lname="'.$data[2].'", age='.$data[3].' WHERE id = '.$data[0];

    try{
        $update_Result = mysqli_query($connect, $update_Query);

        if($update_Result){
            if(mysqli_affected_rows($connect)>0){
                echo 'Data updated';
            }else{
                echo 'Data not updated';
            }
        }

    }catch (Exception $ex){
        echo 'Error update '.$ex->getMessage();
    }

}

?>
<html>
    <head>
        <title>Let's try</title>
    </head>
    <body>
        <form action="php_insert_update_delete_search.php" method="post">
            <input type="number" name="id" placeholder="Id" value="<?php echo $id;?>"><br><br>
            <input type="text" name="fname" placeholder="First Name" value="<?php echo $fname;?>"><br><br>
            <input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname;?>"><br><br>
            <input type="number" name="age" placeholder="Age" value="<?php echo $age;?>"><br><br>
            <div>
                <input type="submit" name="insert" value="Add">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete"  value="Delete">
                <input type="submit" name="search" value="Find">
            </div>

        </form>
    </body>
</html>