<?php

namespace Rcm\LaravelRepository;

class CreateRespository extends CreateRepositoryAbstract
{
    /**
     * Processa a criação de um repositório.
     *
     * @param string $repositorio
     * @return bool
     */
    public function handle(string $repositorio, string $recurso)
    {
        try {
            $this->repository = $repositorio;
            $this->recurso = $recurso;

            $this->checkFileExists(self::BASE_PATH.'Repositories/Contracts/'.$repositorio);
            $this->checkFileExists(self::BASE_PATH.'Repositories/'.$repositorio.'Implementation');

            $this->createInterface();
            $this->createImplementation();

            if (! is_null($this->recurso)) {
                $comando = '@php artisan make:model '.$this->recurso.' -mf';
                echo shell_exec($comando);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
