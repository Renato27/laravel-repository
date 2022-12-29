<?php

namespace Rcm\LaravelRepository;

use Illuminate\Support\ServiceProvider;

abstract class CreateRepositoryAbstract extends ServiceProvider
{
    /**
     * Name of repository.
     *
     * @var string
     */
    protected string $repository;

    /**
     * Name of model
     *
     * @var string
     */
    protected string $resource;

    /**
     * Path of template
     */
    const BASE_FILE = __DIR__ . './files/';

    /**
     * Path default of project laravel
     */
    const BASE_PATH = __DIR__ . '/app/';

    /**
     * Path of files.
     *
     * @var array
     */
    protected array $paths = [
        'template_interface' => self::BASE_FILE .'interface.txt',
        'template_implementation' => self::BASE_FILE .'implementation.txt',

        'path_interface' => self::BASE_PATH.'Repositories/Contracts/',
        'path_implementation' => self::BASE_PATH.'Repositories/',
    ];

    /**
     * Creates a interface.
     *
     * @return void
     */
    protected function createInterface()
    {
        $interface = $this->openOrCreateFile($this->paths['path_interface'], $this->repository, '.php');

        if (!$interface) {
            throw new \Exception('Error creating interface.');
        }

        $conteudoInterface = $this->getContentFile($this->paths['template_interface']);

        if (fwrite($interface, $conteudoInterface)) {
            echo 'Interface created successfully'.PHP_EOL;
            fclose($interface);

            return;
        }

        fclose($interface);

        throw new \Exception('There was an error associating the interface and content.');
    }

    /**
     * Creates implementation.
     *
     * @return void
     */
    protected function createImplementation()
    {
        $implementation = $this->openOrCreateFile($this->paths['path_implementation'], $this->repository, 'Implementation.php');

        if (! $implementation) {
            throw new \Exception('Error creating implementation.');
        }

        $conteudoImplementacao = $this->getContentFile($this->paths['template_implementation']);

        if (fwrite($implementation, $conteudoImplementacao)) {
            echo 'Implementation created successfully'.PHP_EOL;

            return;
        }

        fclose($implementation);

        throw new \Exception('There was an error associating the implementation and content.');
    }

    /**
     * Open or creates a file.
     *
     * @param string $path
     * @param string $name
     * @param string $extension
     * @return void
     */
    private function openOrCreateFile(string $path, string $name, string $extension = '.php')
    {
        if(!is_dir($path)){
            mkdir($path);
        }
        
        return fopen($path.$name.$extension, 'x');
    }

    /**
     * Get the content of file.
     *
     * @param string $path
     * @return string
     */
    private function getContentFile(string $path)
    {
        $content = file_get_contents($path);

        if (! $content) {
            throw new \Exception('The content of '.$path.' file does not exist.');
        }

        $string = str_replace('{repository_name}', $this->repository, $content);

        return str_replace('{recurso}', $this->resource, $string);
    }

    /**
     * Check if file exists.
     *
     * @param string $pathFile
     * @return void
     */
    public function checkFileExists(string $pathFile, ?string $extension = '.php')
    {
        $retorno = file_exists($pathFile.$extension);

        if ($retorno) {
            throw new \Exception($pathFile.$extension .' file already exists');
        }
    }
}
