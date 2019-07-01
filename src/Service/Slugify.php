<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 18/06/19
 * Time: 17:43
 */

namespace App\Service;


class Slugify
{
    public function generate(string $input) :string
    {
        //enlève les accents
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $input);

        // supprime les ponctuations
        $slug = mb_strtolower(preg_replace( '/[^A-Za-z0-9\-\s]/', '', $slug ));

        //remplace les espaces par des -
        $slug = str_replace(' ','-',trim($slug));

        // évite les - successifs
        $slug = preg_replace('/\s\s+/', '-', $slug);

        return $slug;
    }
}