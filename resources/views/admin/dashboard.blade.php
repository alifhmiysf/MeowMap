
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MeowMap</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #202938;
        }

        button, input, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        button:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .hidden {
            display: none !important;
        }

        .login-wrapper {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 12px 35px #1725540c;
        }

        .brand {
            color: #0f766e;
            font-size: 25px;
            font-weight: 800;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .field {
            display: grid;
            gap: 7px;
            margin-top: 18px;
        }

        .field input,
        .select-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: white;
            color: #202938;
        }

        .btn {
            border: 0;
            border-radius: 9px;
            padding: 11px 15px;
            font-weight: 700;
        }

        .btn-primary {
            background: #0f766e;
            color: white;
        }

        .btn-primary:hover {
            background: #115e59;
        }

        .btn-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .btn-light {
            background: #f3f4f6;
            color: #374151;
        }

        .full {
            width: 100%;
            margin-top: 22px;
        }

        .message {
            margin-top: 14px;
            font-size: 14px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .error {
            color: #b91c1c;
        }

        .success {
            color: #047857;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 240px;
            padding: 26px 18px;
            background: #123b39;
            color: white;
            z-index: 10;
        }

        .sidebar .brand {
            color: #99f6e4;
        }

        .sidebar p {
            color: #cbd5e1;
            font-size: 13px;
        }

        .nav-button {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            text-align: left;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: white;
        }

        .nav-button.active,
        .nav-button:hover {
            background: #ffffff20;
        }

        .sidebar-footer {
            position: absolute;
            right: 18px;
            bottom: 24px;
            left: 18px;
        }

        .sidebar-footer .btn {
            width: 100%;
        }

        .main {
            margin-left: 240px;
            padding: 32px;
            min-width: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        h2 {
            margin: 0 0 8px;
            font-size: 19px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin: 28px 0;
        }

        .charts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin: 28px 0;
        }

        .stat,
        .report-card {
            min-width: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
        }

        .stat-number {
            margin-top: 12px;
            font-size: 30px;
            font-weight: 800;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 280px;
            margin-top: 18px;
        }

        .chart-container canvas {
            max-width: 100%;
        }

        .tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 25px 0 18px;
        }

        .tab {
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: white;
            color: #374151;
        }

        .tab.active {
            background: #123b39;
            color: white;
            border-color: #123b39;
        }

        .report-list {
            display: grid;
            gap: 15px;
        }

        .report-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            background: #f3f4f6;
        }

        .badge.pending {
            color: #92400e;
            background: #fef3c7;
        }

        .badge.approved {
            color: #065f46;
            background: #d1fae5;
        }

        .badge.rejected {
            color: #991b1b;
            background: #fee2e2;
        }

        .description {
            margin: 18px 0;
            overflow-wrap: anywhere;
            line-height: 1.6;
        }

        .report-meta {
            display: grid;
            gap: 8px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .report-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .empty {
            padding: 40px 20px;
            text-align: center;
            color: #6b7280;
            background: white;
            border: 1px dashed #d1d5db;
            border-radius: 14px;
        }

        @media (max-width: 1000px) {
            .charts {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                position: static;
                width: 100%;
                padding: 18px;
            }

            .sidebar-footer {
                position: static;
                margin-top: 20px;
            }

            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            h1 {
                font-size: 23px;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>

<body>

    <!-- ================= LOGIN ================= -->

    <section id="loginPage" class="login-wrapper">
        <form id="loginForm" class="login-card">
            <div class="brand">🐱 MeowMap</div>

            <h2 style="margin-top: 24px">Admin Login</h2>

            <p class="muted">
                Masuk untuk mengelola dan memoderasi laporan kucing.
            </p>

            <label class="field">
                <span>Email admin</span>
                <input
                    type="email"
                    id="email"
                    required
                    autocomplete="username"
                    placeholder="admin@example.com"
                >
            </label>

            <label class="field">
                <span>Password</span>
                <input
                    type="password"
                    id="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                >
            </label>

            <button
                id="loginButton"
                class="btn btn-primary full"
                type="submit"
            >
                Masuk ke Dashboard
            </button>

            <p id="loginMessage" class="message" role="status"></p>
        </form>
    </section>


    <!-- ================= ADMIN DASHBOARD ================= -->

    <section id="dashboardPage" class="hidden">

        <aside class="sidebar">
            <div class="brand">🐱 MeowMap</div>
            <p>ADMINISTRATION PANEL</p>

            <button
                class="nav-button active"
                type="button"
            >
                📋 Moderasi Laporan
            </button>

            <div class="sidebar-footer">
                <p id="adminEmail">Administrator</p>

                <button
                    id="logoutButton"
                    class="btn btn-light"
                    type="button"
                >
                    Keluar
                </button>
            </div>
        </aside>


        <main class="main">

            <!-- HEADER -->

            <header class="topbar">
                <div>
                    <h1>Dashboard Admin</h1>
                    <p class="muted">
                        Kelola laporan dan pantau perkembangan laporan kucing.
                    </p>
                </div>

                <button
                    id="refreshButton"
                    class="btn btn-light"
                    type="button"
                >
                    ↻ Refresh
                </button>
            </header>


            <!-- STATISTIK -->

            <section class="stats">

                <div class="stat">
                    <div class="muted">Menunggu moderasi</div>
                    <div id="pendingCount" class="stat-number">—</div>
                </div>

                <div class="stat">
                    <div class="muted">Disetujui</div>
                    <div id="approvedCount" class="stat-number">—</div>
                </div>

                <div class="stat">
                    <div class="muted">Ditolak</div>
                    <div id="rejectedCount" class="stat-number">—</div>
                </div>

            </section>


            <!-- GRAFIK ANALITIK -->

            <section class="charts">

                <div class="stat">
                    <h2>Tren laporan</h2>

                    <p class="muted">
                        Jumlah laporan yang masuk per hari.
                    </p>

                    <label for="trendDays">Periode grafik</label>

                    <select id="trendDays" class="select-input">
                        <option value="7">7 hari terakhir</option>
                        <option value="30" selected>30 hari terakhir</option>
                        <option value="90">90 hari terakhir</option>
                    </select>

                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>

                    <p id="growthSummary" class="muted" aria-live="polite">
                        Memuat analitik...
                    </p>
                </div>


                <div class="stat">
                    <h2>Laporan per kecamatan</h2>

                    <p class="muted">
                        Distribusi laporan berdasarkan kecamatan yang teridentifikasi.
                    </p>

                    <div class="chart-container">
                        <canvas id="districtChart"></canvas>
                    </div>

                    <p id="districtSummary" class="muted"></p>
                </div>

            </section>


            <!-- MODERASI LAPORAN -->

            <section>
                <h2>Daftar laporan</h2>

                <p class="muted">
                    Periksa laporan, setujui, tolak, atau hapus dari daftar aktif.
                </p>

                <div class="tabs">
                    <button
                        class="tab active"
                        data-status="pending"
                        type="button"
                    >
                        Pending
                    </button>

                    <button
                        class="tab"
                        data-status="approved"
                        type="button"
                    >
                        Approved
                    </button>

                    <button
                        class="tab"
                        data-status="rejected"
                        type="button"
                    >
                        Rejected
                    </button>
                </div>

                <p id="listMessage" class="message" role="status"></p>

                <div id="reportList" class="report-list"></div>
            </section>

        </main>
    </section>


    <!-- Chart.js harus dimuat sebelum JavaScript dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        'use strict';

        // =================================================
        // KONFIGURASI
        // =================================================

        const API_BASE = window.location.origin;
        const TOKEN_KEY = 'meowmap_admin_token';

        const loginPage = document.getElementById('loginPage');
        const dashboardPage = document.getElementById('dashboardPage');
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loginMessage = document.getElementById('loginMessage');
        const listMessage = document.getElementById('listMessage');
        const reportList = document.getElementById('reportList');
        const trendDays = document.getElementById('trendDays');
        const growthSummary = document.getElementById('growthSummary');
        const districtSummary = document.getElementById('districtSummary');

        let currentStatus = 'pending';
        let reports = [];
        let trendChart = null;
        let districtChart = null;
        let dashboardLoading = false;


        const statusLabels = {
            pending: 'Menunggu moderasi',
            approved: 'Disetujui',
            rejected: 'Ditolak'
        };

        const typeLabels = {
            lost: 'Kucing Hilang',
            found: 'Kucing Ditemukan',
            pet: 'Kucing Peliharaan',
            adoption: 'Kucing untuk Adopsi',
            sale: 'Kucing Dijual'
        };


        // =================================================
        // AUTENTIKASI DAN REQUEST API
        // =================================================

        function getToken() {
            return sessionStorage.getItem(TOKEN_KEY);
        }


        async function apiRequest(path, options = {}) {
            const headers = {
                Accept: 'application/json',
                ...(options.body
                    ? { 'Content-Type': 'application/json' }
                    : {}),
                ...(getToken()
                    ? { Authorization: `Bearer ${getToken()}` }
                    : {}),
                ...options.headers
            };

            const response = await fetch(`${API_BASE}${path}`, {
                ...options,
                headers
            });

            const text = await response.text();

            let payload = {};

            try {
                payload = text ? JSON.parse(text) : {};
            } catch {
                payload = {};
            }

            if (!response.ok) {
                if (response.status === 401) {
                    sessionStorage.removeItem(TOKEN_KEY);
                }

                if (response.status === 403) {
                    throw new Error(
                        'Akses ditolak. Akun tidak memiliki izin administrator.'
                    );
                }

                throw new Error(
                    payload.message ||
                    `Permintaan gagal (${response.status}).`
                );
            }

            return payload;
        }


        function extractUser(result) {
            return result.user ?? result.data ?? result;
        }


        function showLogin(message = '') {
            loginPage.classList.remove('hidden');
            dashboardPage.classList.add('hidden');

            loginMessage.textContent = message;
            loginMessage.className = message
                ? 'message error'
                : 'message';
        }


        function showDashboard() {
            loginPage.classList.add('hidden');
            dashboardPage.classList.remove('hidden');
        }


        async function verifyAdmin() {
            const result = await apiRequest('/api/user');
            const user = extractUser(result);

            if (!user || user.role !== 'admin') {
                throw new Error(
                    'Akun ini tidak memiliki akses admin.'
                );
            }

            document.getElementById('adminEmail').textContent =
                user.email || 'Administrator';

            return user;
        }


        // =================================================
        // LOGIN
        // =================================================

        loginForm.addEventListener('submit', async event => {
            event.preventDefault();

            loginButton.disabled = true;
            loginButton.textContent = 'Memeriksa akun...';
            loginMessage.textContent = '';

            try {
                const result = await apiRequest('/api/login', {
                    method: 'POST',
                    body: JSON.stringify({
                        email: document.getElementById('email').value.trim(),
                        password: document.getElementById('password').value
                    })
                });

                const token =
                    result.token ??
                    result.access_token ??
                    result.data?.token ??
                    result.data?.access_token;

                if (!token || typeof token !== 'string') {
                    throw new Error(
                        'Token tidak ditemukan. Periksa format respons API login.'
                    );
                }

                sessionStorage.setItem(TOKEN_KEY, token);

                await verifyAdmin();

                showDashboard();
                await refreshDashboard();

            } catch (error) {
                sessionStorage.removeItem(TOKEN_KEY);
                showLogin(error.message);
            } finally {
                loginButton.disabled = false;
                loginButton.textContent = 'Masuk ke Dashboard';
            }
        });


        // =================================================
        // AMBIL DAFTAR LAPORAN
        // =================================================

        async function fetchReports(status) {
            const result = await apiRequest(
                `/api/admin/cat-spottings?status=${encodeURIComponent(status)}`
            );

            // Mendukung array biasa dan pagination Laravel.
            if (Array.isArray(result.data)) {
                return result.data;
            }

            if (Array.isArray(result.data?.data)) {
                return result.data.data;
            }

            if (Array.isArray(result)) {
                return result;
            }

            return [];
        }


        // =================================================
        // REFRESH DASHBOARD
        // =================================================

        async function refreshDashboard() {
            if (dashboardLoading) {
                return;
            }

            dashboardLoading = true;

            const refreshButton =
                document.getElementById('refreshButton');

            refreshButton.disabled = true;
            listMessage.textContent = 'Memuat laporan...';
            listMessage.className = 'message';
            reportList.replaceChildren();

            try {
                const [pending, approved, rejected] = await Promise.all([
                    fetchReports('pending'),
                    fetchReports('approved'),
                    fetchReports('rejected')
                ]);

                document.getElementById('pendingCount').textContent =
                    pending.length;

                document.getElementById('approvedCount').textContent =
                    approved.length;

                document.getElementById('rejectedCount').textContent =
                    rejected.length;

                reports = await fetchReports(currentStatus);

                renderReports();

                listMessage.textContent = '';

            } catch (error) {
                listMessage.textContent = error.message;
                listMessage.className = 'message error';

                // Jangan mempertahankan akses jika token kedaluwarsa.
                if (!getToken()) {
                    reports = [];
                    showLogin('Sesi berakhir. Silakan login kembali.');
                }
            } finally {
                refreshButton.disabled = false;
                dashboardLoading = false;
            }

            // Kegagalan grafik tidak menghalangi moderasi laporan.
            if (getToken() && !dashboardPage.classList.contains('hidden')) {
                await loadAnalytics();
            }
        }


        // =================================================
        // ANALITIK DAN GRAFIK
        // =================================================

        async function loadAnalytics() {
            growthSummary.textContent = 'Memuat tren laporan...';
            districtSummary.textContent = '';

            try {
                const days = Number(trendDays.value);

                if (![7, 30, 90].includes(days)) {
                    throw new Error('Periode grafik tidak valid.');
                }

                const analytics = await apiRequest(
                    `/api/admin/analytics?days=${days}`
                );

                if (
                    !analytics.summary ||
                    !Array.isArray(analytics.trend) ||
                    !Array.isArray(analytics.districts)
                ) {
                    throw new Error(
                        'Format respons analitik tidak sesuai. Periksa endpoint /api/admin/analytics.'
                    );
                }

                renderTrendChart(analytics.trend);
                renderDistrictChart(analytics.districts);

                renderGrowthSummary(analytics.summary);

            } catch (error) {
                growthSummary.textContent =
                    `Grafik tren gagal dimuat: ${error.message}`;

                districtSummary.textContent =
                    'Grafik kecamatan gagal dimuat. Periksa endpoint analitik.';

                console.error('Analytics error:', error);
            }
        }


        function renderTrendChart(trend) {
            const labels = trend.map(item => item.date);
            const totals = trend.map(item => Number(item.total) || 0);

            if (trendChart) {
                trendChart.destroy();
            }

            trendChart = new Chart(
                document.getElementById('trendChart'),
                {
                    type: 'line',

                    data: {
                        labels,

                        datasets: [{
                            label: 'Jumlah laporan',
                            data: totals,
                            borderColor: '#0f766e',
                            backgroundColor: 'rgba(15, 118, 110, 0.12)',
                            borderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.3
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: true
                            }
                        },

                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                }
            );
        }


        function renderDistrictChart(districtData) {
            const districts = districtData.filter(item =>
                item.district &&
                item.district !== 'Belum diketahui'
            );

            if (districtChart) {
                districtChart.destroy();
            }

            districtChart = new Chart(
                document.getElementById('districtChart'),
                {
                    type: 'bar',

                    data: {
                        labels: districts.map(item => item.district),

                        datasets: [{
                            label: 'Jumlah laporan',
                            data: districts.map(item => Number(item.total) || 0),
                            backgroundColor: '#0f766e',
                            borderRadius: 5
                        }]
                    },

                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            }
                        },

                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                }
            );

            if (districts.length === 0) {
                districtSummary.textContent =
                    'Belum ada data kecamatan yang teridentifikasi. Isi kolom district terlebih dahulu.';
            } else {
                districtSummary.textContent =
                    `${districts.length} kecamatan memiliki laporan teridentifikasi.`;
            }
        }


        function renderGrowthSummary(summary) {
            const current = Number(summary.current_period) || 0;
            const previous = Number(summary.previous_period) || 0;
            const growth = summary.growth_percentage;

            if (growth === null || growth === undefined) {
                growthSummary.textContent =
                    `Periode ini: ${current} laporan. Periode sebelumnya: ${previous} laporan. Persentase perubahan belum dapat dihitung karena periode sebelumnya tidak memiliki laporan.`;

                return;
            }

            const percentage = Number(growth);

            if (!Number.isFinite(percentage)) {
                growthSummary.textContent =
                    'Persentase perubahan tidak tersedia.';

                return;
            }

            const direction = percentage > 0
                ? 'Naik'
                : percentage < 0
                    ? 'Turun'
                    : 'Tetap';

            growthSummary.textContent =
                `${direction} ${Math.abs(percentage)}% dibandingkan periode sebelumnya. ` +
                `Periode ini: ${current} laporan; periode sebelumnya: ${previous} laporan.`;
        }


        trendDays.addEventListener('change', loadAnalytics);


        // =================================================
        // MEMBANGUN ELEMEN LAPORAN DENGAN AMAN
        // =================================================

        function createText(tag, text, className = '') {
            const element = document.createElement(tag);

            // textContent mencegah deskripsi laporan diperlakukan sebagai HTML.
            element.textContent = text ?? '—';

            if (className) {
                element.className = className;
            }

            return element;
        }


        // =================================================
        // RENDER DAFTAR LAPORAN
        // =================================================

        function renderReports() {
            reportList.replaceChildren();

            if (reports.length === 0) {
                reportList.appendChild(
                    createText(
                        'div',
                        'Tidak ada laporan pada kategori ini.',
                        'empty'
                    )
                );

                return;
            }

            reports.forEach(report => {
                const card = document.createElement('article');
                card.className = 'report-card';

                const top = document.createElement('div');
                top.className = 'report-top';

                const title = createText(
                    'h2',
                    `🐱 Laporan Kucing #${report.id}`
                );

                const badge = createText(
                    'span',
                    statusLabels[report.status] || report.status,
                    `badge ${report.status}`
                );

                top.append(title, badge);
                card.appendChild(top);


                const type = typeLabels[report.report_type] ||
                    'Belum dikategorikan';

                card.appendChild(
                    createText('p', `🏷️ Jenis: ${type}`)
                );


                const reporter =
                    report.user?.name ??
                    report.reporter?.name ??
                    report.reporter_name ??
                    'Tidak diketahui';

                card.appendChild(
                    createText('p', `👤 Pelapor: ${reporter}`)
                );


                card.appendChild(
                    createText(
                        'p',
                        report.description || 'Tidak ada deskripsi.',
                        'description'
                    )
                );


                const meta = document.createElement('div');
                meta.className = 'report-meta';

                meta.appendChild(
                    createText(
                        'span',
                        `📍 Latitude: ${report.latitude ?? '—'}`
                    )
                );

                meta.appendChild(
                    createText(
                        'span',
                        `📍 Longitude: ${report.longitude ?? '—'}`
                    )
                );

                meta.appendChild(
                    createText(
                        'span',
                        `🗓️ ${report.created_at
                            ? new Date(report.created_at).toLocaleString('id-ID')
                            : 'Tanggal tidak tersedia'}`
                    )
                );

                if (report.district) {
                    meta.appendChild(
                        createText(
                            'span',
                            `📌 Kecamatan: ${report.district}`
                        )
                    );
                }

                card.appendChild(meta);


                // Tombol moderasi hanya muncul untuk laporan pending.
                if (report.status === 'pending') {
                    const actions = document.createElement('div');
                    actions.className = 'report-actions';

                    const approveButton = createText(
                        'button',
                        '✓ Setujui',
                        'btn btn-primary'
                    );

                    approveButton.type = 'button';

                    const rejectButton = createText(
                        'button',
                        '✕ Tolak',
                        'btn btn-danger'
                    );

                    rejectButton.type = 'button';

                    approveButton.addEventListener('click', () =>
                        moderateReport(report.id, 'approved')
                    );

                    rejectButton.addEventListener('click', () =>
                        moderateReport(report.id, 'rejected')
                    );

                    actions.append(approveButton, rejectButton);
                    card.appendChild(actions);
                }


                // Soft delete tersedia untuk semua kategori laporan.
                const deleteActions = document.createElement('div');
                deleteActions.className = 'report-actions';

                const deleteButton = createText(
                    'button',
                    '🗑 Hapus laporan',
                    'btn btn-danger'
                );

                deleteButton.type = 'button';

                deleteButton.addEventListener('click', () =>
                    softDeleteReport(report.id)
                );

                deleteActions.appendChild(deleteButton);
                card.appendChild(deleteActions);

                reportList.appendChild(card);
            });
        }


        // =================================================
        // MODERASI: APPROVE / REJECT
        // =================================================

        async function moderateReport(id, status) {
            const action = status === 'approved'
                ? 'menyetujui'
                : 'menolak';

            if (!confirm(`Yakin ingin ${action} laporan #${id}?`)) {
                return;
            }

            try {
                await apiRequest(
                    `/api/admin/cat-spottings/${id}/status`,
                    {
                        method: 'PATCH',
                        body: JSON.stringify({ status })
                    }
                );

                listMessage.textContent =
                    `Laporan #${id} berhasil diperbarui.`;

                listMessage.className = 'message success';

                await refreshDashboard();

            } catch (error) {
                listMessage.textContent = error.message;
                listMessage.className = 'message error';
            }
        }


        // =================================================
        // SOFT DELETE LAPORAN
        // =================================================

        async function softDeleteReport(id) {
            const confirmed = confirm(
                `Laporan #${id} akan dihapus dari daftar aktif. Lanjutkan?`
            );

            if (!confirmed) {
                return;
            }

            try {
                await apiRequest(
                    `/api/admin/cat-spottings/${id}`,
                    {
                        method: 'DELETE'
                    }
                );

                listMessage.textContent =
                    `Laporan #${id} berhasil dihapus dari daftar aktif.`;

                listMessage.className = 'message success';

                await refreshDashboard();

            } catch (error) {
                listMessage.textContent = error.message;
                listMessage.className = 'message error';
            }
        }


        // =================================================
        // NAVIGASI TAB STATUS
        // =================================================

        document.querySelectorAll('[data-status]').forEach(button => {
            button.addEventListener('click', async () => {
                currentStatus = button.dataset.status;

                document.querySelectorAll('[data-status]').forEach(tab => {
                    tab.classList.toggle('active', tab === button);
                });

                await refreshDashboard();
            });
        });


        // =================================================
        // REFRESH MANUAL
        // =================================================

        document.getElementById('refreshButton').addEventListener(
            'click',
            refreshDashboard
        );


        // =================================================
        // LOGOUT
        // =================================================

        document.getElementById('logoutButton').addEventListener(
            'click',
            async () => {
                try {
                    await apiRequest('/api/logout', {
                        method: 'POST'
                    });
                } catch (error) {
                    console.error('Logout API:', error.message);
                } finally {
                    sessionStorage.removeItem(TOKEN_KEY);

                    reports = [];

                    if (trendChart) {
                        trendChart.destroy();
                        trendChart = null;
                    }

                    if (districtChart) {
                        districtChart.destroy();
                        districtChart = null;
                    }

                    showLogin('Kamu telah keluar dari dashboard admin.');
                }
            }
        );


        // =================================================
        // INISIALISASI DASHBOARD
        // =================================================

        async function initializeDashboard() {
            if (!getToken()) {
                showLogin();
                return;
            }

            try {
                await verifyAdmin();

                showDashboard();

                await refreshDashboard();

            } catch (error) {
                sessionStorage.removeItem(TOKEN_KEY);
                showLogin(error.message);
            }
        }

        initializeDashboard();
    </script>

</body>
</html>
