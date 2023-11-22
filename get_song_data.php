<?php
    session_start();
    require_once('db_connect.php');

    if (isset($_POST['id']) && isset($_POST['type'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];

        if ($type === 'song') {
            // Fetch song data from the database based on the song ID
            $query = "SELECT * FROM all_tracks WHERE id = $id";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $songData = $result->fetch_assoc();
                echo json_encode($songData);
            } else {
                echo json_encode(['error' => 'Song not found']);
            }
        } elseif ($type === 'playlist' && $id === '8') {

            // Fetch playlist data from the database based on the playlist ID
            $query = "SELECT * FROM playlist_1";
            $result = $conn->query($query);
            $data = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
        } elseif ($type === 'playlist' && $id === '7') {

            // Fetch playlist data from the database based on the playlist ID
            $query = "SELECT * FROM playlist_2";
            $result = $conn->query($query);
            $data = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Invalid request type']);
            exit();
        }

        
    }
    if (isset($conn) && $conn) {
        $conn->close();
    }
?>