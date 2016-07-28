<?php
/**
 * Created by PhpStorm.
 * User: P0020755
 * Date: 21/07/2016
 * Time: 11:49
 */
$servername = "localhost";
$username = "root";
$password = "A1m2i3t4";
$dbname = "Html5";
$conn;
$numOfQuestions = 10;

try {
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        $conn->close();
        die("Connection failed: " . $conn->connect_error);
        //throw new Exception("Connection failed: " .$conn->connect_error);
    } else {
        //echo "Connected successfully";

        $query = "SELECT * FROM englishquiz";
        //$result = $conn->query($query, MYSQLI_STORE_RESULT);
        //$numRows = $result->num_rows;
        $result = mysqli_query($conn, $query);
        $numRows = mysqli_num_rows($result);
        $temp_arr = array();
        $return_arr = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $row_array['question'] = $row['question'];
            $row_array['answer1'] = $row['answer1'];
            $row_array['answer2'] = $row['answer2'];
            $row_array['answer3'] = $row['answer3'];
            $row_array['answer4'] = $row['answer4'];
            $row_array['rightAnswer'] = $row['rightAnswer'];
            array_push($temp_arr, $row_array);
        }

        while (count($return_arr) < $numOfQuestions) {
            $index = round(rand(0, $numRows - 1));
            $question = $temp_arr[$index]['question'];

            $found = array_filter($return_arr, function ($e) use ($question) {
                return count($e) > 0 && $e['question'] == $question;
            });

            if (count($found) == 0) {
                array_push($return_arr, $temp_arr[$index]);
            }
        }

        //print_r($temp_arr);
        echo json_encode($return_arr);
    }
}
catch (Exception $ex) {
    die("Exception: " . $ex->getMessage());
    //throw new Exception("Exception: " .$ex->getMessage());
}
finally {
    $conn->close();
}
?>