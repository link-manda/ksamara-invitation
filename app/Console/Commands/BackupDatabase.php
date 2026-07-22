<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database dan menyimpannya di folder storage';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $connection = config('database.default');
        $filename = 'backup-'.Carbon::now()->format('Y-m-d-H-i-s');

        $backupDir = storage_path('app/backups');
        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        if ($connection === 'sqlite') {
            $databasePath = config('database.connections.sqlite.database');
            if (file_exists($databasePath)) {
                $backupPath = $backupDir.'/'.$filename.'.sqlite';
                copy($databasePath, $backupPath);
                $this->info("Database berhasil di-backup ke: {$backupPath}");
            } else {
                $this->error('File SQLite tidak ditemukan.');
            }
        } elseif ($connection === 'mysql') {
            $host = config('database.connections.mysql.host');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $database = config('database.connections.mysql.database');

            $backupPath = $backupDir.'/'.$filename.'.sql';

            $command = sprintf(
                'mysqldump -h %s -u %s %s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                $password ? '-p'.escapeshellarg($password) : '',
                escapeshellarg($database),
                escapeshellarg($backupPath)
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $this->info("Database berhasil di-backup ke: {$backupPath}");
            } else {
                $this->error('Gagal melakukan backup database MySQL.');
            }
        } else {
            $this->error('Tipe database '.$connection.' belum didukung oleh script backup sederhana ini.');
        }
    }
}
