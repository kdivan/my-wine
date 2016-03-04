<?php

namespace AppBundle\Tests\Controller;

class DefaultControllerTest extends AbstractTest
{
    public function testIndex()
    {
        $client = static::createClient();
        $this->logIn($client);
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Je m\'inscris', $crawler->filter('div .cta a')->text());
    }
}