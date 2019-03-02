<?php

namespace App\DataFixtures;

use App\Entity\Template;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TemplateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $templateBlack = new Template();
        $templateBlack->setName('Black');
        $templateBlack->setImage('countdown.png');
        $manager->persist($templateBlack);

        $templateWhite = new Template();
        $templateWhite->setName('White');
        $templateWhite->setImage('countdown-white.png');
        $manager->persist($templateWhite);

        $manager->flush();
    }
}
