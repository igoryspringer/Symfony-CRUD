<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\NamespaceSymfony;
use App\Entity\InterfaceSymfony;
use App\Entity\ClassesSymfony;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ParseSymfonyCommand extends Command
{
    protected static $defaultName = 'app:parse-symfony';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var
     */
    private $url = 'http://api.andreybolonin.com/';

    /**
     * ParseSymfonyCommand constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:parse-symfony')
            ->setDescription('Parsing site api.andreybolonin.com')
            ->setHelp('This command parses the site ...')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('test', 't', InputOption::VALUE_OPTIONAL),
                ])
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $test = $input->getOption('test');

        $namespace = new NamespaceSymfony();
        $namespace->setUrl('http://api.andreybolonin.com');
        $namespace->setName('Symfony');
        $this->em->persist($namespace);
        $this->getContent('http://api.andreybolonin.com//Symfony.html', $namespace, $test);
    }

    /**
     * @param $url='http://api.andreybolonin.com/'.
     */
    public function getContent($url, NamespaceSymfony $parent, $test = false)
    {
        $httpClient = HttpClient::create();
        $html = $httpClient->request('GET', $url);
        $crawler = new Crawler($html->getContent());

        $filteredInterface = $crawler->filter('div#page-content > div.container-fluid.underlined > div.row > div.col-md-6 > em > a > abbr');
        foreach ($filteredInterface as $value1) {
            $urlInterface = 'http://api.andreybolonin.com/'.str_replace('\\', '/', $value1->getAttribute('title').'.html');
            $setInterface = new InterfaceSymfony();
            $setInterface->setName($value1->textContent);
            $setInterface->setUrl($urlInterface);
            $setInterface->setNamespaceSymfony($parent);
            $this->em->persist($setInterface);
            $this->em->flush();
        }

        $filteredClasses = $crawler->filter('div#page-content > div.container-fluid.underlined > div.row > div.col-md-6 > a');
        foreach ($filteredClasses as $value2) {
            $urlClasses = 'http://api.andreybolonin.com/'.str_replace('../', '', $value2->getAttribute('href'));
            $setClasses = new ClassesSymfony();
            $setClasses->setName($value2->textContent);
            $setClasses->setUrl($urlClasses);
            $setClasses->setNamespaceSymfony($parent);
            $this->em->persist($setClasses);
        }

        $filtered = $crawler->filter('div#page-content > div.namespace-list > a');
        //var_dump($filtered->count());
        foreach ($filtered as $value) {
            $urlNamespace = 'http://api.andreybolonin.com/'.str_replace('../', '', $value->getAttribute('href'));
            $setNamespace = new NamespaceSymfony();
            $setNamespace->setName($value->textContent);
            $setNamespace->setUrl($urlNamespace);
            $setNamespace->setParent($parent);
            $this->em->persist($setNamespace);
            $this->em->flush();
            if ($test) {
                exit;
            }
            $this->getContent($urlNamespace, $setNamespace);
        }
        $this->em->flush();
    }
}
