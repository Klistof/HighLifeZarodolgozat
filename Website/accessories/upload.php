<?php

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['files'])) {
        $user = $_GET["u"];
        $clid = base64_decode(str_replace(" ", "+", $_GET["c"]));
        $date = date("Y-m-d H:i:s");

        $path = '../uploads/';
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];

        $all_files = count($_FILES['files']['tmp_name']);

        $file_name = $_FILES['files']['name'][0];
        $file_tmp = $_FILES['files']['tmp_name'][0];
        $file_type = $_FILES['files']['type'][0];
        $file_size = $_FILES['files']['size'][0];
        $file_extension = explode(".", $_FILES['files']['name'][0]);
        $file_ext = strtolower(end($file_extension));

        $file1 = $path . $user . "-" . date("Y-m-d-H-i-s") . "-" . $file_name;



        if ($all_files == 2) {
            $file_name2 = $_FILES['files']['name'][1];
            $file_tmp2 = $_FILES['files']['tmp_name'][1];
            $file_type2 = $_FILES['files']['type'][1];
            $file_size2 = $_FILES['files']['size'][1];
            $file_extension2 = explode(".", $_FILES['files']['name'][1]);
            $file_ext2 = strtolower(end($file_extension2));

            $file2 = $path . $user . "-UCP-" . date("Y-m-d-H-i-s") . "-" . $file_name2;

            if (!in_array($file_ext2, $extensions)) {
                echo json_encode('Extension not allowed: ' . $file_name2 . ' ' . $file_type2);
            }

            if ($file_size2 > 2097152) {
                echo json_encode('File size exceeds limit: ' . $file_name2 . ' ' . $file_type2);
            }

            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file1);
                move_uploaded_file($file_tmp2, $file2);

                $sql = "SET NAMES utf8";
                $link->query($sql);

                $sql = "INSERT INTO `upload`(`ID`, `username`, `date`, `identity`, `aproved`, `photoURL`, `UCP`) VALUES (NULL,\"" . utf8_encode($user) . "\",\"" . $date . "\",\"" . utf8_encode($clid) . "\",0,\"" . $file1 . "\",\"" . $file2 . "\")";
                $link->query($sql);
                echo json_encode('success');
                return;
            }
        }


        if (!in_array($file_ext, $extensions)) {
            echo json_encode('Extension not allowed: ' . $file_name . ' ' . $file_type);
        }




        if ($file_size > 2097152) {
            echo json_encode('File size exceeds limit: ' . $file_name . ' ' . $file_type);
        }


        if (empty($errors)) {
            move_uploaded_file($file_tmp, $file1);

            $sql = "SET NAMES utf8";
            $link->query($sql);

            $sql = "INSERT INTO `upload`(`ID`, `username`, `date`, `identity`, `aproved`, `photoURL`) VALUES (NULL,\"" . utf8_encode($user) . "\",\"" . $date . "\",\"" . utf8_encode($clid) . "\",0,\"" . $file1 . "\"";
            $link->query($sql);
            echo json_encode('success');

        }
    }
}
?>