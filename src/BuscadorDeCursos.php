<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class BuscadorDeCursos
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar($url)
    {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);

        $elementos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementos as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}
