{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Web Bantul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f7f9fc;
            color: #333;
        }

        nav {
            background-color: #fff;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #4f46e5;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                background: #fff;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                padding: 1rem 2rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .nav-links.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }
        }

        .hero-header {
            background: linear-gradient(900deg, #4f46e5, #6366f1);
            color: white;
            text-align: center;
            padding: 4rem 1rem;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .hero-header::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .hero-header h1 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .hero-header .tagline {
            font-size: 1rem;
            font-weight: 300;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.8;
            color: #f0f0f0;
        }

        section {
            padding: 3rem 1rem;
            max-width: 900px;
            margin: auto;
        }

        .section-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #ccc;
            display: inline-block;
        }

        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: transform 0.6s ease, opacity 0.6s ease;
            opacity: 0;
            transform: translateY(30px);
        }

        .card.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .with-blob {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .with-blob::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .with-blob::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -40px;
            width: 150px;
            height: 150px;
            background: rgba(99, 102, 241, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        footer {
            background: #4f46e5;
            color: white;
            text-align: center;
            padding: 1.5rem;
            margin-top: 0;
        }

        a {
            color: #4f46e5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav>
        <div style="max-width: 300px; margin: auto;">
            <svg width="300" height="80" viewBox="0 0 800 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Gradasi -->
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#6366f1; stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#4f46e5; stop-opacity:1" />
                    </linearGradient>
                </defs>

                <!-- Icon Globe with Wave -->
                <g transform="translate(0, 10)">
                    <circle cx="60" cy="60" r="50" fill="url(#grad)" />
                    <path d="M15 60 Q40 40 65 60 T110 60" stroke="white" stroke-width="5" fill="none" />
                    <path d="M15 70 Q40 90 65 70 T110 70" stroke="white" stroke-width="5" fill="none" />
                </g>

                <!-- Text -->
                <text x="140" y="75" fill="url(#grad)" font-family="Poppins, sans-serif" font-size="48"
                    font-weight="700" letter-spacing="1">
                    Buat Web Bantul
                </text>
            </svg>

        </div>
        <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">☰</button>
        <div class="nav-links">
            <a href="#home">Beranda</a>
            <a href="#tentang">Tentang</a>
            <a href="#alasan">Kenapa Kami</a>
            <a href="#digitalisasi">Digitalisasi</a>
            <a href="#kontak">Kontak</a>
        </div>
    </nav>


    <!-- Header -->
    <header class="hero-header" id="home">
        <div class="hero-content">
            <h1>Buat Web Bantul</h1>
            <p class="tagline">
                Mitra digital terpercaya dari Bantul.<br />
                <b>Spesialis website & Java Web Service — Web Sekolah, API Service, Payment Gateway, E-Commerce, dan
                    lainnya.</b>
            </p>
        </div>
    </header>

    <!-- Tentang -->
    <section id="tentang">
        <h2 class="section-title">Tentang Kami</h2>
        <p style="font-size: 1.05rem; line-height: 1.8;">
            <strong>Buat Web Bantul</strong> adalah tim developer lokal yang fokus membantu digitalisasi usaha, sekolah,
            dan instansi di wilayah Bantul dan sekitarnya.
            Kami berpengalaman mengembangkan aplikasi berbasis Java dan Laravel, dari sistem informasi sekolah,
            e-commerce, layanan API, hingga integrasi pembayaran.
        </p>
    </section>

    <!-- Kenapa Kami -->
    <section class="with-blob" id="alasan">
        <h2 class="section-title">Kenapa Memilih Kami?</h2>
        <div class="portfolio-grid">
            <div class="card">
                <h3>Teknologi Modern</h3>
                <p>Kami gunakan teknologi terbaru: Java Spring Boot, Laravel, REST API, dan arsitektur scalable.</p>
            </div>
            <div class="card">
                <h3>Fleksibel & Custom</h3>
                <p>Setiap sistem dibangun sesuai kebutuhan Anda, bukan template jadi — hasilnya unik dan efisien.</p>
            </div>
            <div class="card">
                <h3>Support & Training</h3>
                <p>Kami bantu sampai paham. Termasuk pelatihan, dokumentasi, dan dukungan pasca implementasi.</p>
            </div>
        </div>
    </section>

    <!-- Digitalisasi -->
    <section class="section-3" id="digitalisasi" style="text-align: center;">
        <h2 class="section-title">Siap Digitalisasi?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Konsultasikan kebutuhan aplikasi atau website Anda. Gratis tanpa komitmen.
        </p>

        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="mailto:sigit.fatuhrahman@gmail.com"
                style="display: flex; align-items: center; gap: 0.5rem; background-color: #4f46e5; color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                📧 Kirim Email
            </a>
            <a href="https://wa.me/6281234567890" target="_blank"
                style="display: flex; align-items: center; gap: 0.5rem; background-color: #25D366; color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                💬 Chat WhatsApp
            </a>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak">
        <h2 class="section-title">Contact</h2>
        <p>Jika ingin kerja sama atau tanya-tanya:</p>
        <ul style="margin-top: 1rem; line-height: 2; list-style: none; padding-left: 0;">
            <li>📧 <a href="mailto:sigit.fatuhrahman@gmail.com">sigit.fatuhrahman@gmail.com</a></li>
            <li>🐱 <a href="https://github.com/sigitsigatechnologies" target="_blank">sigitsigatechnologies</a></li>
            <li>🔗 <a href="https://www.linkedin.com/in/sigit-galih-fatuhrahman-b92180137"
                    target="_blank">LinkedIn-sigatech</a></li>
        </ul>
    </section>

    <!-- Footer -->
    <footer>
        &copy; <span id="year"></span> Sigatechnologies. All rights reserved.
    </footer>

    <!-- Animation Script -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);
            if (card.getBoundingClientRect().top < window.innerHeight) {
                card.classList.add('animate');
            }
        });

        // Set current year in footer
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>

</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P5 & E-Rapor</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Raleway', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            background: #f5f6fa;
        }

        /* Left Side */
        .left {
            flex: 1;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            /* gradasi mirip gambar */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            /* biar rata kiri */
            text-align: left;
            padding: 60px;
            position: relative;
            overflow: hidden;
            border-radius: 0px 100px 100px 0px;
        }

        .left h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .left p {
            font-size: 1.2rem;
            font-weight: 400;
            opacity: 0.9;
        }


        .left img {
            width: 100%;
            max-width: 280px;
            border-radius: 20px;
            margin-top: 20px;
            z-index: 2;
            animation: float 3s ease-in-out infinite;
            position: relative;
        }

        /* Floating animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Bola-bola dekorasi */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            animation: bubble 6s ease-in-out infinite;
            z-index: 1;
        }

        .circle:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 10%;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 40%;
            right: 10%;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 90px;
            height: 90px;
            bottom: 15%;
            left: 20%;
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 160px;
            height: 160px;
            bottom: 5%;
            right: 15%;
            animation-delay: 1s;
        }

        @keyframes bubble {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }

            100% {
                transform: translateY(0);
            }
        }

        /* Right Side */
        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background: #f5f6fa;
        }

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            max-width: 800px;
        }

        .card {
            flex: 1 1 300px;
            background: white;
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.1s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(241, 234, 240, 0.348), transparent 70%);
            transform: rotate(25deg);
            z-index: 0;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .card img {
            width: 70px;
            margin-bottom: 15px;
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 1.3rem;
            color: #333;
        }

        .card p {
            color: #666666;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .card button {
            background: #ffae00;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .card button:hover {
            background: #5900ff;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .left h2 {
                font-size: 1.7rem;
            }

            .card {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left,
            .right {
                width: 100%;
                flex: none;
            }

            .left h2 {
                font-size: 1.5rem;
            }

            .left img {
                max-width: 200px;
            }
        }

        @media (max-width: 480px) {
            .left {
                padding: 20px;
            }

            .left h2 {
                font-size: 1.2rem;
            }

            .card {
                width: 100%;
                padding: 20px;
            }

            .card h3 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <div class="left">
         <!-- Container untuk card -->
         <div class="logo" style="margin-bottom: 10px; text-align: center;">
            <img src="images/logo_bopkri.png" alt="Logo BOPKRI" style="width: 100px;">
        </div>
        <h2>Selamat Datang Di<br>SD Bopkri Turen</h2>
        <p>Optimize Dashboard Reporting</p>

        <!-- Bola-bola dekorasi -->
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="right" style="display: flex; flex-direction: column; align-items: center;">

        <!-- Container untuk card -->
        <div class="card-container" style="display: flex; gap: 20px; justify-content: center; margin-top: -20px;">
            <div class="card">
                <div class="card-content">
                    <img src="https://img.icons8.com/?size=100&id=R51JBuB25XpU&format=png&color=000000" alt="p5">
                    <h3>Projek P5</h3>
                    <p>Kelola dan pantau perkembangan projek P5 siswa secara interaktif.</p>
                    <button onclick="window.location.href='/p5'">Masuk</button>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <img src="https://img.icons8.com/?size=100&id=cHppp0h3lMK6&format=png&color=000000" alt="Idea">
                    <h3>E-Rapor</h3>
                    <p>Akses nilai rapor digital dengan mudah dan cepat.</p>
                    <button onclick="window.location.href='/erapor'">Masuk</button>
                </div>
            </div>
        </div>

    </div>




</body>

</html>
