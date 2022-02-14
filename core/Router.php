<?php

namespace app\core;

use app\core\Page;

class Router {
    public Response $response;
    public Request $request;
    public Page $page;
    protected array $routes = [];
    protected array $futas = [];

    public function __construct(Request $request, Response $response)    {
        $this->request = $request;
        $this->response = $response;
    }
    public function resolve() {
        $path = $this->request->getPath();
        //$method = $this->request->getMethod();
        $function_call = $this->request->getFunction();

        /*
        if(strpos($path, '/api/') !== false) {

            return 'api call';
        }
        */

        $files = array_values(array_filter(scandir("views/pages"),function($e) { return is_file("views/pages/$e"); }));
        foreach($files as $filename) {
            $filestream = fopen("views/pages/$filename","r");
            $arr = [];
            while(($line = fgets($filestream)) !== false) {
                if(strpos($line,'==') !== false)
                    break;
                array_push($arr, $line);
            }
            fclose($filestream);

            $page = new Page($arr, $filename);
            $slugs = $this->compareUrls($path, $page->param['url']);
            if(is_array($slugs)) {
                if(!empty($slugs))
                    $page->setSlugs($slugs);
                $this->page = $page;
                break;
            }
        }
        if(!isset($this->page)) {
            $this->response->setStatusCode(404);
            return $this->renderView("notFound");
        }

        if($function_call !== false) {
            return "function called";
        }
        if(isset(Application::$controller)) {
            $param = method_exists(Application::$controller,'onStart') ? call_user_func([Application::$controller,'onStart']) : [];
            foreach($param as $key => $value) {
                if(!isset($this->page->param[$key]))
                    $this->page->param[$key] = $value;
            }
        }
        return $this->renderView($this->page->filename, $this->page->param['layout'], $this->page->param);
    }
    public function compareUrls(String $request_url, String $page_url ) {
        $slugs = [];
        $page_url = explode('/',trim($page_url,'/'));
        $request_url = explode('/', trim($request_url,'/'));
        if(count($page_url) !== count($request_url))
            return false;
        for ($i=0; $i < count($page_url); $i++) { 
            if($page_url[$i] !== $request_url[$i]) {
                if(strpos($page_url[$i],':')) 
                    $slugs[trim($page_url[$i], ':')] = $request_url[$i];
                else
                    return false;
            }
        }
        return $slugs;
    }
    public function renderView($view, $layout = 'default', $param = []) { // render page in layout
        $layoutContent = $this->layoutContent($layout);
        $viewContent = preg_split('/==\n|==\r\n/',$this->renderOnlyView($view, $param));
        return str_replace('{{content}}',$viewContent[count($viewContent)-1],$layoutContent);
    }
    public function renderContent($content) {
        $layoutContent = $this->layoutContent('default');
        return str_replace('{{content}}', $content, $layoutContent);
    }
    protected function layoutContent($layout) {    // render layout
        ob_start();
        include_once Application::$APP_ROOT."/views/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view, $param) { // render only the page
        foreach($param as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$APP_ROOT."/views/pages/$view.php";
        return ob_get_clean();
    }
}
?>