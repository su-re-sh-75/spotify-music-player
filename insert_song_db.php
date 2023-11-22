<?php
    session_start();
    require_once('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $track_name = $_POST['track_name'];
        $track_album = $_POST['track_album'];
        $track_artist = $_POST['track_artist'];
        $image_path = 'images/' . basename($_FILES['image']['name']);
        $audio_path = 'music/' . basename($_FILES['audio']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path) && move_uploaded_file($_FILES['audio']['tmp_name'], $audio_path)) {
            // Insert the data into the database
            $sql = "INSERT INTO all_tracks (track_name, track_artist, track_album, audio_path, image_path) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $track_name, $track_artist, $track_album, $audio_path, $image_path);

            if ($stmt->execute()) {
                header("Location: insert_song.php?success=1");
            } else {
                header("Location: insert_song.php?success=2");
            }
        } else {
            header("Location: insert_song.php?success=3");
        }
    }

    if (isset($conn) && $conn) $conn->close();
?>