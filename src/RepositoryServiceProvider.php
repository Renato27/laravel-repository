<?php

namespace Rcm\LaravelRepository;

class RepositoryServiceProvider extends CreateRepositoryAbstract
{

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(self::BASE_PATH.'Repositories/Contracts/'.$this->repository . '::class', function($app){
            return 'new' . self::BASE_PATH.'Repositories/'.$this->repository.'Implementation'('new' . $this->recurso . '()');
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
  
    }
}
