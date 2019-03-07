<?php

namespace Joeelia\AuthorizeNet\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;

class WebhookJobMakeCommand extends Command {

    protected $signature = 'make:webhookjobs';

    protected $description = 'Command description';

    public function __construct() {
        parent::__construct();
        
    }

    public function handle() {
            $this->replaceClassName();
        }
       
    

    protected function replaceClassName()
    {
        
        $this->checkIfDirExists();
            //
            foreach (config('authorize-net-webhooks.eventWebhooks') as $key => $value){
                $capitalClass = ucwords($key,'_'); 
                $finalClass = str_replace('_','',$capitalClass);
                $webhookDir = base_path().'/app/WebhookJobs/';
                $filename = $webhookDir.$finalClass.'.php';
                if (file_exists($filename)){
                    if ($value === True){
                        echo $finalClass.".php already exists.\n";
                    }
                } else{
                    if ($value === True){
                        $stubfile = file_get_contents(__DIR__.'/../stubs/WebhookJobs.stub');
                        $stub = str_replace('{{class}}',$finalClass,$stubfile);
                        file_put_contents($filename,$stub);
                        echo "Created Webhook Job at ".$filename."\n";
                    }
                }
            }
    }

        

    protected function checkIfDirExists()
    {
        $webhookDir = base_path().'/app/WebhookJobs';
        if (file_exists($webhookDir)){
            //
            return;
        } else{
            echo "Created directory in ".base_path()."/app/WebhookJobs\n";
            mkdir($webhookDir, 0700);
            return;
        }
    }

}