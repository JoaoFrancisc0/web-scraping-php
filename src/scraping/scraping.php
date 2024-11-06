<?php

function scrapePage($url, $client, $mysqli) {
    $crawler = $client->request('GET', $url);

    $crawler->filter('.product_pod')->each(function ($node) use ($mysqli) {
        $produto_id = Null;

        $title = $node->filter('.image_container img')->attr('alt');

        $price = $node->filter('.price_color')->text();

        // Verificar se o produto já existe na tabela 'produtos'
        $stmt = $mysqli->prepare("SELECT id FROM produtos WHERE nome = ?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $stmt->bind_result($produto_id);
        $stmt->fetch();
        $stmt->close();

        // Se o produto não existir, inserimos na tabela 'produtos' e obtemos o ID gerado
        if (!$produto_id) {
            $stmt = $mysqli->prepare("INSERT INTO produtos (nome) VALUES (?)");
            $stmt->bind_param("s", $title);
            $stmt->execute();
            $produto_id = $stmt->insert_id;
            $stmt->close();
        }

        // Inserir o preço no 'historico_precos' com o ID do produto
        $stmt = $mysqli->prepare("INSERT INTO historico_precos (produto_id, preco) VALUES (?, ?)");
        $price = floatval(preg_replace('/[^0-9.]/', '', $price));
        $stmt->bind_param("id", $produto_id, $price);
        $stmt->execute();
        $stmt->close();
    });

    // Paginação
    try {

        $next_page = $crawler->filter('.next > a')->attr('href');

    } catch (InvalidArgumentException) { //Next page not found

        return null;

    }

    return "https://books.toscrape.com/catalogue/" . $next_page;

}

require '../../vendor/autoload.php';

include ("../database/db_connect.php");

use Goutte\Client;

$client = new Client();

$nextUrl = "https://books.toscrape.com/catalogue/page-1.html";


while ($nextUrl) {

    echo "<h2>" . $nextUrl . "</h2>" . PHP_EOL;

    $nextUrl = scrapePage($nextUrl, $client, $mysqli);

}
