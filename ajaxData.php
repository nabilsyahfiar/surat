<?php 
// Include the database config file 
require_once 'functions.php'; 

$conn = connectDatabase();
 
if(!empty($_POST["rwid"])){ 
    // Fetch state data based on the specific country 
    $query = "SELECT * FROM rt WHERE rwid = ".$_POST['rwid']." ORDER BY rt ASC"; 
    $stmt = $conn->prepare($query);
    $stmt->execute();
     
    // Generate HTML of state options list 
    if($stmt->rowCount() > 0){ 
        echo '<option selected disabled>Pilih RT...</option>'; 
        while($row = $stmt->fetch()){  
            echo '<option value="'.$row['rt'].'">'.$row['rt'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">RT not available</option>'; 
    }
}

if(isset($_POST["add"])) {
    $id = generateID($conn);
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $keperluan = $_POST['keperluan'];

    if(addSurat($conn, $id, $nik, $nama, $alamat, $rt, $rw, $keperluan)) {
        echo "Pengajuan surat pengantar berhasil!";
    } else {
        echo "Pengajuan surat gagal!";
    }
}
?>