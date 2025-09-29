<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            /* Warna latar belakang lembut */
        }

        .success-card {
            border: none;
            border-radius: 1rem;
            /* Sudut lebih tumpul */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .success-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            font-size: 5rem;
            /* Ukuran ikon lebih besar */
            color: #198754;
            /* Warna hijau Bootstrap */
        }

        .btn-whatsapp {
            background-color: #25D366;
            border-color: #25D366;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            /* Tombol berbentuk pil */
            transition: all 0.3s ease;
        }

        .btn-whatsapp:hover {
            background-color: #1EAE53;
            border-color: #1EAE53;
            color: white;
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row min-vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">

                <div class="card text-center p-4 p-md-5 success-card">
                    <div class="card-body">

                        <div class="icon-container mb-4">
                            <i class="fas fa-check-circle"></i>
                        </div>

                        <h1 class="card-title fw-bold mb-3">Pendaftaran Berhasil!</h1>

                        <p class="card-text text-muted lead mb-4">
                            Alhamdulillah, Pengisian formulir berhasil. Silahkan hubungi admin untuk melakukan proses
                            verifikasi lebih lanjut.
                        </p>

                        <div class="d-flex  gap-2">
                            <a href="https://wa.me/{{ $nomorAdmin }}?text={{ $pesanWhatsApp }}"
                                class="btn btn-success d-inline-flex align-items-center" target="_blank"
                                rel="noopener noreferrer">
                                <i class="fab fa-whatsapp fa-lg me-2"></i>
                                Hubungi Admin via WhatsApp
                            </a>

                            <a href="{{ url('/') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="fas fa-home fa-lg me-2"></i>
                                Kembali ke Beranda
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
