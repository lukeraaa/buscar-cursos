<?php
// o arquivo Autoload o Composer faz o trabalho necessário para definir um autoload
// de classes de forma que seja possível utilizar as dependências sem incluir seus
// arquivos separadamente.
require 'vendor/autoload.php';

use Alura\BuscadorDeCursos\Buscador;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client([
    'base_uri' => 'https://www.alura.com.br/', //Passa a URL base para o cliente, toda requisição HTTP acontecera a partir desse caminho.
    'verify' => false // esse comando evita a verificação do certificado SSL do site que está sendo acessado, no caso Alura.
]); // Client é uma classe do pacote Guzzle que faz requisições http
$crawler = new Crawler();
$buscador = new Buscador($client, $crawler);

$cursos = $buscador->buscar('/cursos-online-programacao/php'); // passando o complemento de URL para o caminho da requisição

foreach ($cursos as $curso) {
    echo $curso . PHP_EOL;
}