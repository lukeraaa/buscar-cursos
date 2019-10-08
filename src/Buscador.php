<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var ClientInterface
     */
    private $httpClient;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        // Classe Client faz uma requisição do tipo GET
        $resposta = $this->httpClient->request('GET', $url);
        // traz o corpo da requisição.
        $html = $resposta->getBody();
        // Recebe o corpo da requisição feita pelo Cliente e a transforma em um elemento DOM
        $this->crawler->addHtmlContent($html);
        // Filtra os elementos DOM pelas tag html e css
        $elementosCurso = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];

        foreach ($elementosCurso as $elemento) {
            // percorre os elementos DOM e atribui seus textos ao array cursos
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }
}
