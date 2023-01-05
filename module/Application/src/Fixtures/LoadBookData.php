<?php

declare(strict_types=1);


namespace Application\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    const FIXTURE_ORDER = 1;

    public function getOrder()
    {
        return $this::FIXTURE_ORDER;
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->getData();
        foreach ($data as $key => $value) {
            //$slug = mb_strtolower($value['name']);
            //$slug = str_replace(' ','-', $slug);

            $book = new \Application\Entity\Book();
            $book->setTitle($value['name']);
            $book->setYear($value['year']);
            $book->setPages($value['pages']);
            $book->setPostedAt(new \DateTimeImmutable('now'));
            
            $manager->persist($book);
            //$this->addReference($value['reference'], $category);

        }
        $manager->flush();
    }


    public function getData()
    {
        $data = [
            [
                'name' => 'Title 1',
                'year' => 2005,
                'pages' => 100
                //'reference' => 'title-1',
            ],
            [
                'name' => 'Title 2',
                'year' => 2006,
                'pages' => 200
                //'reference' => 'category-2',
            ],
            [
                'name' => 'Title 3',
                'year' => 2007,
                'pages' => 200
                //'reference' => 'category-3',
            ],
        ];

        return $data;
    }


}