<?php
function get_relevance($word){
    $restaurant_array = array("word_db" =>"restaurant",
                "b" => "hotel",
                "c" => "eating",
                "d" => "dining",
                "e" => "food");
$clothing_array = array("word_db" =>"clothing",
                "a" => "dress",
                "b" => "clothes",
                "c" => "shirts",
                "d" => "costumes",
                "e" =>"apparels");
$business_array = array("word_db" =>"business",
                "a" => "company",
                "b" => "industry",
                "c" => "information technology",
                "d" =>"factory");
foreach ($restaurant_array as $restaurant_word){
    if ($word == $restaurant_word){
        return $restaurant_array['word_db'];
    }
}
foreach ($clothing_array as $clothing_word){
if ($word == $clothing_word){
        return $clothing_array['word_db'];
    }
    }
foreach ($business_array as $business_word){
if ($word == $business_word){
        return $business_array['word_db'];
    }
    }
}

?>