| Nama | Silfa Salsa Bila Putri |
| --- | --- |
| NIM | 312310607 |
| Kelas | TI.23.A6 |
| Mata Kuliah | Pemrograman Web 2 |

# PRAKTIKUM 1

- Mengaktifkan  ekstensi PHP di XAMPP:

  ![Screenshot 2025-06-29 231552](https://github.com/user-attachments/assets/a3744583-f3fb-4c4e-b59b-0f7e358acd90)

  Ekstensi ini diperlukan untuk menunjang fitur-fitur yang digunakan CodeIgniter seperti koneksi database dan manipulasi data JSON.

- Instalasi CodeIgniter 4 (Manual)

  ![Screenshot 2025-06-29 234831](https://github.com/user-attachments/assets/0e77e49c-317f-49a1-a274-4e81d8e157aa)

  Tampilan ini menunjukkan bahwa framework telah berhasil diinstal dan dapat diakses dari browser.

- Mengakses CLI
  
  Buka Command Prompt
  Arahkan ke folder ci4
  Jalankan:
  
  ``` php spark ```

  Perintah ini memanggil fitur CLI dari CodeIgniter 4 untuk berbagai proses pengembangan.
  
- Aktifkan Mode Debugging

  Ubah nama file env menjadi .env
  Ubah isian:

  ``` CI_ENVIRONMENT = development ```

  Dengan mode development, kesalahan (error) akan ditampilkan lebih detail di browser.

- Routing & Controller

  Tambahkan route baru di app/Config/Routes.php:
  
  ```
  $routes->get('/about', 'Page::about');
  $routes->get('/contact', 'Page::contact');
  $routes->get('/faqs', 'Page::faqs');
  ```

  ![Screenshot 2025-06-30 000526](https://github.com/user-attachments/assets/9f5520c4-a919-4e61-8eb4-271ec330fefe)

  Buat controller Page.php di folder app/Controllers/:

  ```
  namespace App\Controllers;
  class Page extends BaseController
  {
      public function about() { echo "Ini halaman About"; }
      public function contact() { echo "Ini halaman Contact"; }
      public function faqs() { echo "Ini halaman FAQ"; }
  }
  ```

  ![Screenshot 2025-06-30 000642](https://github.com/user-attachments/assets/e92ad8a6-5d1d-4443-a977-0689d71d03b1)

- Membuat View

  Buat file: app/Views/about.php

  ```
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
  </head>
  <body>
    <h1><?= $title; ?></h1>
  <hr>
    <p><?= $content; ?></p>
    </body>
  </html>
  ```

  Ubah COntroller

  ```
  public function about() {
  return view('about', [
          'title' => 'Halaman About',
          'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
      ]);
  }
  ```

- Layout Web dengan CSS

  Buat template/header.php dan footer.php di app/Views/template/
  Ubah isi about.php:

  ```
  <?= $this->include('template/header'); ?>
  <h1><?= $title; ?></h1>
  <hr>
  <p><?= $content; ?></p>
  <?= $this->include('template/footer'); ?>
  ```

  ![image](https://github.com/user-attachments/assets/e0e5ddec-931a-413f-9862-d65127220121)

# PRAKTIKUM 2

- Persiapan Database

  Buat database:
  
  ``` CREATE DATABASE lab_ci4; ```

  Buat tabel:

  ```
    CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
    );
  ```

  Database lab_ci4 digunakan untuk menyimpan artikel, masing-masing artikel memiliki judul, isi, gambar, slug, dan status.

- Konfigurasi Koneksi Database

    Buka file .env, ubah:

  ```
  database.default.hostname = localhost
  database.default.database = lab_ci4
  database.default.username = root
  database.default.password =
  database.default.DBDriver = MySQLi
  ```

  Mengatur koneksi antara aplikasi dan server database menggunakan konfigurasi environment.

- Membuat Model

  Lokasi: app/Models/ArtikelModel.php

  ```
  namespace App\Models;
  use CodeIgniter\Model;

  class ArtikelModel extends Model
  {
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
  }
  ```

  Model ini digunakan untuk berinteraksi langsung dengan tabel artikel.

- Membuat Controller
  
  Lokasi: app/Controllers/Artikel.php

  ```
  namespace App\Controllers;
  use App\Models\ArtikelModel;

  class Artikel extends BaseController
  {
    public function index()
  {
      $title = 'Daftar Artikel';
      $model = new ArtikelModel();
      $artikel = $model->findAll();
      return view('artikel/index', compact('artikel', 'title'));
    }
  }
  ```

  Method index() digunakan untuk menampilkan daftar artikel ke view.

- Membuat View Index

  Lokasi: app/Views/artikel/index.php

  ```
  <?= $this->include('template/header'); ?>
  <?php if($artikel): foreach($artikel as $row): ?>
  <article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
    <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>">
    <p><?= substr($row['isi'], 0, 200); ?></p>
  </article>
  <hr class="divider" />
  <?php endforeach; else: ?>
  <article class="entry">
    <h2>Belum ada data.</h2>
  </article>
  <?php endif; ?>
  <?= $this->include('template/footer'); ?>
  ```

  Menampilkan daftar artikel yang diambil dari database. Dan jika kita mengakses url http://localhost:8080/artikel maka Belum ada data yang diampilkan. coba tambahkan beberapa data pada database agar muncul datanya.

  ```
  INSERT INTO artikel (judul, isi, slug) VALUE
  ('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf.', 'artikel-pertama'),
  ('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih dari 2000 tahun.', 'artikel-kedua');
  ```

  ![Screenshot 2025-06-30 005926](https://github.com/user-attachments/assets/b2094c1d-7abe-480f-9f5b-1aab6a9060b9)

- Detail Artikel

  Tambahkan method baru di Artikel.php:

  ```
    public function view($slug)
  {
    $model = new ArtikelModel();
    $artikel = $model->where(['slug' => $slug])->first();
    if (!$artikel) {
      throw PageNotFoundException::forPageNotFound();
    }
    $title = $artikel['judul'];
    return view('artikel/detail', compact('artikel', 'title'));
  }
  ```

  Buat file: app/Views/artikel/detail.php

  ```
    <?= $this->include('template/header'); ?>
  <article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= $artikel['judul']; ?>">
    <p><?= $artikel['isi']; ?></p>
  </article>
  <?= $this->include('template/footer'); ?>
  ```

  Tambahkan route di Routes.php:

  ```
  $routes->get('/artikel/(:any)', 'Artikel::view/$1');
  ```

- Menu Admin (CRUD)

  - Tampilan Admin (Read)
    
    Tambahkan method admin_index() pada Controller.
    Buat file admin_index.php untuk menampilkan data.
    
  - Tambah Data
    
    Tambahkan method add()
    Buat form_add.php sebagai view form input

  - Edit Data

    Tambahkan method edit($id)
    Buat form_edit.php untuk form edit

  - Hapus Data

    Tambahkan method delete($id)
  Tambahkan routing admin di Routes.php:

  ```
  $routes->group('admin', function($routes) {
  $routes->get('artikel', 'Artikel::admin_index');
  $routes->add('artikel/add', 'Artikel::add');
  $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
  $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
  });
  ```

HASIL OUTPUT
frame artikel

![Screenshot 2025-06-28 133658](https://github.com/user-attachments/assets/638956d0-509e-41b1-a196-449cbb103ee3)

Frame tambah artikel

![Screenshot (38)](https://github.com/user-attachments/assets/1946952a-6580-4b5a-bab1-8fe0f6426833)


# PRAKTIKUM 3

- Membuat Layout Utama

  Lokasi di app/Views/layout/main.php

  ```
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'My Website' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
  </head>
  <body>
    <div id="container">
      <header><h1>Layout Sederhana</h1></header>
      <nav>
        <a href="<?= base_url('/');?>" class="active">Home</a>
        <a href="<?= base_url('/artikel');?>">Artikel</a>
        <a href="<?= base_url('/about');?>">About</a>
        <a href="<?= base_url('/contact');?>">Kontak</a>
      </nav>
      <section id="wrapper">
        <section id="main">
          <?= $this->renderSection('content') ?>
        </section>
        <aside id="sidebar">
          <?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>
          <!-- Widget statis -->
        </aside>
      </section>
      <footer><p>&copy; 2021 - Universitas Pelita Bangsa</p></footer>
     </div>
  </body>
  </html>
  ```

- Ubah View agar Extend Layout

  Lokasi file di app/Views/home.php

  ```
  <?= $this->extend('layout/main') ?>
  <?= $this->section('content') ?>
  <h1><?= $title; ?></h1>
  <hr>
  <p><?= $content; ?></p>
  <?= $this->endSection() ?>
  ```

  Dengan extend() dan section(), halaman ini memanfaatkan layout main.php dan menyisipkan isi konten utama.

- Membuat View Cell

  Lokasi: app/Cells/ArtikelTerkini.php

  ```
  namespace App\Cells;
  use CodeIgniter\View\Cell;
  use App\Models\ArtikelModel;

  class ArtikelTerkini extends Cell
  {
    public function render()
    {
      $model = new ArtikelModel();
      $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
      return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
  }
  ```

  View Cell ArtikelTerkini mengambil data 5 artikel terbaru dari model dan merender view artikel_terkini.

- View untuk View Cell

  File: app/Views/components/artikel_terkini.php

  ```
  <h3>Artikel Terkini</h3>
  <ul>
    <?php foreach ($artikel as $row): ?>
      <li><a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a></li>
  <?php endforeach; ?>
  </ul>
  ```

- Modifikasi Database

  Agar artikel bisa diurutkan berdasarkan tanggal, tambahkan kolom:

  ``` ALTER TABLE artikel ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP; ```

- Pertanyaan dan Jawaban

   Apa manfaat utama dari penggunaan View Layout dalam pengembangan aplikasi?
  ---
  
  Jawaban:
  View Layout membantu menyederhanakan struktur tampilan dengan cara membuat satu layout utama yang digunakan berulang, sehingga meminimalkan pengulangan kode (DRY principle), membuat pemeliharaan kode lebih mudah dan konsisten di seluruh halaman.

  Jelaskan perbedaan antara View Cell dan View biasa?
  ---

  Jawaban:
  - View Biasa: Menampilkan data langsung dari controller ke tampilan tertentu.
  - View Cell: Merupakan komponen mandiri yang bisa digunakan di berbagai view. Cocok untuk elemen seperti sidebar, notifikasi, atau artikel terbaru karena bisa dipanggil kapan saja tanpa menulis ulang kodenya.

  Ubah View Cell agar hanya menampilkan post dengan kategori tertentu
  ---

  Contoh modifikasi:

  ```
  public function render($kategori = null)
  {
    $model = new ArtikelModel();
    $builder = $model->orderBy('created_at', 'DESC')->limit(5);

    if ($kategori) {
      $builder->where('kategori_id', $kategori);
    }

    $artikel = $builder->findAll();
    return view('components/artikel_terkini', ['artikel' => $artikel]);
  }
  ```

  Memanggiil:

  ``` <?= view_cell('App\\Cells\\ArtikelTerkini::render', ['kategori' => 2]) ?> ```

# PRAKTIKUM 4

- Membuat Tabel User di Database

  ```
    CREATE TABLE user (
    id INT(11) auto_increment,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
  );
  ```
  Kita butuh tabel user untuk menyimpan data pengguna, email, dan password. userpassword akan menyimpan password yang sudah di-hash agar tidak bisa dibaca langsung. useremail akan digunakan saat proses login.

  - Membuat Model User
 
    ```
    class UserModel extends Model {
      protected $table = 'user';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $allowedFields = ['username', 'useremail', 'userpassword'];
    }
    ```

    Model ini akan digunakan untuk mengakses dan memproses data pada tabel user. allowedFields menentukan kolom mana yang boleh diisi/diedit secara massal.

- Membuat Seeder User

  ```
  namespace App\Database\Seeds;
  use CodeIgniter\Database\Seeder;

  class UserSeeder extends Seeder
  {
    public function run()
    {
      $model = model('UserModel');
      $model->insert([
        'username' => 'admin',
        'useremail' => 'admin@email.com',
        'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
      ]);
    }
  }

  ```

  Seeder di atas dipakai untuk mengisi data awal ke database (contoh user admin). Passwordnya juga harus di-hash agar aman, bukan plaintext.

- Membuat Auth Filter

  ```
  namespace App\Filters;
  use CodeIgniter\HTTP\RequestInterface;
  use CodeIgniter\HTTP\ResponseInterface;
  use CodeIgniter\Filters\FilterInterface;

  class Auth implements FilterInterface
  {
    public function before(RequestInterface $request, $arguments = null)
    {
       if (!session()->get('logged_in')) {
        return redirect()->to('/user/login');
      }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
  }
  ```

  Filter ini digunakan untuk mencegah pengguna yang belum login mengakses halaman admin. Cek session logged_in. Kalau belum login, redirect ke /user/login. Mendaftarkan filter auth agar bisa digunakan di Routes.php nanti.

- Proteksi Halaman Admin dengan Filter

  ```
    $routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    ...
  });
  ```

  Sekarang semua route di dalam grup admin/ akan dicek dulu apakah user sudah login. Jika belum → otomatis redirect ke login.

HASIL UOTPUT
---

![Screenshot 2025-07-01 210041](https://github.com/user-attachments/assets/65de9d71-9a49-4104-8bc8-0488bf63030b)

# PRAKTIKUM 5

- Menambahkan Fitur Pagination ke Controller

  Modifikasi Method admin_index() di File: app/Controllers/Artikel.php seperti ini:

  ```
  public function admin_index()
  {
      $title = 'Daftar Artikel';
      $model = new ArtikelModel();
      $data = [
          'title' => $title,
          'artikel' => $model->paginate(10), // Menampilkan 10 data per halaman
          'pager' => $model->pager
      ];
      return view('artikel/admin_index', $data);
  }
  ```

  Fungsi paginate(10) otomatis membagi data artikel menjadi 10 per halaman. $model->pager menyimpan objek pagination yang akan dikirim ke view.

- Menampilkan Link Pagination di View

  letakkan di file app/Views/artikel/admin_index.php, Tambahkan di bawah tabel artikel:

  ``` <?= $pager->links(); ?> ```

  Menampilkan tombol pagination secara otomatis (Next, Previous, halaman 1, 2, dst).

- Menambahkan Fitur Pencarian

  letakkan di file: app/Controllers/Artikel.php, jika sudah Modifikasi admin_index() untuk menambahkan filter pencarian:

  ```
  public function admin_index()
  {
      $title = 'Daftar Artikel';
      $q = $this->request->getVar('q') ?? '';
      $model = new ArtikelModel();
      $data = [
          'title' => $title,
          'q' => $q,
          'artikel' => $model->like('judul', $q)->paginate(10),
          'pager' => $model->pager
      ];
      return view('artikel/admin_index', $data);
  }
  ```

  getVar('q'): mengambil input pencarian dari URL (misalnya: ?q=berita). like('judul', $q): hanya menampilkan artikel yang judulnya mengandung kata kunci.

- Menambahkan Form Pencarian di View

  ```
  <form method="get" class="form-search">
      <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
      <input type="submit" value="Cari" class="btn btn-primary">
  </form>
  ```

  Form akan mengirimkan keyword pencarian ke controller melalui parameter q. Field value="<?= $q; ?>" mempertahankan isi form setelah pencarian.

- Menyesuaikan Link Pagination dengan Query Pencarian

  ``` <?= $pager->only(['q'])->links(); ?> ```

  Supaya link pagination tetap menyertakan query pencarian (q) ketika user klik halaman berikutnya. Tanpa ini, saat klik halaman 2 pencarian bisa hilang.

HASIL OUTPUT
--- 

![Screenshot (41)](https://github.com/user-attachments/assets/0551606d-e79d-42e1-a633-22b8cf85e03e)

# PRAKTIKUM 6

-  Memodifikasi Controller untuk Menyimpan Gambar

   Update method add() Artikel.php menjadi:

   ```
   public function add()
   {
       // validasi data
       $validation = \Config\Services::validation();
       $validation->setRules(['judul' => 'required']);
       $isDataValid = $validation->withRequest($this->request)->run();

       if ($isDataValid)
       {
           $file = $this->request->getFile('gambar');
           $file->move(ROOTPATH . 'public/gambar'); // Pindahkan file ke folder public/gambar

           $artikel = new ArtikelModel();
          $artikel->insert([
               'judul' => $this->request->getPost('judul'),
               'isi' => $this->request->getPost('isi'),
               'slug' => url_title($this->request->getPost('judul')),
               'gambar' => $file->getName(), // Simpan nama file ke database
           ]);

           return redirect('admin/artikel');
       }

       $title = "Tambah Artikel";
       return view('artikel/form_add', compact('title'));
   }
   ```

   getFile('gambar') mengambil file yang dikirim dari form. move() memindahkan file ke folder /public/gambar. getName() digunakan untuk menyimpan nama file ke kolom gambar di tabel.

- Memodifikasi Form Tambah Artikel

  Ubah tag <form> agar bisa mengunggah file:

  ``` <form action="" method="post" enctype="multipart/form-data"> ```

  Tambahkan input untuk file gambar:

  ```
  <p>
      <input type="file" name="gambar">
  </p>
  ```

  enctype="multipart/form-data" wajib untuk upload file. <input type="file" name="gambar"> membuat field unggah file.

- Menyimpan Gambar ke Folder public/gambar

  Langkah yang terjadi saat submit: File dikirim dari browser, Disimpan otomatis ke folder public/gambar/ berkat fungsi move(), Nama file disimpan ke kolom gambar di database artikel.

- Menampilkan Gambar di Daftar dan Detail Artikel

  ``` <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>"> ```

  Gambar ditampilkan menggunakan path /gambar/nama_file, File sebelumnya sudah disimpan di folder public/gambar, jadi aman diakses lewat base_url().

HASIL OUTPUT
---

![Screenshot (42)](https://github.com/user-attachments/assets/85f6fa11-f814-4e39-9f2a-d8bacf1f7ee7)
