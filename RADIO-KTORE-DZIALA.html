<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mini Radio PL</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: #0f0f0f;
        color: #fff;
        padding: 20px;
    }
    .header {
        text-align: center;
        margin-bottom: 30px;
    }
    .header h1 { font-size: 28px; margin-bottom: 8px; }
    .status {
        background: #1a1a1a;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .status.playing { background: #1db954; color: #000; font-weight: 600; }
    .status.error { background: #e22134; }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    .tile {
        background: #1a1a1a;
        border: 2px solid #2a2a2a;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .tile:hover { background: #2a2a2a; border-color: #3a3a3a; }
    .tile.active { background: #1db954; border-color: #1db954; color: #000; }
    .tile .icon {
        width: 80px;
        height: 80px;
        background: #2a2a2a;
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }
    .tile.active .icon { background: rgba(0,0,0,0.2); }
    .tile .name { font-size: 14px; font-weight: 600; line-height: 1.2; }
    .controls {
        position: sticky;
        bottom: 20px;
        background: #1a1a1a;
        padding: 15px;
        border-radius: 16px;
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .btn {
        background: #1db954;
        border: none;
        color: #000;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        font-size: 16px;
    }
    .btn:disabled { background: #2a2a2a; color: #666; cursor: not-allowed; }
    input[type="range"] { flex: 1; accent-color: #1db954; }
    .vol { font-size: 14px; min-width: 45px; }
</style>
</head>
<body>
    <div class="header">
        <h1>Mini Radio PL</h1>
        <p>15 wybranych stacji</p>
    </div>

    <div class="status" id="status">Kliknij kafelek żeby zacząć</div>
    <div class="grid" id="grid"></div>

    <div class="controls">
        <button class="btn" id="playBtn" disabled>Play</button>
        <input type="range" id="volume" min="0" max="100" value="80">
        <span class="vol" id="volText">80%</span>
    </div>

    <audio id="player" crossorigin="anonymous"></audio>

<script>
const STATIONS = [
    { name: 'Antyradio', url: 'https://an01.cdn.eurozet.pl/ant-waw.mp3' },
    { name: 'Muzyczne Radio', url: 'https://pldm1.cdn.eurozet.pl/pldm-148-192.mp3' },
    { name: 'Polskie Radio 24', url: 'https://stream3.polskieradio.pl:8900/' },
    { name: 'Radio Eska Wrocław', url: 'https://ic1.smcdn.pl/2330-1.mp3' },
    { name: 'Radio Kampus', url: 'https://193.0.98.195:8000/radio' },
    { name: 'Radio Kolor', url: 'https://cast.tunzilla.com:8000/radiokolor.mp3' },
    { name: 'Radio Plus', url: 'https://pl01.cdn.eurozet.pl/pls-waw.mp3' },
    { name: 'Radio Republika', url: 'https://stream.radio-republika.pl/radio.mp3' },
    { name: 'Radio Rodzina', url: 'https://stream.radiorodzina.pl:8000/live' },
    { name: 'Radio Wnet', url: 'https://radiownet.pl:8000/live' },
    { name: 'Radio Wrocław', url: 'https://stream4.nadaje.com:9170/rwroc.mp3' },
    { name: 'Radio Złote Przeboje', url: 'https://pldm3.cdn.eurozet.pl/pldm-028-192.mp3' },
    { name: 'RMF FM', url: 'https://rs201-krk.rmfstream.pl/rmf_fm' },
    { name: 'TOK FM', url: 'https://radiostream.pl/tuba.pl/1013-1.mp3' }
];

// Sortowanie alfabetyczne dla pewności
STATIONS.sort((a, b) => a.name.localeCompare(b.name, 'pl'));

const player = document.getElementById('player');
const grid = document.getElementById('grid');
const status = document.getElementById('status');
const playBtn = document.getElementById('playBtn');
const volume = document.getElementById('volume');
const volText = document.getElementById('volText');

let currentStation = null;
player.volume = 0.8;

STATIONS.forEach((st, i) => {
    const tile = document.createElement('div');
    tile.className = 'tile';
    tile.innerHTML = `
        <div class="icon">📻</div>
        <div class="name">${st.name}</div>
    `;
    tile.onclick = () => playStation(i, tile);
    grid.appendChild(tile);
});

function playStation(index, tile) {
    const st = STATIONS[index];
    player.pause();
    document.querySelectorAll('.tile').forEach(t => t.classList.remove('active'));

    currentStation = st;
    tile.classList.add('active');
    status.textContent = 'Ładowanie: ' + st.name + '...';
    status.className = 'status';

    player.src = st.url;
    player.play().then(() => {
        status.textContent = 'Gra: ' + st.name;
        status.className = 'status playing';
        playBtn.textContent = 'Stop';
        playBtn.disabled = false;
    }).catch(err => {
        status.textContent = 'Błąd: ' + st.name + ' - spróbuj ponownie';
        status.className = 'status error';
        tile.classList.remove('active');
        console.error(err);
    });
}

playBtn.onclick = () => {
    if (!currentStation) return;
    if (player.paused) {
        player.play();
        playBtn.textContent = 'Stop';
        status.textContent = 'Gra: ' + currentStation.name;
        status.className = 'status playing';
    } else {
        player.pause();
        playBtn.textContent = 'Play';
        status.textContent = 'Zatrzymane: ' + currentStation.name;
        status.className = 'status';
    }
};

volume.oninput = (e) => {
    player.volume = e.target.value / 100;
    volText.textContent = e.target.value + '%';
};

player.onerror = () => {
    status.textContent = 'Błąd streamu - spróbuj inną stację';
    status.className = 'status error';
    document.querySelector('.tile.active')?.classList.remove('active');
};
</script>
</body>
</html>
