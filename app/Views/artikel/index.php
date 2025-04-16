<?= view('template/header'); ?>

<?php if ($artikel): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2>
                <a href="<?= base_url('/artikel/' . htmlspecialchars($row['slug'])); ?>">
                    <?= htmlspecialchars($row['judul']); ?>
                </a>
            </h2>
            <img src="<?= base_url('/gambar/' . htmlspecialchars($row['gambar'])); ?>" 
                 alt="<?= htmlspecialchars($row['judul']); ?>">
            <p><?= htmlspecialchars(substr($row['isi'], 0, 200)); ?></p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada data.</h2>
    </article>
<?php endif; ?>

<?= view('template/footer'); ?>
