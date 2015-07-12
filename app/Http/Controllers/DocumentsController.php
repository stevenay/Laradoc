<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DocumentRequest;
use App\Document;
use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class DocumentsController extends Controller {

    /**
     * Create new DocumentsController Instance.
     * Ensure only authenticated users can create and edit Documents.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show All Document Articles
     *
     * @return \Illuminate\View\View IndexPage
     */
    public function index()
	{
        // Eagar Loading
        // $categories = Category::with('documents')->get();

        $first_document = Document::where('id', 1)->get(['title'])->first();
        $document_title = strtolower(str_slug($first_document->title));
        return redirect("documents/setup-{$document_title}");
	}

    /**
     * Show the Document
     *
     * @param Document $document
     * @return \Illuminate\View\View
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form to create new Document Article
     *
     * @return \Illuminate\View\View CreateFormPage
     */
    public function create()
    {
        return view('documents.create', compact('categories'));
    }

    /**
     * Persist the Document
     *
     * @param DocumentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DocumentRequest $request)
    {
        $document = $this->createNewDocument($request->all());
        $document->save(); // Save into the Database
        $document->addToIndex(); // Add to ElasticSearch Server

        return redirect('/');
    }

    /**
     * Show the edit form for Document
     *
     * @param Document $document
     * @return \Illuminate\View\View
     */
    public function edit(Document $document)
    {
        return view("documents.edit", compact('document', 'categories'));
    }

    /**
     * Update the Document to the Db
     *
     * @param Document $document
     * @param DocumentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Document $document, DocumentRequest $request)
    {
        $document->buildSearchIndex($request->input('content'))
            ->update($request->all());

        $document->updateIndex();

        return redirect('documents');
    }

    public function createNewDocument(array $data)
    {
        return Document::open($data)
            ->buildSearchIndex($data['content']);
    }

    /**
     * Download and update the content from Laravel.com/docs/master
     */
    public function sync()
    {
        // Logging Variables
        $category_updated = $category_created = $document_updated = $document_created = 0;
        $document_updated_flag = false;

        // Crawling Variables
        $client = new Client();
        $base_uri = 'http://www.laravel.com';
        $link_uri = ['/docs/master'];
        $document_content = [];
        $crawler = $client->request('GET', $base_uri . $link_uri[0]);

        $status_code = $client->getResponse()->getStatus();
        if ($status_code == 200) {
            $crawler->filter('section.sidebar li a')
                ->each(function (Crawler $node, $i) use (&$link_uri) {
                    $node_href = $node->attr('href');
                    $link_uri[] = $node_href;
                });

            // category collection
            $categories = Category::all(['id','category_name','order_index']);

            // category model
            $category = 0;

            // category name
            $category_name = "";

            // document collection
            $documents = Document::all(['id', 'category_id', 'title', 'content', 'order_index']);

            // category order index
            $order_index = 0;

            for ( $n = 1; $n < sizeof($link_uri); $n++ ) {

                $crawler = $client->request('GET', $base_uri . $link_uri[$n]);
                $status_code = $client->getResponse()->getStatus();
                if ($status_code == 200) {
                    try {

                        $category_name_html = $crawler->filter("section.sidebar li a[href='" . $link_uri[$n] . "']");

                        if ( $category_name_html->count() > 0 ) {

                            // Document Title & Content
                            $document_title = $category_name_html->text();
                            $document_content = $crawler->filter('body article')->eq(0)->html();

                            // search category
                            $category_name_html = $category_name_html->parents('li')
                                ->parents('ul')
                                ->parents('li')
                                ->first()
                                ->html();

                            // check if Category exists,
                            if ( preg_match("/(.+)/i", $category_name_html, $matches) ) {

                                // Category order index increment if new category found
                                if ( strcasecmp($category_name, $matches[0]) != 0 ) {

                                    $category_name = $matches[0];

                                    $order_index++;

                                    if ( $categories->contains('category_name', $category_name) ) {
                                        $category = $categories->where('category_name', $category_name)->first();

                                        if ($category->order_index != $order_index) {
                                            $category->order_index = $order_index;
                                            $category->save();

                                            // Category Update Increase
                                            $category_updated++;
                                        }
                                    } else {
                                        $category = Category::create(['category_name' => $category_name, 'order_index' => $order_index]);
                                        $category_created++;
                                    }
                                }
                            }

                            $document = $documents->where('title', $document_title)
                                                ->where('category_id', $category->id)
                                                ->first();

//                            print_r($document);

                            // check if Document exists in the same category,
                            if ( $document !== null ) {

                                if (strcmp($document->content, $document_content) != 0) {
                                    $document->content = $document_content;
                                    $document_updated_flag = true;
                                }

                                if ($document->order_index !== $n) {
                                    $document->order_index = $n;
                                    $document_updated_flag = true;
                                }

                                if ($document_updated_flag) $document_updated++;

                            } else {

                                $document = $this->createNewDocument([
                                    'title'       => $document_title,
                                    'content'     => $document_content,
                                    'order_index' => $n
                                ]);

                                $document_created++;
                            }

                            $category->documents()->save($document);
                        }
                    } catch
                    ( InvalidArgumentException $ex ) {
                        echo "Error occured";
                    }
                }
            }
        }

        echo "<article><h1>Processing Finished</h1>";
        echo "Category Updated: {$category_updated} <br />";
        echo "Category Created: {$category_created} <br />";
        echo "Document Updated: {$document_updated} <br />";
        echo "Document Created: {$document_created} <br />";
        echo "</article>";
    }

}
