<?php namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DocumentsSearchController extends Controller {

    public function index(Request $request)
    {
        $data = [];

        // Retrieve the user's input and escape it
        $q = $request->input('q');

        if (!$q && $q == '')
            return Response::json(array(), 400);

        $documents = Document::searchByQuery([
            'match' => array(
                'search_index_heading' => [
                    "query" => $q,
                    "operator" => "or",
                    "fuzziness" => "auto"
                ]
            )
        ]);

//        $documents = Document::FullTextSearch($q)
//            ->orderBy('score', 'desc')
//            ->take(10)
//            ->get(array('category_id','title', 'content',
//                DB::raw("SUM(MATCH(search_index_heading) AGAINST('".$q."')) AS score")));

//        print_r($documents);
//        exit();

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

        $data = array_slice($data, 0, 15);

        // array_multisort mutate the $data array
//        array_multisort($match_rank, SORT_DESC, $data);

        $this->appendURL($data, 'documents');
        return response()->json(array('data' => $data));
    }


    /** HELPER FUNCTIONS */
    /**
     * Guess the similar word
     *
     * @param string $input
     * @param array $reference_words
     * @return string
     */
    private function levenshteinCloset($input, $reference_words)
    {
        $closest = "";
        $distance = 4;

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

    /**
     * Append the URL to the returned data Array
     *
     * @param $data
     * @param $prefix
     * @return mixed
     */
    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix . '/' . $item['title']);
        }
        return $data;
    }

}
