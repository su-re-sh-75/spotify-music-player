const music = document.getElementById("audio");

let masterPlay = document.getElementById('masterPlay');
let wave = document.getElementsByClassName('wave')[0];

//Play , pause functionality
masterPlay.addEventListener('click', function(){
    if(music.paused || music.currentTime <=0){
        music.play();
        masterPlay.classList.remove('bi-play-fill');
        masterPlay.classList.add('bi-pause-fill');
        wave.classList.add('active2');
    } else{
        music.pause();
        masterPlay.classList.add('bi-play-fill');
        masterPlay.classList.remove('bi-pause-fill');
        wave.classList.remove('active2');
    }
});

let poster_master_play = document.getElementById('poster_master_play');
let title = document.getElementById('title');

let currentStart = document.getElementById('currentStart');
let currentEnd = document.getElementById('currentEnd');
let seek = document.getElementById('seek');
let bar2 = document.getElementById('bar2');
let dot = document.getElementsByClassName('dot')[0];
music.addEventListener('timeupdate', ()=>{
    let music_curr = music.currentTime;
    let music_dur = music.duration;

    let min = Math.floor(music_dur/60);
    let sec = Math.floor(music_dur%60);
    if(sec<10){
        sec = `0${sec}`;
    }
    currentEnd.innerText = `${min}:${sec}`;

    let min1 = Math.floor(music_curr/60);
    let sec1 = Math.floor(music_curr%60);
    if(sec1<10){
        sec1 = `0${sec1}`;
    }
    currentStart .innerText = `${min1}:${sec1}`;
    let progressbar = parseInt((music.currentTime/music.duration)*100);
    seek.value = progressbar;
    let seekbar = seek.value;
    bar2.style.width = `${seekbar}%`;
    dot.style.left = `${seekbar}%`;
});

seek.addEventListener('change', ()=>{
    music.currentTime = seek.value * music.duration/100;
});


let vol_icon = document.getElementById('vol_icon');
let vol = document.getElementById('vol');
let vol_dot = document.getElementById('vol_dot');
let vol_bar = document.getElementsByClassName('vol_bar')[0];

vol.addEventListener('change', ()=>{
    if(vol.value == 0){
        vol_icon.classList.remove('bi-volume-down-fill');
        vol_icon.classList.add('bi-volume-mute-fill');
        vol_icon.classList.remove('bi-volume-up-fill');
    }
    if(vol.value > 0){
        vol_icon.classList.add('bi-volume-down-fill');
        vol_icon.classList.remove('bi-volume-mute-fill');
        vol_icon.classList.remove('bi-volume-up-fill');
    }
    if(vol.value > 50){
        vol_icon.classList.remove('bi-volume-down-fill');
        vol_icon.classList.remove('bi-volume-mute-fill');
        vol_icon.classList.add('bi-volume-up-fill');
    }

    let vol_a = vol.value;
    vol_bar.style.width = `${vol_a}%`;
    vol_dot.style.left = `${vol_a}%`;
    music.volume = vol_a/100;
});

let back = document.getElementById('back');
let next = document.getElementById('next');

 // Function to update the player with the fetched data
function updatePlayer(songData){
    // Update the audio source with the new song's audio path
    $('#audio').attr('src', songData.audio_path);

    // Update other player details (title, artist, etc.)
    $('#poster_master_play').attr('src', songData.image_path);
    $('#title').html(songData.track_name + '<br><div class="subtitle">' + songData.track_artist + '</div>');
    music.addEventListener('canplaythrough', function () {
        masterPlay.click();
    });
}
$(document).ready(function() {
    $('.song').click(function() {
        var songId = $(this).data('id');

        $.ajax({    
            url: 'get_song_data.php',
            type: 'POST',
            data: { id: songId, type: 'song' },
            success: function(response) {
                var songData = JSON.parse(response);
                updatePlayer(songData);
            },
            error: function(error) {
                console.log('Error fetching song data:', error);
            }
        });
    });
});
let playlists = [];
let currentPlaylistIndex = -1; // Index to track the current song in playlist

// Function to load playlist data
const loadPlaylist = function(playlistId, index) {
    $.ajax({
        url: 'get_song_data.php',
        type: 'POST',
        data: { id: playlistId, type: 'playlist' },
        success: function(response) {
            playlists = JSON.parse(response);
            currentPlaylistIndex = index; 
            updatePlayer(playlists[currentPlaylistIndex]); // Play the first song
        },
        error: function(error) {
            console.log('Error fetching playlist data:', error);
        }
    });
};

const playlist_play = document.getElementsByClassName('playListPlay')[0];
playlist_play.addEventListener('click', function() {
        const playlistSearchParams = new URLSearchParams(window.location.search);
        let playlistId = playlistSearchParams.get('id');
        loadPlaylist(playlistId, 0);
});
music.addEventListener('ended', ()=>{
    masterPlay.classList.add('bi-play-fill');
    masterPlay.classList.remove('bi-pause-fill');
    wave.classList.remove('active2');
    next.click();
});

// Click event for next button
next.addEventListener('click', function() {
    if (currentPlaylistIndex < playlists.length - 1) {
        currentPlaylistIndex++;
        updatePlayer(playlists[currentPlaylistIndex]);
    }else {
        // If at the end of the playlist, loop back to the beginning
        currentPlaylistIndex = 0;
        updatePlayer(playlists[currentPlaylistIndex]);
    }
});

// Click event for back button
back.addEventListener('click', function() {
    if (currentPlaylistIndex > 0) {
        currentPlaylistIndex--;
        updatePlayer(playlists[currentPlaylistIndex]);
    }else {
        // If at the end of the playlist, loop back to the beginning
        currentPlaylistIndex = playlists.length - 1;
        updatePlayer(playlists[currentPlaylistIndex]);
    }
});

$('.playlist_song').click(function() {
    const songId = $(this).data('id');
    const playlistSearchParams = new URLSearchParams(window.location.search);
    let playlistId = playlistSearchParams.get('id');
    loadPlaylist(playlistId, songId-1);
});
