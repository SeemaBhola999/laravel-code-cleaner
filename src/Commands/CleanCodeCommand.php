<?php

namespace CodeCleaner\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class CleanCodeCommand extends Command
{
    protected $signature = 'clean:debug 
                            {--path=app : Directory or file path to clean}
                            {--dry : Show what would be cleaned without making changes}
                            {--backup : Create backup before cleaning}';

    protected $description = 'Remove dump, dd, console statements from PHP/JS files';

    protected $patterns = [
        // PHP patterns - improved to handle complete lines
        '/^\s*dump\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        '/^\s*dd\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        '/^\s*var_dump\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        '/^\s*print_r\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        '/^\s*error_log\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        // JS patterns - improved
        '/^\s*console\.(log|error|warn|debug|info)\s*\([^)]*\)\s*;?\s*(\/\/.*)?\s*$/m',
        '/^\s*debugger\s*;?\s*(\/\/.*)?\s*$/m',
    ];

    public function handle()
    {
        $path = $this->option('path');
        $dryRun = $this->option('dry');
        $backup = $this->option('backup');

        if (!File::exists($path)) {
            $this->error("Path {$path} does not exist!");
            return 1;
        }

        $files = $this->getFiles($path);
        $totalCleaned = 0;
        $modifiedFiles = [];

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $cleaned = $this->cleanFile($filePath, $dryRun, $backup);
            
            if ($cleaned > 0) {
                $this->info("Cleaned {$cleaned} statements from: {$filePath}");
                $totalCleaned += $cleaned;
                $modifiedFiles[] = $filePath;
            }
        }

        if ($totalCleaned > 0) {
            $action = $dryRun ? 'Found' : 'Cleaned';
            $this->info("{$action} total {$totalCleaned} debug statements in " . count($modifiedFiles) . " files!");
        } else {
            $this->info('No debug statements found!');
        }

        return 0;
    }

    private function getFiles($path)
    {
        if (File::isFile($path)) {
            return [new \SplFileInfo($path)];
        }

        $finder = new Finder();
        return $finder->files()
            ->in($path)
            ->name('*.php')
            ->name('*.js')
            ->name('*.ts')
            ->name('*.vue')
            ->name('*.jsx')
            ->name('*.tsx')
            ->exclude('vendor')
            ->exclude('node_modules')
            ->exclude('storage');
    }

    private function cleanFile($filePath, $dryRun = false, $backup = false)
    {
        $content = File::get($filePath);
        $originalContent = $content;
        $cleanedCount = 0;

        foreach ($this->patterns as $pattern) {
            $matches = preg_match_all($pattern, $content);
            if ($matches > 0) {
                $cleanedCount += $matches;
                $content = preg_replace($pattern, '', $content);
            }
        }

        if ($content !== $originalContent && !$dryRun) {
            if ($backup) {
                $backupPath = $filePath . '.backup.' . date('Y-m-d-H-i-s');
                File::copy($filePath, $backupPath);
                $this->line("Backup created: {$backupPath}");
            }
            
            File::put($filePath, $content);
        }

        return $cleanedCount;
    }
}