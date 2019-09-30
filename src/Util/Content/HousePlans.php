<?php

namespace App\Util\Content;

use DOMXPath;
use IvoPetkov\HTML5DOMDocument;
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
        $this->content = preg_replace(
          '/<!-- {2}Begin Implement Header Bidding -->(.*)<!-- {2}End Implement Header Bidding -->->/si',
          '',
          $this->content
        );
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($this->content, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
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

        $jsBidding = <<<HTML
          <!--  Begin Implement Header Bidding -->
          <script>
          //<![CDATA[
          "use strict";
          var PREBID_TIMEOUT=2e3;
          function r(e){/in/.test(document.readyState)?setTimeout("r("+e+")",9):e()}
          window.log=function(){
            window.log.history=window.log.history||[]
              ,window.log.history.push(arguments)
              ,this.console&&console.log(Array.prototype.slice.call(arguments))};
            var pbjs=pbjs||{};
            pbjs.que=pbjs.que||[];
            var googletag=googletag||{};
            function initAdserver(){
              pbjs.initAdserverSet||(
                googletag.cmd.push(
                  function(){pbjs.que.push(function(){pbjs.setTargetingForGPTAsync(),googletag.pubads().refresh()})}
                ),
                pbjs.initAdserverSet=!0
              )
            }
            googletag.cmd=googletag.cmd||[]
            ,function(){
              var e=document
              ,n=e.createElement("script");
              e.location.protocol;
              n.type="text/javascript"
              ,n.src="//ap.lijit.com/www/headerauction/prebid.min.js";
              var t=document.getElementsByTagName("head")[0];
              t.insertBefore(n,t.firstChild)}()
              ,googletag.cmd.push(function(){googletag.pubads().disableInitialLoad()})
              ,pbjs.que.push(function(){window.innerWidth&&document.documentElement.clientWidth?Math.min(window.innerWidth,document.documentElement.clientWidth):window.innerWidth||document.documentElement.clientWidth||document.getElementsByTagName("body")[0].clientWidth;var e=[[300,250]],n=[[728,90]],t=[{code:"div-gpt-ad-leaderboard1-728x90",mediaTypes:{banner:{sizes:n}},bids:[{bidder:"rubicon",params:{accountId:18596,siteId:208692,zoneId:1027284}},{bidder:"brealtime",params:{placementId:13525875}},{bidder:"sovrn",params:{tagid:578450}},{bidder:"ix",params:{siteId:"235135",size:[728,90]}}]},{code:"div-gpt-ad-leaderboard2-728x90",mediaTypes:{banner:{sizes:n}},bids:[{bidder:"rubicon",params:{accountId:18596,siteId:208692,zoneId:1027280}},{bidder:"brealtime",params:{placementId:13525876}},{bidder:"sovrn",params:{tagid:578451}},{bidder:"ix",params:{siteId:"235136",size:[728,90]}}]},{code:"div-gpt-ad-box1-300x250",mediaTypes:{banner:{sizes:e}},bids:[{bidder:"rubicon",params:{accountId:18596,siteId:208692,zoneId:1027286}},{bidder:"brealtime",params:{placementId:13525877}},{bidder:"sovrn",params:{tagid:578452}},{bidder:"ix",params:{siteId:"235137",size:[300,250]}}]},{code:"div-gpt-ad-box2-300x250",mediaTypes:{banner:{sizes:e}},bids:[{bidder:"rubicon",params:{accountId:18596,siteId:208692,zoneId:1027288}},{bidder:"brealtime",params:{placementId:13525878}},{bidder:"sovrn",params:{tagid:578453}},{bidder:"ix",params:{siteId:"235138",size:[300,250]}}]}];pbjs.addAdUnits(t),pbjs.requestBids({bidsBackHandler:function(){initAdserver()}}),pbjs.bidderSettings={standard:{adserverTargeting:[{key:"hb_bidder",val:function(e){return e.bidderCode}},{key:"hb_adid",val:function(e){return e.adId}},{key:"hb_pb",val:function(e){return e.pbHg}}]}}}),setTimeout(initAdserver,PREBID_TIMEOUT),window.sovrn=window.sovrn||{},window.sovrn.auction=window.sovrn.auction||{};var beaconFlag=!1;window.sovrn.auction={sendBeacon:function(){try{var e;if(beaconFlag)return!1;"sovrn_beacon",(e=window.sovrn.auction.createiFrame("sovrn_beacon",1,1)).src=window.sovrn.auction.getBeaconURL(),document.body.appendChild(e),beaconFlag=!0}catch(e){return window.log("error making beacon",e),!1}return!0},createiFrame:function(e,n,t){var i,o,d,r,a,s;for(d in o=(i=document.createElement("iframe")).style,s={margin:"0px",padding:"0px",border:"0px none",width:n+"px",height:t+"px",overflow:"hidden"},a={id:e,margin:"0",padding:"0",frameborder:"0",width:n+"",height:t+"",scrolling:"no",src:"about:blank"})a.hasOwnProperty(d)&&i.setAttribute(d,a[d]);for(r in s)if(s.hasOwnProperty(r))try{o[r]=s[r]}catch(e){}return i},getBeaconURL:function(){return"https://gslbeacon.lijit.com/beacon?viewId=swelcome_header_auction&rand="+Math.floor(9e3*Math.random())+"&informer=13188016&type=fpads&loc="+window.location.host+"&v=1.2"},sendContainer:function(){var e="sovrn_container",n=window.sovrn.auction.createiFrame(e,1,1);document.body.appendChild(n);var t=document.getElementById(e)
              ,i='<!DOCTYPE html><html><head><title>Sovrn Container</title><meta http-equiv="Content-Type" content="text/html;charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"></he' + 'ad><b' + 'ody style="margin:0;padding:0">'
                +"<scr"
                  .concat(
                    'ipt type="text/javascript" src="https://ap.lijit.com/res/sovrn.containertag.min.js?cid=17&aid=231607"></sc',
                    "ript></b" + "ody></ht" + "ml>"
                  );
              try{var o=t.contentDocument||t.contentWindow.document;o.open("text/html","replace"),o.write(i)}catch(e){}}},r(function(){window.sovrn.auction.sendBeacon()});var reg=new RegExp("MSIE ([0-9]+[\\.0-9]*)");reg.exec(navigator.userAgent)?10===parseInt(RegExp.$1)&&(window.onload=function(){window.sovrn.auction.sendContainer()}):window.onload=function(){window.sovrn.auction.sendContainer()};

          //]]>
          </script>
          <!--  End Implement Header Bidding -->
HTML;
        $dom->insertHTML($js);
        $dom->insertHTML($jsBidding);

        $filters = $this->getXpathFilters();
        $xpath = new DOMXPath($dom);

        foreach ($filters as $reachGoal => $query) {
            $result = $xpath->query($query);

            foreach ($result as $item) {
              $item->setAttribute('onclick', "ym(54607231, 'reachGoal', '${reachGoal}');");
            }
        }

        $xpathQuery = "//div[contains(@id, 'div-gpt-ad-box2-300x250')]|//div[contains(@id, 'div-gpt-ad-leaderboard2-728x90')]|//div[contains(@id, 'div-gpt-ad-box1-300x250')]|//a[contains(@href, '1-800-913-2350')]|//div[@class='text-center text-xl bg-white mb-5 py-8']|//img[contains(@src, 'banner')]|//a[contains(@href, '1‑888‑705‑1300')]|//div[@class='w-full text-center border border-nav-menu-light mb-4 p-4 max-w-xl mx-auto']";
        $result = $xpath->query($xpathQuery);

        foreach ($result as $item) {
          $item
            ->parentNode
            ->removeChild($item);
        }

        return $dom->saveHTML();
    }

    protected function getXpathFilters(): array
    {
        return [
            'Search_plans_button'       => "//input[@type='submit'][@value='Search Plans']",
            'Add_cart_button'           => "//form[@id='add-plan-to-cart-form']//button[contains(text(), 'Add to Cart')]",
            'Cart_button'               => "//a[@href='/cart']|//a[@href='/checkout']",
            'Proceed_button'            => "//form[@action='/cart/submit']//button[contains(text(), 'Proceed to Checkout')]",
            'Submit_button'             => "//form[@id='salesforce-form']//button[contains(text(), 'SUBMIT')]",
            'Place_secure_order_button' => "//form[@action='/checkout/submit']//button[contains(text(), 'Place Secure Order')]",
            'Modify_this_plan_button'   => "//a[contains(text(), 'Modify This Plan')]",
            'Get_cost_to_build_button'  => "//a[contains(text(), 'Get Cost-To-Build Report')]",
        ];
    }
}
