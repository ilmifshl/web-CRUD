<?php
include("connect.php");

function query($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function addData($data)
{
    global $db;
    $nrp = $data["nrp"];
    $jenis_kelamin = $data["jenis_kelamin"];
    $jurusan = $data["jurusan"];
    $email = $data["email"];


    // upload gambar
    try {
        $gambar = upload();
    } catch (Exception $e) {
        return array("status" => -1, "result" => $e->getMessage());
    }


    $sql = "INSERT INTO MAHASISWA (nrp, jenis_kelamin, jurusan, email, gambar) VALUES ('$nrp', '$jenis_kelamin', '$jurusan', '$email', '$gambar')";
    mysqli_query($db, $sql);

    return array("status" => mysqli_affected_rows($db), "result" => "Data berhasil ditambahkan");
}

function upload()
{
    $fileName = $_FILES["gambar"]["name"];
    $fileSize = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];
    $validExt = ['png', 'jpg', 'jpeg'];
    $tmp = explode(".", $fileName);
    $fileExt = strtolower(end($tmp));

    if ($error === 4) {
        throw new Exception("Upload file gambar terlebih dahulu.");
    }

    if (!in_array($fileExt, $validExt)) {
        throw new Exception("File gambar harus berekstensi jpg, jpeg, atau png.");
    }

    if ($fileSize > 3145728) {
        throw new Exception("Ukuran gambar tidak boleh melebihi 3 MB.");
    }

    $newFileName = uniqid() . "." . $fileExt;
    move_uploaded_file($tmpName, "../image/" . $newFileName);
    return $newFileName;
}

function registration($data)
{
  global $db;
  $nama = $_POST["nama"];
  $username = strtolower(stripslashes($data["username"]));
  $email = $data["email"];
  $password = mysqli_real_escape_string($db, $data["password"]);
  $confirm_password = mysqli_real_escape_string($db, $data["confirmPassword"]);

  if( $password !==  $confirm_password){
    return false;
  }     

  $password = password_hash($password, PASSWORD_DEFAULT);
  mysqli_query($db, "INSERT INTO USER VALUES('$email', '$password', '$nama', '$username', 'guest')");

  return array("status" => mysqli_affected_rows($db), "result" => "Silakan lakukan login untuk melanjutkan");
}

function addSubject($data)
{
    global $db;
    $email = $_SESSION["email"];
    $subject_name = $data["subject_name"];
    $major = $data["major"];
    $queryLecturer = mysqli_query($db, "SELECT * FROM lecturer WHERE email = '$email'");
    $row = mysqli_fetch_assoc($queryLecturer);
    $lecturerId = $row["nip"];

    $sql = "INSERT INTO SUBJECT (subject_id, nip, major, subject_name) VALUES (null, '$lecturerId', '$major', '$subject_name')";
    mysqli_query($db, $sql);

    return array("status" => mysqli_affected_rows($db), "result" => "Data berhasil ditambahkan");
}