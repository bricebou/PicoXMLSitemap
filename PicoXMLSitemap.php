<?php

/**
* PicoXMLSitemap - Automatically generate a valid xml sitemap!
*
* This simple plugin will generate an XML sitemap of your Pico website.
* To access the sitemap,
* point your browser to `http://yoursite.com/?sitemap.xml` 
* or `http://yoursite.com/sitemap.xml` if you have mod_rewrite enabled. 
*
* @author Dave Kinsella
* @link https://github.com/Techn0tic/Pico_Sitemap
* @license http://opensource.org/licenses/MIT
* @version 1.0
* 
* @author Brice Boucard
* @link https://github.com/bricebou/PicoXMLSitemap
* @license https://bricebou.mit-license.org/
* @version 2.0 
*
*/
class PicoXMLSitemap extends AbstractPicoPlugin
{
    const API_VERSION = 2;
    protected $enabled = null;

    private $is_sitemap = false;
    private $excluded_url = array();
    private $excluded_url_patterns = array();

    public function onConfigLoaded(array &$config)
    {


        if (isset($config['pico_sitemap']['url']) && $config['pico_sitemap']['url'] != "")
        {
            $this->pico_sitemap_url = $config['pico_sitemap']['url'];
        }
        else
            $this->pico_sitemap_url = "sitemap.xml";

        if (isset($config['pico_sitemap']['excluded_url']) && is_array($config['pico_sitemap']['excluded_url']))
        {
            // $this->excluded_url = $config['pico_sitemap']['excluded_url'];

            $this->excluded_url = preg_filter('/^/', $config['base_url'], $config['pico_sitemap']['excluded_url']);
        }

        $this->excluded_url_pattern = $config['pico_sitemap']['excluded_url_pattern'];



    }

    public function onRequestUrl(&$url)
    {
        // Are we requesting the sitemep?
        if($url == $this->pico_sitemap_url) {
            //We are looking for the sitemap!
            $this->is_sitemap = true;
        }
    }

    public function onPagesLoaded(&$pages)
    {

        // generate excluded urls from supplied patterns
        if (isset($this->excluded_url_pattern) && is_array($this->excluded_url_pattern))
        {
            $urls = [];
            //generate a list of URLs to match pattern against
            foreach($pages as $p){
                $urls = array_merge($urls, array($p['url']));
            }

            //add urls that match the pattern to excluded_urls
            foreach( $this->excluded_url_pattern as $pattern ){
                $this->excluded_url = array_merge($this->excluded_url, preg_grep ($pattern , $urls));
            }

        }

        //Generate XML Sitemap
        if($this->is_sitemap){
            //Sitemap found, 200 OK
            header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
            //Set content-type to text/xml
            header('Content-Type: text/xml; charset=UTF-8');
            //XML Start
            $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            //Page loop
            foreach( $pages as $page ){
                if (!in_array($page['url'], $this->excluded_url)) {
                    //Page URL
                    $xml .= '<url><loc>'.$page['url'].'</loc>';
                    //Page date/last modified
                    if(!empty($page['date'])){
                        $xml .= '<lastmod>'.date('c', $page['time']).'</lastmod>';
                    }
                    $xml .= '</url>';
                }
            }
            //XML End
            $xml .= '</urlset>';
            //Show generated sitemap
            die($xml);
        }
    }
}
