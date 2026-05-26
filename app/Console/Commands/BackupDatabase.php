<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza backup do banco de dados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

        $path = storage_path('app/backups/' . $filename);

        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $mysqldump = config('backup.mysqldump_path');

         $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s > "%s"',
            $mysqldump,
            $username,
            $password,
            $host,
            $database,
            $path
        );

        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error('Erro ao gerar backup.');
            return;
        }

        $this->info('Backup realizado com sucesso!');
    }
}
