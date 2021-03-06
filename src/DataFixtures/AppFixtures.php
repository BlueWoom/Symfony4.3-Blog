<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Author;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\UserActivity;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array();
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName("Categoria_" . $i);
            $category->setDescription("Descrizione categoria_" . $i);
            array_push($categories, $category);
            $manager->persist($category);
        }

        $color_array = ["#f23a2e", "#8bc34a", "#f89d13", "#6c757d", "#4472ca", "#4b97ff", "#ff0005", "#0a369d", "#d7263d", "#ffd151"];
        $tags = array();
        for ($i = 1; $i <= 8; $i++) {
            $tag = new Tag();
            $tag->setName("tag_" . $i);
            $tag->setDescription("Descrizione tag_" . $i);

            $index_color = array_rand($color_array);
            $tag->setColor($color_array[$index_color]);
            unset($color_array[$index_color]);

            array_push($tags, $tag);
            $manager->persist($tag);
        }

        $images_a = ['person_1.jpg', 'person_2.jpg', 'person_3.jpg', 'person_4.jpg', 'person_5.jpg'];
        $author = new Author();
        $author->setImage($images_a[array_rand($images_a)]);
        $author->setName('autore');
        $author->setTitle('title');
        $author->setCompany('company');
        $author->setUsername('admin');
        $author->setEmail('admin@gmail.com');
        $author->setShortBio('bio autore');
        $author->setPhone('1234567890');
        $author->setFacebook('facebook');
        $author->setTwitter('twitter');
        $author->setGithub('github');
        $author->setLinkedin('github');

        $author->setPlainPassword('admin');
        $author->setEnabled(true);
        $author->setRoles(array('ROLE_ADMIN'));
        $manager->persist($author);

        $images_p = array("img_1.jpg", "img_2.jpg", "img_3.jpg", "img_4.jpg");
        for ($i = 0; $i <= 30; $i++) {
            $post = new Post();
            $post->setTitle('Titolo_' . $i);
            $post->setSlug('titolo-' . $i);
            $post->setPreview($images_p[array_rand($images_p)]);
            $post->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');
            $post->setBody('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.');
            $post->setAuthor($author);
            $post->setCategory($categories[array_rand($categories)]);
            $post->addTag($tags[array_rand($tags)]);
            $post->addTag($tags[array_rand($tags)]);
            $post->addTag($tags[array_rand($tags)]);
            $manager->persist($post);

            $comment = new UserActivity();
            $comment->setType('comment');
            $comment->setName($this->generateRandomString());
            $comment->setEmail($this->generateRandomString(32) . '@gmail.com');
            $comment->setMessage('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');
            $comment->setIP($this->generateIP());
            $comment->setPost($post);
            $manager->persist($comment);
        }

        $manager->flush();
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateIP($length = 12)
    {
        $randomString = rand(0, 255) . rand(0, 255) . rand(0, 255) . rand(0, 255);
        return $randomString;
    }
}
