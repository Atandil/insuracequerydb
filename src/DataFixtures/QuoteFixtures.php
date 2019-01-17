<?php
/*
 * This is DataFixturess to make some data
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Quote;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [$reference, $description, $ammount]) {
            $quote = new Quote();
            $quote->setReference($reference);
            $quote->setDescription($description);
            $quote->setAmmount($ammount);
           
            $manager->persist($quote);
            
        }

        $manager->flush();
    }
    
    private function getData(): array
    {
        return [
            // $quoteData = [$reference, $description, $ammount];
            ['a123','Test Case 1',10000],
            ['b123','Test Case 2',500],
            ['c123','Test Case 3',3000],
            ['d123','Test Case 4',23000],
            ['a432','Test Case 5',4000],
            ['a888','Test Case 6',3200],
            ['a4322fs43','Test Case 7',46000]
        ];
    }
}
