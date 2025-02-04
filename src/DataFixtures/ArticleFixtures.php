<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 17/06/19
 * Time: 10:25
 */

namespace App\DataFixtures;


use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 50; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent(mb_strtolower($faker->text()));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 4)));
        }
            $manager->flush();
    }

    public function getDependencies()
        {
        // TODO: Implement getDependencies() method.
        return [CategoryFixtures::class];
        }
}