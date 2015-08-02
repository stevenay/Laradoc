<?php namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApiSearchController extends Controller {

    public function test()
    {
        echo $this->closestByLevenshtein('HMST');
    }

    /**
     * Guess the similar word
     *
     * @param string $input
     * @param array $reference_words
     * @return string
     */
    private function levenshteinCloset($input, $reference_words)
    {
        $closest = "Nothing";
        $distance = -1;

        foreach($reference_words as $word){
            $lev = levenshtein($input, $word);

            // exact match
            if($lev == 0){
                $closest = $word;

                // no need to continue as we have found exact match
                break;
            }

            // if distance is less than the currently stored distance and it is less than our initial value
            if($lev <= $distance || $distance < 0){
                $closest  = $word;
                $distance = $lev;
            }
        }

        return $closest;
    }

    public function getAPI(Request $request)
	{
        $data = [];

        // Retrieve the user's input and escape it
        $q = $request->input('q');

        if (!$q && $q == '')
            return Response::json(array(), 400);

        $documents = Document::FullTextSearch($q)
                        ->orderBy('score', 'desc')
                        ->take(5)
                        ->get(array('category_id','title', 'content',
                            DB::raw("SUM(MATCH(search_index_heading) AGAINST('".$q."')) AS score")));

//        SELECT title FROM documents WHERE levenshtein('subsribe',  search_index_heading) BETWEEN 0 AND 4
        foreach ($documents as $document) {
            $content = $document->content;
            $matches = array();
            if (preg_match_all("/(?:<h[2-3]>)(.+?)(?:<\/h[2-3]>)/i", $content, $matches)) {

                $full_matches = $matches[0];
                $text_matches = $matches[1];

                $category_name = $document->category->category_name;

                foreach ( $text_matches as $key => $match_text ) {

                    $search_words = explode( ' ', $q );
                    $match_rank = 0;
                    $match_words = explode( ' ', $match_text );

                    foreach ($search_words as $word_key => $search_word) {
                        $search_word = $this->levenshteinCloset($search_word, $match_words);

                        if ( stripos($match_text, $search_word) !== false )
                            $match_rank++;
                    }

                    if ( $match_rank > 0 ) {
                        $data[] = array(
                            'title'      => $document->title,
                            'content'    => $full_matches[$key],
                            'text_only'  => $text_matches[$key],
                            'url'        => strtolower(str_slug($category_name.' '.$document->title)) . '#' . str_slug($text_matches[$key]),
                            'match_rank' => $match_rank
                        );
                    }
                }
            }
        }

        $match_rank = array();
        foreach ($data as $key => $row)
        {
            $match_rank[$key] = $row['match_rank'];
        }

        // array_multisort mutate the $data array
//        array_multisort($match_rank, SORT_DESC, $data);

        $this->appendURL($data, 'documents');
        return response()->json(array('data' => $data));
	}

    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix . '/' . $item['title']);
        }
        return $data;
    }

}


//Let's say I have the following sample text:
//
//    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
//    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
//
//    Define Methodology
//
//    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
//    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
//    ad minim veniam, quis nostrud exercitation ullamco laboris nisi u
//    t aliquip ex ea commodo consequat.
//
//I want to search "**Define Methodology**" from the above text by the following sample search strings:
//
// - "How should I define methodology?"
// - "How to Define methodology?"
// - "What is possible to Define Methodology?"
// - "The way to Define Methodology?", etc.
//
//These search strings can be any possible sentences which include "**Define Methodology**".

//foreach ($documents as $document) {
//    $content = $document->content;
//
//    $matches = array();
//    if (preg_match_all("/(?:<h[2-3]>).*?$q.*?(?:<\/h[2-3 ]>)/i", $content, $matches)) {
//
//        foreach ( $matches[0] as $key => $val ) {
//
//            $data[] = array(
//                'title'  => $document->title,
//                'content' => $val,
//                'url'    => ''
//            );
//        }
//    }
//}
