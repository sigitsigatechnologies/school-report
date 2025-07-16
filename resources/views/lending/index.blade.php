{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Web Bantul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f7f9fc;
            color: #333;
        }

        header {
            background: #4f46e5;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        section {
            padding: 3rem 1rem;
            max-width: 900px;
            margin: auto;
        }

        .section-title {
            font-size: 1.8rem;
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

        /* .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: transform 0.3s ease;
        } */

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .card p {
            font-size: 0.95rem;
            color: #555;
        }

        footer {
            background: #4f46e5;
            /* ganti dari #333 */
            color: white;
            text-align: center;
            padding: 1.5rem;
            margin-top: 0;
            /* hilangkan margin biar nempel */
        }


        a {
            color: #4f46e5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
            font-size: 2.8rem;
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .hero-header .tagline {
            font-size: 1.1rem;
            font-weight: 300;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.8;
            color: #f0f0f0;
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

        /* Saat card masuk ke layar (dikasih class 'animate') */
        .card.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .wave svg {
            display: block;
            width: 100%;
            height: auto;
            margin-top: -1px;
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

        .with-gradient {
            background: linear-gradient(135deg, #f7f9fc, #e9edff);
        }

    </style>
</head>

<body>

    <header class="hero-header" id="home">

        <div class="hero-content">
            <h1>Buat Web Bantul</h1>
            <p class="tagline">
                Mitra digital terpercaya dari Bantul.<br>
                <b>Spesialis website & Java Web Service — Web Sekolah, API Service, Payment Gateway, E-Commerce, dan lainnya.</b>
            </p>
        </div>
    
        <!-- Diagonal Cut -->
        <div class="diagonal-divider"></div>
    </header>

    <nav style="
    background-color: #ffffff;
    padding: 1rem 2rem;
    position: sticky;
    top: 0;
    z-index: 999;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    justify-content: center;
    gap: 2rem;
">
    <a href="#home" style="color: #4f46e5; font-weight: 600;">Beranda</a>
    <a href="#tentang" style="color: #4f46e5; font-weight: 600;">Tentang</a>
    <a href="#alasan" style="color: #4f46e5; font-weight: 600;">Kenapa Kami</a>
    <a href="#digitalisasi" style="color: #4f46e5; font-weight: 600;">Digitalisasi</a>
    <a href="#kontak" style="color: #4f46e5; font-weight: 600;">Kontak</a>
</nav>

<section id="tentang">
    <h2 class="section-title">Tentang Kami</h2>
        <p style="font-size: 1.05rem; line-height: 1.8;">
            <strong>Buat Web Bantul</strong> adalah tim developer lokal yang fokus membantu digitalisasi usaha, sekolah,
            dan instansi di wilayah Bantul dan sekitarnya.
            Kami berpengalaman mengembangkan aplikasi berbasis Java dan Laravel, dari sistem informasi sekolah,
            e-commerce, layanan API, hingga integrasi pembayaran.
        </p>
    </section>

    <section class="with-blob">
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


    <section class="section-3" style="text-align: center;">
        <h2 class="section-title">Siap Digitalisasi?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Konsultasikan kebutuhan aplikasi atau website Anda. Gratis tanpa komitmen.
        </p>
    
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <!-- Tombol Email -->
            <a href="mailto:sigit.fatuhrahman@gmail.com"
               style="display: flex; align-items: center; gap: 0.5rem; background-color: #4f46e5; color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="1.5" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75M21.75 6.75L12 13.5 2.25 6.75" />
                </svg>
                Kirim Email
            </a>
    
            <!-- Tombol WhatsApp -->
            <a href="https://wa.me/6281234567890" target="_blank"
               style="display: flex; align-items: center; gap: 0.5rem; background-color: #25D366; color: white; padding: 0.8rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 32 32" width="20" height="20">
                    <path d="M16.004 2.67c-7.24 0-13.1 5.877-13.1 13.128 0 2.31.61 4.565 1.77 6.547L2 30l7.89-2.563a13.018 13.018 0 006.114 1.552h.001c7.242 0 13.104-5.878 13.104-13.13 0-3.503-1.365-6.794-3.843-9.273A13.03 13.03 0 0016.004 2.67zm-.015 23.544a11.55 11.55 0 01-5.894-1.61l-.422-.25-4.683 1.524 1.54-4.567-.275-.47a11.538 11.538 0 01-1.697-6.067c0-6.39 5.197-11.587 11.586-11.587 3.097 0 6.008 1.206 8.2 3.397 2.193 2.193 3.397 5.104 3.397 8.202 0 6.39-5.197 11.591-11.591 11.591zm6.36-8.716c-.347-.174-2.048-1.015-2.366-1.132-.319-.117-.55-.174-.782.174s-.9 1.132-1.106 1.364c-.201.232-.402.261-.748.087-.347-.174-1.464-.54-2.788-1.72-1.03-.92-1.724-2.058-1.927-2.406-.2-.347-.022-.535.152-.709.155-.153.347-.402.52-.603.175-.202.233-.348.35-.58.117-.232.058-.435-.029-.609-.087-.174-.782-1.888-1.071-2.585-.28-.672-.564-.582-.782-.593l-.667-.012c-.232 0-.609.087-.928.435-.319.348-1.217 1.19-1.217 2.9s1.246 3.363 1.418 3.597c.174.232 2.454 3.745 5.947 5.25 3.493 1.505 3.493 1.004 4.127.928.637-.077 2.048-.835 2.34-1.64.29-.804.29-1.492.203-1.64-.087-.145-.319-.232-.667-.406z"/>
                </svg>
                Chat WhatsApp
            </a>
        </div>
    </section>
    
   

    <section>
        <h2 class="section-title">Contact</h2>
        <p>Jika ingin kerja sama atau tanya-tanya:</p>
        <ul style="margin-top: 1rem; line-height: 2; list-style: none; padding-left: 0;">
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    style="width: 1.2rem; height: 1.2rem; display: inline; margin-right: 0.5rem; color: #4f46e5;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75M21.75 6.75L12 13.5 2.25 6.75" />
                </svg>
                <a href="mailto:sigit.fatuhrahman@gmail.com">sigit.fatuhrahman@gmail.com</a>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    style="width: 1.2rem; height: 1.2rem; display: inline; margin-right: 0.5rem; color: #4f46e5;">
                    <path
                        d="M12 .5C5.648.5.5 5.648.5 12c0 5.092 3.29 9.394 7.86 10.915.574.106.786-.25.786-.555 0-.275-.01-1.004-.015-1.97-3.2.694-3.877-1.543-3.877-1.543-.522-1.327-1.276-1.68-1.276-1.68-1.044-.714.08-.7.08-.7 1.154.08 1.76 1.184 1.76 1.184 1.025 1.754 2.688 1.247 3.342.954.103-.743.4-1.247.727-1.535-2.554-.29-5.238-1.276-5.238-5.68 0-1.254.448-2.278 1.182-3.08-.12-.29-.51-1.462.11-3.05 0 0 .96-.307 3.15 1.175a10.98 10.98 0 012.872-.385c.974.005 1.956.13 2.872.385 2.19-1.482 3.15-1.175 3.15-1.175.62 1.588.23 2.76.11 3.05.735.802 1.182 1.826 1.182 3.08 0 4.416-2.69 5.387-5.253 5.672.412.355.777 1.05.777 2.118 0 1.53-.014 2.764-.014 3.14 0 .307.21.666.792.552C20.71 21.39 24 17.092 24 12 24 5.648 18.352.5 12 .5z" />
                </svg>
                <a href="https://github.com/sigitsigatechnologies" target="_blank">sigitsigatechnologies</a>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    style="width: 1.2rem; height: 1.2rem; display: inline; margin-right: 0.5rem; color: #4f46e5;">
                    <path
                        d="M19 0h-14c-2.762 0-5 2.238-5 5v14c0 2.761 2.238 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.762-2.238-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.271c-.966 0-1.75-.785-1.75-1.75s.784-1.75 1.75-1.75 1.75.785 1.75 1.75-.784 1.75-1.75 1.75zm13.5 10.271h-3v-4.5c0-1.07-.43-1.5-1.25-1.5s-1.25.43-1.25 1.5v4.5h-3v-9h3v1.182c.441-.682 1.205-1.182 2.25-1.182 1.733 0 3.25 1.336 3.25 3.5v5.5z" />
                </svg>
                <a href="https://www.linkedin.com/in/sigit-galih-fatuhrahman-b92180137"
                    target="_blank">Linkedin-sigatech</a>
            </li>
        </ul>
    </section>
    <div style="margin-top: 4rem; margin-bottom: -5px;">
        <svg viewBox="0 0 1440 320" style="display: block;" xmlns="http://www.w3.org/2000/svg">
            <path fill="#4f46e5" fill-opacity="1"
                d="M0,256L48,240C96,224,192,192,288,186.7C384,181,480,203,576,208C672,213,768,203,864,176C960,149,1056,107,1152,101.3C1248,96,1344,128,1392,144L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>




    <footer>
        &copy; <span id="year"></span> Sigatechnologies. All rights reserved.
    </footer>


    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                    observer.unobserve(entry.target); // Unobserve setelah animasi
                }
            });
        }, {
            threshold: 0.2
        });

        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);

            // Paksa animasi saat awal load (jika sudah terlihat)
            if (card.getBoundingClientRect().top < window.innerHeight) {
                card.classList.add('animate');
            }
        });
    </script>

</body>

</html> --}}

<!DOCTYPE html>
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

</html>
