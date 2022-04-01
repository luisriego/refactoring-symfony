<?php

namespace App\Tests\Controller;

use App\Exception\NoNameAddedException;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CondoControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    public ?string $condoId = null;

    public function testCondosShowList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/condo/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Condo index');
        $this->assertCount(3, $crawler->filter('tr'));
        $this->assertCount(12, $crawler->filter('td'));
        $this->condoId = $crawler->filter('td')
            ->first()
            ->text()
        ;
    }

    public function testGetCondoById(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/condo/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Condo');
        $this->assertCount(5, $crawler->filter('tr'));
        $this->assertCount(12, $crawler->filter('td'));
    }

    public function testCreateNewCondo(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/condo/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Condo');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['condo[name]'] = 'Fabien';
        $form['condo[taxCode]'] = '14289531000150';

        // submit the Form object
        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertCount(4, $crawler->filter('tr'));
        $this->assertCount(18, $crawler->filter('td'));
    }

//    public function testCreateNewCondoFail(): void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/condo/new');
//
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Create new Condo');
//
//        // select the button
//        $buttonCrawlerNode = $crawler->selectButton('Save');
//        $form = $buttonCrawlerNode->form();
//
//        // set values on a form object
////        $form['condo[name]'] = 'Fabien';
//        $form['condo[taxCode]'] = '14289531000150';
//        $this->expectException(\LogicException::class);
//        // submit the Form object
//        $client->submit($form);
//    }
}
