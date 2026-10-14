<?php

require_once 'koneksi.php';

$pesan_sukses = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelapor   = $_POST['nama_pelapor'];
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $lokasi         = $_POST['lokasi'];
    $id_kategori    = $_POST['id_kategori'];
    $deskripsi      = $_POST['deskripsi'];
    $prioritas      = $_POST['prioritas'];
    $status         = "Baru";

    $sql = "INSERT INTO laporan_kerusakan (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas, status) 
            VALUES (:nama_pelapor, :nama_fasilitas, :lokasi, :id_kategori, :deskripsi, :prioritas, :status)";
    
    $stmt = $pdo->prepare($sql);
    $simpan = $stmt->execute([
        ':nama_pelapor'   => $nama_pelapor,
        ':nama_fasilitas' => $nama_fasilitas,
        ':lokasi'         => $lokasi,
        ':id_kategori'    => $id_kategori,
        ':deskripsi'      => $deskripsi,
        ':prioritas'      => $prioritas,
        ':status'         => $status
    ]);

    if ($simpan) {
        $pesan_sukses = "Laporan berhasil dikirim dan tersimpan di database.";
    }
}


$query = $pdo->query("SELECT * FROM laporan_kerusakan ORDER BY id DESC");
$laporan_list = $query->fetchAll(PDO::FETCH_ASSOC);


function getKategoriNama($id) {
    switch ($id) {
        case 1: return 'Elektronik';
        case 2: return 'Furnitur';
        case 3: return 'Jaringan';
        case 4: return 'Peralatan Kelas';
        default: return 'Lainnya';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan Kerusakan Fasilitas Sekolah</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: -0.5px;
        }
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }
        .form-control, .form-select {
            border-color: #cbd5e1;
            padding: 0.65rem 0.75rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .btn-primary {
            background-color: #1e293b;
            border-color: #1e293b;
            padding: 0.65rem 1.25rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0f172a;
            border-color: #0f172a;
        }
        table th {
            font-weight: 600;
            background-color: #f1f5f9 !important;
            color: #334155;
        }
    </style>
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Pelaporan Fasilitas Sekolah</span>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-light px-3" href="#form-laporan">Buat Laporan</a>
                <a class="nav-link text-light px-3" href="#daftar-laporan">Daftar Laporan</a>
            </div>
        </div>
    </nav>

    
    <header class="container mb-5 text-center">
        <h1 class="h2 fw-bold text-dark mb-2">Sistem Pelaporan Kerusakan Fasilitas Sekolah</h1>
        <p class="text-secondary">Catat dan pantau laporan kerusakan inventaris serta fasilitas sekolah secara terpusat.</p>
    </header>

    <main class="container mb-5">
        
        <?php if (!empty($pesan_sukses)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($pesan_sukses); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        
        <section id="form-laporan" class="card p-4 mb-5">
            <h2 class="h5 fw-bold text-dark mb-3">Formulir Pelaporan Kerusakan</h2>
            <p class="text-secondary small mb-4">Lengkapi formulir di bawah ini secara akurat untuk melaporkan kerusakan fasilitas.</p>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="nama_pelapor" class="form-label fw-medium">Nama Pelapor</label>
                    <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" maxlength="100" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="nama_fasilitas" class="form-label fw-medium">Nama Fasilitas</label>
                    <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas" maxlength="100" placeholder="Contoh: Proyektor Epson / Kursi Siswa" required>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label fw-medium">Lokasi Kerusakan</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100" placeholder="Contoh: Ruang Kelas 10A" required>
                </div>

                <div class="mb-3">
                    <label for="id_kategori" class="form-label fw-medium">Kategori Fasilitas</label>
                    <select id="id_kategori" name="id_kategori" class="form-select" required>
                        <option value="">Pilih kategori fasilitas</option>
                        <option value="1">Elektronik</option>
                        <option value="2">Furnitur</option>
                        <option value="3">Jaringan</option>
                        <option value="4">Peralatan Kelas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-medium">Deskripsi Kerusakan</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan detail kerusakan yang terjadi..." required></textarea>
                </div>

                <div class="mb-4">
                    <label for="prioritas" class="form-label fw-medium">Tingkat Prioritas</label>
                    <select id="prioritas" name="prioritas" class="form-select" required>
                        <option value="">Pilih tingkat prioritas</option>
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Tinggi">Tinggi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </form>
        </section>

        
        <section id="daftar-laporan" class="card p-4">
            <h2 class="h5 fw-bold text-dark mb-3">Daftar Laporan Kerusakan</h2>
            <p class="text-secondary small mb-4">Seluruh laporan kerusakan yang tercatat dalam sistem ditampilkan pada tabel di bawah ini.</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">No.</th>
                            <th scope="col" style="width: 20%;">Fasilitas</th>
                            <th scope="col" style="width: 20%;">Lokasi</th>
                            <th scope="col" style="width: 15%;">Pelapor</th>
                            <th scope="col" style="width: 15%;">Prioritas</th>
                            <th scope="col" style="width: 10%;">Status</th>
                            <th scope="col" style="width: 15%;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($laporan_list) > 0): ?>
                            <?php $no = 1; foreach ($laporan_list as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['nama_fasilitas']); ?></strong><br>
                                        <small class="text-muted">Kategori: <?= getKategoriNama($row['id_kategori']); ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_pelapor']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $row['prioritas'] == 'Tinggi' ? 'danger' : ($row['prioritas'] == 'Sedang' ? 'warning text-dark' : 'secondary'); 
                                        ?>">
                                            <?= htmlspecialchars($row['prioritas']); ?>
                                        </span>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['status']); ?></span></td>
                                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">Belum ada data laporan yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    
    <footer class="bg-white border-top py-4 text-center text-secondary small">
        <div class="container">
            <p class="mb-0">&copy; 2026 Sistem Pelaporan Kerusakan Fasilitas Sekolah. Hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>