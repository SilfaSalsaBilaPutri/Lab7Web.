<?php
namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function render(string $kategori = null): string
    {
        $model = new ArtikelModel();

        // Ambil artikel berdasarkan kategori tertentu jika parameter kategori diberikan
        if ($kategori) {
            $artikel = $model->where('kategori', $kategori)
                             ->orderBy('created_at', 'DESC')
                             ->limit(5)
                             ->findAll();
        } else {
            // Jika tidak ada kategori yang diberikan, tampilkan semua artikel terbaru
            $artikel = $model->orderBy('created_at', 'DESC')
                             ->limit(5)
                             ->findAll();
        }

        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
