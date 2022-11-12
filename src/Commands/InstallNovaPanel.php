<?php

namespace Wainwright\CasinoDog\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

trait InstallNovaPanel
{

    public function installPanel($verbose = NULL) 
    {
        try {
        \Artisan::call('nova:install');
        } catch(\Exception $e) {
        }
        $this->installNovaStubs($verbose);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function installNovaStubs(string $verbose = NULL)
    {

        if (!is_dir($stubsPathBaseDir = base_path('app/Nova'))) {
            (new Filesystem)->makeDirectory($stubsPathBaseDir, 0755, true);
        }

        $files = [
            __DIR__ . '../../../stubs/nova/DataLogger.php' => $stubsPathBaseDir . '/DataLogger.php',
            __DIR__ . '../../../stubs/nova/GameImporterJob.php' => $stubsPathBaseDir . '/GameImporterJob.php',
            __DIR__ . '../../../stubs/nova/Gameslist.php' => $stubsPathBaseDir . '/Gameslist.php',
            __DIR__ . '../../../stubs/nova/GameRespinTemplates.php' => $stubsPathBaseDir . '/GameRespinTemplates.php',
            __DIR__ . '../../../stubs/nova/GamesThumbnails.php' => $stubsPathBaseDir . '/GamesThumbnails.php',
            __DIR__ . '../../../stubs/nova/ImportedGames.php' => $stubsPathBaseDir . '/ImportedGames.php',
            __DIR__ . '../../../stubs/nova/OperatorAccess.php' => $stubsPathBaseDir . '/OperatorAccess.php',
            __DIR__ . '../../../stubs/nova/ParentSessions.php' => $stubsPathBaseDir . '/ParentSessions.php',
            __DIR__ . '../../../stubs/nova/User.php' => $stubsPathBaseDir . '/User.php',
        ];

        $this->writeStubs($files, $verbose);

        if (!is_dir($stubsPathActions = base_path('app/Nova/Actions'))) {
            (new Filesystem)->makeDirectory($stubsPathActions, 0755, true);
        }

        $files = [
            __DIR__ . '../../../stubs/nova/Actions/AddOperatorAllowedIP.php' => $stubsPathActions . '/AddOperatorAllowedIP.php',
            __DIR__ . '../../../stubs/nova/Actions/GenerateOperatorSecret.php' => $stubsPathActions . '/GenerateOperatorSecret.php',
            __DIR__ . '../../../stubs/nova/Actions/ImageStoreS3CustomURL.php' => $stubsPathActions . '/ImageStoreS3CustomURL.php',
            __DIR__ . '../../../stubs/nova/Actions/iSoftbetRawIdentifierFromDemo.php' => $stubsPathActions . '/iSoftbetRawIdentifierFromDemo.php',
            __DIR__ . '../../../stubs/nova/Actions/ProcessImportedGame.php' => $stubsPathActions . '/ProcessImportedGame.php',
            __DIR__ . '../../../stubs/nova/Actions/RetrieveDemoURL.php' => $stubsPathActions . '/RetrieveDemoURL.php',
            __DIR__ . '../../../stubs/nova/Actions/OperatorSendPing.php' => $stubsPathActions . '/OperatorSendPing.php',
            __DIR__ . '../../../stubs/nova/Actions/StartGameImport.php' => $stubsPathActions . '/StartGameImport.php',
            __DIR__ . '../../../stubs/nova/Actions/StoreImageS3.php' => $stubsPathActions . '/StoreImageS3.php',
        ];

        $this->writeStubs($files, $verbose);


        if (!is_dir($stubsPathActions = base_path('app/Nova/Metrics'))) {
            (new Filesystem)->makeDirectory($stubsPathActions, 0755, true);
        }


        $files = [
            __DIR__ . '../../../stubs/nova/Metrics/DefaultGameImporter.php' => $stubsPathActions . '/DefaultGameImporter.php',
            __DIR__ . '../../../stubs/nova/Metrics/GamesAmount.php' => $stubsPathActions . '/GamesAmount.php',
            __DIR__ . '../../../stubs/nova/Metrics/DefaultGamelistTable.php' => $stubsPathActions . '/DefaultGamelistTable.php',
            __DIR__ . '../../../stubs/nova/Metrics/GamesPerProvider.php' => $stubsPathActions . '/GamesPerProvider.php',
        ];

        $this->writeStubs($files, $verbose);

        if (!is_dir($stubsPathActions = base_path('app/Nova/Helper'))) {
            (new Filesystem)->makeDirectory($stubsPathActions, 0755, true);
        }


        $files = [
            __DIR__ . '../../../stubs/nova/Helper/DefaultGameHelper.php' => $stubsPathActions . '/DefaultGameHelper.php',
        ];

        $this->writeStubs($files, $verbose);

        if (!is_dir($stubsPathDashboards = base_path('app/Nova/Dashboards'))) {
            (new Filesystem)->makeDirectory($stubsPathDashboards, 0755, true);
        }

        $files = [
            __DIR__ . '../../../stubs/nova/Dashboards/Main.php' => $stubsPathDashboards . '/Main.php',
        ];

        $this->writeStubs($files, $verbose);

        if (!is_dir($stubsPathFilters = base_path('app/Nova/Filters'))) {
            (new Filesystem)->makeDirectory($stubsPathFilters, 0755, true);
        }

        $files = [
            __DIR__ . '../../../stubs/nova/Filters/ProviderFilter.php' => $stubsPathFilters . '/ProviderFilter.php',
            __DIR__ . '../../../stubs/nova/Filters/SourcedDemourl.php' => $stubsPathFilters . '/SourcedDemourl.php',
            __DIR__ . '../../../stubs/nova/Filters/UploadedImageS3.php' => $stubsPathFilters . '/UploadedImageS3.php',
        ];

        $this->writeStubs($files, $verbose);

        $this->info('Stubs published.');
    }

    public function writeStubs($files, $verbose):void {
        foreach ($files as $from => $to) {
            if (!file_exists($to)) {
                file_put_contents($to, file_get_contents($from));
                $this->info('> '.$to.' saved.');
            } else {
                if($verbose === 'silent') {
                    file_put_contents($to, file_get_contents($from));
                } else {
                    if($this->confirm($to.' exists already. Do you want to overwrite this file?')) {
                        file_put_contents($to, file_get_contents($from));
                        $this->info('> '.$to.' saved.');
                    } else {
                        $this->error('Skipped '.$to);
                    }
                }
            }
        }
    }



}
