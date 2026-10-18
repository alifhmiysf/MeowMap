
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f7f8f3">
    <title>MeowMap — Temukan Kucing di Sekitarmu</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <style>
        :root {
            --green: #47734c;
            --green-dark: #365b3b;
            --green-light: #f0f5ec;
            --background: #f7f8f3;
            --text: #292b27;
            --muted: #777b72;
            --border: #e8e9e2;
            --danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--background);
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        a {
            color: var(--green);
        }

        [hidden] {
            display: none !important;
        }

        /* ==============================
           HEADER DAN NAVIGASI
        ============================== */

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 5%;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }

        .brand {
            flex-shrink: 0;
            color: var(--green);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.8px;
            text-decoration: none;
        }

        .brand span {
            color: var(--text);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.4;
            text-decoration: none;
            cursor: pointer;
            transition:
                background 0.2s,
                color 0.2s,
                border-color 0.2s;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-outline {
            color: var(--green);
            border-color: #cbd8c9;
            background: #fff;
        }

        .btn-outline:hover {
            border-color: var(--green);
            background: var(--green-light);
        }

        .btn-primary {
            color: #fff;
            background: var(--green);
        }

        .btn-primary:hover {
            background: var(--green-dark);
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            max-width: 230px;
            padding: 7px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--green-light);
        }

        .user-avatar {
            display: grid;
            flex-shrink: 0;
            place-items: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            color: var(--green);
            background: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .user-info {
            min-width: 0;
        }

        .user-info small {
            display: block;
            margin-bottom: 2px;
            color: var(--muted);
            font-size: 10px;
        }

        .user-info strong {
            display: block;
            overflow: hidden;
            max-width: 150px;
            color: var(--text);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ==============================
           LAYOUT UTAMA
        ============================== */

        main {
            width: 100%;
            max-width: 1240px;
            margin: auto;
            padding: 36px 22px;
        }

        .hero {
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--green);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 12px 0;
            font-size: clamp(32px, 5vw, 48px);
            letter-spacing: -1.8px;
            line-height: 1.13;
        }

        .hero p {
            max-width: 650px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.8;
        }

        .map-layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            align-items: start;
            gap: 20px;
        }

        .panel,
        .map-panel {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(41, 43, 39, 0.025);
        }

        .panel {
            padding: 22px;
        }

        .panel h2 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .panel p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .stat {
            margin: 22px 0 28px;
            padding: 18px;
            border: 1px solid #e1eadc;
            border-radius: 14px;
            background: var(--green-light);
        }

        .stat strong {
            display: block;
            margin-bottom: 5px;
            color: var(--green);
            font-size: 32px;
        }

        .stat span {
            color: var(--muted);
            font-size: 12px;
        }

        .map-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 18px 20px;
        }

        .map-heading h2 {
            margin: 0;
            font-size: 17px;
        }

        .map-heading span {
            color: var(--muted);
            font-size: 12px;
        }

        #map {
            width: 100%;
            height: 490px;
            background: #e9eee5;
        }

        /* ==============================
           DAFTAR LAPORAN
        ============================== */

        #report-list {
            display: grid;
            gap: 10px;
            margin-top: 16px;
        }

        .report-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px;
            border: 1px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }

        .report-item:hover {
            border-color: #cbd8c9;
            background: var(--background);
        }

        .report-thumbnail {
            display: grid;
            flex-shrink: 0;
            place-items: center;
            width: 60px;
            height: 60px;
            overflow: hidden;
            border-radius: 10px;
            background: var(--green-light);
            font-size: 25px;
        }

        .report-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .report-item-content {
            min-width: 0;
        }

        .report-item-content strong {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .report-item-content small {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .notice {
            padding: 14px;
            border-radius: 10px;
            color: var(--muted);
            background: var(--background);
            font-size: 12px;
            line-height: 1.7;
        }

        /* ==============================
           FORM LAPORAN
        ============================== */

        #report-form-section {
            margin-top: 24px;
        }

        #report-form-section h2 {
            margin-bottom: 8px;
        }

        #report-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            display: block;
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d9ded5;
            border-radius: 10px;
            outline: none;
            color: var(--text);
            background: #fff;
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(71, 115, 76, 0.1);
        }

        .form-group input[readonly] {
            background: #f5f6f2;
        }

        .form-help {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        #form-message {
            margin-top: 14px;
            white-space: pre-line;
            overflow-wrap: anywhere;
            font-size: 13px;
            line-height: 1.7;
        }

        #form-message.error {
            color: var(--danger);
        }

        #form-message.success {
            color: #26713a;
        }

        footer {
            padding: 26px 18px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
            text-align: center;
        }

        /* ==============================
           MARKER DAN POPUP PETA
        ============================== */

        .cat-photo-marker {
            border: none;
            background: transparent;
        }

        .cat-photo-marker img {
            display: block;
            width: 54px;
            height: 54px;
            border: 3px solid #fff;
            border-radius: 50%;
            background: var(--green-light);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.25);
            object-fit: cover;
            transition: transform 0.2s;
        }

        .cat-photo-marker img:hover {
            transform: scale(1.1);
        }

        .cat-popup {
            width: 230px;
            color: var(--text);
            overflow-wrap: anywhere;
        }

        .cat-popup .popup-cat-photo {
            display: block;
            width: 100%;
            max-height: 180px;
            margin-bottom: 10px;
            border-radius: 10px;
            object-fit: cover;
        }

        .cat-popup h3 {
            margin: 7px 0;
            font-size: 15px;
        }

        .cat-popup p {
            margin: 8px 0;
            color: var(--text);
            font-size: 12px;
            line-height: 1.6;
        }

        .cat-popup .popup-coordinates {
            margin-top: 6px;
            color: var(--muted);
            font-size: 10px;
            overflow-wrap: anywhere;
        }

        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 900px) {
            .site-header {
                padding: 15px 20px;
            }

            .map-layout {
                grid-template-columns: 260px minmax(0, 1fr);
            }

            .nav-actions {
                gap: 7px;
            }

            .btn {
                padding: 9px 11px;
                font-size: 12px;
            }

            .user-badge {
                max-width: 190px;
            }
        }

        @media (max-width: 700px) {
            .site-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .nav-actions {
                justify-content: flex-start;
                width: 100%;
            }

            .user-badge {
                max-width: 100%;
            }

            .user-info strong {
                max-width: 125px;
            }

            main {
                padding: 27px 14px;
            }

            .hero h1 {
                letter-spacing: -1px;
            }

            .hero p {
                font-size: 13px;
            }

            .map-layout {
                grid-template-columns: 1fr;
            }

            #map {
                height: 390px;
            }

            .panel {
                padding: 18px;
            }
        }

        @media (max-width: 380px) {
            .nav-actions {
                gap: 6px;
            }

            .btn {
                padding: 9px;
                font-size: 11px;
            }

            .user-badge {
                padding: 6px 8px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>
    <header class="site-header">
        <a href="/" class="brand">Meow<span>Map.</span></a>

        <nav class="nav-actions" aria-label="Navigasi utama">
            <a href="#map-section" class="btn btn-outline">
                Jelajahi Peta
            </a>

            <a
                href="/login"
                class="btn btn-outline"
                id="login-link"
            >
                Login
            </a>

            <a
                href="/register"
                class="btn btn-outline"
                id="register-link"
            >
                Register
            </a>

            <div class="user-badge" id="user-badge" hidden>
                <div class="user-avatar" id="user-avatar">U</div>

                <div class="user-info">
                    <small>Sedang login sebagai</small>
                    <strong id="user-name">Pengguna</strong>
                </div>
            </div>

            <button
                type="button"
                class="btn btn-outline"
                id="logout-button"
                hidden
            >
                Logout
            </button>

            <button
                type="button"
                class="btn btn-primary"
                id="report-button"
            >
                + Laporkan Kucing
            </button>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="eyebrow">Community-powered cat map</div>

            <h1>Temukan kucing,<br>di sekitar kita.</h1>

            <p>
                Lihat lokasi kucing yang dilaporkan oleh komunitas.
                Bantu orang lain menemukan dan mengenali kucing
                di lingkungan sekitar.
            </p>
        </section>

        <section class="map-layout" id="map-section">
            <aside class="panel">
                <h2>Jelajahi MeowMap</h2>

                <p>
                    Setiap titik di peta menunjukkan laporan kucing
                    yang telah disetujui oleh admin.
                </p>

                <div class="stat">
                    <strong id="report-count">—</strong>
                    <span>Laporan publik</span>
                </div>

                <h2>Laporan terbaru</h2>

                <div id="report-list">
                    <div class="notice">Memuat laporan...</div>
                </div>
            </aside>

            <div class="map-panel">
                <div class="map-heading">
                    <h2>Peta persebaran kucing</h2>
                    <span>📍 Lokasi laporan</span>
                </div>

                <div id="map"></div>
            </div>
        </section>

        <section
            class="panel"
            id="report-form-section"
            hidden
        >
            <h2>🐱 Laporkan Kucing</h2>

            <p>
                Isi informasi kucing dan unggah fotonya.
                Foto wajib disertakan.
            </p>

            <form id="report-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="report_type">Jenis laporan</label>

                    <select id="report_type" name="report_type" required>
                        <option value="">Pilih jenis laporan</option>
                        <option value="lost">Kucing hilang</option>
                        <option value="found">Kucing ditemukan</option>
                        <option value="pet">Kucing peliharaan</option>
                        <option value="adoption">Kucing untuk adopsi</option>
                        <option value="sale">Kucing dijual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi kucing</label>

                    <textarea
                        id="description"
                        name="description"
                        minlength="3"
                        maxlength="1000"
                        required
                        placeholder="Contoh: Kucing oren ditemukan di dekat taman..."
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="latitude">Latitude</label>

                    <input
                        id="latitude"
                        name="latitude"
                        type="number"
                        step="any"
                        min="-90"
                        max="90"
                        readonly
                        required
                        placeholder="Klik lokasi pada peta"
                    >
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude</label>

                    <input
                        id="longitude"
                        name="longitude"
                        type="number"
                        step="any"
                        min="-180"
                        max="180"
                        readonly
                        required
                        placeholder="Klik lokasi pada peta"
                    >

                    <p class="form-help">
                        Klik titik lokasi kucing pada peta di atas
                        untuk menentukan koordinat.
                    </p>
                </div>

                <div class="form-group">
                    <label for="photo">
                        Foto kucing (wajib, maksimal 2 MB)
                    </label>

                    <input
                        id="photo"
                        name="photo"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                    <p class="form-help">
                        Format yang didukung: JPG, PNG, dan WebP.
                    </p>
                </div>

                <div class="form-actions">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="submit-report"
                    >
                        Kirim Laporan
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline"
                        id="cancel-report"
                    >
                        Batal
                    </button>
                </div>

                <p
                    id="form-message"
                    role="status"
                    aria-live="polite"
                ></p>
            </form>
        </section>
    </main>

    <footer>
        MeowMap — Dibangun untuk komunitas pecinta kucing.
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ==========================================
        // KONFIGURASI
        // ==========================================

        const API_BASE = @json(url('/api'));
        const HOME_URL = @json(url('/'));
        const LOGIN_URL = @json(url('/login'));

        const reportList = document.getElementById('report-list');
        const reportCount = document.getElementById('report-count');

        const loginLink = document.getElementById('login-link');
        const registerLink = document.getElementById('register-link');
        const logoutButton = document.getElementById('logout-button');

        const userBadge = document.getElementById('user-badge');
        const userName = document.getElementById('user-name');
        const userAvatar = document.getElementById('user-avatar');

        const reportButton = document.getElementById('report-button');
        const reportSection = document.getElementById('report-form-section');
        const reportForm = document.getElementById('report-form');
        const formMessage = document.getElementById('form-message');
        const submitButton = document.getElementById('submit-report');

        const reportTypes = {
            lost: 'Kucing hilang',
            found: 'Kucing ditemukan',
            pet: 'Kucing peliharaan',
            adoption: 'Kucing untuk adopsi',
            sale: 'Kucing dijual'
        };

        let currentUser = null;
        let selectedLocation = null;
        let locationMarker = null;

        // ==========================================
        // TOKEN DAN STATUS LOGIN
        // ==========================================

        function getToken() {
            return localStorage.getItem('meowmap_token');
        }

        function showLoggedOutState() {
            currentUser = null;

            loginLink.hidden = false;
            registerLink.hidden = false;
            userBadge.hidden = true;
            logoutButton.hidden = true;
        }

        function showLoggedInState(user) {
            currentUser = user;

            loginLink.hidden = true;
            registerLink.hidden = true;
            userBadge.hidden = false;
            logoutButton.hidden = false;

            // Gunakan textContent agar nama tidak diperlakukan sebagai HTML.
            userName.textContent = user.name || user.email || 'Pengguna MeowMap';

            const displayName = (user.name || user.email || 'U')
                .trim();

            userAvatar.textContent = displayName
                ? displayName.charAt(0).toUpperCase()
                : 'U';
        }

        async function checkAuthentication() {
            const token = getToken();

            if (!token) {
                showLoggedOutState();
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/user`, {
                    method: 'GET',
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${token}`
                    }
                });

                if (response.status === 401 || response.status === 403) {
                    localStorage.removeItem('meowmap_token');
                    showLoggedOutState();
                    return;
                }

                if (!response.ok) {
                    throw new Error(
                        `Gagal memeriksa sesi (${response.status}).`
                    );
                }

                const result = await response.json();

                // Mendukung respons user langsung maupun dalam objek data.
                const user =
                    result.data?.user ??
                    result.data ??
                    result.user ??
                    result;

                if (!user || !user.id || !user.name) {
                    throw new Error(
                        'Data pengguna tidak ditemukan dalam respons API.'
                    );
                }

                showLoggedInState(user);

            } catch (error) {
                console.error('Pemeriksaan autentikasi gagal:', error);

                // Jika server sementara tidak bisa dihubungi,
                // jangan langsung menghapus token yang mungkin masih valid.
                loginLink.hidden = true;
                registerLink.hidden = true;
                userBadge.hidden = false;
                logoutButton.hidden = false;
                userName.textContent = 'Sesi belum terverifikasi';
                userAvatar.textContent = '?';
            }
        }

        // ==========================================
        // LOGOUT
        // ==========================================

        logoutButton.addEventListener('click', async function () {
            const token = getToken();

            logoutButton.disabled = true;
            logoutButton.textContent = 'Keluar...';

            try {
                if (token) {
                    await fetch(`${API_BASE}/logout`, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            Authorization: `Bearer ${token}`
                        }
                    });
                }
            } catch (error) {
                console.error('Permintaan logout gagal:', error);
            } finally {
                localStorage.removeItem('meowmap_token');
                showLoggedOutState();

                reportForm.reset();
                reportSection.hidden = true;
                formMessage.textContent = '';
                formMessage.className = '';

                logoutButton.disabled = false;
                logoutButton.textContent = 'Logout';

                window.location.assign(LOGIN_URL);
            }
        });

        // ==========================================
        // INISIALISASI PETA
        // ==========================================

        const map = L.map('map').setView([-7.7956, 110.3695], 13);

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }
        ).addTo(map);

        // ==========================================
        // UTILITAS
        // ==========================================

        function getPhotoUrl(value) {
            if (!value || typeof value !== 'string') {
                return '';
            }

            try {
                const url = new URL(value, window.location.origin);

                if (!['http:', 'https:'].includes(url.protocol)) {
                    return '';
                }

                return url.href;
            } catch {
                return '';
            }
        }

        function createPhotoMarker(photoUrl) {
            const container = document.createElement('div');
            container.className = 'cat-photo-marker';

            if (photoUrl) {
                const image = document.createElement('img');
                image.src = photoUrl;
                image.alt = 'Foto kucing';
                image.loading = 'lazy';
                container.appendChild(image);
            } else {
                container.textContent = '🐱';
                container.style.fontSize = '35px';
                container.style.lineHeight = '54px';
            }

            return L.divIcon({
                className: 'cat-photo-marker',
                html: container.innerHTML,
                iconSize: [54, 54],
                iconAnchor: [27, 27],
                popupAnchor: [0, -28]
            });
        }

        function appendPopupText(parent, tag, text, className = '') {
            const element = document.createElement(tag);
            element.textContent = text;

            if (className) {
                element.className = className;
            }

            parent.appendChild(element);
            return element;
        }

        // ==========================================
        // MEMUAT LAPORAN PUBLIK
        // ==========================================

        async function loadReports() {
            try {
                const response = await fetch(
                    `${API_BASE}/cat-spottings`,
                    {
                        headers: {
                            Accept: 'application/json'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const result = await response.json();
                const reports = Array.isArray(result.data)
                    ? result.data
                    : [];

                reportCount.textContent = result.total ?? reports.length;
                reportList.replaceChildren();

                if (reports.length === 0) {
                    reportList.innerHTML =
                        '<div class="notice">Belum ada laporan kucing yang disetujui.</div>';
                    return;
                }

                const bounds = [];

                reports.forEach(function (report) {
                    const lat = Number(report.latitude);
                    const lng = Number(report.longitude);

                    if (
                        !Number.isFinite(lat) ||
                        !Number.isFinite(lng) ||
                        lat < -90 || lat > 90 ||
                        lng < -180 || lng > 180
                    ) {
                        return;
                    }

                    const photoUrl = getPhotoUrl(report.photo_url);

                    // ------------------------------
                    // MARKER
                    // ------------------------------

                    const marker = L.marker([lat, lng], {
                        icon: createPhotoMarker(photoUrl)
                    }).addTo(map);

                    // ------------------------------
                    // POPUP
                    // ------------------------------

                    const popup = document.createElement('div');
                    popup.className = 'cat-popup';

                    if (photoUrl) {
                        const image = document.createElement('img');
                        image.className = 'popup-cat-photo';
                        image.src = photoUrl;
                        image.alt = 'Foto kucing';
                        image.loading = 'lazy';
                        popup.appendChild(image);
                    }

                    appendPopupText(
                        popup,
                        'h3',
                        `🐱 Laporan Kucing #${report.id}`
                    );

                    appendPopupText(
                        popup,
                        'p',
                        '🏷️ Jenis: ' +
                        (reportTypes[report.report_type] ||
                            'Belum dikategorikan')
                    );

                    appendPopupText(
                        popup,
                        'p',
                        '👤 Pelapor: ' +
                        (report.user?.name || 'Pengguna MeowMap')
                    );

                    appendPopupText(
                        popup,
                        'p',
                        report.description || 'Tidak ada deskripsi.'
                    );

                    

                    appendPopupText(
    popup,
    'div',
    `📍 Kecamatan ${report.district || 'Belum diketahui'}`,
    'popup-coordinates'
);

                    if (report.created_at) {
                        const parsedDate = new Date(report.created_at);

                        const dateText = Number.isNaN(parsedDate.getTime())
                            ? report.created_at
                            : parsedDate.toLocaleString('id-ID');

                        appendPopupText(
                            popup,
                            'div',
                            `🗓️ ${dateText}`,
                            'popup-coordinates'
                        );
                    }

                    marker.bindPopup(popup, { maxWidth: 260 });
                    bounds.push([lat, lng]);

                    // ------------------------------
                    // ITEM DAFTAR LAPORAN
                    // ------------------------------

                    const item = document.createElement('div');
                    item.className = 'report-item';
                    item.tabIndex = 0;
                    item.setAttribute(
                        'aria-label',
                        `Buka lokasi laporan ${report.id}`
                    );

                    const thumbnail = document.createElement('div');
                    thumbnail.className = 'report-thumbnail';

                    if (photoUrl) {
                        const image = document.createElement('img');
                        image.src = photoUrl;
                        image.alt = 'Foto kucing';
                        image.loading = 'lazy';
                        thumbnail.appendChild(image);
                    } else {
                        thumbnail.textContent = '🐱';
                    }

                    const content = document.createElement('div');
                    content.className = 'report-item-content';

                    appendPopupText(
                        content,
                        'strong',
                        `Laporan #${report.id} · ` +
                        (reportTypes[report.report_type] ||
                            'Belum dikategorikan')
                    );

                    appendPopupText(
                        content,
                        'small',
                        report.description || 'Tanpa deskripsi'
                    );

                    appendPopupText(
                        content,
                        'small',
                        `👤 ${report.user?.name || 'Pengguna MeowMap'}`
                    );

                    item.append(thumbnail, content);

                    function openReportLocation() {
                        map.setView([lat, lng], 16);
                        marker.openPopup();
                    }

                    item.addEventListener('click', openReportLocation);

                    item.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openReportLocation();
                        }
                    });

                    reportList.appendChild(item);
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, {
                        padding: [30, 30],
                        maxZoom: 15
                    });
                }

            } catch (error) {
                console.error('Gagal memuat laporan:', error);

                reportList.replaceChildren();

                const notice = document.createElement('div');
                notice.className = 'notice';
                notice.textContent =
                    'Laporan gagal dimuat. Periksa koneksi server Laravel.';

                reportList.appendChild(notice);
            }
        }

        // ==========================================
        // FORM LAPORAN
        // ==========================================

        
function requestCurrentLocation() {
    if (!navigator.geolocation) {
        formMessage.textContent =
            'Browser tidak mendukung GPS. Silakan klik lokasi kucing pada peta.';
        formMessage.className = 'error';
        return;
    }

    formMessage.textContent = 'Meminta izin dan mencari lokasi GPS...';
    formMessage.className = '';

    navigator.geolocation.getCurrentPosition(
        function (position) {
            // Jangan timpa lokasi jika pengguna sudah memilih
            // titik manual ketika GPS masih mencari lokasi.
            if (selectedLocation) {
                return;
            }

            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            selectedLocation = L.latLng(lat, lng);

            document.getElementById('latitude').value =
                lat.toFixed(7);

            document.getElementById('longitude').value =
                lng.toFixed(7);

            if (locationMarker) {
                map.removeLayer(locationMarker);
            }

            locationMarker = L.marker(selectedLocation)
                .addTo(map)
                .bindPopup('Lokasi GPS kamu');

            map.setView(selectedLocation, 16);
            locationMarker.openPopup();

            formMessage.textContent =
                'Lokasi GPS berhasil ditemukan. Klik peta jika ingin mengubah lokasi kucing.';
            formMessage.className = 'success';
        },
        function (error) {
            let message;

            switch (error.code) {
                case error.PERMISSION_DENIED:
                    message =
                        'Izin lokasi ditolak. Kamu tetap bisa memilih lokasi kucing dengan mengeklik peta.';
                    break;

                case error.POSITION_UNAVAILABLE:
                    message =
                        'Lokasi GPS tidak tersedia. Silakan pilih lokasi secara manual pada peta.';
                    break;

                case error.TIMEOUT:
                    message =
                        'Pencarian GPS terlalu lama. Silakan pilih lokasi secara manual pada peta.';
                    break;

                default:
                    message =
                        'GPS gagal ditemukan. Silakan pilih lokasi secara manual pada peta.';
            }

            formMessage.textContent = message;
            formMessage.className = 'error';
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        }
    );
}

reportButton.addEventListener('click', function () {
    if (!getToken() || !currentUser) {
        window.location.assign(LOGIN_URL);
        return;
    }

    reportSection.hidden = false;

    reportSection.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });

    setTimeout(function () {
        map.invalidateSize();
    }, 250);

    // Cari lokasi GPS secara otomatis ketika form dibuka.
    // Jika pengguna sudah memiliki pilihan lokasi, pertahankan.
    if (!selectedLocation) {
        requestCurrentLocation();
    }
});


        // ==========================================
        // SUBMIT LAPORAN
        // ==========================================

        reportForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            formMessage.textContent = '';
            formMessage.className = '';

            const token = getToken();

            if (!token || !currentUser) {
                formMessage.textContent =
                    'Silakan login sebelum mengirim laporan.';
                formMessage.className = 'error';
                return;
            }

            const reportType =
                document.getElementById('report_type').value;

            const description =
                document.getElementById('description').value.trim();

            const photo =
                document.getElementById('photo').files[0];

            if (!reportType) {
                formMessage.textContent = 'Pilih jenis laporan.';
                formMessage.className = 'error';
                return;
            }

            if (description.length < 3) {
                formMessage.textContent =
                    'Deskripsi minimal 3 karakter.';
                formMessage.className = 'error';
                return;
            }

            if (!photo) {
                formMessage.textContent = 'Foto kucing wajib diunggah.';
                formMessage.className = 'error';
                return;
            }

            if (photo.size > 2 * 1024 * 1024) {
                formMessage.textContent =
                    'Ukuran foto maksimal 2 MB.';
                formMessage.className = 'error';
                return;
            }

            if (!['image/jpeg', 'image/png', 'image/webp'].includes(photo.type)) {
                formMessage.textContent =
                    'Format foto harus JPG, PNG, atau WebP.';
                formMessage.className = 'error';
                return;
            }

            if (!selectedLocation) {
                formMessage.textContent =
                    'Pilih lokasi kucing pada peta terlebih dahulu.';
                formMessage.className = 'error';
                return;
            }

            const formData = new FormData();

            formData.append('report_type', reportType);
            formData.append('description', description);
            formData.append(
                'latitude',
                selectedLocation.lat.toFixed(7)
            );
            formData.append(
                'longitude',
                selectedLocation.lng.toFixed(7)
            );
            formData.append('photo', photo);

            submitButton.disabled = true;
            submitButton.textContent = 'Mengirim...';

            try {
                const response = await fetch(
                    `${API_BASE}/cat-spottings`,
                    {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            Authorization: `Bearer ${token}`
                        },
                        body: formData
                    }
                );

                const result = await response.json().catch(function () {
                    return {};
                });

                if (response.status === 401) {
                    localStorage.removeItem('meowmap_token');
                    showLoggedOutState();

                    throw new Error(
                        'Sesi login tidak valid. Silakan login kembali.'
                    );
                }

                if (response.status === 422) {
                    const errors = Object.values(
                        result.errors || {}
                    ).flat();

                    throw new Error(
                        errors.join('\n') ||
                        'Data laporan tidak valid.'
                    );
                }

                if (response.status === 413) {
                    throw new Error('Ukuran file terlalu besar.');
                }

                if (!response.ok) {
                    throw new Error(
                        result.message ||
                        `Gagal mengirim laporan (${response.status}).`
                    );
                }

                formMessage.textContent =
                    result.message ||
                    'Laporan berhasil dikirim dan menunggu persetujuan admin.';

                formMessage.className = 'success';

                reportForm.reset();
                selectedLocation = null;

                if (locationMarker) {
                    map.removeLayer(locationMarker);
                    locationMarker = null;
                }

                // Laporan pending tidak ditambahkan ke peta publik.
                // Daftar publik tetap menampilkan laporan yang disetujui.

            } catch (error) {
                formMessage.textContent =
                    error.message ||
                    'Terjadi kesalahan saat mengirim laporan.';

                formMessage.className = 'error';

            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Kirim Laporan';
            }
        });

        // ==========================================
        // JALANKAN HALAMAN
        // ==========================================

        async function initializePage() {
            await checkAuthentication();
            await loadReports();
        }

        initializePage();
    </script>
</body>
</html>
