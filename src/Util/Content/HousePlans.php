<?php

namespace App\Util\Content;

use Symfony\Component\DomCrawler\Crawler;
use DOMWrap\Document;

class HousePlans
{
    protected $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent() : string
    {
        $dom = new \IvoPetkov\HTML5DOMDocument();
        $dom->loadHTML($this->content);
        $js = 
          '<script type="text/javascript" >
          (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
          m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
          (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

          ym(54607231, "init", {
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true,
          webvisor:true
          });
          </script>
          <noscript><div><img src="https://mc.yandex.ru/watch/54607231" style="position:absolute; left:-9999px;" alt="" /></div></noscript>';

        $dom->insertHTML($js);

        $xpath = new \DOMXPath($dom);


        $filters = $this->getXpathFilters();
        $xpath = new \DOMXPath($dom);

        foreach ($filters as $reachGoal => $query) {
            $result = $xpath->query($query);

            foreach ($result as $item) {
              $item->setAttribute('onclick', "ym(54607231, 'reachGoal', '${reachGoal}');");
            }
        }

        $xpathQuery = "//a[contains(@href, '1-800-913-2350')]|//div[@class='text-center text-xl bg-white mb-5 py-8']|//img[contains(@src, 'banner')]|//a[contains(@href, '1‑888‑705‑1300')]|//div[@class='w-full text-center border border-nav-menu-light mb-4 p-4 max-w-xl mx-auto']";
        $result = $xpath->query($xpathQuery);

        foreach ($result as $item) {
          $item
            ->parentNode
            ->removeChild($item);
        }

        return $dom->saveHTML();
    }

    protected function getXpathFilters()
    {
        return [
            'Search_plans_button'       => "//input[@type='submit'][@value='Search Plans']",
            'Add_cart_button'           => "//form[@id='add-plan-to-cart-form']//button[contains(text(), 'Add to Cart')]",
            'Cart_button'               => "//a[@href='/cart']|//a[@href='/checkout']",
            'Proceed_button'            => "//form[@action='/cart/submit']//button[contains(text(), 'Proceed to Checkout')]",
            'Submit_button'             => "//form[@id='salesforce-form']//button[contains(text(), 'SUBMIT')]",
            'Place_secure_order_button' => "//form[@action='/checkout/submit']//button[contains(text(), 'Place Secure Order')]",
        ];
    }
}