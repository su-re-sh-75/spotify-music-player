<?php 
    session_start();
    require_once('db_connect.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Prime</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/cspd-player.css">
    <link href="https://css.gg/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ADLaM+Display&family=Montserrat:wght@500&family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <audio src="" id="audio"></audio>
    <header>
        <nav>
            <img id="spotify-logo" src="images/Spotify Logo PNG With Drop Shadow.webp" alt="spotify-logo">
            <a href="home.php" id="nav-thumb">Spotify Prime</a>
            <form action="search.php" class="search-bar" method="get">
                <input type="search" name="search" id="search" placeholder="Search your favourite song">
                <i class="bi bi-search"></i>
            </form>
            <?php 
                if (isset($_SESSION['success']) || $_SESSION['success'] == 1){
                    echo '<a class="login" href="logout.php">Log out</a>';
                    $_SESSION['success'] = 0;
                }elseif (!isset($_SESSION['success']) || $_SESSION['success'] !== 1){
                    echo '<a class="login" href="login.php">Login</a>';
                }
            ?>
        </nav>
    </header>
    <main>
        <section class="sidebar">
            <div class="browse">
                <p class="category">Browse</p>
                <a href="home.php">Discover</a>
                <a href="new_release.php" style="color:#1ed760;">New Release</a>
                <a href="album.php">Album</a>
                <a href="artists.php">Artists</a>
                <a href="insert_song.php">Add new Song</a>
            </div>
            <div class="library">
                <p class="category">Playlists</p>
                <div class="playlist-sidebar" >
                    <a href="playlist_1.php?id=8">Rewind Hits 2022</a>
                </div>
                <div class="playlist-sidebar">
                    <a href="playlist_2.php?id=7">Best of 2017 </a>
                </div>
            </div>
        </section>
        <section class="hero-sec">
            <div class="song-sections">
                <?php 
                    $music = $conn->query('SELECT * FROM all_tracks WHERE id BETWEEN 80 AND 97');
                    while($row = $music->fetch_assoc()):
                ?>
                <div class="song" data-id="<?= $row['id'] ?>">
                    <a class="track_name" href="#"><img src="<?= is_file(explode("?",$row['image_path'])[0]) ? $row['image_path'] : "images/leo-tamil-2023.webp" ?>" alt="song logo">
                    <br><?= $row['track_name'] ?></a>
                    <p class="composer"><?= $row['track_artist'] ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <footer class="master-play">
        <div class="wave">
            <div class="wave1"></div>
            <div class="wave1"></div>
            <div class="wave1"></div>
        </div>
        <img src="images/master-a tamil-2021.webp" alt="Song PFP" id="poster_master_play" >
        <h5 id="title">JD Badass Intro <br>
            <div class="subtitle">Anirudh Ravichander</div>
        </h5>
        <div class="icon">
            <i class="bi bi-skip-start-fill" id="back"></i>
            <i class="bi bi-play-fill" id="masterPlay"></i>
            <i class="bi bi-skip-end-fill" id="next" ></i>
        </div>
        <span id="currentStart">0:00</span>
        <div class="bar">
            <input type="range" name="songbar" id="seek" min="0" max="100">
            <div class="bar2" id="bar2"></div>
            <div class="dot"></div>
        </div>
        <span id="currentEnd">0:00</span>
        <div class="vol">
            <i class="bi bi-volume-down-fill" id="vol_icon"></i>
            <input type="range" name="volumebar" id="vol" min="0" max="100" value="50">
            <div class="vol_bar"></div>
            <div class="dot" id="vol_dot"></div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="JS/home.js"></script>
</body>
<?php if(isset($conn) && $conn) @$conn->close(); ?>
</html>