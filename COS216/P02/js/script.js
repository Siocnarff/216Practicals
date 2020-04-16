'use strict';

//TRENDING
//========================================================================================================

function populateTrending(number) {
    addLoadingIcon();
    setTracksFromPlaylist(6600320724, number);
}

function setTracksFromPlaylist(id, number) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let json = JSON.parse(req.responseText);
            for (let i = 0; i < number; i++) {
                getAlbumById(json["tracks"].data[i]["album"].id, addTrackToGrid, json["tracks"].data[i], true);
            }
        }
    };
    req.open(
        "GET",
        "https://cors-anywhere.herokuapp.com/https://api.deezer.com/playlist/" + id,
        true
    );
    req.send();
}

function addTrackToGrid(albumJson, trackJson) {
    const releaseDate = albumJson["release_date"];
    let label = albumJson.label;
    let genre = albumJson["genres"].data[0].name;
    let r = rating();
    let br = barRating(r);
    document.getElementById("album_blocks").innerHTML += `
        <div class="album_block">
            <div class="cover_art">
                <p class="release_date_over_album">${releaseDate}</p>
                <img alt="Album Art" src="${albumJson["cover_medium"]}">                    
            </div> 
            <div class="album_info">
                <div class="star_rating">
                    <p class="rating_text">${r}</p>
                    <p class="rating_visual">${br}</p>
                </div>
                <div class="album_and_artist">
                    <p class="title">${trackJson.title}</h1>
                    <p class="artist">${trackJson["artist"].name}</h2>
                </div>
                <div class="grey small_text padding_tm">
                    <p>${label}</p>
                    <p>${genre}</p>
                </div>
            </div>
        </div>
    `;
}

function searchTrending() {
    addLoadingIcon();
    document.getElementById("album_blocks").innerHTML = "";
    let sDepthList = document.getElementById("search_depth");
    let sDepth = sDepthList[sDepthList.selectedIndex].value;
    //let sGenreList = document.getElementById("search_genre");
    //let sGenre = sGenreList[sGenreList.selectedIndex].value;
    //let sDateList = document.getElementById("search_depth");
    //let sDate = sDateList[sDateList.selectedIndex].value;

    let searchInfo = document.getElementById("searchTrending").value;
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let json = JSON.parse(req.responseText);
            let i = 0;
            while (i < sDepth) {
                if (json.data === undefined) {
                    alert("Sorry, could not find that.");
                    removeLoadingIcon();
                    break;
                } else if (json.data[i] !== undefined) {
                    i++;
                    getAlbumById(json.data[i]["album"].id, addTrackToGrid, json.data[i]);
                }
            }
        }
    };
    req.open(
        "GET",
        "https://cors-anywhere.herokuapp.com/https://api.deezer.com/search?q=" + searchInfo,
        true
    );
    req.send();
}

// NEW RELEASES
//========================================================================================================

function populateAlbums(number) {
    addLoadingIcon();
    setAlbumsFromPlaylist(1282495565, number);
}


function setAlbumsFromPlaylist(id, number) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let json = JSON.parse(req.responseText);
            for (let i = 0; i < number; i++) {
                if (133889172 !== json["tracks"].data[i]["album"].id) {
                    getAlbumById(json["tracks"].data[i]["album"].id, addAlbumToGrid);
                }
            }
        }
    };
    req.open(
        "GET",
        "https://cors-anywhere.herokuapp.com/https://api.deezer.com/playlist/" + id,
        true
    );
    req.send();
}

function addAlbumToGrid(albumJson, id = generateId()) {
    let r = rating();
    let br = barRating(r);
    document.getElementById("album_blocks").innerHTML += `
        <div class="album_block">
            <div class="cover_art">
                <span id="review${id}" class="review_in_tooltip small_text"></span>
                <img alt="Album Art" src="${albumJson["cover_medium"]}">                    
            </div> 
            <div class="album_info">
                <div class="star_rating">
                    <p class="rating_text">${r}</p>
                    <p class="rating_visual">${br}</p>
                </div>
                <div class="album_and_artist">
                    <p class="title">${albumJson.title}</p>
                    <p class="artist">${albumJson["artist"].name}</p>
                </div>
                <div class="grey small_text padding_tm">
                    <p>${albumJson.label}</p>
                    <p>${albumJson["genres"].data[0].name}</p>
                </div>
            </div>
        </div>
    `;
    setQuote(id);
}

function generateId() {
    return (new Date()).getTime();
}

function setQuote(id, useAPI = true) {
    if (useAPI) {
        let xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
                document.getElementById("review" + id).innerHTML = JSON.parse(this.responseText).message;
            }
        });

        xhr.open("GET", "https://150000-quotes.p.rapidapi.com/random");
        xhr.setRequestHeader("x-rapidapi-host", "150000-quotes.p.rapidapi.com");
        xhr.setRequestHeader("x-rapidapi-key", "1d86708b26msh87ef48acd276a7ep16603ajsn8b3874ca29b5");
        xhr.send();
    } else {
        document.getElementById("review" + id).innerHTML = "Please set useAPI to true";
    }
}


//TOP
//========================================================================================================

function populateTopTracks(number) {
    addLoadingIcon();
    getTopTracksChart(number);
}

function getTopTracksChart(number) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let json = JSON.parse(req.responseText);
            for (let i = 0; i < number; i++) {
                getAlbumById(json["tracks"].data[i]["album"].id, addTrackToChartList, json["tracks"].data[i], false);
            }
        }
    };
    req.open("GET", "https://cors-anywhere.herokuapp.com/https://api.deezer.com/chart/track", true);
    req.send();
}

function addTrackToChartList(albumJson, trackJson) {
    let label = albumJson.label;
    let genre = albumJson["genres"].data[0].name;
    document.getElementById("ranked_songs").innerHTML += `
        <div class="ranked_song">
            <div class="image_and_ranking">
                <h1>${trackJson.position}</h1>
                <img alt="Album Art" src="${trackJson["album"]["cover_medium"]}">
            </div>
            <div class="title_and_artist">
                <h2>${trackJson.title}</h2>
                <h3>${trackJson["artist"].name}</h3>
            </div>
            <div class="small_text grey">
                <p>${genre}</p>
                <p>${label}</p>
            </div>
        </div>
    `;
}


// FEATURED
//========================================================================================================

function populateFeatured() {
    addLoadingIcon();
    // Departure Songs 11302436
    // Caamp 14324246
    //getAlbumById(11302436,  addFeaturedAlbum);
    //Oceans
    setTrackById(92601004);
    //Caamp
    setTrackById(134364230);
    //No Time For Caution
    setTrackById(647286472);
    //Towers
    setTrackById(754176292);
    //Power Corruption And Lies
    setTrackById(107907786);
}

function setTrackById(id, async = true) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            let track = JSON.parse(req.responseText);
            getAlbumById(track["album"].id, addFeaturedTrack, track)
        }
    };
    req.open("GET", "https://cors-anywhere.herokuapp.com/https://api.deezer.com/track/" + id, async);
    req.send();
}

function addFeaturedAlbum(albumJson) {
    document.getElementById("featured_album").innerHTML += `
        <div class="wide_album_focus">
            <div class="featured_album_info">
                <h2>${albumJson.title}</h2>
                <h3>${albumJson["artist"].name}</h3>  
            </div>
            <img alt="Full Cover Art" src="${albumJson["cover_xl"]}">
            <div class="grey small_text">
                <p>${albumJson["release_date"]}</p>
                <p>${Math.round(albumJson.duration / 60)} min</p>
                <p>${albumJson["genres"].data[0].name}</p>
            </div>
        </div>
    `;
}

function addFeaturedTrack(albumJson, trackJson) {
    let releaseDate = albumJson["release_date"];
    let genre = albumJson["genres"].data[0].name;
    document.getElementById("featured_songs_grid").innerHTML += `
        <div class="album_block" >
            <audio id="audio_${trackJson["album"].id}">
                <source src="${trackJson["preview"]}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio> 
            <div 
                class="cover_art"
                onclick="togglePlay(${trackJson["album"].id})" 
                onmouseover="showIcon(${trackJson["album"].id})"
                onmouseout="hideIcon(${trackJson["album"].id})"
            >
                <img 
                    style="display: none" 
                    class="audio_icon" 
                    id="playIcon_${trackJson["album"].id}"
                    src="images/icons/pause.png" 
                    alt="Pause"
                 >
                <img 
                    style="display: none"  
                    class="audio_icon" 
                    id="pauseIcon_${trackJson["album"].id}" 
                    src="images/icons/play.png" 
                    alt="Play"
                 >
                <img alt="Album Art" src="${albumJson["cover_big"]}">  
            </div>
            <div class="album_info">
                <div class="album_and_artist">
                    <p class="title">${trackJson.title}</h1>
                    <p class="artist">${trackJson["artist"].name}</h2>
                </div>
                <div class="grey small_text padding_tm">
                    <p>${releaseDate}</p>
                    <p>${Math.round(albumJson.duration / 60)} min</p>
                    <p>${genre}</p>
                </div>
            </div>
        </div>
    `;
}


// CALENDAR
//========================================================================================================

function populateCalendar(month = null, year = null) {
    let date;
    if (month != null && year != null) {
        date = new Date(year, month, 0);
        localStorage['month'] = month;
        localStorage['year'] = year;
    } else {
        date = new Date();
        localStorage['month'] = date.getMonth() + 1;
        localStorage['year'] = date.getFullYear();
    }
    document.getElementById("calendar_main").innerHTML = "";
    document.getElementById("date").innerHTML = getMonthName(date.getMonth()) + " " + date.getFullYear();
    let days = parseInt(getDaysInMonth(date.getMonth(), date.getFullYear()));
    for (let i = 0; i < days; i++) {
        addDayToCalendar(i + 1);
    }
    let index = 0;
    let storedPlaylist = localStorage.getItem("playlist" + index);
    while (storedPlaylist != null) {
        let songs = JSON.parse(storedPlaylist).items;
        for (let i = 0; i < songs.length; i++) {
            let track = songs[i].track;
            let y = parseInt(track["album"]["release_date"].substr(0, 4));
            let m = parseInt(track["album"]["release_date"].substr(5, 7)) - 1;
            let d = parseInt(track["album"]["release_date"].substr(8));
            if (y === date.getFullYear() && m === date.getMonth()) {
                addTrackToCalendar(d, track)
            }
        }
        storedPlaylist = localStorage.getItem("playlist" + (++index));
    }
    removeLoadingIcon();
}

function storeSpotifyPlaylist() {
    addLoadingIcon();
    getSpotifyToken(addPlaylistsToInternalStorage);
}

function addPlaylistsToInternalStorage(
    ids = [
        "37i9dQZEVXbmHdDN7MUN7d",
        "37i9dQZF1DWWW9iyuOPGds",
        "1pMB5VwjH6fzf8ldHch1IG",
        "593HKP3qHQXS0RLZmeeHly"
    ],
    index = 0
) {
    if (ids.length > index) {
        let req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (req.readyState === 4 && req.status === 200) {
                localStorage['playlist' + index] = req.responseText;
                addPlaylistsToInternalStorage(ids, index + 1);
            }
        };
        req.open(
            "GET",
            "https://cors-anywhere.herokuapp.com/https://api.spotify.com/v1/playlists/" + ids[index] + "/tracks",
            true
        );
        req.setRequestHeader("Authorization", "Bearer " + localStorage["bearer"]);
        req.send()
    } else {
        populateCalendar();
    }
}

// function getSpotifyPlaylist(id = "37i9dQZF1DWWW9iyuOPGds", callback = populateCalendar) {
//     let req = new XMLHttpRequest();
//     req.onreadystatechange = function () {
//         if(req.readyState == 4 && req.status == 200) {
//             localStorage['playlist'] = req.responseText;
//             callback();
//         }
//     }
//     req.open(
//     "GET",
//     "https://cors-anywhere.herokuapp.com/https://api.spotify.com/v1/playlists/" + id + "/tracks",
//     true
//     );
//     req.setRequestHeader("Authorization", "Bearer " + localStorage["bearer"]);
//     req.send()
// }

function getSpotifyToken(callback) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            localStorage.setItem('bearer', JSON.parse(req.responseText)["access_token"]);
            callback();
        }
    };
    req.open(
        "POST",
        "https://cors-anywhere.herokuapp.com/https://accounts.spotify.com/api/token",
        true
    );
    req.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    req.setRequestHeader(
        "Authorization",
        "Basic NGEwMzdmMGM5OWIyNGUwYjgyMDBkMmRjNDk1ZDU1NDY6OTk4MWU4NDcwOWNlNGMzNzg1ODRjNGI0ZWE5YTc1Mjg="
    );
    req.send("grant_type=client_credentials");
}

function popPrevMonth() {
    let month = parseInt(localStorage['month']) - 1;
    let year = parseInt(localStorage['year']);
    if (month < 0) {
        populateCalendar(11, year - 1);
    } else {
        populateCalendar(month, year);
    }

}

function popNextMonth() {
    let month = parseInt(localStorage['month']) + 1;
    let year = parseInt(localStorage['year']);
    if (month > 11) {
        populateCalendar(0, year + 1);
    } else {
        populateCalendar(month, year);
    }
}

function storePlaylist(id, callback) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            localStorage.setItem("newReleases", req.responseText);
            callback();
        }
    };
    req.open(
        "GET",
        "https://cors-anywhere.herokuapp.com/https://api.deezer.com/playlist/" + id,
        true
    );
    req.send()
}

function addDayToCalendar(day) {
    document.getElementById("calendar_main").innerHTML += `
        <div class="day_instance" id="${day}">
            <h2>${day}</h2>
        </div>
    `;
}

function addTrackToCalendar(day, track) {
    document.getElementById(day).innerHTML += `
        <div class="song_instance" id="${track.id}" >
            <div class="mini_info" onclick="songFocus('${track.id}')">
                <div>
                    <img alt="Album Cover" class="mini_cover" src="${track["album"].images[2].url}">
                </div>
                <div>
                    <h4 class="title">${track.name}</h4>
                </div>
            </div>
        </div>
    `;
}

function songFocus(id) {
    if (localStorage['song_focus'] !== undefined) {
        let toMakeVisible = document.getElementById(localStorage['song_focus']);
        if (toMakeVisible !== null) {
            toMakeVisible.getElementsByTagName("div")[0].style.display = "grid";
        }
    }
    localStorage['song_focus'] = id;
    let toDelete = document.getElementById("large_info");
    if (toDelete != null) {
        toDelete.remove()
    }
    let track = getTrackFromStorage(id);
    let songInstance = document.getElementById(id);
    songInstance.getElementsByTagName("div")[0].style.display = "none";
    songInstance.innerHTML += `
        <div id="large_info" class="large_info">
            <div 
                class="cover_and_audio"
                onclick="togglePlay('${id}')" 
                onmouseover="showIcon('${id}')"
                onmouseout="hideIcon('${id}')"
            >
                <audio id="audio_${id}">
                    <source src="${track["preview_url"]}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <img 
                    style="display: none" 
                    class="audio_icon" 
                    id="playIcon_${id}"
                    src="images/icons/pause.png" 
                    alt="Pause"
                 >
                <img 
                    style="display: block"  
                    class="audio_icon" 
                    id="pauseIcon_${id}" 
                    src="images/icons/play.png" 
                    alt="Play"
                 >
                <img alt="Album Cover" class="large_cover" src="${track["album"].images[1].url}">
            </div>
            <div>
                <h3 class="title">${track.name}</h3>
                <h4>${track["artists"][0].name}</h4>
                <p class="small_text">${Math.round(track["duration_ms"] / 1000)} s</p>
            </div>
        </div>
    `;
}

function togglePlay(id) {
    let audio = document.getElementById("audio_" + id);
    if (audio.paused) {
        audio.play();
    } else {
        audio.pause();
    }
    toggleIcon(id)
}

function toggleIcon(id) {
    let play = document.getElementById("playIcon_" + id);
    let pause = document.getElementById("pauseIcon_" + id);
    if (play.style.display === "none") {
        pause.style.display = "none";
        play.style.display = "block";
    } else {
        play.style.display = "none";
        pause.style.display = "block";
    }
}

function showIcon(id) {
    let audio = document.getElementById("audio_" + id);
    if (audio.paused) {
        let pause = document.getElementById("pauseIcon_" + id);
        pause.style.display = "block";
    } else {
        let play = document.getElementById("playIcon_" + id);
        play.style.display = "block";
    }
}

function hideIcon(id) {
    let audio = document.getElementById("audio_" + id);
    if (audio.paused) {
        let pause = document.getElementById("pauseIcon_" + id);
        pause.style.display = "none";
    } else {
        let play = document.getElementById("playIcon_" + id);
        play.style.display = "none";
    }
}

function getTrackFromStorage(id) {
    let index = 0;
    let storedPlaylist = localStorage.getItem("playlist" + index);
    while (storedPlaylist != null) {
        let songs = JSON.parse(storedPlaylist).items;
        for (let i = 0; i < songs.length; i++) {
            if (songs[i].track.id === id) {
                return songs[i].track;
            }
        }
        storedPlaylist = localStorage.getItem("playlist" + (++index));
    }
}

function gotToToday() {
    let goTo;
    let date = new Date();
    if (date.getFullYear() !== localStorage['year'] || (date.getMonth() + 1) !== localStorage['month']) {
        populateCalendar(date.getMonth() + 1, date.getFullYear());
    }
    let day = (date.getDate()).toString();
    if (day <= 2) {
        goTo = 1;
    } else {
        goTo = day - 2;
    }
    window.location.hash = '#' + (goTo);
    document.getElementById(day).style.backgroundColor = "#383838";
}

// GLOBAL HELPER FUNCTIONS
//========================================================================================================

function getAlbumById(id, callback, track = null, async = true) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            removeLoadingIcon();
            let album = JSON.parse(req.responseText);
            if (track === null) {
                callback(album)
            } else {
                callback(album, track)
            }
        }
    };
    req.open("GET", "https://cors-anywhere.herokuapp.com/https://api.deezer.com/album/" + id, async);
    req.send();
}

function addLoadingIcon() {
    document.getElementById("loading").style.display = "block";
}

function removeLoadingIcon() {
    document.getElementById("loading").style.display = "none";
}

function rating() {
    return 5 + Math.floor(4 * Math.random());
}

function barRating(rating) {
    let bars = "<span>";
    for (let i = 0; i <= rating; i++) {
        bars += "|"
    }
    bars += "</span>";
    for (let i = rating + 1; i <= 10; i++) {
        bars += "|";
    }
    return bars;
}

function getDaysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

function getMonthName(day) {
    let months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    return months[day];
}